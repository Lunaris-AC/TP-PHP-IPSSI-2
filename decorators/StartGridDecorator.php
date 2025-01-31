<?php

namespace GalacticRace\Decorators;

use GalacticRace\Controllers\CourseController;

class StartGridDecorator
{
    private CourseController $courseController;

    public function __construct(CourseController $courseController)
    {
        $this->courseController = $courseController;
    }

    public function display(): string // Retourne du HTML
    {
        $participants = $this->courseController->getStartGridData();
        $output = "<section class='mb-8'>
            <h2 class='text-2xl font-bold mb-2'>Grille de Départ</h2>
            <ul class='list-decimal pl-5'>";
        $participantColors = ['blue', 'red', 'green', 'orange', 'purple', 'cyan', 'magenta', 'lime', 'teal', 'brown']; // Palette de couleurs (DOIT CORRESPONDRE À game.js et index.php)

        foreach ($participants as $index => $participant) {
            $classeNom = (new \ReflectionClass($participant))->getShortName();
            $type = $participant->getType();
            $determinant = in_array($classeNom, ['Asteroide', 'Comete']) ? "un" : "une";
            $color = $participantColors[$index % count($participantColors)]; // Récupérer la couleur

            $output .= "<li class='mb-1'>
                Le " . ($index + 1) . "ème participant <span class='font-semibold'><span style='color: " . htmlspecialchars($color) . ";'>" . htmlspecialchars($participant->getNom()) . "</span></span> est $determinant <span >" . htmlspecialchars($classeNom) . "</span> de type " . htmlspecialchars($type) . ".
            </li>";
        }
        $output .= "</ul></section>";
        return $output;
    }
}