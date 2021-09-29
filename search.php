<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<button id="showData">Show User Data</button>

<div id="table-container"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="ajax-script.js"></script>

<script>


$(document).on('click','#showData',function(e){
      $.ajax({    
        type: "GET",
        url: "backend-script.php",             
        dataType: "html",                  
        success: function(data){                    
            $("#table-container").html(data); 
           
        }
    });
});

$(document).ready(function (){
   $("#submit").click(function (){
        alert("hi");
        if($("#email").val()==""||$("#pass").val()=="")
            $("div#ack").html("please enter email and pass");
        else
            $.post( $("#myForm").attr("action"), 
                    $("#myForm :input").serializeArray(),
                    function(data){
                        $("div#ack").html(data);
                    });
        $("#myForm").submit( function(){
            return false;
        });
     });
    });

$.ajax({
		url: "View_ajax.php",
		type: "POST",
		cache: false,
		success: function(data){
			alert(data);
			$('#table').html(data); 
		}
	});
</script>






</body>
</html>