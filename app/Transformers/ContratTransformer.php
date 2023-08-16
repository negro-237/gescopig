<?php
namespace App\Transformers;

use App\Models\Contrat;
use League\Fractal\TransformerAbstract;


class EnseignementTransformer extends TransformerAbstract{
    protected $availableIncludes = [
        'apprenants',
        'specialites',
        'villes'
    ];

    public function transform(Enseignement $enseignement){
        return[
            'apprenant_id' => $contrat->apprenant->nom,
            'specialite_id' => $contrat->specialite->slug. ' ' .$contrat->cycle->niveau,
            'ville_id' => $contrat->ville->nom,
            'academic_year_id' => $contrat->academic_year->debut. '/' .$contrat->academic_year->fin,
            /*
            'dateDebutPrevue' => $enseignement->dateDebutPrevue->format('d/m/y'),
            'dateDebutEff' => $enseignement->dateDebutEff->format('d/m/y'),
            'dateFinPrevue' => $enseignement->dateFinPrevue->format('d/m/y'),
            'dateFinEff' => $enseignement->dateFinEff->format('d/m/y'),
            'mhTotal' => (int)$enseignement->mhTotal,
            'mhEff' => (int)$enseignement->mhEff,
            'mhSemaine' => (int) $enseignement->mhSemaine,
            */
        ];
    }
}