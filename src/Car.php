<?php
/**
 * Contains code relating to Car objects
 * 
 * @author Sarah Eslamdoust (sarah.eslamdoust@gmail.com)
 */

/**
 * Represents a Car.
 */
if(!class_exists("Car")){
    class Car {

        /**
         * A constant representing the total speed a Car can travel.
         */
        const TOTAL_SPEED = 22;

        /**
         * A constant representing the minimum speed a Car can travel on a given Track Element Type.
         */
        const MIN_SPEED = 4;

        /**
         * A constant representing the maximum speed a Car can travel on a given Track Element Type.
         */
        const MAX_SPEED = self::TOTAL_SPEED - self::MIN_SPEED;

        /**
         * @var array containing the Car's speeds on different track types.
         */
        private $speedsArray;

        /**
         * @var int of the Car's current position on the track.
         */
        private $position;

        /**
         * Initializes a Car object.
         */
        public function __construct() {
            $this->speedsArray = $this->randomizeSpeeds();
            $this->position = 0;
        }

        /**
         * Generates random speeds for the car on either element type.
         * 
         * @return  array   $speedArray     The speeds
         */
        private function randomizeSpeeds(): array {
            $curveSpeed = rand(self::MIN_SPEED, self::MAX_SPEED);
            $straightSpeed = self::TOTAL_SPEED - $curveSpeed;

            $speedArray = array($straightSpeed, $curveSpeed);
            
            return $speedArray;
        }

        /**
         * Returns the speed of the car on a given Track Element type.
         * 
         * @param   int     $trackElementType   (0 or 1) representing the Track Element type (straight or curve)
         * @return  int     the speed of the car on that Element type
         */
        public function getSpeed(int $trackElementType): int {
            return $this->speedsArray[$trackElementType];
        }
        
        /**
         * Returns the car's current position
         * 
         * @return  int     $position
         */
        public function getPosition(): int {
            return $this->position;
        }
        
        /**
         * Sets the Car's position.
         * 
         * @param   int     $newPosition    The new position of the car
         */
        public function setPosition($newPosition) {
            $this->position = $newPosition;
        }
    }
}