<!--php code here-->
<?php require ("connection/dbConnection.php");
require ("notifications/notifications.php");

///////////////////////////////New Student////////////////////////////////////////////////////////////
function indexGenerate()
{
    $query = "SELECT * FROM student ORDER BY id DESC LIMIT 1";
    $result_set = runQuery($query);
    if ($result_set) {
        $result_set = mysqli_fetch_assoc($result_set);
        $raw = $result_set['id']+1;
        $raw = strval($raw);
        $year = substr(strval(date("Y")),-2);
        if(strlen($raw)==1){
            return $year."000".$raw."S";
        }else if(strlen($raw)==2){
            return $year."00".$raw."S";
        }else if(strlen($raw)==3){
            return $year."0".$raw."S";
        }else if(strlen($raw)==4){
            return $year.$raw."S";
        }else{
            return "System reached the maximum number of users !";
        }

    }
}


if(isset($_POST['issue'])) {
    $indexNo = $_POST['index'];
    $stuMail = $_POST['stumail'];
    $query = "INSERT INTO student (indexNumber) VALUE ('$indexNo')";
    runQuery($query);
    if(strlen(trim($stuMail))>0) {
        sendMail($stuMail, "Your Registration Index Number of ", "This is a valid index number issued by Yureka Higner Education Institute.If you have any problem with registration please contact our office. <br><h1 align='center' style='background-color:lightgray; color:#4CAF50; width:400px; padding:20px; border:solid 4px gray; border-radius:50px; margin-left:20%; margin-top: 50px; margin-bottom: 50px;'>Index Number : " . $indexNo."</h1><br><a href='#'>Yureka Higher Education Institute</a> All Rights Reserved!", "Yureka Institute");
    }
    echo '<script>window.location.href = "owner.php";</script>';
    exit();
}

///////////////////////////////New Student////////////////////////////////////////////////////////////

///////////////////////////////Add Teacher////////////////////////////////////////////////////////////

///////////////////////////////Add Teacher////////////////////////////////////////////////////////////


///////////////////////////////Courses////////////////////////////////////////////////////////////

/////////////////////////////// Add Courses////////////////////////////////////////////////////////////

$weekDays_DD = "<option>Sunday</option>
                                <option>Monday</option>
                                <option>Tuesday</option>
                                <option>Wednesday</option>
                                <option>Thursday</option>
                                <option>Friday</option>
                                <option>Saturday</option>";

$availableHalls_DD = "<option>Hall No:1</option>
                                <option>Hall No:2</option>
                                <option>Hall No:3</option>";

$availableSubjects_DD = "";

if(isset($_POST['doneAdd'])){
    //if($_POST['upPass'] == $_SESSION['password']) { *************************************** complete this line **************
    if(true){
        $query_courseAdd = "INSERT INTO courses (subject, teacher, classDay, classTime, hall) VALUES ('{$_POST["subject"]}','{$_POST["teacher"]}','{$_POST["classDay"]}','{$_POST["classTime"]}','{$_POST["hall"]}')";
        runQuery($query_courseAdd);
        echo "<script type='text/javascript'>alert('Course Successfully Added !');</script>";
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }
}

$availableTeachers = "";
$query_teacher = "SELECT * FROM teacher";
$teachers = runQuery($query_teacher);
if(mysqli_num_rows($teachers)>0) {
    while ($teacher = mysqli_fetch_assoc($teachers)) {
        $availableTeachers.="<option>{$teacher['firstName']} {$teacher['lastName']}</option>";
    }
}else{
    $availableTeachers =  "<option>No Teachers</option>";
}

/////////////////////////////// Add Courses////////////////////////////////////////////////////////////

///////////////////////////////Update Courses////////////////////////////////////////////////////////////

