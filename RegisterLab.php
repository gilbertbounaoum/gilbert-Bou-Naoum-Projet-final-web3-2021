<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Welcome</title>
    <link rel="stylesheet" href="https://js.arcgis.com/4.20/esri/themes/light/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	 <!-- <link rel="stylesheet" href="mystyle.css">-->
    <style>
     body{padding: 10px;
     margin: 10px;}
		label{font-weight: bold;}
		
    select{margin: 10px;}

    button{margin: 0px;}
    .search,
  .logo {
  position: absolute;
  right: 15px;
}

.search {
  top: 15px;
}

.logo {
  bottom: 30px;
}
html,
    body,
    #viewDiv {
      padding: 0;
      margin: 0;
      height: 100%;
      width: 100%;
    }

    #content {
        position: relative;
    }
    #content img {
        position: absolute;
        top: -50px;
        right: -650px;
    }
    </style>
 <script src="https://js.arcgis.com/4.20/"></script>
  <script>
require([
     "esri/config",
      "esri/Map",
      "esri/views/MapView", "esri/widgets/Search"
    ],(esriConfig, Map, MapView,Search)=> {

      esriConfig.apiKey= "AAPK7293e8b323fd4326b9ea63bdb3e81d27fN5St2Krn1DgEBgilYuJK5YB7HjNTfO65HzH6CNlNSfAq1TlBBE151V6-YgPKHPV";
      const map = new Map({
        basemap: "arcgis-topographic" // Basemap layer
      });



const view = new MapView({
  map: map,
  center: [-118.805, 34.027], // Longitude, latitude
  zoom: 13, // scale: 72223.819286
  container: "viewDiv",
  constraints: {
    snapToZoom: false
  }
});
const search = new Search({  //Add Search widget
     view: view
   });
    view.ui.add(search, "top-right");
});


    
</script>

</head>



<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name   = $phoneNumber = $address = "";
$name_err  = $errorString=  $phone_err = $address_err="";





if($_SERVER["REQUEST_METHOD"] == "POST"){
 // Validate name
    //

$name1=$_POST['name'];


if(empty(trim($name1))){
     // if (!isset($_POST['name'])){
        $name_err = "Please enter a name.";     
    }  else{
        $name = trim($_POST["name"]);
    }
	
	  
      if (!isset($_POST['inputAddress'])){
        $address_err = "Please enter a address.";     
    }
     else{
        $address = trim($_POST["inputAddress"]);
    }

   // if (!isset($_POST['inputFatherName'])){
  




    if (!isset($_POST['inputPhone'])){
      $phone_err  = "Please enter a valid Phone Number.";     
  }  elseif (!preg_match("^([0-9]{8})$^",
        $_POST["inputPhone"], $parts)){
    $phone_err .=
      "Incorect Phone Number " ;}
      else{
        $phoneNumber = trim($_POST["inputPhone"]);
    }
    if(!empty($name_err) &&  !empty($phone_err) && !empty($address_err)){
      echo '<script>alert("Oops! Something went wrong. Please try again later.")</script> ';

    }
  if(empty($name_err)  && empty($phone_err) && empty($address_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO lab (lab_name,lab_phone,lab_address) VALUES (?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name,$phoneNumber,$param_address);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
		      	
           
            $param_phoneNumber=$phoneNumber;
           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
               
                echo '<script>alert("Save Successfull")</script> ';
               // header("location: addnewpatient.php");
            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script> ';
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }    mysqli_close($link);
}

?>
 

<body>
    <div><h4 >Loged In As <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h4> <a href="logout.php">
    <span  class="btn btn-primary"  style="float: right;">Logout</span></a>
    </div>
    
    <form class="row g-3 align-items-center " action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="col-md-6">
    <label  class="form-label" >Lab Name</label>
    <input name="name" type="text" class="form-control" <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" >
    <span class="invalid-feedback"><?php echo $name_err; ?></span>
    <?php echo $name_err;?>
  </div>


  <div class="col-md-6">
    <label  class="form-label">Address</label>
    <input type="text" name="inputAddress" class="form-control" <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
    <span class="invalid-feedback"><?php echo $address_err; ?></span>
    <?php echo $address_err;?>
  </div>

  <div class="col-md-6">
    <label  class="form-label">Phone Number</label>
    <input type="text" name="inputPhone" class="form-control" id="inputPhone" >
    <?php echo $phone_err;?>
  </div>

  
  
 
 




<div id="liveAlertPlaceholder"></div>
  <div class="col-8">
    <button type="submit" class="btn btn-primary" id="liveAlertBtn">Save</button>
  
   
    <a href="home.php">
    <span  class="btn btn-primary"  >back</span></a>
  </div>

  
 


</form>

<div id="viewDiv"></div>
</body>
</html>