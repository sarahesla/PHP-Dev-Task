<?php
/**
 * Contains code relating to the RaceResult.
 * 
 * @author Sarah Eslamdoust
 */


/**
 * Represnts a Race Result.
 */
if(!class_exists("RaceResult")){
  class RaceResult {
    
    /**
     * @var array of roundResult objects.
     */
    private $roundResults = [];

    /**
     * Returns the object's roundResults array
     * 
     * @return array $roundResults
     */
    public function getRoundResults(): array
    {
        return $this->roundResults;
    }

    /**
     * Adds a RoundResult object to the object's roundResult array.
     * 
     * @param RoundResult $newRoundResult   A RoundResult object
     */
    public function addRoundResult($newRoundResult) {
        array_push($this->roundResults, $newRoundResult);
    }

    /**
     * Determines the winner(s) of a Race.
     * 
     * @return array $winners   Contains the indices of Car(s) that won/tied.
     */
    public function getWinners(): array {
      $finalRound = end($this->roundResults);
      $finalCarPositions = $finalRound->getCarsPosition();
      $winners = [];

      for ($i = 0; $i < count($finalCarPositions); $i++) {
        if ($finalCarPositions[$i] >= Race::RACE_LENGTH) {
          array_push($winners, $i);
        }
      }

      return $winners;
    }
  }
}