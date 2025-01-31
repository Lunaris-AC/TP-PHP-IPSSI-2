function initGame(participantsData) {
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const raceInfoTextDiv = document.getElementById('raceInfoText');

    const sunRadius = 50;
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;

    const orbitScale = 50; // Pixels par million de km pour le demiGrandAxe

    ctx.clearRect(0, 0, canvas.width, canvas.height); // Effacer le canvas

    const padding = 60; // Marge autour du graphique
    const chartWidth = canvas.width - 2 * padding;
    const chartHeight = canvas.height - 2 * padding;

    // Trouver les valeurs min/max pour normaliser les données
    let minDemiGrandAxe = Infinity;
    let maxDemiGrandAxe = -Infinity;
    let minVitesse = Infinity;
    let maxVitesse = -Infinity;

    participantsData.forEach(participant => {
        minDemiGrandAxe = Math.min(minDemiGrandAxe, participant.demiGrandAxe);
        maxDemiGrandAxe = Math.max(maxDemiGrandAxe, participant.demiGrandAxe);
        minVitesse = Math.min(minVitesse, participant.vitesse);
        maxVitesse = Math.max(maxVitesse, participant.vitesse);
    });

    // Ajustement pour éviter division par zéro si min/max sont identiques
    if (maxDemiGrandAxe === minDemiGrandAxe) maxDemiGrandAxe = minDemiGrandAxe + 1;
    if (maxVitesse === minVitesse) maxVitesse = minVitesse + 1;


    function drawAxes() {
        ctx.strokeStyle = 'black';
        ctx.lineWidth = 1;

        // Axe X
        ctx.beginPath();
        ctx.moveTo(padding, canvas.height - padding);
        ctx.lineTo(canvas.width - padding, canvas.height - padding);
        ctx.stroke();

        // Axe Y
        ctx.beginPath();
        ctx.moveTo(padding, canvas.height - padding);
        ctx.lineTo(padding, padding);
        ctx.stroke();

        // Légendes des axes
        ctx.fillStyle = 'black';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'top';
        ctx.fillText('Demi-grand axe (millions de km)', centerX, canvas.height - padding + 10);

        ctx.textAlign = 'right';
        ctx.textBaseline = 'middle';
        ctx.fillText('Vitesse orbitale (km/h)', padding - 10, padding);
        ctx.save();
        ctx.translate(padding - 30, centerY);
        ctx.rotate(-Math.PI / 2);
        ctx.textAlign = 'center';
        ctx.fillText('Vitesse orbitale (milliers de km/h)', 0, 0);
        ctx.restore();
    }

    function drawCelestialBodyPoint(x, y, color, participant) { // Passer l'objet participant entier
        ctx.beginPath();
        ctx.arc(x, y, 6, 0, 2 * Math.PI); // Points plus petits
        ctx.fillStyle = color;
        ctx.fill();

        ctx.fillStyle = 'black'; // Couleur du texte
        ctx.font = '10px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'top';

        let textYOffset = 8; // Espacement initial sous le point
        ctx.fillText(participant.nom, x, y + textYOffset);
        textYOffset += 12; // Espacement pour la ligne suivante
        ctx.fillText(`Type: ${participant.type}`, x, y + textYOffset);
        textYOffset += 12;
        ctx.fillText(`Axe: ${participant.demiGrandAxe}Mkm`, x, y + textYOffset);
        textYOffset += 12;
        ctx.fillText(`Vitesse: ${participant.vitesse}k/h`, x, y + textYOffset);
    }


    function updateRaceInfo() {
        raceInfoTextDiv.innerHTML = "Schéma XY : Demi-grand axe vs. Vitesse orbitale";
    }


    drawAxes(); // Dessiner les axes du graphique
    updateRaceInfo(); // Mettre à jour le texte d'information

    participantsData.forEach((participant, index) => {
        // Normaliser les valeurs pour les positionner dans le graphique
        const normalizedX = (participant.demiGrandAxe - minDemiGrandAxe) / (maxDemiGrandAxe - minDemiGrandAxe);
        const normalizedY = 1 - (participant.vitesse - minVitesse) / (maxVitesse - minVitesse); // Inverser l'axe Y pour que les vitesses plus élevées soient en haut

        const pointX = padding + normalizedX * chartWidth;
        const pointY = padding + normalizedY * chartHeight;

        const colors = ['blue', 'red', 'green', 'orange', 'purple', 'cyan', 'magenta', 'lime', 'teal', 'brown']; // Palette de couleurs
        drawCelestialBodyPoint(pointX, pointY, colors[index % colors.length], participant); // Passer l'objet participant
    });
}