<?php
session_start();
include "phpqrcode/qrlib.php" ;
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

  



//include "phpqrcode/qrlib.php" ;
$target_dir = "./upload/";
$r1= basename($_FILES["fileToUpload"]["name"]);
$r = preg_replace("/\s+/", "", $r1);        // eza fi spcae aw character to remove them

//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $r;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	

// Check if image file is a actual image or fake image


if(isset($_POST["submit"])) {

}

// Check if file already exists
if (file_exists($target_file)) {
  
  echo '<script>alert("Sorry, file already exists.")</script> ';
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo '<script>alert("Sorry, your file is too large.")</script> ';
 
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf") {
  echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed or File not assign")</script> ';
 
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo '<script>alert("Sorry, your file was not uploaded.")</script> ';
  
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {  
	echo $target_file;


// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

	
	$dir =".\\upload\\";






echo "\n";
echo $r;
$p='./upload/'.$r;;
$file1=$dir.$r;
$file=$file1;


$pp='./test/';
$path=$pp.$r;

echo $target_file;
$pagecount = $mpdf->setSourceFile( $file);
$tplId = $mpdf->ImportPage($pagecount);
$mpdf->UseTemplate($tplId);


//$qrp='https://atommedical-lb.com/pdf/test/';
$qrcodepath=$qrp.$r;
$pbkp=$p.$r;

QRcode::png($pbkp,"test.png");
$mpdf->Image("test.png",30, 230, 50, 50, "png");
//$mpdf->Image(".\sign\stamp.png",152, 230, 50, 50, "png");

$mpdf->Output($p,'F');
$mpdf->Output($p,'I');
if (ftp_put($conn_id, $path,$p, FTP_BINARY)) {
    echo "Successfully uploaded $file\n";

}

	
  } else {
    echo '<script>alert("Sorry, there was an error uploading your file.")</script> ';
   header("location: Uploadpdf.php");
   exit;
  }
  
}
?>