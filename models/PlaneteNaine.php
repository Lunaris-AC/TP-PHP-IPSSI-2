<?php

namespace GalacticRace\Models;

class PlaneteNaine extends CorpsCeleste
{
    private string $type;

    public const TYPES_PLANETE_NAINE = ['liquide', 'solide', 'gazeux'];

    public function __construct(float $masse, int $diametre, int $demiGrandAxe, float $vitesse, string $nom, string $type)
    {
        if (!in_array($type, self::TYPES_PLANETE_NAINE)) {
            throw new \InvalidArgumentException("Le type de planète naine doit être 'liquide', 'solide' ou 'gazeux'.");
        }
        parent::__construct($masse, $diametre, $demiGrandAxe, $vitesse, $nom);
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
