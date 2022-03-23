<?php
include('Race.php');

// run a race and print the results
$test = new Race;
$results = $test->runRace();
print_r($results->getRoundResults());

// printRounds($results);
// printWinners($results->getWinners());

/**
 * Prints the result of each round.
 * 
 * @param RaceResult $results a RaceResult object
 */
// function printRounds($results) {
//   $roundResults = $results->getRoundResults();
//   $counter = 1;
//   foreach($roundResults as $roundResult) {
//     print_r("<h4>Round {$roundResult->step}</h4>");
//     print_r("-----------------------");

//     $carCounter = 1;
//     foreach($roundResult->carsPosition as $carPosition) {
//       print_r("<p>Car {$carCounter} Position: {$carPosition}</p>");
//       $carCounter++;
//     }
//     print_r("\n\n");
//   }
// }

/**
 * Prints the winner(s) of the race.
 * 
 * @param array $winners an array containing the index of Car(s) that won/tied.
 */
// function printWinners($winners) {
//   print_r("<h4>FINISH!</h4>");

//   count($winners) == 1 ? print_r("WINNER: ") : print_r("TIE: ");

//   foreach($winners as $winner) {
//     $winner += 1;
//     print_r("</br>Car {$winner} ");
//   }
// }
