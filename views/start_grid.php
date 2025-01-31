<section class="mb-8">
    <h2 class="text-2xl font-bold mb-2">Grille de Départ</h2>
    <ul class="list-decimal pl-5">
    <?php foreach ($participants as $index => $participant): ?>
        <?php
            $classeNom = (new \ReflectionClass($participant))->getShortName();
            $type = $participant->getType();
            $determinant = in_array($classeNom, ['Asteroide', 'Comete']) ? "un" : "une";
        ?>
        <li class="mb-1">
            Le <?= $index + 1 ?>ème participant <span class="font-semibold"><?= htmlspecialchars($participant->getNom()) ?></span> est <?= $determinant ?> <?= htmlspecialchars($classeNom) ?> de type <?= htmlspecialchars($type) ?>.
        </li>
    <?php endforeach; ?>
    </ul>
</section>
