@extends('layout')

@section('title', __('publications_create.title'))

@section('content')
    <div class="container mt-3">

        <form action="{{ route('publications.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="name" class="form-label">{{ __('publications_create.name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}"
                        required>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="type" class="form-label">{{ __('publications_create.type') }}</label>
                    <select name="type" class="form-select" id="type" required>
                        <option value="se busca" {{ old('type') == 'se busca' ? 'selected' : '' }}>
                            {{ __('publications_create.type_seeking') }}
                        </option>
                        <option value="se adopta" {{ old('type') == 'se adopta' ? 'selected' : '' }}>
                            {{ __('publications_create.type_adopt') }}
                        </option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <label for="type_animal" class="form-label">{{ __('publications_create.animal_type') }}</label>
                    <select name="type_animal" class="form-select" id="type_animal" required>
                        <option value="perro" {{ old('type_animal') == 'perro' ? 'selected' : '' }}>
                            {{ __('publications_create.animal_type_dog') }}
                        </option>
                        <option value="gato" {{ old('type_animal') == 'gato' ? 'selected' : '' }}>
                            {{ __('publications_create.animal_type_cat') }}
                        </option>
                        <option value="otro" {{ old('type_animal') == 'otro' ? 'selected' : '' }}>
                            {{ __('publications_create.animal_type_other') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label for="size" class="form-label">{{ __('publications_create.size') }}</label>
                    <select name="size" class="form-select" id="size" required>
                        <option value="Grande" {{ old('size') == 'Grande' ? 'selected' : '' }}>
                            {{ __('publications_create.size_large') }}
                        </option>
                        <option value="Mediano" {{ old('size') == 'Mediano' ? 'selected' : '' }}>
                            {{ __('publications_create.size_medium') }}
                        </option>
                        <option value="Pequeño" {{ old('size') == 'Pequeño' ? 'selected' : '' }}>
                            {{ __('publications_create.size_small') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label for="date" class="form-label">{{ __('publications_create.date') }}</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{ old('date') }}"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="image" class="form-label">{{ __('publications_create.image') }}</label>
                    <input type="file" name="image" class="form-control" id="image" required>
                </div>
                <div class="col-md-9 mb-2">
                    <label for="description" class="form-label">{{ __('publications_create.description') }}</label>
                    <textarea rows="1" name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-12">
                    <!-- Mapa de Leaflet -->
                    <div id="mi_mapa" class="mapa-leaflet"></div>
                    <!-- Campos ocultos para latitud y longitud -->
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" required>
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="country" class="form-label" data-bs-toggle="tooltip"
                        title="{{ __('publications_create.country_tooltip') }}">{{ __('publications_create.country') }}</label>
                    <select name="country" class="form-select" id="country">
                        <option value="">{{ __('publications_create.select_country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="street" class="form-label" data-bs-toggle="tooltip"
                        title="{{ __('publications_create.street_tooltip') }}">{{ __('publications_create.street') }}</label>
                    <input type="text" name="street" class="form-control" id="street" value="{{ old('street') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <label for="city" class="form-label" data-bs-toggle="tooltip"
                        title="{{ __('publications_create.city_tooltip') }}">{{ __('publications_create.city') }}</label>
                    <input type="text" name="city" class="form-control" id="city"
                        value="{{ old('city') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <label for="zip" class="form-label" data-bs-toggle="tooltip"
                        title="{{ __('publications_create.zip_tooltip') }}">{{ __('publications_create.zip') }}</label>
                    <input type="text" name="zip" class="form-control" id="zip"
                        value="{{ old('zip') }}">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <a href="{{ url()->previous() }}"
                        class="btn btn-secondary w-100">{{ __('publications_create.back') }}</a>
                </div>
                <div class="col-md-6">
                    <button type="submit"
                        class="btn btn-primary w-100">{{ __('publications_create.create_publication') }}</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let map = L.map('mi_mapa').setView([39.4699, -0.3763], 12); // Coordenadas de Valencia, España

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        let marker;

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        const updateMapLocation = (query) => {
            fetch(`https://nominatim.openstreetmap.org/search?${query}&format=json&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = data[0].lat;
                        const lon = data[0].lon;
                        map.setView([lat, lon], 13);
                    }
                });
        };

        document.getElementById('country').addEventListener('change', function() {
            const selectedCountry = this.value;
            updateMapLocation(`country=${selectedCountry}`);
        });

        document.getElementById('city').addEventListener('blur', function() {
            const city = this.value;
            const country = document.getElementById('country').value;
            updateMapLocation(`city=${city}&country=${country}`);
        });

        document.getElementById('zip').addEventListener('blur', function() {
            const zip = this.value;
            const country = document.getElementById('country').value;
            updateMapLocation(`postalcode=${zip}&country=${country}`);
        });

        document.getElementById('street').addEventListener('blur', function() {
            const street = this.value;
            const city = document.getElementById('city').value;
            const country = document.getElementById('country').value;
            updateMapLocation(`street=${street}&city=${city}&country=${country}`);
        });

        document.addEventListener("DOMContentLoaded", function() {
            let dateInput = document.getElementById('date');
            let today = new Date();
            let year = today.getFullYear();
            let month = ("0" + (today.getMonth() + 1)).slice(-2);
            let day = ("0" + today.getDate()).slice(-2);
            let maxDate = `${year}-${month}-${day}`;
            let minDate = `${year - 1}-${month}-${day}`;

            dateInput.setAttribute('max', maxDate);
            dateInput.setAttribute('min', minDate);

            if (!dateInput.value) {
                dateInput.value = maxDate;
            }
        });

        // Initialize tooltips; campos país, ciudad, calle y zip
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
