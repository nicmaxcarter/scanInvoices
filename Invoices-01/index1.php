  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    
</head>

<body>
    <div class="container">
            <div class="row" style="padding-top: 10px;">
                <h3>Maintenance Invoices</h3>
            </div>
            <div class="row">
              <p>
                <a href="create.php"class="btn btn-success">Add Invoice</a>
              </p>
                <table class="table table-striped table-sm table-bordered">
                  <thead>
                    <tr>
                      <th>Invoice Date</th>
                      <th>Vendor</th>
                      <th>Truck Number</th>
                      <th>Company</th>
                      <th>Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <!-- <?php
                    include 'database.php';
                    $pdo = Database::connect();

                    $getEntities = 'SELECT * FROM entity';
                    $getTrucks = 'SELECT * FROM truck';

                    $entities = array();
                    $trucks = array();

                    foreach ($pdo->query($getEntities) as $row) {
                        $entities[$row['entity_id']] = $row['entity_name'];
                    }

                    foreach ($pdo->query($getTrucks) as $row) {
                        $trucks[$row['fxg_num']] = $row['entity_id'];
                    }

                    // echo "<pre>";
                    // print_r($trucks);

                    $sql = 'SELECT * FROM maint_invoice ORDER BY invoice_date DESC';
                    foreach ($pdo->query($sql) as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['invoice_date'] . '</td>';
                        echo '<td>' . $row['vendor_id'] . '</td>';
                        echo '<td>' . $row['truck_num'] . '</td>';
                        echo '<td>' . $entities[$trucks[$row['truck_num']]] . '</td>';
                        echo '<td>$' . $row['total'] . '</td>';
                        echo '<td><a class="btn" href="read.php?id='.$row['id'].'">Read</a></td>';
                        echo '</tr>';

                    }
                    Database::disconnect();
                  ?> -->
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>