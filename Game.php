<?php

require_once 'Dice.php';

class Game {
    private $dice;
    private $throwCount;
    private $totalValue;
    private $maxThrows;
    private $countForTotal;

    public function __construct() {
        $this->dice = new Dice();
        $this->throwCount = 0;
        $this->totalValue = 0;
        $this->maxThrows = 3;
        $this->countForTotal = 0;
    }

    public function play($numberOfDice) {
        $results = [];

        // Voer de worpen uit
        for ($i = 0; $i < $numberOfDice; $i++) {
            $this->dice->throwDice();
            $results[] = $this->dice->getFaceValue();
            $this->totalValue += $results[$i];
        }

        // Verhoog het aantal worpen
        $this->throwCount++;

        // Controleer of we binnen de eerste drie worpen zijn voor het berekenen van het totaal
        if ($this->throwCount <= $this->maxThrows) {
            $this->countForTotal++;
        }

        // Reset de worpteller als het maximumaantal worpen is bereikt
        if ($this->throwCount > $this->maxThrows) {
            $this->throwCount = 1;
            $this->countForTotal = 1;
            $this->totalValue = 0; // Reset het totaal na drie worpen
        }

        return $results;
    }

    public function getThrowCount() {
        return $this->throwCount;
    }

    public function getTotalValue() {
        if ($this->countForTotal > $this->maxThrows) {
            return 0; // Geef 0 terug als we voorbij de eerste drie worpen zijn
        }
        return $this->totalValue;
    }
}

?>
