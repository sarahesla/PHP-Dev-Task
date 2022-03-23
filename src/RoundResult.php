<?php
/**
 * Contains code relating to the RoundResult.
 * 
 * @author Sarah Eslamdoust
 */

/**
 * Represents a Round Result.
 */
if(!class_exists("RoundResult")){
    class RoundResult {
        
        /**
         * @var int representing the round of the race
         */
        public $step;

        /**
         * @var array contains Car positions
         */
        public $carsPosition;

        /**
         * Initializes a RoundResult object.
         */
        public function __construct(int $step, array $carsPosition)
        {
            $this->step = $step;
            $this->carsPosition = $carsPosition;
        }

        /**
         * Returns the $carsPosition array.
         * 
         * @return array $carsPosition
         */
        public function getCarsPosition(): array {
            return $this->carsPosition;
        }
    }
}