//>>>>>>>>>>>>>>Load Data <<<<<<<<<<<<<<<<<<<<<<<<<
$query_courseUp = "SELECT * FROM courses";
$coursesUpdate = runQuery($query_courseUp);
$courseID_array = array();
$updateCourseDataTable = "<tr>";
while ($courseUpdate = mysqli_fetch_assoc($coursesUpdate)){
    array_push($courseID_array, $courseUpdate['courseId']);
    $availableSubjects_DD .= "<option>{$courseUpdate['subject']}</option>";
    $updateCourseDataTable .= "<td><input type='text' name='changedSub[]' value='{$courseUpdate['subject']}'></td>";
    $updateCourseDataTable .= "<td><select name='changedTeacher[]'>
                                   <option selected hidden>{$courseUpdate['teacher']}</option>
                                   {$availableTeachers}
                                </select></td>";
    $updateCourseDataTable .= "<td><select name='changedDay[]'>
                                <option selected hidden>{$courseUpdate['classDay']}</option>
                                {$weekDays_DD}
                                </select></td>";
    $updateCourseDataTable .= "<td><input type='time' name='changedTime[]' value='{$courseUpdate['classTime']}'></td>";
    $updateCourseDataTable .= "<td><select name='changedHall[]'>
                                <option selected hidden>{$courseUpdate['hall']}</option>
                                {$availableHalls_DD}
                                </select></td>";
    $updateCourseDataTable .= "</tr>";
}
//>>>>>>>>>>>>>>Load Data <<<<<<<<<<<<<<<<<<<<<<<<<

//>>>>>>>>>>>>>>Update Data<<<<<<<<<<<<<<<<<<<<<<<<<
if(isset($_POST['doneUpdate'])){
    //if($_POST['changesPass'] == $_SESSION['password']) { *************************************** complete this line **************
    if(true){
        $noOfRows = mysqli_num_rows($coursesUpdate);
        $sub_array = $_POST['changedSub'];
        $tea_array = $_POST['changedTeacher'];
        $day_array = $_POST['changedDay'];
        $time_array = $_POST['changedTime'];
        $hall_array = $_POST['changedHall'];
        for ($i=0;$i<$noOfRows;$i++){
            $query_changes = "UPDATE courses SET subject='{$sub_array[$i]}',teacher='{$tea_array[$i]}',classDay='{$day_array[$i]}',classTime ='{$time_array[$i]}' ,hall='{$hall_array[$i]}' WHERE courseID='{$courseID_array[$i]}'";
            runQuery($query_changes);
        }
        echo "<script type='text/javascript'>alert('Course details Successfully Updated !');</script>";
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
    }
}
//>>>>>>>>>>>>>>Update Data<<<<<<<<<<<<<<<<<<<<<<<<<

//>>>>>>>>>>>>>>Delete Data<<<<<<<<<<<<<<<<<<<<<<<<<

if(isset($_POST['doneDelete'])){
    //if($_POST['deletePass'] == $_SESSION['password']) { *************************************** complete this line **************
    if(true){
        echo "<script type='text/javascript'>alert({$_POST["deleteSub"]});</script>";
        $query_delete = "DELETE FROM courses WHERE subject='{$_POST["deleteSub"]}' AND teacher='{$_POST["deleteTeacher"]}' AND classDay='{$_POST["deleteDay"]}'";
        runQuery($query_delete);
        $deletedRows = mysqli_affected_rows($connection);
        if($deletedRows==1) {
            echo "<script type='text/javascript'>alert('Course Successfully Deleted !');</script>";
        }else{
            echo "<script type='text/javascript'>alert('Not found Course match with given data !');</script>";
        }
    }else{
        echo "<script type='text/javascript'>alert('Invalid Password!');</script>";
    }
    echo '<script>window.location.href = "owner.php";</script>';
    exit();
}

//>>>>>>>>>>>>>>Delete Data<<<<<<<<<<<<<<<<<<<<<<<<<


///////////////////////////////Update Courses////////////////////////////////////////////////////////////

///////////////////////////////Courses////////////////////////////////////////////////////////////

///////////////////////////////Send Notifications////////////////////////////////////////////////////////////
if(isset($_POST['sendBtn'])){
    sendNotification("Owner");
    sendNotificationMail("Yureka notification from","Owner");
        echo "<script type='text/javascript'>alert('Notification Sent!');</script>";
        echo '<script>window.location.href = "owner.php";</script>';
        exit();
}
///////////////////////////////Send Notifications////////////////////////////////////////////////////////////

