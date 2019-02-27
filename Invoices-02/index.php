<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoices</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <style type="text/css">
        html, body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        .wrapper{
            width: 80%;
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
        $(document).ready(function() {
    $('#invoices').DataTable();
} );
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">INVOICES</h2>
                        <a href="create.php" class="btn btn-primary pull-right">Add New Invoice</a>
                    </div>
                    <?php
// Include config file
include "database.php";
$pdo = Database::connect();

$getEntities = 'SELECT * FROM entity';
$getTrucks = 'SELECT * FROM truck';
$getVendors = 'SELECT * FROM maint_vendor';

$entities = array();
$trucks = array();
$vendors = array();

foreach ($pdo->query($getEntities) as $row) {
    $entities[$row['entity_id']] = $row['entity_name'];
}

foreach ($pdo->query($getTrucks) as $row) {
    $trucks[$row['fxg_num']] = $row['entity_id'];
}

foreach ($pdo->query($getVendors) as $row) {
    $vendors[$row['vendor_id']] = $row['name'];
}

$inv_count = 1;

// Attempt select query execution

echo "<table id='invoices' class='table table-bordered table-striped'>";
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

$sql = "SELECT * FROM maint_invoice";
foreach ($pdo->query($sql) as $row) {

    echo "<tr>";
    echo "<td>" . $inv_count++ . "</td>";
    echo "<td>" . $row['invoice_date'] . "</td>";
    echo "<td>" . $row['truck_num'] . "</td>";
    echo "<td>$" . $row['total'] . "</td>";
    // getVendor($row['vendor_id']);

    echo '<td>' . $vendors[$row['vendor_id']] . '</td>';

    echo '<td>' . $entities[$trucks[$row['truck_num']]] . '</td>';

    // echo "<td>" . $row['entity_id'] . "</td>";
    echo "<td>";
    echo "<a href='read.php?id=" . $row['id'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
    echo "<a href='update.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
    echo "<a style='color: #f56954' href='delete.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
    echo "</td>";
    echo "</tr>";

    // Free result set
    unset($result);
}

Database::disconnect();

echo "</tbody>";
echo "</table>";

function getVendor($id)
{
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