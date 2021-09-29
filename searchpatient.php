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
     




<body>
<?php
session_start();?>
     
<div><h4 >Loged In As <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h4>  <a href="logout.php">
<span  class="btn btn-primary"  style="float: right;">Logout</span></a>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/myscript.js"></script>

<div id="loginForm">
 <label>Please Search for patient by unique passport number</label><br/>
 <form id="myForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
 <input name="passort" id="passort" type="text" placeholder="Enter passport"/><br/>

  <button type="submit" class="btn btn-primary" id="liveAlertBtn">Search</button>
  <a href="home.php">
     <span  class="btn btn-primary"  >back</span></a>
 </form>
</div>
<div id="ack"></div>

<script>
  $(document).ready(function (){
  $("button#submit").click(function (){
        alert("hi");
        e = $("#passort").val();
        //p = $("#pass").val();
        if($("#passort").val()=="")
            $("div#ack").html("please enter email and pass");
        else
            $.post( $("#myForm").attr("action"), 
                    //$("#myForm :input").serializeArray(),
                    {passort: e},
                    function(data){
                        $("div#ack").html(data);
                    });
        $("#myForm").submit( function(){
            return false;
        });
     });
});
    </script>


     


<?php

// echo $email;
// echo "<br>";
// $sql = "SELECT `name`,`familyname`,`fathername` FROM `patient` WHERE `name`='$email'";
// $result =mysqli_query($link, $sql);
// while ($row=mysqli_fetch_assoc($result)){

//     $name=$row['name'];
//     $familyname=$row['familyname'];
//     $fathername=$row['fathername'];
  

//     echo $name;echo "<br>";
//     echo $familyname;echo "<br>";
//     echo $fathername;

//}
function fetch_data(){
    //global $db;
    include "config.php";
    
    $passort1 = $_POST['passort'];
    $sql = "SELECT * FROM `patient` WHERE `passport`='$passort1'";
    $_POST['passort']=0;
    //$sql = "SELECT `name`,`familyname`,`fathername`,`dob` FROM `patient` WHERE `name`='$email'";
    $result =mysqli_query($link, $sql);
     if(mysqli_num_rows($result)>0){
       $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
       return $row;  
           
     }else{
       return $row=[];
     }
   }
   $fetchData= fetch_data();
   show_data($fetchData);
   
   function show_data($fetchData){
   
   
    if(count($fetchData)>0){
         $sn=1;
         foreach($fetchData as $data){ 
   
   
     echo'
     
     
     
    
  
   <div class=."col-md-6".>
     <label  class="form-label" >Name</label>
     
     '.$data['name'].'
     
   </div>
   <div class="col-md-6">
     <label class="form-label">Father Name</label>
     '.$data['fathername'].'
   
   </div>
   <div class="col-md-6">
     <label  class="form-label">Family Name</label>
     '.$data['familyname'].'
   </div>
 
   <div class="col-md-6">
     <label name="inputAddress" class="form-label">Address</label>
     '.$data['address'].'
   </div>
   <div class="col-md-6">
     <label  class="form-label">Phone Number</label>
     '.$data['phonenumber'].'
   </div>
 
 
   <div class="col-md-6">
     <label name="inputPasport" id="passport" class="form-label">PassPort Number</label>
     '.$data['passport'].'
   </div>
   <div class="col-md-6">
     <label  class="form-label">Date Of Birth</label>
     '.$data['dob'].'
 
     
   </div>
  
   <div class="col-md-6">
     <label name="inputGender" class="form-label">Gender</label>
     '.$data['gender'].'
     
   </div>
   <div class="col-md-6">
     <label  class="form-label">PCR Test Result</label>
     '.$data['pcr_results'].'
     
   
   </div>
 
   <div id="content">
     <img src="images/BGP.png" class="ribbon"/>
   
 </div>
 

 
  ';
          
     $sn++; 
        }
   }else{
        
     echo "<tr>
           <td colspan='7'>No Data Found</td>
          </tr>"; 
   }
     echo "</table>";
   }

    ?>


<div id="liveAlertPlaceholder"></div>
   <div class="col-8">
     
   
 
     
   </div>