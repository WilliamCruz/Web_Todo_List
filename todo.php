<?php
//William Cruz
//5/31/14
//Building Todo List - building a todo list in php
//Completing exercise

// Create array to hold list of todo items
$items = array();

function sort_menu($items) {
    echo '(A)-Z, (Z)-A, (O)rder Entered, (R)everse order entered: ';
    $input = trim(fgets(STDIN));

    if ($input == 'A' || $input == 'a') {
        sort($items);
        // break;
    } elseif ($input == 'Z' || $input == 'z') {
        rsort($items);
        // break;
    } elseif ($input == 'O' || $input == 'o') {
        ksort($items);
        // break;
    } elseif ($input == 'R' || $input == 'r') {
        krsort($items);
        // break;
    }
    return $items;
}
do {
    // Iterate through list items
    foreach ($items as $key => $item){ 
    $key++;
    echo "[{$key}] {$item}\n";
    }
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort, (Q)uit : ';
    // Get the input from user and Use trim() to remove whitespace and newlines
    $input = trim(fgets(STDIN));
    // Check for actionable input
    if ($input == 'N' || $input == 'n') {
    // Ask for entry
        echo 'Enter item: ';
    // Add entry to list array
        $items[] = trim(fgets(STDIN));
    } elseif ($input == 'R' || $input == 'r') {
    // Remove item?
        echo 'Enter item number to remove: ';
    // Get array key
        $key = trim(fgets(STDIN));
        $key--;
        unset($items[$key]);
        $items = array_values($items);
    // Remove from array
    } elseif ($input == 'S' || $input == 's') {
        sort_menu(); 
    }
    // array_unshift($items)      
} while ($input != 'Q' && $input != 'q'); 
echo "Goodbye!\n";
//exit the loop!
exit(0);