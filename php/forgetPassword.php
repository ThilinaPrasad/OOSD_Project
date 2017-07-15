<?php require ("connection/dbConnection.php");
require("notifications/notifications.php");?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Forget Password</title>
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <link rel="icon" href="../img/favicon.png">

</head>
<body bgcolor="#e3e6ea" class="container demo-1">
<div class="content">
    <div id="large-header" class="large-header">
        <canvas id="demo-canvas"></canvas>

        <!--header section-->
        <header>
            <center><img src="../img/Yureka%20logo.png" id="mainLogo"></center>
            
        </header>

        <!--body content section-->
        <section class="bodyInner">
            
                <form id="frmFogot"  method="post">
                 <h1>Forgot Password?</h1>
                 <div class="field-group">
					<div><label for="username">Index Number</label></div>
					<div><input type="text" name="index" id="index" class="input-field" style="width: 50%"> </div>
				</div>
	
	
	<div class="field-group">
		<div><input type="submit" name="forgot-password" id="forgot-password" value="Submit" class="form-submit-button"></div>
	</div>	
                    
       </form>
           
        </section>

        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a href="../index.php" >Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>
</div>

<script src="../javascript/validations/signupValidations.js"></script>
<script src="../javascript/validations/Validations.js"></script>
<script src="../javascript/backgroundCanvas/TweenLite.min.js"></script>
<script src="../javascript/backgroundCanvas/EasePack.min.js"></script>
<script src="../javascript/backgroundCanvas/particles.js"></script>
<script src="../javascript/backgroundCanvas/rAF.js"></script>

</body>
</html>



<?php 
if (isset($_POST['forgot-password'])) {
	$indexNo=$_POST['index'];
	if ($indexNo!=null ) {

		$query_check = "SELECT * FROM student WHERE indexNumber ='$indexNo'";
        $result = runQuery($query_check);

        if (mysqli_num_rows($result)==1) {
        	$result= mysqli_fetch_assoc($result);
        	$email=$result['email'];
        	$number='';
        	for ($i = 0; $i<5; $i++) {
    				$number .= mt_rand(0,9);
				}
		$num=sha1($number);		
		$sql="UPDATE student SET password='$num' WHERE indexNumber='$indexNo'";	
		runQuery($sql);	
		sendMail($email,'Forgot Password',"This is the recovery password issued by the Yureka Institute Online System <br><br> Password: ".$number."Use this password to login", "Yureka Institute");

		echo "<script>alert('Successfully sent the recovery  password to your email address!'); </script>";
		
        	
        }
        else{
        	echo "<script type='text/javascript'>alert('Invalid Index Number  !'); fieldColorChange(document.getElementById('index'),'red');</script>";
        }
	}
}
 ?>