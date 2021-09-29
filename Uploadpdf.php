<!DOCTYPE html>
<html>
<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<link rel="stylesheet" href="https://js.arcgis.com/4.20/esri/themes/light/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>

		<style>
		 #content {
        position: relative;
    }
    #content img {
        position: absolute;
        top: 300px;
        right: -850px;
    }
	</style>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand " href=""><h3 class="text-primary"> PCR RESULTS QR CODE GENERATOR</h3></a>
		</div>
		
	</nav>
	<div class="d-grid gap-2 d-md-flex justify-content-md-end">  <a href="logout.php">
    <span  class="btn btn-primary"  >Logout</span></a>
	
	  <a href="home.php">
    <span  class="btn btn-primary"  >back</span></a>
	
	
	</div>
	

		
		
	
		<div class="col-md-4">
			<div class="form-group">
<form action="uploadcontrol.php" method="post" enctype="multipart/form-data">
<div >
<h5 class="text-primary">Select PDF Results File To Upload</h5>

<div class="input-group mb-4">
  <input type="file" name="fileToUpload" class="form-control" id="inputGroupFile02">
 

  <button class="btn btn-primary ><input type="submit" value="Upload File" name="submit">Upload</button></div>
 

</div>





</form>
<div id="content">
    <img src="images/BGP.png" class="ribbon"/>
  
</div>
</body>
</html>