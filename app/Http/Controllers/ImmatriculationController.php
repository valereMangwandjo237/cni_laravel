<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Immatriculation;

class ImmatriculationController extends Controller
{
    public function store(Request $request){
        try {
            // Ton code de traitement ici...
            $immatriculation = Immatriculation::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'lieu_naissance' => $request->lieu_de_naissance,
                'date_naissance' => $request->date_de_naissance,
                'email' => $request->email,
                'numero_cni' => $request->numero,
                'status' => $request->status,
            ]);

            // Enregistrement des images
            if ($request->hasFile('photo_recto')) {
                $path_recto = $request->file('photo_recto')->store('cni', 'public');
                $immatriculation->images()->create([
                    'type' => 'recto',
                    'path' => $path_recto,
                    'nature' => $request->nature
                ]);
            }

            if ($request->hasFile('photo_verso')) {
                $path_verso = $request->file('photo_verso')->store('cni', 'public');
                $immatriculation->images()->create([
                    'type' => 'verso',
                    'path' => $path_verso,
                    'nature' => $request->nature
                ]);
            }

            return response()->json(['message' => 'Enregistrement réussi']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur interne',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
