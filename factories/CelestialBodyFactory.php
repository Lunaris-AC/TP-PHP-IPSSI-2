<?php

namespace GalacticRace\Factories;

use GalacticRace\Models\Asteroide;
use GalacticRace\Models\Comete;
use GalacticRace\Models\Planete;
use GalacticRace\Models\PlaneteNaine;
use GalacticRace\Utils\RandomStringGenerator;

class CelestialBodyFactory
{
    public static function createRandomCelestialBody(): object
    {
        $types = ['Planete', 'Asteroide', 'Comete', 'PlaneteNaine'];
        $randomType = $types[array_rand($types)];

        $nom = RandomStringGenerator::generateRandomString(8);
        $demiGrandAxe = rand(1, 1000);
        $vitesse = lcg_value() * (100 - 10) + 10; // Flottant entre 10 et 100
        $masse = lcg_value(); // Flottant entre 0 et 1
        $diametre = rand(1, 100000);

        switch ($randomType) {
            case 'Planete':
                $typePlanete = Planete::TYPES_PLANETE[array_rand(Planete::TYPES_PLANETE)];
                return new Planete($masse, $diametre, $demiGrandAxe, $vitesse, $nom, $typePlanete);
            case 'Asteroide':
                return new Asteroide($masse, $diametre, $demiGrandAxe, $vitesse, $nom);
            case 'Comete':
                return new Comete($masse, $diametre, $demiGrandAxe, $vitesse, $nom);
            case 'PlaneteNaine':
                $typePlaneteNaine = PlaneteNaine::TYPES_PLANETE_NAINE[array_rand(PlaneteNaine::TYPES_PLANETE_NAINE)];
                return new PlaneteNaine($masse, $diametre, $demiGrandAxe, $vitesse, $nom, $typePlaneteNaine);
            default:
                throw new \Exception("Type de corps céleste inconnu.");
        }
    }
}
