<?php

namespace GalacticRace\Decorators;

use GalacticRace\Controllers\CourseController;

class ResultsDecorator
{
    private CourseController $courseController;
    private array $results;

    public function __construct(CourseController $courseController, array $results)
    {
        $this->courseController = $courseController;
        $this->results = $results;
    }

    public function display(): string // Retourne du HTML
    {
        $top3Resultats = $this->courseController->getResultsData($this->results);
        $output = "<section>
            <h2 class='text-2xl font-bold mb-2'>Résultats de la Course</h2>
            <ol class='list-decimal pl-5'>";
        $podiumNoms = ["vainqueur", "lauréat de la médaille d'argent", "troisième candidat sur le podium"];
        $podiumDeterminants = ["le", "le", "le"];
        $podiumPronoms = ["grand", "talentueux", "vénérable"];
        $participantColors = ['blue', 'red', 'green', 'orange', 'purple', 'cyan', 'magenta', 'lime', 'teal', 'brown']; // Palette de couleurs (DOIT CORRESPONDRE À game.js et index.php)


        foreach ($top3Resultats as $index => $resultat) {
            $participant = $resultat['participant'];
            $tours = round($resultat['tours'], 2);
            $classeNom = (new \ReflectionClass($participant))->getShortName();
            $type = $participant->getType();
            $determinant = in_array($classeNom, ['Asteroide', 'Comete']) ? "un" : "une";
            $pronom = $podiumPronoms[$index];
            $color = $participantColors[$index % count($participantColors)]; // Récupérer la couleur

            $output .= "<li class='mb-2'>
                " . $podiumDeterminants[$index] . " <span class='font-semibold'>" . $podiumNoms[$index] . "</span> est $determinant <span >" . htmlspecialchars($classeNom) . "</span> de type " . htmlspecialchars($type) . ",
                <span class='font-semibold'><span style='color: " . htmlspecialchars($color) . ";'>" . htmlspecialchars($participant->getNom()) . "</span></span>, il a effectué <span class='font-semibold'>" . $tours . "</span> tours d'orbite.
            </li>";
        }
        $output .= "</ol></section>";
        return $output;
    }
}