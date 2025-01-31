<?php

namespace GalacticRace\Models;

abstract class CorpsCeleste
{
    protected float $masse;
    protected int $diametre;
    protected int $demiGrandAxe;
    protected float $vitesse;
    protected string $nom;

    public function __construct(float $masse, int $diametre, int $demiGrandAxe, float $vitesse, string $nom)
    {
        if ($masse < 0 || $masse > 1) {
            throw new \InvalidArgumentException("La masse doit être un flottant non signé entre 0 et 1.");
        }
        if ($diametre < 0) {
            throw new \InvalidArgumentException("Le diamètre doit être un entier non signé.");
        }
        if ($demiGrandAxe < 0) {
            throw new \InvalidArgumentException("Le demi-grand axe doit être un entier non signé.");
        }
        if ($vitesse < 0) {
            throw new \InvalidArgumentException("La vitesse doit être un flottant non signé.");
        }

        $this->masse = $masse;
        $this->diametre = $diametre;
        $this->demiGrandAxe = $demiGrandAxe;
        $this->vitesse = $vitesse;
        $this->nom = $nom;
    }

    public function getMasse(): float
    {
        return $this->masse;
    }

    public function getDiametre(): int
    {
        return $this->diametre;
    }

    public function getDemiGrandAxe(): int
    {
        return $this->demiGrandAxe;
    }

    public function getVitesse(): float
    {
        return $this->vitesse;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    abstract public function getType(): string;

    public function calculerAvancementOrbital(int $dureeEnAnnees): float
    {
        // Formule simplifiée : distance parcourue = vitesse * temps
        // Périmètre de l'orbite (approximation circulaire) : 2 * pi * demiGrandAxe (en millions de km)
        // Fraction de l'orbite parcourue = distance parcourue / périmètre de l'orbite

        $distanceParcourue = $this->vitesse * ($dureeEnAnnees * 365 * 24); // en milliers de km
        $perimetreOrbital = 2 * pi() * $this->demiGrandAxe * 1000000; // en km (on ajuste demiGrandAxe en km)
        $perimetreOrbitalEnMilliersKm = $perimetreOrbital / 1000;

        if ($perimetreOrbitalEnMilliersKm <= 0) {
            return 0; // Éviter la division par zéro si demiGrandAxe est nul (bien que non autorisé par les contraintes)
        }

        return $distanceParcourue / $perimetreOrbitalEnMilliersKm;
    }
}
