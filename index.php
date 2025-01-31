<?php

require_once __DIR__ . '/utils/RandomStringGenerator.php';
require_once __DIR__ . '/models/CorpsCeleste.php';
require_once __DIR__ . '/models/Planete.php';
require_once __DIR__ . '/models/Asteroide.php';
require_once __DIR__ . '/models/Comete.php';
require_once __DIR__ . '/models/PlaneteNaine.php';
require_once __DIR__ . '/factories/CelestialBodyFactory.php';
require_once __DIR__ . '/controllers/CourseController.php';
require_once __DIR__ . '/decorators/StartGridDecorator.php'; // Peut être supprimé
require_once __DIR__ . '/decorators/ResultsDecorator.php';  // Peut être supprimé

use GalacticRace\Controllers\CourseController;
use GalacticRace\Decorators\StartGridDecorator; // Peut être supprimé
use GalacticRace\Decorators\ResultsDecorator;  // Peut être supprimé

// Initialisation de la course
$courseController = new CourseController();

// Récupération des données pour la grille de départ
//$startGridDecorator = new StartGridDecorator($courseController); // Plus nécessaire, on appelle directement le controller
//$participantsGrille = $startGridDecorator->display();
$participants = $courseController->getStartGridData(); // VARIABLE RENOMMÉE ICI !

// Déroulement de la course et récupération des résultats
$resultatsCourse = $courseController->runCourse();

// Récupération des données pour les résultats
//$resultsDecorator = new ResultsDecorator($courseController, $resultatsCourse); // Plus nécessaire, on appelle directement le controller
//$top3Resultats = $resultsDecorator->display();
$top3Resultats = $courseController->getResultsData($resultatsCourse);


// Inclusion des vues
require_once __DIR__ . '/views/header.php';
require_once __DIR__ . '/views/start_grid.php';

// On passe directement $top3Resultats car getResultsData retourne déjà les 3 premiers
$resultats = $top3Resultats;
require_once __DIR__ . '/views/results.php';
require_once __DIR__ . '/views/footer.php';
