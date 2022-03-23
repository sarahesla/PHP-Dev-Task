<?php
/**
 * Contains code that defines the available Track Element Types.
 * 
 * @author Sarah Eslamdoust
 */

/**
 * A final class to define Track Element Types (in lieu of an enum).
 */
if(!class_exists("TrackElementType")){
  final class TrackElementType {
    
    const STRAIGHT = 0;
    const CURVE = 1;
  
  }
}
