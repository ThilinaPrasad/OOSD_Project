<!--php code here-->
<?php require_once("connection/dbConnection.php");

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
    $query = "INSERT INTO student (indexNumber) VALUE ('$indexNo')";
    runQuery($query);
    echo '<script>window.location.href = "owner.php";</script>';
    exit();
}

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
    <link href="../css/courses.css" rel="stylesheet">
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
                <li><a href="courses.php">Courses</a></li>
                <li><a href="#">Site 3</a></li>
                <li><a href="#">Site 2</a></li>
                </li>
                <li ><a href="#"><img src="../img/nav/nav_logout.png" style="vertical-align: bottom">&nbsp;Log Out</a></li>
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
                        <a href="#" id="updateCourses" onclick="ownerLayers(); changeLayer(updateCourses_btn,updateCourses_layer);">Update Courses</a>
                        <a href="#" id="newStudent" onclick="ownerLayers(); changeLayer(newStudent_btn,newStudent_layer);">New Student</a>
                    </div>
                </div>

                <div id="right_container">


                    <div class="notification_panel" style="display: block;">
                        <select>
                            <option>All</option>
                            <option>Students</option>
                            <option>Teachers</option>
                        </select>
                        <textarea rows="10" columns="40" class="message" placeholder="Type Your Message Here"></textarea>
                        <ul>
                            <li><button class="clr">Clear</button></li>
                            <li><button class="send">Send</button></li>
                        </ul>
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


                                <button onclick="submitOnclick()">Add Teacher</button>
                            </form>
                        </div>
                    </div>

                    <div class="updateCourses_panel" style="display: none;">
                        <table>
                            <tr>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Class Day</th>
                                <th>Time</th>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                            <tr>
                                <td contenteditable='true'>Test Subject</td>
                                <td contenteditable='true'>Test Teacher</td>
                                <td contenteditable='true'>Test Day</td>
                                <td contenteditable='true'>Test Time</td>
                            </tr>

                        </table>
                        <ul id="update">
                            <li><button class="clr">Reset Table</button></li>
                            <li><button >Save Changes</button></li>
                        </ul>
                    </div>

                    <div class="updateDetails_panel" style="display:none;">
                        <div class="formContainer">
                            <form id="updateDetails">
                                <h1 align="center">Update Account Info</h1>
                                <Lable>Name</Lable><br>
                                <input type="text" id="firstName_u"  placeholder="First Name">
                                <input type="text" id="lastName_u"  placeholder="Last Name"><br>
                                <Lable>Address</Lable><br>
                                <textarea rows="4" columns="40" id="address_u"></textarea>
                                <br>
                                <Lable>Birthday</Lable><br>
                                <input type="date" id="bDay_u" >

                                <br>
                                <Lable>Gender</Lable><br>
                                <select id="gender_u">
                                    <option hidden>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>

                                <br>
                                <Lable>Email</Lable><br>
                                <input type="email" id="email_u" >

                                <br>
                                <Lable>Telephone</Lable><br>
                                <input type="tel" id="telephoneNo_u" >


                                <br>
                                <Lable>Create a Password</Lable><br>
                                <input type="password" id="password_u">

                                <br>
                                <Lable>Confirm Password</Lable><br>
                                <input type="password" id="confirmPassword_u" >


                                <button onclick="submitOnclick()">Update</button>
                            </form>
                        </div>
                    </div>

                    <div class="newStudent_panel" style="display: none;">
                            <button id="generateIndex">Generate Index</button>
                            <form method="post" action="owner.php" style="display: none;" id="indexForm">
                            <input type="text" name="index" id ="displayIndex"  readonly>
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
<script src="../javascript/dayTimeSelector.js"></script>
<script src="../javascript/Layers.js"></script>
<script src="../javascript/backgroundCanvas/TweenLite.min.js"></script>
<script src="../javascript/backgroundCanvas/EasePack.min.js"></script>
<script src="../javascript/backgroundCanvas/particles.js"></script>
<script src="../javascript/backgroundCanvas/rAF.js"></script>

</body>
</html>
