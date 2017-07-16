<!--php code here-->
<?php
require("connection/dbConnection.php");
require('excelUpload/uploadFile.php');
require("notifications/notifications.php");
include_once ("tutorials/tutorialAutoDelete.php");

///////Load user data//////////////////////////////////////////////////////////////////////////////////////////
session_start();
$query = "SELECT * FROM teacher WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
$result = runQuery($query);
if (mysqli_num_rows($result) == 1 && $_SESSION['logged']) {
    $data = mysqli_fetch_assoc($result);
    $fullName = $data['firstName'] . " " . $data['lastName'];
///////Load user data//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////// Load Subjects /////////////////////////////////////
    $availableSubjects_DD = "";
    $query_course = "SELECT * FROM courses";
    $coursesUpdate = runQuery($query_course);
    while ($courseUpdate = mysqli_fetch_assoc($coursesUpdate)) {
        $availableSubjects_DD .= "<option>{$courseUpdate['subject']}</option>";
    }
/////////////////////////////////////////////////////////////////// Load Subjects /////////////////////////////////////

/////////////////////////////////////////////////////////////////// result excel upload /////////////////////////////////////

    if (isset($_POST['resultupload'])) {
        if (sha1($_POST['uploadResultPass']) == $_SESSION['password']) {
            $file_path = $_FILES['resultfile']['tmp_name'];
            if (saveToDB($file_path, $_POST['filesubject'])) {
                echo "<script>alert('Successfully Added Results !');</script>";
            } else {
                echo "<script>alert('Error happened uploading !');</script>";
            }
        } else {
            echo "<script>alert('Invalid Password !');</script>";
        }
        echo '<script>window.location.href = "teacher.php";</script>';
        exit();
    }
/////////////////////////////////////////////////////////////////// result excel upload /////////////////////////////////////

/////////////////////////////////////////////////////////////////// result upload row by row /////////////////////////////////////
    if (isset($_POST['resultupload_one'])) {
        if (!$_SESSION['oneadded']) {
            runQuery($query_truncate_results);
        }
        $query_one = "INSERT INTO results (indexNumber,subject, marks) VALUES ('{$_POST['resultIndex_one']}','{$_POST['resultSub_one']}','{$_POST['resultMark_one']}')";
        if (runQuery($query_one)) {
            echo "<script>alert('Successfully Added Results !');</script>";
        } else {
            echo "<script>alert('Error happened uploading !');</script>";
        }
        echo '<script>window.location.href = "teacher.php";</script>';
        $_SESSION['oneadded'] = true;
        exit();
    }
/////////////////////////////////////////////////////////////////// result upload row by row /////////////////////////////////////

///////////////////////////////Send Notifications////////////////////////////////////////////////////////////
    if (isset($_POST['sendBtn'])) {
        sendNotification($fullName);
        sendNotificationMail("Yureka notification from", $fullName);
        echo "<script type='text/javascript'>alert('Notification Sent!');</script>";
        echo '<script>window.location.href = "teacher.php";</script>';
        exit();
    }
///////////////////////////////Send Notifications////////////////////////////////////////////////////////////

///////Load available Notifications////////////////////////////////////////////////////////////////////////////////

    $notificationPanel = loadNotifiPanel(loadData('Teachers'));

///////Load available Notifications////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////Change Password////////////////////////////////////////////////////////////
    if (isset($_POST['tchangePassBtn'])) {
        $newPassword = sha1($_POST['tnewPass']);
        if ($_SESSION['password'] == sha1($_POST['tcurrentPass'])) {
            $query_cp = "UPDATE teacher SET password='{$newPassword}' WHERE indexNumber='{$_SESSION["username"]}'";
            runQuery($query_cp);
            $_SESSION['password'] = $newPassword;
            sendMail($data['email'], "Yureka LogIn Password Changed By", "Your Yureka Institute online user account password changed by " . $fullName . " on " . date("Y-m-d") . " at " . date("h:i:sa") . "<br><br><br><a href='#'>Yureka Higher Education Institute</a> All Rights Reserved!", $fullName);
            echo "<script type='text/javascript'>alert('Password Successfully Changed!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Invalid Current Password!');</script>";
        }
        echo '<script>window.location.href = "teacher.php";</script>';
        exit();
    }
///////////////////////////////Change Password////////////////////////////////////////////////////////////

    ///////////////////////////////Change Profile pic////////////////////////////////////////////////////////////
    if (isset($_POST['profilepicdone_t'])) {
        if ($data['profilePic'] != '../img/profilePics/16401b92e208d08bd8d0e064441977fc713bf45d.png' && file_exists($data['profilePic'])) {
            unlink($data['profilePic']);
        }
        $pic_id = sha1($data['indexNumber']);
        $file = $_FILES['profileimg_t'];
        $path = "../img/profilePics/" . $pic_id . ".jpg";
        if (move_uploaded_file($file['tmp_name'], $path)) {
            $query_update_pic = "UPDATE teacher SET profilePic='{$path}' WHERE indexNumber='{$_SESSION['username']}'";
            runQuery($query_update_pic);
            echo "<script type='text/javascript'>alert('Successfully updated your Profile Picture!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Failed uploading please try again!');</script>";
        }
        echo '<script>window.location.href = "teacher.php";</script>';
        exit();
    }
    ///////////////////////////////Change Profile pic////////////////////////////////////////////////////////////

    ///////////////////////////////Tutorial upload ////////////////////////////////////////////////////////////

    if (isset($_POST['tutorialUpload'])) {
        $date = date('Y-m-d');
        $query_last_tid = "SELECT id FROM tutorials ORDER BY id DESC LIMIT 1";
        $lid = runQuery($query_last_tid);
        $lid_a = mysqli_fetch_assoc($lid);
        $lid = sha1($lid_a['id'] + 1);
        $file = $_FILES['tutorialFile'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $path_move = "../tutorials/" . $lid . '.' . $ext;
        $tuto_name = $_POST['tutorialName'];
        if(strlen(trim($tuto_name))==0){
            $tuto_name = "Tutorial_".($lid_a['id']+1);
        }
        if (empty($file['name']) || move_uploaded_file($file['tmp_name'], $path_move)) {
            $path_load = "../tutorials/" . $lid . '.' . $ext;
            if (empty($file['name'])) {
                $path_load = null;
            }
            $query_tadd = "INSERT INTO tutorials (uploadedDate, teacher, subject, tutorialName,tutorialMsg, filePath, link) VALUES ('{$date}','{$fullName}','{$_POST['tutorialSub']}','{$tuto_name}','{$_POST['tutorialMsg']}','{$path_load}','{$_POST['tutorialLink']}')";
            runQuery($query_tadd);
            $msg = $_POST['tutorialSub']." ".$tuto_name." tutorial added !";
            $sql="INSERT INTO notifications (notice,receiver,sender,sendDate)  VALUE ('{$msg}','Students','{$fullName}',CURDATE())";
            runQuery($sql);
            $query_email = "SELECT email FROM student";
            $result_mail=runQuery($query_email);
            while ($smail = mysqli_fetch_assoc($result_mail)){
                sendMail($smail['email'],"Yureka notification from",$msg. "<br><br><br><a href='#'>Yureka Higher Education Institute</a> All Rights Reserved!",$fullName);
            }
            echo "<script type='text/javascript'>alert('Successfully Added!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Failed uploading please try again!');</script>";
        }
        echo '<script>window.location.href = "teacher.php";</script>';
        exit();
    }

    ///////////////////////////////Tutorial upload ////////////////////////////////////////////////////////////

    ///////////////////////////////Delete Account////////////////////////////////////////////////////////////
    if(isset($_POST['deleteAccBtn'])){
        $dpass = sha1($_POST['deleteAccPass']);
        if ($_SESSION['password'] ==$dpass ) {
            $query_delete_acc = "DELETE FROM teacher WHERE indexNumber='{$_SESSION['username']}' AND password='{$dpass}'";
            runQuery($query_delete_acc);
            echo "<script type='text/javascript'>alert('Successfully Deleted your account!');</script>";
            echo '<script>window.location.href = "login.php";</script>';
            exit();
        }else{
            echo "<script type='text/javascript'>alert('Invalid password!');</script>";
        }

    }
    ///////////////////////////////Delete Account////////////////////////////////////////////////////////////
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Teacher</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <link href="../css/owner.css" rel="stylesheet">
    <link href="../css/notification_panel.css" rel="stylesheet">
    <link href="../css/teacher.css" rel="stylesheet">

</head>
<body bgcolor="#e3e6ea" class="container demo-1">
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
                <li><a href="about.html">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li id="nav_noti"><a href="#" onclick="openNav()" style="color: white;"><img
                                src='<?php echo $notifiLogo; ?>'></a></li>
                <li><a href="logout.php"><img src="../img/nav/nav_logout.png" style="vertical-align: bottom">&nbsp;Log
                        Out</a></li>
                <img src='<?php echo $data['profilePic']; ?>' class="profilePic"
                     onclick="document.getElementById('profilePicContainer').style.display='block'">
                <!--upload password -->
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section>
            <!--Update Profile pic Section-->
            <div id="profilePicContainer" class="modal">
                <div class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('profilePicContainer').style.display='none'"
                              class="close" title="Close Modal">&times;</span>
                    </div>
                    <div class="container">
                        <img src='<?php echo $data['profilePic']; ?>' class="displayProfilepic"><br><br>
                        <label><b>Select New Profile Picture</b></label>
                        <form action="teacher.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="profileimg_t"><br>
                            <font size="2" color="red">(*must select square shape images)</font><br>
                            <input type="submit" name="profilepicdone_t" value="Update Profile Picture">
                        </form>
                    </div>
                </div>
            </div>
            <!--Update Profile pic Section-->

            <!--Notification panel-->
            <div id="myNav" class="overlay">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a id="topic">Notification Panel</a>
                <hr class="hr1">
                <hr class="hr2">
                <div class="overlay-content">
                    <?php
                    echo $notificationPanel;
                    ?>
                </div>
            </div>
            <!--Notification panel-->

            <div class="Containerlayout">
                <div id="left_container">

                    <!--Day Timer and User Info-->
                    <div id="userData">
                        <ul>
                            <li><img src="../img/dayTime/morning.png" class="dayTimeImage">
                                <img src="../img/dayTime/afternoon.png" class="dayTimeImage" style="display: none;">
                                <img src="../img/dayTime/evening.png" class="dayTimeImage" style="display: none;">
                                <img src="../img/dayTime/night.png" class="dayTimeImage" style="display: none;">
                            </li>
                            <ul>
                                <div id="dayTime">Good Evening!</div>
                            </ul>
                        </ul>
                        <a href="#" id="loggedName" class="loggedName" title="Update Information"
                           onclick="teacherLayers(); updateDetails_layer.style.display='block';"><?php echo $fullName; ?></a>
                    </div>
                    <!--Day Timer and User Info-->

                    <div class="vertical-menu">
                        <a href="#" class="active" id="tutorials"
                           onclick="teacherLayers(); changeLayer(tutorials_btn,tutorials_layer);">Tutorials</a>
                        <a href="#" id="results" onclick="teacherLayers(); changeLayer(results_btn,results_layer);">Results</a>
                        <a href="#" id="sendNotification"
                           onclick="teacherLayers(); changeLayer(sendNotifi_btn,sendNotifi_layer);">Send
                            Notifications</a>
                    </div>
                </div>

                <div id="right_container">

                    <div class="tutorial_panel" style="display: block;">
                        <form action="teacher.php" method="post" enctype="multipart/form-data">
                            <select name="tutorialSub" id="tutorialSub">
                                <option selected hidden>Select Subject</option>
                                <?php echo $availableSubjects_DD; ?>
                            </select>
                            <textarea rows="10" columns="40" placeholder="Your message about tutorial here "
                                      name="tutorialMsg" id="tutorialMessage"></textarea>
                            <input type="text" name="tutorialName"
                                   placeholder="Your Tutorial Name Here (Default:Tutorial_ID)" id="tutorialName">
                            <input type="url" placeholder="Your link here" name="tutorialLink" id="tutorialUrl">
                            <br><br>
                            <label><b>Or</b></label>
                            <br><br>
                            <input type="file" name="tutorialFile" id="tutorialFile"><br>
                            <font size="2" color="red">(*max file size is 50MB)</font><br>
                            <ul>
                                <li>
                                    <button class="clr" onclick="tuClrOnClick(); return false;">Clear</button>
                                </li>
                                <li>
                                    <button class="send" name="tutorialUpload">Upload</button>
                                </li>
                            </ul>
                        </form>

                    </div>

                    <div class="results_panel" style="display: none;">
                        <div id="resultFileSection">
                            <form action="teacher.php" method="post" enctype="multipart/form-data">
                                <h1 align="center" id="sampleSheet">Upload Excel Result Sheet</h1>
                                <a href="../requiredFiles/ResultSheet.xlsx" id="sampleSheetLink" title="Download Sheet">Download
                                    Sample Result Sheet</a>
                                <select class="subjectDD" name="filesubject" id="uploadResultSub">
                                    <option selected hidden>Select Subject</option>
                                    <?php echo $availableSubjects_DD; ?>
                                </select><br>
                                <input type="file" name="resultfile" id="uploadResultFile">
                                <font size="2" id="fileWarning">(*must select .xlsx file before upload)</font>
                                <input type="submit" value="Upload Results" Id="uploadResultBtn"
                                       onclick="return uploadResultsOnClick();">

                                <!--upload password -->
                                <div id="fileUploadPassword" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('fileUploadPassword').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Your Password</b></label>
                                            <input type="password" placeholder="Password" name="uploadResultPass"
                                                   required>
                                            <input type="submit" name="resultupload" value="Done">
                                        </div>
                                    </div>
                                </div>
                                <!---->

                            </form>
                        </div>

                        <hr class="hr1" style="margin-top: 50px;">
                        <hr class="hr1" style="margin-bottom: 50px;">

                        <div id="resultOneByOneSection">
                            <form action="teacher.php" method="post">
                                <h1 align="center">Upload Results One By One</h1>
                                <ul id="marksDataRow">
                                    <li><select name="resultSub_one" id="resultSub_one">
                                            <option selected hidden>Select Subject</option>
                                            <?php echo $availableSubjects_DD; ?>
                                        </select></li>
                                    <li><input type="text" placeholder="Index Number" name="resultIndex_one"
                                               id="resultIndex_one"></li>
                                    <li><input type="number" placeholder="Marks" name="resultMark_one"
                                               id="resultMark_one"></li>
                                </ul>
                                <input type="submit" name="resultupload_one" value="Upload Results"
                                       id="uploadResultOneByOne" onclick="return uploadResults_oneOnclick();">
                            </form>
                        </div>

                    </div>

                    <div class="notification_panel" style="display: none;">
                        <form action="teacher.php" method="post">
                            <select name="receiver" id="tnotReceiver">
                                <option>All</option>
                                <option>Students</option>
                                <option>Teachers</option>
                            </select>
                            <textarea rows="10" columns="40" class="message" id="tnotice" name="notice"
                                      placeholder="Type Your Message Here"></textarea>
                            <ul>
                                <li>
                                    <button class="clr"
                                            onclick="notificationCrear(document.getElementById('tnotReceiver'),document.getElementById('tnotice')); return false;">
                                        Clear
                                    </button>
                                </li>
                                <li>
                                    <button class="send" name="sendBtn" id="sendBtn"
                                            onclick="return noticeCheck(document.getElementById('tnotice'));">Send
                                    </button>
                                </li>
                            </ul>
                        </form>
                    </div>

                    <div class="updateDetails_panel" style="display:none;">
                        <div class="formContainer">
                            <form id="tupdateDetails" action="teacher.php" method="post">
                                <h1 align="center">Update Details</h1>
                                <br>
                                <Lable>Index Number</Lable>
                                <br>
                                <input type="text"
                                    <?php echo "value='{$data["indexNumber"]}'"; ?> disabled>
                                <Lable>Name</Lable>
                                <font size="2" class="warning" color="red"></font>          <!--name warning 0-->
                                <br>
                                <input type="text" id="tfirstName" placeholder="First Name"
                                       name="tfirstName" <?php echo "value='{$data["firstName"]}'"; ?>>
                                <input type="text" id="tlastName" placeholder="Last Name"
                                       name="tlastName" <?php echo "value='{$data["lastName"]}'"; ?>><br>


                                <br>
                                <Lable>Address</Lable>
                                <br>
                                <textarea rows="4" columns="40" id="taddress"
                                          name="taddress"><?php echo $data["address"]; ?></textarea>
                                <br>
                                <Lable>Birthday</Lable>
                                <br>
                                <input type="date" id="tbDay" name="tbday" <?php echo "value='{$data["birthDay"]}'"; ?>>

                                <br>
                                <Lable>Gender</Lable>
                                <br>
                                <select id="tgender" name="tgender">
                                    <option hidden>Select</option>
                                    <option <?php if ($data["gender"] == "Male") {
                                        echo "selected='selected'";
                                    } ?>>Male
                                    </option>
                                    <option <?php if ($data["gender"] == "Female") {
                                        echo "selected='selected'";
                                    } ?>>Female
                                    </option>
                                </select>

                                <br>
                                <Lable>Email</Lable>
                                <font size="2" class="warning" color="red"></font>  <!--email warning 1-->
                                <br>
                                <input type="email" id="temail" name="temail" <?php echo "value='{$data["email"]}'"; ?>>

                                <br>
                                <Lable>Telephone</Lable>
                                <font size="2" class="warning">(*Must contain 10 digits)</font><br> <!--tel warning 2-->
                                <font size="2" class="warning" color="red"></font><br> <!--tel warning 3-->
                                <input type="tel" id="ttelephoneNo"
                                       name="ttelephone" <?php echo "value='{$data["telephone"]}'"; ?>>

                                <br>
                                <Lable>Educational Qualifications</Lable>
                                <br>
                                <input type="text" id="ateduQualifications"
                                       name="teducationalQualifi" <?php echo "value='{$data["eduQualification"]}'"; ?>>

                                <br>
                                <input type="submit" value="Update" onclick="updateValidationOnclick();">

                                <!--update Password container -->
                                <div id="id01" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('id01').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Your Password</b></label>
                                            <input type="password" placeholder="Password" name="updatePass" required>
                                            <input type="submit" name="saveChanges" value="Save Changes">
                                        </div>
                                    </div>
                                </div>
                                <!---->
                                <a href="#"
                                   onclick="document.getElementById('changePassword').style.display='block';return false;">Change
                                    Password</a>
                                <a href="#" class="deleteAccount"
                                   onclick="document.getElementById('deleteAccPass').style.display='block';return false;">Delete My Account</a>

                            </form>

                            <form action="teacher.php" method="post">
                                <!--change password container -->
                                <div id="changePassword" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('changePassword').style.display='none'"
                                                  class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Change Password</b></label>
                                            <input type="password" placeholder="Current Password" name="tcurrentPass"
                                                   id="ocurrentPass" required>
                                            <font size="2" id="ochangePassWarn">(*password must have 8-16 digits)</font><br>
                                            <input type="password" placeholder="New Password" name="tnewPass"
                                                   id="onewPass" required>
                                            <input type="password" placeholder="Confirm New Password" name="tcmfnewPass"
                                                   id="ocmfPass" required>
                                            <input type="submit" name="tchangePassBtn" value="Change Password"
                                                   onclick="return changePassBtnOnclick(document.getElementById('ocurrentPass'),document.getElementById('onewPass'),document.getElementById('ocmfPass'),document.getElementById('ochangePassWarn'));">
                                        </div>
                                    </div>
                                </div>
                                <!---->
                            </form>

                            <!--Delete Account-->
                            <form action="teacher.php" method="post">
                                <!--Password container -->
                                <div id="deleteAccPass" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer" ">
                                        <span onclick="document.getElementById('deleteAccPass').style.display='none'"
                                              class="close" title="Close Modal">&times;</span>
                                    </div>
                                    <div class="container">
                                        <label><b>Are you sure about this decision ?</b></label>
                                        <input type="password" placeholder="Password" name="deleteAccPass" class="resetFields" required>
                                        <input type="submit" name="deleteAccBtn" value="Delete Account" >
                                    </div>
                                </div>
                        </div>
                        <!---->
                        </form>
                        <!--Delete Account-->
                        </div>
                    </div>


                </div>
            </div>

        </section>
        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a
                        href="../index.php">Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>
</div>

<script src="../javascript/dayTimeSelector.js"></script>
<script src="../javascript/notificationPanel.js"></script>
<script src="../javascript/Layers.js"></script>
<script src="../javascript/validations/teacherValidations.js"></script>
<script src="../javascript/validations/Validations.js"></script>
<script src="../javascript/backgroundCanvas/TweenLite.min.js"></script>
<script src="../javascript/backgroundCanvas/EasePack.min.js"></script>
<script src="../javascript/backgroundCanvas/particles.js"></script>
<script src="../javascript/backgroundCanvas/rAF.js"></script>
<?php
///////update details code//////////////////////////////////////////////////////////////////////////////////////////
function updateData()
{
    global $data;
    $firstName = $_POST['tfirstName'];
    $lastName = $_POST['tlastName'];
    $address = $_POST['taddress'];
    $bday = $_POST['tbday'];
    $gender = $_POST['tgender'];
    $email = $_POST['temail'];
    $telephone = $_POST['ttelephone'];
    $eduQau = $_POST['teducationalQualifi'];

    $checkChanges = $firstName != $data['firstName'] || $lastName != $data['lastName'] || $address != $data['address'] || $bday != $data['birthDay']
        || $gender != $data['gender'] || $email != $data['email'] || $telephone != $data['telephone'] || $eduQau != $data['eduQualification'];

    $query = "UPDATE teacher SET firstName='$firstName',lastName='$lastName',address='$address',birthDay='$bday',gender='$gender',email='$email',telephone='$telephone',eduQualification='$eduQau' WHERE indexNumber='{$_SESSION["username"]}' AND password='{$_SESSION["password"]}'";
    if ($checkChanges) {
        if (sha1($_POST['updatePass']) == $_SESSION['password']) {
            runQuery($query);
            echo "<script>alert('Successfully updated!');</script>";
            echo "<script>window.location.href = 'teacher.php';</script>";
        } else {
            echo "<script>alert('Invalid Password!'); updateDetails_layer.style.display = 'block';</script>";
        }
    } else {
        echo "<script>alert('No changes detected!'); updateDetails_layer.style.display = 'block';</script>";

    }
}

if ($_SESSION['logged']) {
    if (isset($_POST['updatePass'])) {
        updateData();
    }
}

///////update details code//////////////////////////////////////////////////////////////////////////////////////////

?>
</body>
</html>
