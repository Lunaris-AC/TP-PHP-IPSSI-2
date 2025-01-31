#!/bin/bash

# Création des dossiers
mkdir -p controllers
mkdir -p decorators
mkdir -p factories
mkdir -p models
mkdir -p utils
mkdir -p views
mkdir -p public/css

# Création des fichiers et ajout du contenu

# utils/RandomStringGenerator.php (CORRIGÉ !)
cat > utils/RandomStringGenerator.php <<EOL
<?php

namespace GalacticRace\Utils;

class RandomStringGenerator
{
    public static function generateRandomString(int \$length = 10): string
    {
        \$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        \$charactersLength = strlen(\$characters);
        \$randomString = '';
        for (\$i = 0; \$i < \$length; \$i++) {
            \$randomIndex = rand(0, \$charactersLength - 1); // Générer un index aléatoire
            \$randomString .= \$characters[\$randomIndex];      // Utiliser l'index aléatoire pour choisir un caractère
        }
        return \$randomString;
    }
}
EOL

# models/CorpsCeleste.php
cat > models/CorpsCeleste.php <<EOL
<?php

namespace GalacticRace\Models;

abstract class CorpsCeleste
{
    protected float \$masse;
    protected int \$diametre;
    protected int \$demiGrandAxe;
    protected float \$vitesse;
    protected string \$nom;

    public function __construct(float \$masse, int \$diametre, int \$demiGrandAxe, float \$vitesse, string \$nom)
    {
        if (\$masse < 0 || \$masse > 1) {
            throw new \InvalidArgumentException("La masse doit être un flottant non signé entre 0 et 1.");
        }
        if (\$diametre < 0) {
            throw new \InvalidArgumentException("Le diamètre doit être un entier non signé.");
        }
        if (\$demiGrandAxe < 0) {
            throw new \InvalidArgumentException("Le demi-grand axe doit être un entier non signé.");
        }
        if (\$vitesse < 0) {
            throw new \InvalidArgumentException("La vitesse doit être un flottant non signé.");
        }

        \$this->masse = \$masse;
        \$this->diametre = \$diametre;
        \$this->demiGrandAxe = \$demiGrandAxe;
        \$this->vitesse = \$vitesse;
        \$this->nom = \$nom;
    }

    public function getMasse(): float
    {
        return \$this->masse;
    }

    public function getDiametre(): int
    {
        return \$this->diametre;
    }

    public function getDemiGrandAxe(): int
    {
        return \$this->demiGrandAxe;
    }

    public function getVitesse(): float
    {
        return \$this->vitesse;
    }

    public function getNom(): string
    {
        return \$this->nom;
    }

    abstract public function getType(): string;

    public function calculerAvancementOrbital(int \$dureeEnAnnees): float
    {
        // Formule simplifiée : distance parcourue = vitesse * temps
        // Périmètre de l'orbite (approximation circulaire) : 2 * pi * demiGrandAxe (en millions de km)
        // Fraction de l'orbite parcourue = distance parcourue / périmètre de l'orbite

        \$distanceParcourue = \$this->vitesse * (\$dureeEnAnnees * 365 * 24); // en milliers de km
        \$perimetreOrbital = 2 * pi() * \$this->demiGrandAxe * 1000000; // en km (on ajuste demiGrandAxe en km)
        \$perimetreOrbitalEnMilliersKm = \$perimetreOrbital / 1000;

        if (\$perimetreOrbitalEnMilliersKm <= 0) {
            return 0; // Éviter la division par zéro si demiGrandAxe est nul (bien que non autorisé par les contraintes)
        }

        return \$distanceParcourue / \$perimetreOrbitalEnMilliersKm;
    }
}
EOL

# models/Planete.php
cat > models/Planete.php <<EOL
<?php

namespace GalacticRace\Models;

class Planete extends CorpsCeleste
{
    private string \$type;

    public const TYPES_PLANETE = ['liquide', 'solide', 'gazeux'];

