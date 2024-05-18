<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Http\Requests\PublicationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publications = Publication::all();
        return view('publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = $this->getCountries();
        return view('publications.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PublicationRequest $request)
    {

        $validatedData = $request->validated();

        if (!$request->filled('latitude') || !$request->filled('longitude')) {
            return redirect()->back()->withInput()->withErrors([
                'latitude' => 'La latitud es obligatoria.',
                'longitude' => 'La longitud es obligatoria.',
            ]);
        }

        $publication = new Publication($validatedData);
        $publication->user_id = Auth::id();
        $publication->save();

        if ($request->hasFile('image')) {
            $request->file('image')->storeAs('publications', $publication->id . '.jpg', 'public');
            $publication->image = 'publications/' . $publication->id . '.jpg';
            $publication->save();
        }

        return redirect()->route('publications.index')->with('success', 'Publicación creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        return view('publications.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $publication)
    {
        $countries = $this->getCountries();
        return view('publications.edit', compact('publication', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PublicationRequest $request, Publication $publication)
    {
        $validatedData = $request->validated();

        // Manejar la imagen
        if ($request->hasFile('image')) {
            // Elimina la imagen anterior si existe
            if ($publication->image) {
                Storage::disk('public')->delete($publication->image);
            }

            // Almacena la nueva imagen
            $path = $request->file('image')->storeAs('publications', $publication->id . '.jpg', 'public');
            $validatedData['image'] = $path;
        } else {
            // Mantiene la imagen actual
            $validatedData['image'] = $publication->image;
        }

        // Actualiza la publicación
        $publication->update($validatedData);

        return redirect()->route('publications.index')->with('success', 'Publicación actualizada exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();
        return redirect()->route('publications.my')->with('success', 'Publicación eliminada exitosamente');
    }

    /**
     * Display the user's publications.
     */
    public function myPublications()
    {
        $user = Auth::user();
        $publications = Publication::where('user_id', $user->id)->get();

        return view('publications.my', compact('publications'));
    }

    /**
     * Get the list of countries.
     */
    private function getCountries()
    {
        return [
            'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia',
            'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize',
            'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso',
            'Burundi', 'Cabo Verde', 'Cambodia', 'Cameroon', 'Canada', 'Central African Republic', 'Chad', 'Chile', 'China',
            'Colombia', 'Comoros', 'Congo, Democratic Republic of the', 'Congo, Republic of the', 'Costa Rica', 'Croatia',
            'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt',
            'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia', 'Fiji', 'Finland', 'France',
            'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau',
            'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel',
            'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea, North', 'Korea, South', 'Kosovo',
            'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania',
            'Luxembourg', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania',
            'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar',
            'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Macedonia',
            'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines',
            'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines',
            'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone',
            'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan', 'Spain', 'Sri Lanka',
            'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste',
            'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine',
            'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City',
            'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
        ];
    }
}