?>

<!--php code here-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Owner</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
    <link href="../css/owner.css" rel="stylesheet">



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
                <li><a href="#">Site 3</a></li>
                <li><a href="#">Site 2</a></li>
                </li>
                <li ><a href="login.php"><img src="../img/nav/nav_logout.png" style="vertical-align: bottom">&nbsp;Log Out</a></li>
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section>

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
                            <ul><div id="dayTime">Good Evening !</div></ul>
                        </ul>
                        <a href="#" id="loggedName" title="Update Information" onclick="ownerLayers(); updateDetails_layer.style.display='block';">First Name</a>
                    </div>
                    <!--Day Timer and User Info-->

                    <div class="vertical-menu">
                        <a href="#" class="active" id="sendNotification" onclick="ownerLayers(); changeLayer(sendNotifi_btn,sendNotifi_layer);">Send Notifications</a>
                        <a href="#" id="advertisement" onclick="ownerLayers(); changeLayer(advertisement_btn,advertisement_layer);">Add Advertisement</a>
                        <a href="#" id="addTeacher" onclick="ownerLayers(); changeLayer(addTeacher_btn,addTeacher_layer);">Add Teacher</a>
                        <a href="#" id="updateCourses" onclick="ownerLayers(); changeLayer(updateCourses_btn,updateCourses_layer);">Manage Courses</a>
                        <a href="#" id="newStudent" onclick="ownerLayers(); changeLayer(newStudent_btn,newStudent_layer);">New Student</a>
                    </div>
                </div>

                <div id="right_container">


                    <div class="notification_panel" style="display: block;">
                        <form action="owner.php" method="post">
                            <select name="receiver">
                                <option>All</option>
                                <option>Students</option>
                                <option>Teachers</option>
                            </select>
                            <textarea rows="10" columns="40" class="message" id="notice" name="notice" placeholder="Type Your Message Here"></textarea>
                            <ul>
                                <li><button class="clr">Clear</button></li>
                                <li><button class="send" name="sendBtn" id="sendBtn">Send</button></li>
                            </ul>
                        </form>
                    </div>

                    <div class="advertisement_panel" style="display: none;">
                        <textarea rows="10" columns="40" class="message" placeholder="Add Description Here"></textarea>
                        <textarea rows="10" columns="40" class="message" placeholder="Add Description Here for Image"></textarea>
                        <input type="file" id="fileSelect" name="fileSelect" class="fileSelect">
                        <ul>
                            <li><button class="clr">Clear</button></li>
                            <li><button class="">Send</button></li>
                        </ul>
                    </div>

                    <div class="addTeacher_panel" style="display: none;">
                        <div class="formContainer">
                            <form id="signup">
                                <h1 align="center">Add Teacher</h1>
                                <Lable>Name</Lable><br>
                                <input type="text" id="firstName"  placeholder="First Name">
                                <input type="text" id="lastName"  placeholder="Last Name"><br>
                                <Lable>Address</Lable><br>
                                <textarea rows="4" columns="40" id="address"></textarea>
                                <br>
                                <Lable>Birthday</Lable><br>
                                <input type="date" id="bDay" >

                                <br>
                                <Lable>Gender</Lable><br>
                                <select id="gender">
                                    <option hidden>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>

                                <br>
                                <Lable>Email</Lable><br>
                                <input type="email" id="email" >

                                <br>
                                <Lable>Telephone</Lable><br>
                                <input type="tel" id="telephoneNo" >


                                <br>
                                <Lable>Create a Password</Lable><br>
                                <input type="password" id="password">

                                <br>
                                <Lable>Confirm Password</Lable><br>
                                <input type="password" id="confirmPassword" >


                                <button onclick="">Add Teacher</button>
                            </form>
                        </div>
                    </div>

                    <div class="updateCourses_panel" style="display: none;">
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <a href="#update_section">Update Course</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#deleteCourse_innerLink">Delete Course</a>
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Add courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <div class="formContainer" id="addCourse_innerLink">
                        <form action="owner.php" method="post" >
                            <h1 align="center">Add New Course</h1>
                            <label>Subject</label><br>
                            <input type="text" placeholder="Subject" name="subject" id="subject">
                            <label>Teacher</label><br>
                            <select name="teacher" title="Only display registered teachers" id="teacherSelect">
                                <option selected hidden>Select Teacher </option>
                                <?php
                                    echo $availableTeachers;
                                ?>
                            </select>
                            <br>
                            <label>Class Day</label><br>
                            <select name="classDay">
                                <?php
                                echo $weekDays_DD;
                                ?>
                            </select>
                            <br>
                            <label>Time</label><br>
                            <input type="time" name="classTime" id="classTime" value="06:00">
                            <br>
                            <label>Hall</label><br>
                            <select name="hall">
                                <?php
                                echo $availableHalls_DD;
                                ?>
                            </select>
                            <br>

                            <input type="submit" value="Add Course" onclick="addCourseOnClick()">

                            <!--Index container -->
                            <div id="validateAddCourse" class="modal">
                                <div class="modal-content animate">
                                    <div class="imgcontainer">
                                        <span onclick="document.getElementById('validateAddCourse').style.display='none'" class="close" title="Close Modal">&times;</span>
                                    </div>
                                    <div class="container">
                                        <label><b>Enter Password</b></label>
                                        <input type="password" placeholder="Password" name="upPass" required>
                                        <input type="submit" name="doneAdd" value="Done">
                                    </div>
                                </div>
                            </div>
                            <!---->
                        </form>
                        </div>
                        <br>

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Add courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->

                       <hr class="hr1">
                       <hr class="hr1">

                       <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>update courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <div id="update_section" >
                        <form action="owner.php" method="post">
                            <h1 align="center">Update Course</h1>
                            <table>
                                <tr>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Class Day</th>
                                    <th>Time</th>
                                    <th>Hall</th>
                                </tr>

                                <?php echo $updateCourseDataTable;?>

                            </table>
                                <input type="submit" name="updateCourses" value="Update Changes" onclick="document.getElementById('changeCourse').style.display = 'block';">
                                <!--Password for course changes -->
                                <div id="changeCourse" class="modal">
                                    <div class="modal-content animate">
                                        <div class="imgcontainer">
                                            <span onclick="document.getElementById('changeCourse').style.display='none'" class="close" title="Close Modal">&times;</span>
                                        </div>
                                        <div class="container">
                                            <label><b>Enter Password</b></label>
                                            <input type="password" placeholder="Password" name="changesPass" required>
                                            <input type="submit" name="doneUpdate" value="Save Changes">
                                        </div>
                                    </div>
                                </div>
                                <!--Password for course changes-->

                        </form>

                        </div>
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>update courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->

                        <hr class="hr1" style="margin-top: 50px;">
                        <hr class="hr1" style="margin-bottom: 50px;">

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Delete courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <div id="deleteCourse_innerLink">
                        <form action="owner.php" method="post" id="deleteBorder">
                                <h1 align="center" style="color: red;">Delete Course</h1>
                            <h6 align="center" style="font-weight: normal;"><font size="2">(*must fill all fields to delete)</font></h6>
                            <ul style="margin-left: 12%;">

                                <li><select name="deleteSub" id="deleteSub">
                                    <option selected hidden>Select Subject</option>
                                    <?php echo $availableSubjects_DD;?>
                                    </select></li>
                                    <li><select name="deleteTeacher" id="deleteTeacher">
                                            <option selected hidden>Select Teacher</option>
                                            <?php echo $availableTeachers;?>
                                        </select></li>
                                    <li><select name="deleteDay" id="deleteDay">
                                            <option selected hidden>Select Day</option>
                                            <?php echo $weekDays_DD;?>
                                        </select></li>
                                    <li><input type="submit" id="deleteBtn" value="Delete Subject" onclick="deleteOnClick();"></li>
                                </ul>
                            <!--Password for delete courses -->
                            <div id="deleteCourse" class="modal">
                                <div class="modal-content animate">
                                    <div class="imgcontainer">
                                        <span onclick="document.getElementById('deleteCourse').style.display='none'" class="close" title="Close Modal">&times;</span>
                                    </div>
                                    <div class="container">
                                        <label><b>Enter Password</b></label>
                                        <input type="password" placeholder="Password" name="deletePass" required>
                                        <input type="submit" name="doneDelete" value="Done">
                                    </div>
                                </div>
                            </div>
                            <!--Password for delete courses -->

                            </form>
                        </div>

                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Delete courses section<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                        <a href="#right_container">Add New Course</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#update_section">Update Course</a>
                        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>inner Links<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<-->
                  </div>

                  <div class="updateDetails_panel" style="display:none;">
                      <div class="formContainer">
                          <form id="oupdateDetails" action="" method="post">
                              <h1 align="center">Update Details</h1>
                              <Lable>Name</Lable>
                              <font size="2" class="warning" color="red"></font>          <!--name warning 0-->
                                <br>
                                <input type="text" id="ofirstName"  placeholder="First Name" name="ofirstName">
                                <input type="text" id="olastName"  placeholder="Last Name" name="olastName"><br>


                                <br>
                                <Lable>Address</Lable><br>
                                <textarea rows="4" columns="40" id="oaddress" name="oaddress"></textarea>
                                <br>
                                <Lable>Birthday</Lable><br>
                                <input type="date" id="obDay" name="obday">

                                <br>
                                <Lable>Gender</Lable><br>
                                <select id="ogender" name="ogender">
                                    <option hidden>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>

                                <br>
                                <Lable>Email</Lable>
                                <font size="2" class="warning" color="red"></font>  <!--email warning 1-->
                                <br>
                                <input type="email" id="oemail" name="oemail">

                                <br>
                                <Lable>Telephone</Lable>
                                <font size="2" class="warning">(*Must contain 10 digits)</font><br> <!--tel warning 2-->
                                <font size="2" class="warning" color="red"></font><br> <!--tel warning 3-->
                                <input type="tel" id="otelephoneNo" name="otelephone">

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

                    <div class="newStudent_panel" style="display: none;">
                            <button id="generateIndex">Generate Index</button>
                            <form method="post" action="owner.php" style="display: none;" id="indexForm">
                            <input type="text" name="index" id ="displayIndex"  readonly>
                                <input type="text" placeholder="Student Email Here (optianal)" title="Add student have an email" name="stumail" id="stumail">
                            <input type="submit"  id="issuedIndex" name="issue" value="Issued">
                        </form>

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

<script>
   var generate_btn = document.getElementById("generateIndex");
    var display = document.getElementById("displayIndex");
    var issuedBtn  = document.getElementById("issuedIndex");
    var formLayer = document.getElementById("indexForm");

   var index =  '<?php $indexNo = indexGenerate();
                  echo $indexNo?>';

   generate_btn.onclick = function () {
        display.value = index;
        generate_btn.style.display = "none";
        formLayer.style.display = "block";
    }

    issuedBtn.onclick = function () {
            alert(index+" Index Successfully Issued!");
            formLayer.style.display = "none";
            generate_btn.style.display = "block";
    }


</script>



<script src="../javascript/jquery/jquery-3.2.1.min.js"></script>
<script src="../javascript/validations/ownerValidations.js"></script>
<script src="../javascript/validations/Validations.js"></script>
<script src="../javascript/dayTimeSelector.js"></script>
<script src="../javascript/Layers.js"></script>
<script src="../javascript/backgroundCanvas/TweenLite.min.js"></script>
<script src="../javascript/backgroundCanvas/EasePack.min.js"></script>
<script src="../javascript/backgroundCanvas/particles.js"></script>
<script src="../javascript/backgroundCanvas/rAF.js"></script>

</body>
</html>
