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

    public function display(): array
    {
        return $this->courseController->getResultsData($this->results); // Retourne les données
    }
}
