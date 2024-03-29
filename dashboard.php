<?php
// Initialize the session
session_start();

// Include config file
require "../cgi/db.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mediship Inventory Management</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.css"
    crossorigin="anonymous" />
    
    <link rel="stylesheet" href="./css/style.css">


  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Mediship <i class="fas fa-box-open"></i></a> 
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <i class="fas fa-home"></i><span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">IT Support <i class="far fa-question-circle"></i></a>
          </li>
          
        </ul>
        <form class="form-inline my-2 my-lg-0" action="logout.php">
          <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Logout</button>
        </form>
      </div>
    </nav>

    <section>
      <div class="jumbotron text-center">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1>Mediship Company Intranet</h1>
              
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    

    <div class="col-lg-6"></div>
    <div class="container">
       <div class="row text-center">
		  <div class="col-lg-6 offset-lg-3"><h4>Facility Inventory Records</h4>
		  </div>
       </div>
       <br>
       <hr>
       <br>

       <div class="container">
        <h3 class="accordion">Query Product in Inventory</h3>
        
        <div class="panel">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <p>Search for product within Mediship Inventory</p>
          <div class="row d-flex align-items-end">
          
            <div class="col-md-10">
              <label for="inputQueryProduct">Product Name or Product ID</label>
              <input type="text" class="form-control" id="inputQueryProduct" name="query" placeholder="Product Name or ID" required>
              </div>
            <div class="col-md-2">
            <button type="submit" id="searchBtn" class="btn btn-primary" >Search</button>
            <input type="hidden" name="doSearch" value ='1'>
            </div>
            
          </div>
          </form>
          <div class="pt-4"id="result-div">
            
            <?php
            
              include 'search.php';
            
            ?>
          </div>
        </div>
        <h3 class="accordion">Add New Product from Vendor</h3>
        <div class="panel">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <p>Add a new product record with all required fields in Inventory</p>
          <div class="row d-flex align-items-end">
          
            <div class="col-md-4">
              <label for="inputProductName">Product Name</label>
              <input type="text" class="form-control" id="inputProductName" placeholder="Product Name" name="product"required>
              </div>

              <div class="col-md-4">
              <label for="inputCostPerProduct">Product Cost Per Unit</label>
              <input type="text" class="form-control" id="inputCostPerProduct" name="cost" placeholder="Cost Per Unit" required>
            </div>
            <div class="col-md-4">
              <label for="inputVendor">Vendor:</label>
              <select class="form-control" name="inputVendor" id="inputVendor">
              <?php
                include "dynamic_vendor.php";
              ?></select>
            </div>
          </div>
          <div class="row d-flex align-items-end">
            <div class="col-md-4">
              <label for="count">Quantity:</label>
              <input type="number" name="count" id="count" placeholder='Quantity' class="form-control">
            </div>
            <div class="col-md-4">
            <label for="inputFacility">Facility:</label>
              <select class="form-control" name="inputFacility" id="inputFacility">
                <?php
                  include 'dynamic_facility.php';
                ?>
              </select>
              </div>
          
              <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <input type="hidden" name="addProduct" value='1'>
              </div>
                
          </div>
          </form>
          <div class="pt-4">
            <?php
              include 'insert.php';
            ?>
          </div>
        </div>
          
          
          
          
          
        
        <h3 class="accordion">Delete Product from Inventory</h3>
        <div class="panel">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <p>
          Delete a discontinued product from Inventory
          </p>
          
          <div class="row d-flex align-items-end">
            <div class="col-md-10">
              <label for="delete">Product Name or Product ID</label>
              <input type="text" class="form-control" id="delete"  name="delete" placeholder="Product Name or ID">
            </div>
            <div class="col-md-2">
            <button type="submit" class="btn btn-danger" onclick="delPrompt()">Delete</button>
            <input type="hidden" name="delProduct" id="delProduct" value='0'>
            </div>
          </div>
          </form>
          <div class="pt-4">
            <?php
              include 'del.php';
            ?>
          </div>
        </div>
        <h3 class="accordion">Ship Product</h3>
        <div class="panel">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <p>
          Ship product to a Mediship facility
          </p>
          <div class="row d-flex align-items-end">
            <div class=" col-md-4">
              <label for="shipProduct">Product ID</label>
              <input type="text" class="form-control" id="shipProduct" name="shipProduct" placeholder="Product ID">
            </div>
            <div class=" col-md-4">
              <label for="shipFacilityID">Facility Location</label>
              <input type="text" class="form-control" id="shipFacilityID" name="shipFacilityID" placeholder="Facility ID">
            </div>
            <div class="col-md-4">
            <button type="submit" class="btn btn-success">Ship to facility</button>
            <input type="hidden" name="ship" value='1'>
            </div>
        </form>
        <div class="pt-4">
            <?php
            
              include 'ship.php';
            
            ?>
          </div>
        </div>
      </div>
      </div>


       <hr>
       <footer class="text-center footer">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <p>Copyright © Mediship. All rights reserved.</p>
            </div>
          </div>
        </div>
      </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
  integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
  integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
  integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
  <script src="./js/app.js"></script>
    

  </body>
</html>
