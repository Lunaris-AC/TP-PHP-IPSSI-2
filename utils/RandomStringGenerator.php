<?php

namespace GalacticRace\Utils;

class RandomStringGenerator
{
    public static function generateRandomString(int $length = 10): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, $charactersLength - 1); // Générer un index aléatoire
            $randomString .= $characters[$randomIndex];      // Utiliser l'index aléatoire pour choisir un caractère
        }
        return $randomString;
    }
}
