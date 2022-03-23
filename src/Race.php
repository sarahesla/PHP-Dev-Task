<?php
/**
 * Contains code related to the Race simulation.
 * 
 * @author Sarah Eslamdoust
 */
include("Car.php");
include("TrackElement.php");
include("RaceResult.php");
include("RoundResult.php");
include("TrackElementType.php");

/**
 * Represents a Race object; defines the simulation of a race.
 */
if(!class_exists("Race")){
    class Race
    {  
        /**
         * A constant representing the total length of a Race.
         */
        const RACE_LENGTH = 2000;

        /**
         * A constant representing the length of a track element.
         */
        const TRACK_ELEMENT_LENGTH = 40;

        /**
         * A constant representing the number of track elements in a track.
         * Ex. a race of length 2000 has 50 track elements if each element is 40 long.
         */
        const NUM_TRACK_ELEMENTS = self::RACE_LENGTH / self::TRACK_ELEMENT_LENGTH;

        /**
         * A constant representing the probability of a Straight vs Curve track being generated.
         */
        const TRACK_PROBABILITY = 50;

        /**
         * A constant representing the number of Cars in a Race.
         */
        const NUM_CARS = 5;

        /**
         * @var array containing Car objects.
         */
        private $carsArray;

        /**
         * @var array containing TrackElement objects, representing the racetrack.
         */
        private $trackArray;

        /**
         * Constructs/Initializes a Race object.
         */
        public function __construct() {
            $this->carsArray = $this->generateCars();
            $this->trackArray = $this->generateTrack();
        }

        /**
         * Populates the Race with Cars.
         * 
         * @return  array    $carArray      Contains Car objects
         */
        private function generateCars(): array {
            for ($i = 0; $i < self::NUM_CARS; $i++) {
                $carArray[$i] = new Car();
            }

            return $carArray;
        }

        /**
         * Creates a track for the Race. A track is an array consisting of 
         * TrackElement objects.
         * 
         * @return  array   $trackArray     Contains TrackElement objects
         */
        private function generateTrack(): array {
            for ($i = 0; $i < self::NUM_TRACK_ELEMENTS; $i++) {
                $trackType = $this->randomizeTrackType();
                $trackArray[$i] = new TrackElement($trackType);
            }

            return $trackArray;
        }

        /**
         * Generates Track Elements at random based on a 50-50 probability.
         * 
         * @return  int     0 or 1 representing a STRAIGHT track or CURVE track
         */
        private function randomizeTrackType(): int {
            $randomNumber = rand(1, 100);

            return $randomNumber <= self::TRACK_PROBABILITY ? TrackElementType::STRAIGHT : TrackElementType::CURVE; 
        }  

        /**
         * Takes a position and returns the index of $trackArray the car is on.
         * 
         * @param   int     $position       The position of a Car object
         * @return  int     $trackIndex     The index of the track in the Race's $trackArray
         */
        private function getCurrentTrackIndex($position): int {
            $trackIndex = (int)($position / self::TRACK_ELEMENT_LENGTH);

            return $trackIndex;
        }

        /**
         * Determines the distance a Car is from the next unit of track (element of $trackArray).
         * 
         * @param  int  $position                   The position of a Car object
         * @return int  $distanceToNextTrackElement The distance to the next track piece
         */
        private function getDistanceToNextTrackElement($position): int {
            $distanceFromTrackElementStart = $position % self::TRACK_ELEMENT_LENGTH;
            $distanceToNextTrackElement = self::TRACK_ELEMENT_LENGTH - $distanceFromTrackElementStart;
            return $distanceToNextTrackElement;
        }

        /**
         * Gets the type of the next piece of track.
         * 
         * @param   int     $currentTrackID The ID of the current track
         * @return  int     (0 or 1) representing a STRAIGHT or CURVE track
         */
        private function getNextTrackElementType($currentTrackID): int {
            // check if there's another track to proceed to
            // if yes, return the type
            if ($currentTrackID < self::NUM_TRACK_ELEMENTS - 1) {
                $nextElement = $this->trackArray[$currentTrackID + 1];
                return $nextElement->getElementType();
            }
            
            // otherwise, use the current element type so the cars can continue past
            // the finish line with no issues
            return $this->trackArray[$currentTrackID]->getElementType();
        }

        /**
         * Defines the logic for moving a car based on the rules of the Race.
         * 
         * @param   Car     $car    A Car object
         * @return  int             The new position of the Car object
         */
        private function moveCar($car): int {
            $carPosition = $car->getPosition();
            $currentTrackID = $this->getCurrentTrackIndex($carPosition);
            $currentTrackElement = $this->trackArray[$currentTrackID];
            $currentTrackElementType = $currentTrackElement->getElementType();
            $carSpeed = $car->getSpeed($currentTrackElementType);

            $nextTrackElementType = $this->getNextTrackElementType($currentTrackID);
            $distanceToNextTrackElement = $this->getDistanceToNextTrackElement($carPosition);

            if (($currentTrackElementType !== $nextTrackElementType) && 
                ($carSpeed >= $distanceToNextTrackElement)) {
                    $newPosition = $carPosition + $distanceToNextTrackElement;
            }

            else {
                $newPosition = $carPosition + $carSpeed;
            }

            $car->setPosition($newPosition);

            return $car->getPosition();
        }

        /**
         * Checks if any of the Cars have reached the end of the race.
         * 
         * @param   array   $positionArray  Contains the positons of the Cars
         * @return  bool    $raceEnd        TRUE if yes, FALSE if no
         */
        private function checkRaceEnd($positionArray): bool {
            for ($i = 0; $i < self::NUM_CARS; $i++) {
                if ($positionArray[$i] >= self::RACE_LENGTH) {
                    $raceEnd = TRUE;
                    break;
                }
                else {
                    $raceEnd = FALSE;
                }
            }
            return $raceEnd;
        }

        /**
         * Runs a round of racing, creates a RoundResult object 
         * containing the results of the round.
         * 
         * @param   int         $roundNumber    The round of the Race.
         * @return  RoundResult $roundResult    Contains the results of the round.
         */
        private function runRound($roundNumber): RoundResult 
        {
            for ($i = 0; $i < self::NUM_CARS; $i++) {
                $positionArray[$i] = $this->moveCar($this->carsArray[$i]);
            }

            $roundResult = new RoundResult($roundNumber, $positionArray);

            return $roundResult;
        }

        /**
         * Runs a Race.
         * Creates a RaceResult object containing an array of RoundResults.
         * 
         * @return  RaceResult  $raceResult     Contains an array of RoundResults
         */
        public function runRace(): RaceResult
        {
            $raceEnd = FALSE;
            $roundNumber = 1;

            $raceResult = new RaceResult();

            while (!$raceEnd) {
                $roundResult = $this->runRound($roundNumber);
                $raceResult->addRoundResult($roundResult);
                $raceEnd = $this->checkRaceEnd($roundResult->getCarsPosition());
                $roundNumber++;
            }

            return $raceResult;
        }
    }
}