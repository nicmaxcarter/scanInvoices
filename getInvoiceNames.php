<?php

// Set the directory to scan
$dir = "invoices";

// Get array of filenames
$filesInDir = scandir($dir);

// Print the array
echo "<pre>";
print_r($filesInDir);