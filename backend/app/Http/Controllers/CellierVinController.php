<?php

namespace App\Http\Controllers;

use App\Models\CellierVin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CellierVinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * La méthode affiche les détails d'une bouteill spécifique appartenant a l'usager connecté
     * La méthode récupére une entrée de la table 'cellier_vins' en fonction de son id
     * en incluant les relations avec le la table vin et la table cellier
     * ELle vérifie également que la bouteille appartient bien a un cellier associé a l'uager actuellement 
     * connecté
     * Elle retourne les informations détaillées de la bouteille sous forme de JSON
     * @param int  $id de la boouteille dans le cellier
     * @return JSON
     */

    public function show($id)
    {
        $cellierVin = CellierVin::with(['vin', 'cellier'])
            ->where('cellier_vins.id', $id)
            ->whereHas('cellier', function ($query) {
                $query->where('usager_id', Auth::id());
            })
            ->first();
        if (!$cellierVin) {
            return response()->json([
                'error' => 'Bouteille non trouvée ou accès refusé'
            ], 404);
        }

        return response()->json([
            'id' => $cellierVin->id,
            'nom' => $cellierVin->vin->nom,
            'prix' => $cellierVin->vin->prix,
            'pays' => $cellierVin->vin->pays,
            'region' => $cellierVin->vin->region,
            'format' => $cellierVin->vin->format,
            'annee' => $cellierVin->vin->annee,
            'image' => $cellierVin->vin->image_url,
            'couleur' => $cellierVin->vin->couleur,
            'quantite' => $cellierVin->quantite,
            'cellier_nom' => $cellierVin->cellier->nom,
            'cepage' => $cellierVin->vin->cepage,
            'degre_alcool' => $cellierVin->vin->degre_alcool,
            'taux_sucre' => $cellierVin->vin->taux_sucre,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CellierVin $cellierVin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CellierVin $cellierVin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CellierVin $cellierVin)
    {
        //
    }
}
