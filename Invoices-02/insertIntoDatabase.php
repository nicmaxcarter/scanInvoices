<?php

// This file was used to add all old invoices submitted before the CRUD page was live.

// Get array from the csv file 'entries.csv'
$csv = array_map('str_getcsv', file('entries.csv'));

// Print the array
echo "<pre>";
// print_r($csv);

// Include config file
include "database.php";

$getEntities = 'SELECT * FROM entity';
$getTrucks = 'SELECT * FROM truck';
$getVendors = 'SELECT * FROM maint_vendor';

$entities = array();
$trucks = array();
$vendors = array();

$pdo = Database::connect();

foreach ($pdo->query($getTrucks) as $row) {
    $trucks[$row['fxg_num']] = $row['entity_id'];
}
Database::disconnect();

// print_r($trucks);

insert($csv, $trucks);

function insert($array, $trucks)
{

    $pdo = Database::connect();

    foreach ($array as $row) {
        // store the values of each row
        $invoiceDate = $row[0];
        $truck_num = $row[1];
        $vendor_name = $row[2];
        $total = $row[3];
        $entity_id = $trucks[$truck_num];

        // check to see if the vendor already exists
        $vendor_id = checkVendor($vendor_name, $pdo);
        

        
        // print "done";
        // echo $truck_num;
        $sql = "INSERT INTO `maint_invoice` (invoice_date, truck_num, total, vendor_id, entity_id) VALUES ('".$invoiceDate."','".$truck_num."','".$total."','".$vendor_id."','".$entity_id."')";
        try {
            $queryResult = $pdo->query($sql);
            $info = $pdo->errorInfo();
            if (!($info[0] == 0000)) {
                print_r($info);
            } else {
                echo "added <br/>";
            }
    
        } catch (PDOException $e) {
            die(print $e->getMessage());
        }

    }

    Database::disconnect();
}

// check to see if the vendor is already in the database
function checkVendor($name, $pdo)
{
    $sql = "SELECT vendor_id FROM maint_vendor WHERE name = '" . $name . "'";

    $result = "0";
    try {
        $queryResult = $pdo->query($sql);
        $info = $pdo->errorInfo();
        if (!($info[0] == 0000)) {
            echo $info;
        }
        foreach ($queryResult as $row) {
            $result = $row['vendor_id'];
        }

    } catch (PDOException $e) {
        die(print $e->getMessage());
    }

    // if result is still "0", then the vendor is absent from the database
    if ($result == "0") {
        // create the vendor and return it.
        $result = createVendor($name, $pdo);
    }

    // print $result;
    return $result;

}

function createVendor($name, $pdo)
{
    $sql = "INSERT INTO `maint_vendor`(name) VALUES ('" . $name . "')";

    try {
        $pdo->query($sql);
        $info = $pdo->errorInfo();
        if (!($info[0] == 0000)) {
            echo $info;
        }

    } catch (PDOException $e) {
        die($e->getMessage());
    }

    // return the entry that was added.
    return checkVendor($name, $pdo);

}