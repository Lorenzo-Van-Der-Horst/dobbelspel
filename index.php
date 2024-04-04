<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dobbelspel</title>
    <style>
        .dice-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Dobbelspel</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="numberOfDice">Aantal dobbelstenen (1-6):</label>
        <input type="number" id="numberOfDice" name="numberOfDice" min="1" max="6" value="1">
        <input type="submit" value="Werp de dobbelstenen">
    </form>
    <h2>Resultaat:</h2>
    <?php
    require_once 'Game.php';
    session_start();

    // Controleer of het spel al is gestart en installeer de Game
    if (!isset($_SESSION['game'])) {
        $_SESSION['game'] = new Game();
    }

    // Als het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Haal het aantal dobbelstenen op van het formulier
        $numberOfDice = $_POST['numberOfDice'];

        // Speel het spel en haal het resultaat op
        $result = $_SESSION['game']->play($numberOfDice);

        // Toon het resultaat van elke worp als afbeeldingen van dobbelstenen
        echo "Worp " . $_SESSION['game']->getThrowCount() . ": ";
        if (!empty($result)) {
            foreach ($result as $diceValue) {
                echo "<img src='dice$diceValue.png' alt='Dobbelsteen met $diceValue ogen' class='dice-image'>";
            }
        }
        echo "<br/>";

        // Als de derde worp is bereikt, toon de totale waarde en voeg deze toe aan het scoreboard
        if ($_SESSION['game']->getThrowCount() == 3) {
            $totalValue = $_SESSION['game']->getTotalValue();
            echo "Totale waarde van alle worpen: $totalValue<br/>";
            $scoreboard = isset($_SESSION['scoreboard']) ? $_SESSION['scoreboard'] : [];
            array_push($scoreboard, $totalValue);
            arsort($scoreboard);
            $scoreboard = array_slice($scoreboard, 0, 5);
            $_SESSION['scoreboard'] = $scoreboard;
        }
    }

    // Toon altijd het scoreboard
    echo "<h2>Scoreboard:</h2>";
    $scoreboard = isset($_SESSION['scoreboard']) ? $_SESSION['scoreboard'] : [];
    echo "<ol>";
    foreach ($scoreboard as $score) {
        echo "<li>$score</li>";
    }
    echo "</ol>";
    ?>
</body>
</html>
