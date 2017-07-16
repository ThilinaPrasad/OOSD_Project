<?php

require_once("connection/dbConnection.php");

$query_courseUp = "SELECT * FROM courses";
$coursesUpdate = runQuery($query_courseUp);
$updateCourseDataTable = "<tr>";
while ($courseUpdate = mysqli_fetch_assoc($coursesUpdate)){
    $updateCourseDataTable .= "<td>{$courseUpdate['subject']}</td>";
    $updateCourseDataTable .= "<td>{$courseUpdate['teacher']}</td>";
    $updateCourseDataTable .= "<td>{$courseUpdate['classDay']}</td>";
    $updateCourseDataTable .= "<td>{$courseUpdate["classTime"]}</td>";
    $updateCourseDataTable .= "<td>{$courseUpdate["hall"]}</td>";
    $updateCourseDataTable .= "</tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Courses</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/courses.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
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
                <li class="active"><a href="courses.php">Courses</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="signup.php"><img src="../img/nav/nav_signup.png" style="vertical-align: bottom">&nbsp;Sign Up</a>
                </li>
                <li ><a href="login.php"><img src="../img/nav/nav_login.png" style="vertical-align: bottom">&nbsp;Log
                        In</a></li>
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section class="bodyInner">

            <table>
                <caption>Available Classes</caption>
                <tr>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Class Day</th>
                    <th>Time</th>
                    <th>Hall</th>
                </tr>

                <?php echo $updateCourseDataTable;?>

            </table>

        </section>
        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a href="../index.php" >Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>
</div>

<script src="../javascript/backgroundCanvas/TweenLite.min.js"></script>
<script src="../javascript/backgroundCanvas/EasePack.min.js"></script>
<script src="../javascript/backgroundCanvas/particles.js"></script>
<script src="../javascript/backgroundCanvas/rAF.js"></script>
</body>
</html>

