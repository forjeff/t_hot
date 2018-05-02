<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <title>Register Page  - Taoyuan_Hot.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<style type="text/css">
.btn span.glyphicon {    			
	opacity: 0;				
}
.btn.active span.glyphicon {				
	opacity: 1;				
}
body, html{
     height: 100%;
 	background-repeat: no-repeat;
 	background-color: #d3d3d3;
 	font-family: 'Oxygen', sans-serif;
}

.main{
 	margin-top: 70px;
}

h1.title { 
	font-size: 40px;
	font-weight: 400; 
}

hr{
	width: 10%;
	color: #fff;
}

.form-group{
	margin-bottom: 15px;
}

label{
	margin-bottom: 15px;
}

input,
input::-webkit-input-placeholder {
    font-size: 11px;
    padding-top: 3px;
}

.main-login{
 	background-color: #fff;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

}

.main-center{
 	margin-top: 30px;
 	margin: 0 auto;
 	max-width: 400px;
    padding: 40px 40px;

}

.login-button{
	margin-top: 5px;
}

.login-register{
	font-size: 11px;
	text-align: center;
}
.set{
	position:relative;
    right:0px;
	text-align: center;
	font-size: 11px;
}
.form-control-22 {
    display:inline;
}
.greenstyle{
	color: rgb(253, 13, 77);
}
	</style>  
	<script src="jquery-3.2.1.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>
<body>
	<!DOCTYPE html>
<html lang="en">
    <head> 
	    <link rel="stylesheet" href="font-awesome.min.css">
		<title>Admin</title>
	</head>
	<body>
		<?php
			require_once("Member_menu.php");
		?>
		<div class="container">
			<div class="row">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">修改你的資料</h1>
	               	</div>
	            </div> 
				<div class="main-login main-center">	
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">Your Name</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter your Name"/>
							</div>
						</div>
					</div>		

					<div class="form-group">
						<label for="birthdayer" class="cols-sm-2 control-label">Birthday</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
								<input type="date" class="form-control" name="birthday" id="birthday"  placeholder="格式如：2014-09-18"/>
							</div>
						</div>
					</div>						

					<div class="form-group">
						<label for="email" class="cols-sm-2 control-label">Your Email</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
								<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="cols-sm-2 control-label">Password</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
								<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
								<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
							</div>
						</div>
					</div>

					<div class="form-group ">
						<p id="createResult"></p>
						<?php
							echo "<button type='button' class='btn btn-primary btn-lg btn-block login-button' value=".$_SESSION['uID']." id='save'>送出修改</button>";
						?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/Javascript">
			$(document).ready(function() {
				$("#save").click(function() {
					//document.write($("#save").val());
       				 $.ajax({
        			    type: "POST",
        			    url: "Member_handler.php",
       				    dataType: "text",
       				    data: {
						   state : '3',
						   name : $("#name").val(),
         			       email: $("#email").val(),
						   birthday: $("#birthday").val(),
         	    		   password: $("#password").val(),
         			       confirm: $("#confirm").val(),
							id: $("#save").val(),
        			    },
         			    success: function(data) {
         	          		$("#createResult").html(data);
							//document.getElementById)("createResult").innerHTML=data;
							 if(data=="fail")
								window.location.href = "edit_fail.php";
							if(data=="ok"){
							   window.location.href ="edit_success.php";
							   //$("#up").html("aaa");
							}
         		   		},
         		   		error: function(jqXHR) {
         		   		    alert("發生錯誤: " + jqXHR.status);
         	  			}
        			})
   				 })			
			});
		</script>
	</body>
</html>
</body>
</html>