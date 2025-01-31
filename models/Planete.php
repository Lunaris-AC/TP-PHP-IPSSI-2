<?php

namespace GalacticRace\Models;

class Planete extends CorpsCeleste
{
    private string $type;

    public const TYPES_PLANETE = ['liquide', 'solide', 'gazeux'];

    public function __construct(float $masse, int $diametre, int $demiGrandAxe, float $vitesse, string $nom, string $type)
    {
        if (!in_array($type, self::TYPES_PLANETE)) {
            throw new \InvalidArgumentException("Le type de planète doit être 'liquide', 'solide' ou 'gazeux'.");
        }
        parent::__construct($masse, $diametre, $demiGrandAxe, $vitesse, $nom);
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
