<section>
    <h2 class="text-2xl font-bold mb-2">Résultats de la Course</h2>
    <ol class="list-decimal pl-5">
    <?php foreach ($resultats as $index => $resultat): ?>
        <?php
            $participant = $resultat['participant'];
            $tours = round($resultat['tours'], 2);
            $classeNom = (new \ReflectionClass($participant))->getShortName();
            $type = $participant->getType();
            $podiumNoms = ["vainqueur", "lauréat de la médaille d'argent", "troisième candidat sur le podium"];
            $podiumDeterminants = ["le", "le", "le"];
            $podiumPronoms = ["grand", "talentueux", "vénérable"];
            $determinant = in_array($classeNom, ['Asteroide', 'Comete']) ? "un" : "une";
            $pronom = $podiumPronoms[$index];
        ?>
        <li class="mb-2">
            <?= $podiumDeterminants[$index] ?> <span class="font-semibold"><?= $podiumNoms[$index] ?></span> est <?= $determinant ?> <?= htmlspecialchars($classeNom) ?> de type <?= htmlspecialchars($type) ?>,
            <span class="font-semibold"><?= htmlspecialchars($participant->getNom()) ?></span>, il a effectué <span class="font-semibold"><?= $tours ?></span> tours d'orbite.
        </li>
    <?php endforeach; ?>
    </ol>
</section>
