<?php

namespace GalacticRace\Controllers;

use GalacticRace\Factories\CelestialBodyFactory;
use GalacticRace\Decorators\StartGridDecorator;
use GalacticRace\Decorators\ResultsDecorator;

class CourseController
{
    private array $participants = [];
    private int $dureeCourse;

    public function __construct()
    {
        // Générer 10 corps célestes aléatoirement
        for ($i = 0; $i < 10; $i++) {
            $this->participants[] = CelestialBodyFactory::createRandomCelestialBody();
        }
        $this->dureeCourse = rand(1, 100); // Durée aléatoire de la course (1 à 100 ans)
    }

    public function runCourse(): array
    {
        $resultats = [];
        foreach ($this->participants as $participant) {
            $toursOrbital = $participant->calculerAvancementOrbital($this->dureeCourse);
            $resultats[] = [
                'participant' => $participant,
                'tours' => $toursOrbital,
            ];
        }

        // Tri des résultats par nombre de tours (décroissant)
        usort($resultats, function ($a, $b) {
            return $b['tours'] <=> $a['tours'];
        });

        return $resultats;
    }

    public function getStartGridData(): array
    {
        $participantsGrille = $this->participants;

        // Tri selon les critères : orbite (demiGrandAxe), vitesse, nom
        usort($participantsGrille, function ($a, $b) {
            if ($a->getDemiGrandAxe() !== $b->getDemiGrandAxe()) {
                return $a->getDemiGrandAxe() <=> $b->getDemiGrandAxe(); // Orbite croissante
            }
            if ($b->getVitesse() !== $a->getVitesse()) {
                return $b->getVitesse() <=> $a->getVitesse(); // Vitesse décroissante
            }
            return strcmp($a->getNom(), $b->getNom()); // Nom alphabétique
        });

        return $participantsGrille;
    }

    public function getResultsData(array $resultats): array
    {
        return array_slice($resultats, 0, 3); // Retourne les 3 premiers
    }

    // Nouvelle fonction pour obtenir les données des participants pour le graphique
    public function getParticipantsDataForGame(): array
    {
        $participantsData = [];
        foreach ($this->participants as $participant) {
            $participantsData[] = [
                'nom' => $participant->getNom(),
                'classe' => (new \ReflectionClass($participant))->getShortName(),
                'type' => $participant->getType(),
                'demiGrandAxe' => $participant->getDemiGrandAxe(),
                'vitesse' => $participant->getVitesse(),
                // On pourrait ajouter d'autres données si nécessaire pour le graphique
            ];
        }
        return $participantsData;
    }


    public function getParticipants(): array {
        return $this->participants;
    }
}
