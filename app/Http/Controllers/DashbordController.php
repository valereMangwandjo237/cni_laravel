<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Immatriculation;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationImmatriculation;
use Illuminate\Support\Facades\Storage;

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
        $nature = $immat->nature();

        if ($action === 'valider') {
            $immat->status = 0;
        } elseif ($action === 'rejeter') {
            $immat->status = 1;
        }

        $immat->save();

        $this->copy_image_model_path($immat);

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

    private function copy_image_model_path($immatriculation){
        $images = $immatriculation->images()->get();
        $nature = $immatriculation->nature();

        foreach ($images as $image) {
            $originalPath = $image->path; // chemin actuel, ex: images/recto.jpg
            $fileName = basename($originalPath); // nom du fichier seulement

            // Nouveau chemin
            if ($immatriculation->status == 0) {
                $newPath = "models/{$nature}/{$fileName}";
            }elseif ($immatriculation->status == 1){
                $newPath = "models/others/{$fileName}";
            }

            // Copier le fichier
            if (Storage::disk('public')->exists($originalPath)) {
                Storage::disk('public')->copy($originalPath, $newPath);
            }else{Log::warning("Fichier non trouvé : " . $originalPath);}
        }
    }

}


