<?php

namespace GalacticRace\Models;

class Asteroide extends CorpsCeleste
{
    private string $type = 'solide'; // Type fixe pour les astéroïdes

    public function __construct(float $masse, int $diametre, int $demiGrandAxe, float $vitesse, string $nom)
    {
        parent::__construct($masse, $diametre, $demiGrandAxe, $vitesse, $nom);
    }

    public function getType(): string
    {
        return $this->type;
    }
}
