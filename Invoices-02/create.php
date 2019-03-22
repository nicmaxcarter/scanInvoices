<?php
// Include config file
include "database.php";
$pdo = Database::connect();

// echo var_dump($_POST);

// echo var_dump($_POST);
// Define variables and initialize with empty values
$date = $number = $inv_num = $total = $category = $vendor = $entity = $details = "";
$date_err = $inv_num_err = $number_err = $total_err = $category_err = $vendor_err = $entity_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get the date
    if (empty($_POST["invoice_date"])) {
        $date_err = "Missing";
    } else {
        $date = $_POST["invoice_date"];
    }

    // get the date
    if (empty($_POST["invoice_number"])) {
        $inv_num_err = "Missing";
        $inv_num = "n/a";
    } else {
        $inv_num = $_POST["invoice_number"];
    }

    // get the truck number
    if (empty($_POST["truck_num"])) {
        $number = 100001;
    } else {
        $number = $_POST["truck_num"];
    }

    // get the total
    if (empty($_POST["total_amt"])) {
        $total_err = "Missing";
    } else {
        $total = $_POST["total_amt"];
    }

    // get the category
    if (empty($_POST["category"])) {
        $category_err = "Missing";
    } else {
        $category = $_POST["category"];
    }

    // get the vendor
    if (empty($_POST["vendor_id"])) {
        $vendor_err = "Missing";
    } else {
        $vendor = $_POST["vendor_id"];
    }

    // get the entity
    if (empty($_POST["entity_id"])) {
        $entity_err = "Missing";
    } else {
        $entity = $_POST["entity_id"];
    }

    // get the details
    if (empty($_POST["details"])) {
        $details = "n/a";
    } else {
        $details = $_POST["details"];
    }

    echo "<pre>";

    $getVendorList = 'SELECT * FROM maint_vendor';

    $vendorList = array();

    foreach ($pdo->query($getVendorList) as $row) {
        $vendorList[$row['vendor_id']] = $row['name'];
    }

    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
        echo "we are in";

        $uploaddir = 'uploads/';
        if ($inv_num == 'n/a'){
            $uploadfile = $uploaddir . $date . " " . $number . " " . $vendorList[$vendor] . " $" . $total . ".pdf";
        } else {
            $uploadfile = $uploaddir . $date . " " . $number . " " . $inv_num . " " . $vendorList[$vendor] . " $" . $total . ".pdf";
        }

        echo '<pre>';
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            echo "File is valid, and was successfully uploaded.\n";
        } else {
            echo "Something went wrong with the file upload!\n";
            die();
        }

        echo 'Here is some more debugging info:';
        print_r($_FILES);
    }

    print "</pre>";

    // Check input errors before inserting in database
    if (empty($date_err) && empty($number_err) && empty($total_err) && empty($category_err) && empty($vendor_err) && empty($entity_err)) {
        //     // Prepare an insert statement
        $sql = "INSERT INTO maint_invoice (invoice_date, invoice_number, truck_num, total, category, vendor_id, entity_id, detail) VALUES (:invoice_date, :invoice_number, :truck_num, :total, :category, :vendor_id, :entity_id, :details)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":invoice_date", $param_date);
            $stmt->bindParam(":invoice_number", $param_inv_num);
            $stmt->bindParam(":truck_num", $param_num);
            $stmt->bindParam(":total", $param_total);
            $stmt->bindParam(":category", $param_cat);
            $stmt->bindParam(":vendor_id", $param_vend);
            $stmt->bindParam(":entity_id", $param_ent);
            $stmt->bindParam(":details", $param_det);

            // Set parameters
            $param_date = $date;
            $param_inv_num = $inv_num;
            $param_num = $number;
            $param_total = $total;
            $param_cat = $category;
            $param_vend = $vendor;
            $param_ent = $entity;
            $param_det = $details;

            // Set parameters
            // $param_date = $date;
            // $param_inv_num = "TEST";
            // $param_num = $number;
            // $param_total = "123";
            // $param_cat = $category;
            // $param_vend = $vendor;
            // $param_ent = $entity;
            // $param_det = "yep";

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page

                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
                print_r($stmt);
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        .container-fluid {
            max-width: 800px;
        }
    </style>

    <!-- <script src="dropzone.js"></script> -->
    <script type="text/javascript">
        // set global var for trucklist
        var truckList;

        // get list of trucks from php section that called the code
        function callTrucks(trucks) {
            truckList = trucks;
            console.log('loaded');
        }
        function checkForm(truckNum){
            var truckEntered = document.getElementById("truck_num").value;
            // console.log(truckEntered);
            var n = true;
            if(truckEntered.length > 0){
            n = truckList.includes(truckEntered);
            }
            // console.log(n);
            if(n){
                return true;
            }
            else {
                alert("Please enter a valid truck number!");
                return false;
            }

        }
    </script>
</head>
<body>
<?php

// Include config file
$pdo = Database::connect();

$getEntities = 'SELECT * FROM entity';
$getVendors = 'SELECT * FROM maint_vendor ORDER BY name';
$getTrucks = 'SELECT * FROM truck';

$entities = array();
$vendors = array();
$trucks = array();

foreach ($pdo->query($getEntities) as $row) {
    // $entities[$row['entity_id']] = $row['entity_name'];
    $entities[] = array($row['entity_id'], $row['entity_name']);
}

foreach ($pdo->query($getVendors) as $row) {
    $vendors[] = array($row['vendor_id'], $row['name']);
}

foreach ($pdo->query($getTrucks) as $row) {
    $trucks[] = $row['fxg_num'];
}

echo '<script type="text/javascript">callTrucks(' . json_encode($trucks) . ');</script>';
unset($pdo);

?>
    <div class="wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="page-header">
              <h2>Create Invoice</h2>
            </div>
            <p>
              Please fill this form and submit to add an invoice record to the
              database.

            </p>
            <form onsubmit="return checkForm('123');" action="" method="post" enctype="multipart/form-data">

              <label for="invoice_date">Invoice Date</label>
              <input type="date" class="form-control" name="invoice_date" required/>

              <label for="invoice_number">Invoice Number</label>
              <input type="text" class="form-control" name="invoice_number" required/>

              <label for="truck_num">Truck Number</label>
              <input type="number" class="form-control" name="truck_num" id="truck_num"/>

              <label for="total_amt">Total</label>
              <input type="number" class="form-control" name="total_amt" step="0.01" required/>

              <label for="category">Category</label>
              <select type="text" class="form-control" name="category" required>
                <option value="preventive">Preventive</option>
                <option value="unscheduled">Unscheduled</option>
                <option value="tires">Tires</option>
                <option value="non-maintenance">Non-Maintenance</option>
</select>

              <label for="vendor_id">Vendor</label>
              <select type="text" class="form-control" name="vendor_id" required>
              <?php
foreach ($vendors as $vendor) {?>
                <option value='<?php echo $vendor[0]; ?>'><?php echo $vendor[1]; ?></option>
               <?php }
?>
</select>
              <label for="entity_id">Entity</label>
              <select type="text" class="form-control" name="entity_id" required>
              <?php
foreach ($entities as $entity) {?>
                <option value='<?php echo $entity[0]; ?>'><?php echo $entity[1]; ?></option>
               <?php }
?>
</select>
              <label for="details">Details</label>
              <textarea type="text" class="form-control" name="details">
</textarea>
<br/>
              <input type="file" name="file" />
              <br />

              <input type="submit" class="btn btn-primary" value="Submit" />
              <a href="index.php" class="btn btn-default">Cancel</a>
            </form>
          </div>
          <div class="col-md-6"></div>
        </div>
      </div>
    </div>

  </body>
</html>
