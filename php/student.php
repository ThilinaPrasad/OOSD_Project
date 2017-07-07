<?php
require_once("connection/dbConnection.php");

///////Load user data//////////////////////////////////////////////////////////////////////////////////////////
session_start();
$query = "SELECT * FROM student WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
$result = runQuery($query);

if(mysqli_num_rows($result)==1 && $_SESSION['logged']){
    $data = mysqli_fetch_assoc($result);
}

///////Load user data//////////////////////////////////////////////////////////////////////////////////////////
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Student</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <link href="../css/courses.css" rel="stylesheet">
    <link href="../css/owner.css" rel="stylesheet">
    <link href="../css/notification_panel.css" rel="stylesheet">

</head>
<body bgcolor="#e3e6ea"  class="container demo-1">
<div class="content">
    <div id="large-header" class="large-header">
        <canvas id="demo-canvas"></canvas>
        <!--header section-->
        <header>
            <center><img src="../img/Yureka%20logo.png" id="mainLogo"></center>
            <!--navigation bar start-->
            <ul class="nav">
                <li><a href="../index.php"><img src="../img/nav/nav_yureka_logo.png"></a></li>
                <li><a href="courses.php" target="_blank">Courses</a></li>
                <li class="dropdown"><a href="#">Site 3</a></li>
                <li class="dropdown"><a href="#">Site 3</a></li>
                <li id="nav_noti"><a href="#" onclick="openNav()" style="color: white;">&#128276;</a></li>
                </li>
                <li ><a href="#"><img src="../img/nav/nav_logout.png" style="vertical-align: bottom">&nbsp;Log Out</a></li>
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section>

            <!--Notification panel-->
            <div id="myNav" class="overlay">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a id="topic">Notification Panel</a>
                <hr class="hr1">
                <hr class="hr2">
                <div class="overlay-content">

                    <div class="notification">
                        <h3 class="sender">Sender_1</h3>
                        <p class="content">Notification Info 1</p>
                        <button class="notifiClose" onclick="closeNotifi(0);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_2</h3>
                        <p class="content">Notification Info 2</p>
                        <button class="notifiClose" onclick="closeNotifi(1);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_3</h3>
                        <p class="content">Notification Info 3</p>
                        <button class="notifiClose" onclick="closeNotifi(2);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_4</h3>
                        <p class="content">Notification Info 4</p>
                        <button class="notifiClose" onclick="closeNotifi(3);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_5</h3>
                        <p class="content">Notification Info 5</p>
                        <button class="notifiClose" onclick="closeNotifi(4);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_6</h3>
                        <p class="content">Notification Info 6</p>
                        <button class="notifiClose" onclick="closeNotifi(5);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_7</h3>
                        <p class="content">Notification Info 7</p>
                        <button class="notifiClose" onclick="closeNotifi(6);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_8</h3>
                        <p class="content">Notification Info 8</p>
                        <button class="notifiClose" onclick="closeNotifi(7);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_9</h3>
                        <p class="content">Notification Info 9</p>
                        <button class="notifiClose" onclick="closeNotifi(8);">Close</button>
                    </div>

                    <div class="notification">
                        <h3 class="sender">Sender_10</h3>
                        <p class="content">Notification Info 10</p>
                        <button class="notifiClose" onclick="closeNotifi(9);">Close</button>
                    </div>

                </div>
            </div>
            <!--Notification panel-->

            <div class="Containerlayout">
                <div id ="left_container">

                    <!--Day Timer and User Info-->
                    <div id="userData">
                        <ul>
                            <li><img src="../img/dayTime/morning.png"  class="dayTimeImage">
                                <img src="../img/dayTime/afternoon.png" class="dayTimeImage" style="display: none;">
                                <img src="../img/dayTime/evening.png" class="dayTimeImage" style="display: none;" >
                                <img src="../img/dayTime/night.png" class="dayTimeImage" style="display: none;">
                            </li>
                            <ul><div id="dayTime">Good Evening!</div></ul>
                        </ul>
                        <a href="#" id="loggedName" title="Update Information" onclick="studentLayers(); updateDetails_layer.style.display='block';"><?php echo $data['firstName']." ".$data['lastName'];?></a>
                    </div>
                    <!--Day Timer and User Info-->

                    <div class="vertical-menu">
                        <a href="#" class="active" id="tutorials" onclick="studentLayers(); changeLayer(tutorials_btn,tutorials_layer);">Tutorials</a>
                        <a href="#" id="results" onclick="studentLayers(); changeLayer(results_btn,results_layer);">Results</a>
                    </div>
                </div>

                <div id="right_container">
                    <div class="tutorial_panel" style="display: block;">


                    </div>

                    <div class="results_panel" style="display: none;">

                    </div>

                    <div class="updateDetails_panel" style="display:none;">
                        <div class="formContainer">
                            <form id="supdateDetails" action="student.php" method="post">
                                <h1 align="center">Update Details</h1>
                                <Lable>Name</Lable>
                                <font size="2" class="warning" color="red"></font>          <!--name warning 0-->
                                <br>
                                <input type="text" id="sfirstName"  placeholder="First Name" name="sfirstName" <?php echo "value='{$data["firstName"]}'";?>>
                                <input type="text" id="slastName"  placeholder="Last Name" name="slastName" <?php echo "value='{$data["lastName"]}'";?>><br>


                                <br>
                                <Lable>Address</Lable><br>
                                <textarea rows="4" columns="40" id="saddress" name="saddress"><?php echo $data["address"];?></textarea>
                                <br>
                                <Lable>Birthday</Lable><br>
                                <input type="date" id="sbDay" name="sbday" <?php echo "value='{$data["birthDay"]}'";?>>

                                <br>
                                <Lable>Gender</Lable><br>
                                <select id="sgender" name="sgender">
                                    <option hidden>Select</option>
                                    <option <?php if($data["gender"]=="Male"){echo "selected='selected'";}?>>Male</option>
                                    <option <?php if($data["gender"]=="Female"){echo "selected='selected'";}?>>Female</option>
                                </select>

                                <br>
                                <Lable>Email</Lable>
                                <font size="2" class="warning" color="red"></font>  <!--email warning 1-->
                                <br>
                                <input type="email" id="semail" name="semail" <?php echo "value='{$data["email"]}'";?>>

                                <br>
                                <Lable>Telephone</Lable>
                                <font size="2" class="warning">(*Must contain 10 digits)</font><br> <!--tel warning 2-->
                                <font size="2" class="warning" color="red"></font><br> <!--tel warning 3-->
                                <input type="tel" id="stelephoneNo" name="stelephone" <?php echo "value='{$data["telephone"]}'";?>>

                                <br>
                                <input type="submit" value="Update" onclick="updateValidationOnclick();" >
                                <!--onclick="submitOnclick();" for validations"-->

                                <!--Index container -->
                                <div id="id01" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Your Password</b></label>
                                            <input type="password" placeholder="Password" name="updatePass" required>
                                            <input type="submit" name="saveChanges" value="Save Changes">
                                        </div>
                                    </div>
                                </div>
                                <!---->

                            </form>
                        </div>
                    </div>


                </div>
            </div >

        </section>
        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a href="../index.php" >Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>