    public function __construct(float \$masse, int \$diametre, int \$demiGrandAxe, float \$vitesse, string \$nom, string \$type)
    {
        if (!in_array(\$type, self::TYPES_PLANETE)) {
            throw new \InvalidArgumentException("Le type de planète doit être 'liquide', 'solide' ou 'gazeux'.");
        }
        parent::__construct(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom);
        \$this->type = \$type;
    }

    public function getType(): string
    {
        return \$this->type;
    }
}
EOL

# models/Asteroide.php
cat > models/Asteroide.php <<EOL
<?php

namespace GalacticRace\Models;

class Asteroide extends CorpsCeleste
{
    private string \$type = 'solide'; // Type fixe pour les astéroïdes

    public function __construct(float \$masse, int \$diametre, int \$demiGrandAxe, float \$vitesse, string \$nom)
    {
        parent::__construct(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom);
    }

    public function getType(): string
    {
        return \$this->type;
    }
}
EOL

# models/Comete.php
cat > models/Comete.php <<EOL
<?php

namespace GalacticRace\Models;

class Comete extends CorpsCeleste
{
    private string \$type = 'solide'; // Type fixe pour les comètes

    public function __construct(float \$masse, int \$diametre, int \$demiGrandAxe, float \$vitesse, string \$nom)
    {
        parent::__construct(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom);
    }

    public function getType(): string
    {
        return \$this->type;
    }
}
EOL

# models/PlaneteNaine.php
cat > models/PlaneteNaine.php <<EOL
<?php

namespace GalacticRace\Models;

class PlaneteNaine extends CorpsCeleste
{
    private string \$type;

    public const TYPES_PLANETE_NAINE = ['liquide', 'solide', 'gazeux'];

    public function __construct(float \$masse, int \$diametre, int \$demiGrandAxe, float \$vitesse, string \$nom, string \$type)
    {
        if (!in_array(\$type, self::TYPES_PLANETE_NAINE)) {
            throw new \InvalidArgumentException("Le type de planète naine doit être 'liquide', 'solide' ou 'gazeux'.");
        }
        parent::__construct(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom);
        \$this->type = \$type;
    }

    public function getType(): string
    {
        return \$this->type;
    }
}
EOL

# factories/CelestialBodyFactory.php
cat > factories/CelestialBodyFactory.php <<EOL
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
        \$types = ['Planete', 'Asteroide', 'Comete', 'PlaneteNaine'];
        \$randomType = \$types[array_rand(\$types)];

        \$nom = RandomStringGenerator::generateRandomString(8);
        \$demiGrandAxe = rand(1, 1000);
        \$vitesse = lcg_value() * (100 - 10) + 10; // Flottant entre 10 et 100
        \$masse = lcg_value(); // Flottant entre 0 et 1
        \$diametre = rand(1, 100000);

        switch (\$randomType) {
            case 'Planete':
                \$typePlanete = Planete::TYPES_PLANETE[array_rand(Planete::TYPES_PLANETE)];
                return new Planete(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom, \$typePlanete);
            case 'Asteroide':
                return new Asteroide(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom);
            case 'Comete':
                return new Comete(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom);
            case 'PlaneteNaine':
                \$typePlaneteNaine = PlaneteNaine::TYPES_PLANETE_NAINE[array_rand(PlaneteNaine::TYPES_PLANETE_NAINE)];
                return new PlaneteNaine(\$masse, \$diametre, \$demiGrandAxe, \$vitesse, \$nom, \$typePlaneteNaine);
            default:
                throw new \Exception("Type de corps céleste inconnu.");
        }
    }
}
EOL

# controllers/CourseController.php
cat > controllers/CourseController.php <<EOL
<?php

namespace GalacticRace\Controllers;

use GalacticRace\Factories\CelestialBodyFactory;
use GalacticRace\Decorators\StartGridDecorator;
use GalacticRace\Decorators\ResultsDecorator;

class CourseController
{
    private array \$participants = [];
    private int \$dureeCourse;

