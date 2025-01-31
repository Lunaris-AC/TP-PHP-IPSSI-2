<?php

namespace GalacticRace\Models;

class Comete extends CorpsCeleste
{
    private string $type = 'solide'; // Type fixe pour les comètes

    public function __construct(float $masse, int $diametre, int $demiGrandAxe, float $vitesse, string $nom)
    {
        parent::__construct($masse, $diametre, $demiGrandAxe, $vitesse, $nom);
    }

    public function getType(): string
    {
        return $this->type;
    }
}
