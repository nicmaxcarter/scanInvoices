<?php

require 'database.php';

if (!empty($_POST)) {
    // // keep track validation errors
    // $nameError = null;
    // $emailError = null;
    // $mobileError = null;

    // keep track post values
    $invoice_date = $_POST['invoice_date'];
    $vendor = $_POST['vendor'];
    $truck_num = $_POST['truck_num'];
    $company = $_POST['company_select'];
    $total = $_POST['total'];

    // validate input
    $valid = true;
    // if (empty($name)) {
    //     $nameError = 'Please enter Name';
    //     $valid = false;
    // }

    // if (empty($email)) {
    //     $emailError = 'Please enter Email Address';
    //     $valid = false;
    // } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    //     $emailError = 'Please enter a valid Email Address';
    //     $valid = false;
    // }

    // if (empty($mobile)) {
    //     $mobileError = 'Please enter Mobile Number';
    //     $valid = false;
    // }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO maint_invoice (invoice_date,truck_num,total,vendor_id, entity_id) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($invoice_date, $truck_num, $total, $vendor, $company));
        Database::disconnect();
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>

<body>
    <div class="container">

    

        <div class="span10 offset1">
            <div class="row">
                <h3>Create an Invoice</h3>
            </div>


            
            <form class="form-horizontal dropzone" action="create.php" method="post">
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="invoice_date">Invoice Date</label>
                        <div class="col-md-4">
                            <input id="invoice_date" name="invoice_date" type="text" placeholder=""
                                class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="vendor">Vendor</label>
                        <div class="col-md-4">
                            <select id="vendor" name="vendor" class="form-control" required="">
                                <option value="710">Dads Truck Repair</option>
                            </select>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="truck_num">Truck Number</label>
                        <div class="col-md-4">
                            <input id="truck_num" name="truck_num" type="text" placeholder=""
                                class="form-control input-md">

                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="company_select">Company</label>
                        <div class="col-md-4">
                            <select id="company_select" name="company_select" class="form-control" required="">
                                <option value="V0018371">CDST Transport</option>
                                <option value="V0019106">Ethos Transport</option>
                                <option value="V0020002">Pathos Transport</option>
                                <option value="V0020297">K&amp;J Transport</option>
                            </select>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="total">Total</label>
                        <div class="col-md-4">
                            <input id="total" name="total" type="text" placeholder="" class="form-control input-md"
                                required="">

                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="submit_btn"></label>
                        <div class="col-md-8">
                            <button type="submit" id="submit_btn" name="submit_btn" class="btn btn-success">Submit</button>
                            <button id="back_btn" name="back_btn" class="btn btn-default">Back</button>
                        </div>
                    </div>

                </fieldset>
            </form>

            <div class="row">
              <!-- Users Stats -->
              <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
                <div class="card card-small">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Users</h6>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row border-bottom py-2 bg-light">
                      <div class="col-12 col-sm-6">
                        <div id="blog-overview-date-range" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
                          <input type="text" class="input-sm form-control" name="start" placeholder="Start Date" id="blog-overview-date-range-1">
                          <input type="text" class="input-sm form-control" name="end" placeholder="End Date" id="blog-overview-date-range-2">
                          <span class="input-group-append">
                            <span class="input-group-text">
                              <i class="material-icons"></i>
                            </span>
                          </span>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
                        <button type="button" class="btn btn-sm btn-white ml-auto mr-auto ml-sm-auto mr-sm-0 mt-3 mt-sm-0">View Full Report &rarr;</button>
                      </div>
                    </div>
                    <canvas height="130" style="max-width: 100% !important;" class="blog-overview-users"></canvas>
                  </div>
                </div>
              </div>



        </div>

    </div> <!-- /container -->
</body>

</html>