    public function __construct()
    {
        // Générer 10 corps célestes aléatoirement
        for (\$i = 0; \$i < 10; \$i++) {
            \$this->participants[] = CelestialBodyFactory::createRandomCelestialBody();
        }
        \$this->dureeCourse = rand(1, 100); // Durée aléatoire de la course (1 à 100 ans)
    }

    public function runCourse(): array
    {
        \$resultats = [];
        foreach (\$this->participants as \$participant) {
            \$toursOrbital = \$participant->calculerAvancementOrbital(\$this->dureeCourse);
            \$resultats[] = [
                'participant' => \$participant,
                'tours' => \$toursOrbital,
            ];
        }

        // Tri des résultats par nombre de tours (décroissant)
        usort(\$resultats, function (\$a, \$b) {
            return \$b['tours'] <=> \$a['tours'];
        });

        return \$resultats;
    }

    public function getStartGridData(): array
    {
        \$participantsGrille = \$this->participants;

        // Tri selon les critères : orbite (demiGrandAxe), vitesse, nom
        usort(\$participantsGrille, function (\$a, \$b) {
            if (\$a->getDemiGrandAxe() !== \$b->getDemiGrandAxe()) {
                return \$a->getDemiGrandAxe() <=> \$b->getDemiGrandAxe(); // Orbite croissante
            }
            if (\$b->getVitesse() !== \$a->getVitesse()) {
                return \$b->getVitesse() <=> \$a->getVitesse(); // Vitesse décroissante
            }
            return strcmp(\$a->getNom(), \$b->getNom()); // Nom alphabétique
        });

        return \$participantsGrille;
    }


    public function getResultsData(array \$resultats): array
    {
        return array_slice(\$resultats, 0, 3); // Retourne les 3 premiers
    }

    public function getParticipants(): array {
        return \$this->participants;
    }
}
EOL

# decorators/StartGridDecorator.php
cat > decorators/StartGridDecorator.php <<EOL
<?php

namespace GalacticRace\Decorators;

use GalacticRace\Controllers\CourseController;

class StartGridDecorator
{
    private CourseController \$courseController;

    public function __construct(CourseController \$courseController)
    {
        \$this->courseController = \$courseController;
    }

    public function display(): array
    {
        return \$this->courseController->getStartGridData(); // Retourne les données, ne fait plus d'affichage direct
    }
}
EOL

# decorators/ResultsDecorator.php
cat > decorators/ResultsDecorator.php <<EOL
<?php

namespace GalacticRace\Decorators;

use GalacticRace\Controllers\CourseController;

class ResultsDecorator
{
    private CourseController \$courseController;
    private array \$results;

    public function __construct(CourseController \$courseController, array \$results)
    {
        \$this->courseController = \$courseController;
        \$this->results = \$results;
    }

    public function display(): array
    {
        return \$this->courseController->getResultsData(\$this->results); // Retourne les données
    }
}
EOL

# views/header.php
cat > views/header.php <<EOL
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Galactique</title>
    <link href="./public/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-4">La Course Galactique</h1>
EOL

# views/footer.php
cat > views/footer.php <<EOL
    </div>
</body>
</html>
EOL

# views/start_grid.php
cat > views/start_grid.php <<EOL
<section class="mb-8">
    <h2 class="text-2xl font-bold mb-2">Grille de Départ</h2>
    <ul class="list-decimal pl-5">
    <?php foreach (\$participants as \$index => \$participant): ?>
        <?php
            \$classeNom = (new \ReflectionClass(\$participant))->getShortName();
            \$type = \$participant->getType();
            \$determinant = in_array(\$classeNom, ['Asteroide', 'Comete']) ? "un" : "une";
        ?>
        <li class="mb-1">
            Le <?= \$index + 1 ?>ème participant <span class="font-semibold"><?= htmlspecialchars(\$participant->getNom()) ?></span> est <?= \$determinant ?> <?= htmlspecialchars(\$classeNom) ?> de type <?= htmlspecialchars(\$type) ?>.
        </li>
    <?php endforeach; ?>
    </ul>
</section>
EOL

