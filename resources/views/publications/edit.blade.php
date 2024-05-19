@extends('layout')

@section('content')
    <div class="container mt-4">

        <form action="{{ route('publications.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" id="name"
                        value="{{ old('name', $publication->name) }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="type" class="form-label">Tipo</label>
                    <select name="type" class="form-select" id="type" required>
                        <option value="se busca" {{ old('type', $publication->type) == 'se busca' ? 'selected' : '' }}>Se
                            busca</option>
                        <option value="se adopta" {{ old('type', $publication->type) == 'se adopta' ? 'selected' : '' }}>Se
                            adopta</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="type_animal" class="form-label">Tipo de Animal</label>
                    <select name="type_animal" class="form-select" id="type_animal" required>
                        <option value="perro"
                            {{ old('type_animal', $publication->type_animal) == 'perro' ? 'selected' : '' }}>Perro</option>
                        <option value="gato"
                            {{ old('type_animal', $publication->type_animal) == 'gato' ? 'selected' : '' }}>Gato</option>
                        <option value="otro"
                            {{ old('type_animal', $publication->type_animal) == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="size" class="form-label">Tamaño</label>
                    <select name="size" class="form-select" id="size" required>
                        <option value="Grande" {{ old('size', $publication->size) == 'Grande' ? 'selected' : '' }}>Grande
                        </option>
                        <option value="Mediano" {{ old('size', $publication->size) == 'Mediano' ? 'selected' : '' }}>Mediano
                        </option>
                        <option value="Pequeño" {{ old('size', $publication->size) == 'Pequeño' ? 'selected' : '' }}>Pequeño
                        </option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="date" class="form-label">Fecha</label>
                    <input type="date" name="date" class="form-control" id="date"
                        value="{{ old('date', $publication->date) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="image" class="form-label">Imagen</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <div class="col-md-9 mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea rows="1" name="description" class="form-control" id="description">{{ old('description', $publication->description) }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Mapa de Leaflet -->
                    <div id="mi_mapa" style="width: 100%; height: 400px;" class="mb-3"></div>
                    <!-- Campos ocultos para latitud y longitud -->
                    <input type="hidden" name="latitude" id="latitude"
                        value="{{ old('latitude', $publication->latitude) }}" required>
                    <input type="hidden" name="longitude" id="longitude"
                        value="{{ old('longitude', $publication->longitude) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="country" class="form-label">País</label>
                    <select name="country" class="form-select" id="country">
                        <option value="">Seleccionar País</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}"
                                {{ old('country', $publication->country) == $country ? 'selected' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="street" class="form-label">Calle</label>
                    <input type="text" name="street" class="form-control" id="street"
                        value="{{ old('street', $publication->street) }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="city" class="form-label">Ciudad</label>
                    <input type="text" name="city" class="form-control" id="city"
                        value="{{ old('city', $publication->city) }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="zip" class="form-label">Código Postal</label>
                    <input type="text" name="zip" class="form-control" id="zip"
                        value="{{ old('zip', $publication->zip) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary my-3 w-100">Actualizar Publicación</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let map = L.map('mi_mapa').setView([{{ old('latitude', $publication->latitude) }},
            {{ old('longitude', $publication->longitude) }}
        ], 12); // Coordenadas iniciales

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        let marker = L.marker([{{ old('latitude', $publication->latitude) }},
            {{ old('longitude', $publication->longitude) }}
        ]).addTo(map);

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
            var dateInput = document.getElementById('date');
            var today = new Date();
            var year = today.getFullYear();
            var month = ("0" + (today.getMonth() + 1)).slice(-2);
            var day = ("0" + today.getDate()).slice(-2);
            var maxDate = `${year}-${month}-${day}`;
            var minDate = `${year - 1}-${month}-${day}`;

            dateInput.setAttribute('max', maxDate);
            dateInput.setAttribute('min', minDate);

            if (!dateInput.value) {
                dateInput.value = maxDate;
            }
        });
    </script>
@endsection