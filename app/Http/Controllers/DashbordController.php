<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Immatriculation;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationImmatriculation;

class DashbordController extends Controller
{
    public function index(){
        return view("welcome");
    }

    public function all_immat(){
        $immatriculations = Immatriculation::orderBy('created_at', 'desc')->paginate(10);

        return view("all_imma", compact("immatriculations"));
    }

    public function validate_immat(){
        $immatriculations = Immatriculation::where('status', 0)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view("validate_imma", compact("immatriculations"));
    }

    public function wait_immat(){
        $immatriculations = Immatriculation::where('status', 2)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view("attente_imma", compact("immatriculations"));
    }

    public function block_immat(){
        $immatriculations = Immatriculation::where('status', 1)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view("block_imma", compact("immatriculations"));
    }

    public function show($id){
        $immat = Immatriculation::with('images')->findOrFail($id);

        return view('show', compact('immat'));
    }

    public function traiter(Request $request, $id){
        $immat = Immatriculation::findOrFail($id);
        $action = $request->input('action');

        if ($action === 'valider') {
            $immat->status = 0;
        } elseif ($action === 'rejeter') {
            $immat->status = 1;
        }

        $immat->save();

        try {

            if ($action === 'rejeter') {
                $nom = $immat->nom . ' ' . $immat->prenom;
                Mail::to($immat->email)
                    ->send(new NotificationImmatriculation($immat->created_at, $nom));

                return redirect()->route('dash_home')->with('success', "Un mail a été envoyé à l'usager.");
            }
            return redirect()->route('dash_home')->with('success', "Immatriculation validée.");
        } catch (\Exception $e) {
            return redirect()->route('dash_home')->with('error', 'Erreur lors de l\'envoi du mail : ' . $e->getMessage());
        }
    }

}


