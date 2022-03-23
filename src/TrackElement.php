<?php
/**
 * Contains code relating to Track Elements
 * 
 * @author Sarah Eslamdoust (sarah.eslamdoust@gmail.com)
 */

/**
 * Represents a Track Element
 */
if(!class_exists("TrackElement")){
    class TrackElement {
        
        /**
         * @var int a 0 or 1 representing the element type (curve or straght).
         */
        private $elementType;

        /**
         * Initializes a TrackElement.
         */
        public function __construct($elementType) {
            $this->elementType = $elementType;
        }

        /**
         * Returns the element type of this track.
         * 
         * @return int $elementType (0 or 1) representing straight or curve.
         */
        public function getElementType() {
            return $this->elementType;
        }

        /**
         * Sets the track element type to the specified value.
         * @param   int     $newElementType     A 0 or 1
         */
        public function setElementType($newElementType) {
            $this->elementType = $newElementType;
        }
    }
}
