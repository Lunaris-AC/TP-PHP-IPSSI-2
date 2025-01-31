<?php

require_once __DIR__ . '/utils/RandomStringGenerator.php';
require_once __DIR__ . '/models/CorpsCeleste.php';
require_once __DIR__ . '/models/Planete.php';
require_once __DIR__ . '/models/Asteroide.php';
require_once __DIR__ . '/models/Comete.php';
require_once __DIR__ . '/models/PlaneteNaine.php';
require_once __DIR__ . '/factories/CelestialBodyFactory.php';
require_once __DIR__ . '/controllers/CourseController.php';
require_once __DIR__ . '/decorators/StartGridDecorator.php';
require_once __DIR__ . '/decorators/ResultsDecorator.php';

use GalacticRace\Controllers\CourseController;
use GalacticRace\Decorators\StartGridDecorator;
use GalacticRace\Decorators\ResultsDecorator;

// Initialisation de la course
$courseController = new CourseController();

// Récupération des données pour la grille de départ
$startGridDecorator = new StartGridDecorator($courseController);
$startGridHTML = $startGridDecorator->display(); // Récupérer le HTML formaté

// Déroulement de la course et récupération des résultats
$resultatsCourse = $courseController->runCourse();

// Récupération des données pour les résultats
$resultsDecorator = new ResultsDecorator($courseController, $resultatsCourse);
$resultsHTML = $resultsDecorator->display(); // Récupérer le HTML formaté

// Récupération des données pour le jeu graphique
$participantsDataForGame = $courseController->getParticipantsDataForGame();

// Générer un tableau de couleurs pour les participants (pour correspondre à game.js et decorators)
$participantColors = ['blue', 'red', 'green', 'orange', 'purple', 'cyan', 'magenta', 'lime', 'teal', 'brown'];
foreach ($participantsDataForGame as $index => &$participantData) {
    $participantData['color'] = $participantColors[$index % count($participantColors)]; // Ajouter la couleur à chaque participant
}
unset($participantData); // Rompre la référence


// Inclusion des vues
require_once __DIR__ . '/views/header.php';

echo $startGridHTML; // Affichage de la grille de départ textuelle

require_once __DIR__ . '/views/game.php'; // Affichage de la partie graphique du jeu

echo $resultsHTML; // Affichage des résultats textuels

require_once __DIR__ . '/views/footer.php';