</div>

<script src="../javascript/dayTimeSelector.js"></script>
<script src="../javascript/notificationPanel.js"></script>
<script src="../javascript/Layers.js"></script>
<script src="../javascript/validations/studentValidations.js"></script>
<script src="../javascript/validations/Validations.js"></script>
<script src="../javascript/backgroundCanvas/TweenLite.min.js"></script>
<script src="../javascript/backgroundCanvas/EasePack.min.js"></script>
<script src="../javascript/backgroundCanvas/particles.js"></script>
<script src="../javascript/backgroundCanvas/rAF.js"></script>

<?php

///////update details code//////////////////////////////////////////////////////////////////////////////////////////
function updateData(){
    global $data;
    $firstName = $_POST['sfirstName'];
    $lastName = $_POST['slastName'];
    $address = $_POST['saddress'];
    $bday = $_POST['sbday'];
    $gender = $_POST['sgender'];
    $email = $_POST['semail'];
    $telephone = $_POST['stelephone'];

    $checkChanges = $firstName != $data['firstName'] || $lastName != $data['lastName'] || $address != $data['address'] || $bday != $data['birthDay']
        || $gender != $data['gender'] || $email != $data['email'] || $telephone != $data['telephone'] ;

        $query = "UPDATE student SET firstName='$firstName',lastName='$lastName',address='$address',birthDay='$bday',gender='$gender',email='$email',telephone='$telephone' WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
    if($checkChanges) {
        if (sha1($_POST['updatePass']) == $_SESSION['password']) {
            runQuery($query);
            echo "<script>alert('Successfully updated!');</script>";
            echo "<script>window.location.href = 'student.php';</script>";
        } else {
            echo "<script>alert('Invalid Password!'); updateDetails_layer.style.display = 'block';</script>";
        }
    } else {
        echo "<script>alert('No changes detected!'); updateDetails_layer.style.display = 'block';</script>";

    }
}

if(isset($_POST['updatePass'])){
    updateData();
}

///////update details code//////////////////////////////////////////////////////////////////////////////////////////

?>
</body>
</html>