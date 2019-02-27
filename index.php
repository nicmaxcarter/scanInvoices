<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoices</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Invoices</h2>
                        <a href="create.php" class="btn btn-success pull-right">Add New Invoice</a>
                    </div>
                    <?php
// Include config file
include "database.php";

$inv_count = 1;

// Attempt select query execution


$sql = "SELECT * FROM maint_invoice";
if ($result = $con->query($sql)) {
    if ($result->rowCount() > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Invoice Date</th>";
        echo "<th>Truck #</th>";
        echo "<th>Total</th>";
        echo "<th>Vendor</th>";
        echo "<th>Entity</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch()) {
            echo "<tr>";
            echo "<td>" . $inv_count++ . "</td>";
            echo "<td>" . $row['invoice_date'] . "</td>";
            echo "<td>" . $row['truck_num'] . "</td>";
            echo "<td>$" . $row['total'] . "</td>";
            // getVendor($row['vendor_id']);
            foreach ($con->query("SELECT `name` FROM `maint_vendor` WHERE `vendor_id` = " . $row['vendor_id']) as $subRow) {
                $value = $subRow['name'];
                echo "<td>" . $value . "</td>";
            }
            foreach ($con->query("SELECT `entity_name` FROM `entity` WHERE `entity_id` = '" . $row['entity_id'] . "'") as $subRow) {
                $value = $subRow['entity_name'];
                echo "<td>" . $value . "</td>";
            }
            // echo "<td>" . $row['entity_id'] . "</td>";
            echo "<td>";
            echo "<a href='read.php?id=" . $row['id'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
            echo "<a href='update.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
            echo "<a href='delete.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        // Free result set
        unset($result);
    } else {
        echo "<p class='lead'><em>No records were found.</em></p>";
    }
} else {
    echo "Connection error:";
}

function getVendor($id){
    $value = "0";
    foreach ($con->query("SELECT `name` FROM `maint_vendor` WHERE `vendor_id` = " . $id) as $row) {
        $value = $row['name'];
    }

    print $value;
}

// Close connection
unset($pdo);
?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>