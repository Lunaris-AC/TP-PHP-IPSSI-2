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

    public function display(): array
    {
        return $this->courseController->getStartGridData(); // Retourne les données, ne fait plus d'affichage direct
    }
}
