<?php

// Set the directory to scan
$dir = "./invoices";

// Get array of filenames
$filesInDir = scandir($dir);

// Print the array
echo "<pre>";
// print_r($filesInDir);

// split into multidimensional array
$separatedFiles = array();
foreach ($filesInDir as $file) {
    $separatedFiles[] = explode(" ", $file);
}

// remove the first two blank entries
unset($separatedFiles[0], $separatedFiles[1]);

// print_r($separatedFiles);

$file = fopen('entries.csv', 'w');

foreach ($separatedFiles as $row) {
    fputcsv($file, $row);
}

fclose($file);