# views/results.php
cat > views/results.php <<EOL
<section>
    <h2 class="text-2xl font-bold mb-2">Résultats de la Course</h2>
    <ol class="list-decimal pl-5">
    <?php foreach (\$resultats as \$index => \$resultat): ?>
        <?php
            \$participant = \$resultat['participant'];
            \$tours = round(\$resultat['tours'], 2);
            \$classeNom = (new \ReflectionClass(\$participant))->getShortName();
            \$type = \$participant->getType();
            \$podiumNoms = ["vainqueur", "lauréat de la médaille d'argent", "troisième candidat sur le podium"];
            \$podiumDeterminants = ["le", "le", "le"];
            \$podiumPronoms = ["grand", "talentueux", "vénérable"];
            \$determinant = in_array(\$classeNom, ['Asteroide', 'Comete']) ? "un" : "une";
            \$pronom = \$podiumPronoms[\$index];
        ?>
        <li class="mb-2">
            <?= \$podiumDeterminants[\$index] ?> <span class="font-semibold"><?= \$podiumNoms[\$index] ?></span> est <?= \$determinant ?> <?= htmlspecialchars(\$classeNom) ?> de type <?= htmlspecialchars(\$type) ?>,
            <span class="font-semibold"><?= htmlspecialchars(\$participant->getNom()) ?></span>, il a effectué <span class="font-semibold"><?= \$tours ?></span> tours d'orbite.
        </li>
    <?php endforeach; ?>
    </ol>
</section>
EOL

# index.php
cat > index.php <<EOL
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
\$courseController = new CourseController();

// Récupération des données pour la grille de départ
//\$startGridDecorator = new StartGridDecorator(\$courseController); // Plus nécessaire, on appelle directement le controller
//\$participantsGrille = \$startGridDecorator->display();
\$participants = \$courseController->getStartGridData(); // VARIABLE RENOMMÉE ICI !

// Déroulement de la course et récupération des résultats
\$resultatsCourse = \$courseController->runCourse();

// Récupération des données pour les résultats
//\$resultsDecorator = new ResultsDecorator(\$courseController, \$resultatsCourse); // Plus nécessaire, on appelle directement le controller
//\$top3Resultats = \$resultsDecorator->display();
\$top3Resultats = \$courseController->getResultsData(\$resultatsCourse);


// Inclusion des vues
require_once __DIR__ . '/views/header.php';
require_once __DIR__ . '/views/start_grid.php';

// On passe directement \$top3Resultats car getResultsData retourne déjà les 3 premiers
\$resultats = \$top3Resultats;
require_once __DIR__ . '/views/results.php';
require_once __DIR__ . '/views/footer.php';
EOL

# author.txt
cat > author.txt <<EOL
votre_nom votre_prenom
EOL

# tailwind.config.js
cat > tailwind.config.js <<EOL
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.php", "./**/*.php", "./views/**/*.php"], // Indique où Tailwind doit scanner les classes CSS
  theme: {
    extend: {},
  },
  plugins: [],
}
EOL

# postcss.config.js
cat > postcss.config.js <<EOL
module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
}
EOL

# package.json
cat > package.json <<EOL
{
  "name": "galactic-race",
  "version": "1.0.0",
  "description": "",
  "main": "index.php",
  "scripts": {
    "build-css": "tailwindcss -i ./public/css/input.css -o ./public/css/style.css --watch"
  },
  "keywords": [],
  "author": "",
  "license": "ISC",
  "devDependencies": {
    "autoprefixer": "^10.4.17",
    "postcss": "^8.4.35",
    "tailwindcss": "^3.4.1"
  }
}
EOL

# public/css/input.css
cat > public/css/input.css <<EOL
@tailwind base;
@tailwind components;
@tailwind utilities;
EOL

echo "Projet Galactic Race créé avec succès !"
echo "N'oubliez pas de remplacer 'votre_nom votre_prenom' dans author.txt par vos informations."
echo "Pour installer les dépendances Node.js et construire les CSS Tailwind, exécutez:"
echo "npm install && npm run build-css"