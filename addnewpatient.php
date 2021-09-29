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
body{
        font-family: Arail, sans-serif;
    }
    /* Formatting search box */
    .search-box{
        width: 300px;
        position: relative;
    
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
       
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>
</head>



<?php

// Initialize the session
session_start();

include "phpqrcode/qrlib.php" ;
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $familyname = $dob = $fathername = $phoneNumber = $address = "";
$name_err = $familyname_err = $dob_err = $fathername_err = $errorString=  $phone_err ="";





if($_SERVER["REQUEST_METHOD"] == "POST"){
 // Validate name
    //

$name1=$_POST['name'];
$familyname1=$_POST['inputFname'];
$dob1=$_POST['inputDOB'];
$fathername1=$_POST['inputFatherName'];
$address1=$_POST['address'];
$passport1=$_POST['passport'];
$gender1=$_POST['Gender'];
$pcr1=$_POST['pcr'];

if(empty(trim($name1))){
     // if (!isset($_POST['name'])){
        $name_err = "Please enter a name.";     
    }  else{
        $name = trim($_POST["name"]);
    }
	
	  if(empty(trim($familyname1))){
      //if (!isset($_POST['inputFname'])){
        $familyname_err = "Please enter a familyname.";     
    }
     else{
        $familyname = trim($_POST["inputFname"]);
    }

   // if (!isset($_POST['inputFatherName'])){
    if(empty(trim($fathername1))){
      $fathername_err = "Please enter a familyname.";     
  }
   else{
      $fathername = trim($_POST["inputFatherName"]);
  }
  if(empty(trim($address1))){
    $address_err = "Please enter a address.";     
}
 else{
    $address = trim($_POST["address"]);
}
if(empty(trim($passport1))){
  $passport_err = "Please enter a passport.";     
}
else{
  $passport = trim($_POST["passport"]);
}
if(empty(trim($gender1))){
  $gender_err = "Please enter a gender.";     
}
else{
  $gender = trim($_POST["Gender"]);
}

if(empty(trim($pcr1))){
  $pcr_err = "Please enter a pcr.";     
}
else{
  $pcr = trim($_POST["pcr"]);
}


  if(empty(trim($dob1))){
	  //if (!isset($_POST['inputDOB'])){
        $dob_err  = "Please enter a Date Of Birth.";     
    }  elseif (!preg_match("^([0-9]{4})-([0-9]{2})-([0-9]{2})$^",
          $_POST["inputDOB"], $parts)){
      $dob_err .=
        "The date of birth is not a valid date in the " .
        "format DD/MM/YYYY";}
elseif (!checkdate($parts[2],$parts[3],$parts[1])){
      $dob_err .= "The date of birth is invalid. " .
    "Please check that the month is between 1 and 12, " .
    "and the day is valid for that month.";}
  elseif (intval($parts[1]) < 1890){
      // Make sure that the user has a reasonable birth year
      $dob_err .=
         "You must be alive to use this service.";}

  // If all the following are NOT true,
  // then report an error.
     else{
        $dob = trim($_POST["inputDOB"]);
    }

    if (!isset($_POST['inputPhone'])){
      $phone_err  = "Please enter a valid Phone Number.";     
  }  elseif (!preg_match("^([0-9]{8})$^",
        $_POST["inputPhone"], $parts)){
    $phone_err .=
      "Incorect Phone Number " ;}
      else{
        $phoneNumber = trim($_POST["inputPhone"]);
    }
    if(!empty($name_err) && !empty($familyname_err) && !empty($dob_err) && !empty($phone_err) && !empty($fathername_err)){
      echo '<script>alert("Oops! Something went wrong. Please try again later.")</script> ';

    }
  if(empty($name_err) && empty($familyname_err) && empty($dob_err) && empty($phone_err) && empty($fathername_err ) && empty($phonenumber_err )  && empty($address_err ) && empty($passport_err) && empty($gender_err ) && empty($pcr_err )   ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO patient (name, familyname,dob,fathername,phonenumber,address,passport,pcr_results,gender) VALUES (?, ?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_name, $param_familyname,$param_dob,$param_fatherName,$phoneNumber,$param_address,$param_passport,$pcr_gender,$param_gender);
            
            // Set parameters
            $param_name = $name;
            $param_familyname = $familyname;
		      	$param_dob = $dob;
           $param_fatherName=$fathername;
            $param_phoneNumber=$phoneNumber;
           $param_address=$address;
           $param_passport=$passport;
           $param_gender=$gender;
           $pcr_gender=$pcr;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
               
                echo '<script>alert("Save Successfull")</script> ';
                
                $r1=$name.$fathername.$familyname;
                $r2=preg_replace("/\s+/", "", $r1);
                $r=$r2.'.pdf';
                $dir='./pcrtemplate.pdf';
                $file1=$dir.$r;
                $file=$file1;
                $p="./upload/" ;
                //$p='D:/upload/' ;
                $pbkp=$p.$r;
                $date=date("Y-m-d");
                $pagecount = $mpdf->setSourceFile( $dir);
                $tplId = $mpdf->ImportPage($pagecount);
                $mpdf->UseTemplate($tplId);
                
               



                QRcode::png($pbkp,"test.png");
                $mpdf->Write(122,$name,50);

                $mpdf->Write(48,$date,50);
                $mpdf->Write(9,$passport,170);
                $mpdf->Write(10,$dob,170);
               
                $mpdf->Write(28,$pcr,80);
                $mpdf->Image("test.png",30, 230, 50, 50, "png");
                ob_clean();
                $mpdf->Output($pbkp,'F');
                $mpdf->Output($pbkp,'I');




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
    <div><h4 >Loged In As <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h4>  <a href="logout.php">
    <span  class="btn btn-primary"  style="float: right;">Logout</span></a>
    </div>
    
    <form class="row g-3 align-items-center " action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="col-md-6">
    <label  class="form-label" >Name</label>
    <input name="name" type="text" class="form-control" <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" >
    <span class="invalid-feedback"><?php echo $name_err; ?></span>
    <?php echo $name_err;?>
  </div>
  <div class="col-md-6">
    <label class="form-label">Father Name</label>
    <input type="text"  name="inputFatherName" class="form-control" >
    <?php echo $fathername_err;?>
  </div>
  <div class="col-md-6">
    <label  class="form-label">Family Name</label>
    <input type="text" name="inputFname" class="form-control" id="inputFname">
    <?php echo $familyname_err;?>
  </div>
  <div class="search-box">
        
   
  <div class="col-md-6">
    <label name="inputAddress" class="form-label">Address</label>
 
    <input type="text" name="address" autocomplete="off" placeholder="Search address..." />
        <div class="result"></div>
  </div> </div>
  <div class="col-md-6">
    <label  class="form-label">Phone Number</label>
    <input type="text" name="inputPhone" class="form-control" id="inputPhone" >
    <?php echo $phone_err;?>
  </div>

  <div class="col-md-6">
    <label name="passport" class="form-label">PassPort Number</label>
    <input type="text" name="passport" class="form-control" id="inputPasport" >
  </div>
  <div class="col-md-6">
    <label  class="form-label">Date Of Birth</label>
    <input type="date" name="inputDOB" class="form-control" >

    <?php echo $dob_err;?>
  </div>
 
  <div class="col-md-6">
    <label  class="form-label">Gender</label>
    <select class="form-select" name="Gender" aria-label="Default select example">
    <option value="M">Male</option>
    <option value="F">Female</option>
    </select>
  </div>
  <div class="col-md-6">
    <label  class="form-label">PCR Test Result</label>
    <select class="form-select-padding-"  name="pcr" aria-label="Default select example">
    <option value="pos"></option>
    <option value="pos">Positive</option>
    <option value="neg">Negative</option>
    </select>
  </div>

  <div id="content">
    <img src="images/BGP.png" class="ribbon"/>
  
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