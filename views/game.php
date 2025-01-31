<section class="mb-8">
    <h2 class="text-2xl font-bold mb-4 text-center">Aperçu Graphique de la Course</h2>
    <div class="relative">
        <canvas id="gameCanvas" width="800" height="600" class="border border-gray-300 bg-gray-200"></canvas>
        <div id="raceInfoText" class="absolute top-2 left-2 p-2 bg-white bg-opacity-75 rounded shadow-md">
            <!-- Informations textuelles sur la course seront affichées ici par JavaScript -->
        </div>
    </div>
</section>

<script src="./public/js/game.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const participantsData = <?php echo json_encode($participantsDataForGame); ?>; // Passer les données PHP à JavaScript
        initGame(participantsData); // Initialiser le jeu graphique avec les données
    });
</script>
