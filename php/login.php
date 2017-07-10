<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Login</title>
    <link rel="icon" href="../img/favicon.png">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/up_in.css" rel="stylesheet">
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

                <li class="dropdown"><a href="#">Site 3</a></li>

                <li><a href="#">Site 2</a></li>
                <li><a href="signup.php"><img src="../img/nav/nav_signup.png" style="vertical-align: bottom">&nbsp;Sign Up</a>
                </li>
                <li class="active"><a href="login.php"><img src="../img/nav/nav_login.png" style="vertical-align: bottom">&nbsp;Log
                        In</a></li>
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section class="bodyInner">
            <!--Log In forum -->
            <div class="wrapper">
                <form action="login.php" method="post">
                    <h1 align="center">Log In</h1>
                    <center><img src="../img/avatar.png" id="avatar" width="50%" height="50%"></center>
                    <br>
                    <input type="text" id="login_username" placeholder="Index Number" name="loginUsername" required><br>
                    <input type="password" id="login_password" placeholder="Password" name="loginPassword" required><br>
                    <input type="checkbox" id="keepMeLogin" checked><label for="keepMeLogin">Remember me</label>
                    <a href="#" class="forgetpsw" title="Frogot your password ?" name="forgetPassword">Forget Password?</a><br>
                    <input type="submit" value="Log In" name="loginBtn"><br>

                </form>
            </div>
            <!--Log In forum -->
        </section>
        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a href="../index.php" >Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>
</div>

<script src="../javascript/validations/Validations.js"></script>
<script src="../javascript/backgroundCanvas/TweenLite.min.js"></script>
<script src="../javascript/backgroundCanvas/EasePack.min.js"></script>
<script src="../javascript/backgroundCanvas/particles.js"></script>
<script src="../javascript/backgroundCanvas/rAF.js"></script>



<?php

require_once("connection/dbConnection.php");

function submitOnclick()
{
    global $connection;
    // echo "<script type='text/javascript'>fieldColorChange(document.getElementsByClassName('login_username'),'');fieldColorChange(document.getElementsByClassName('login_password'),'');</script>";
    session_start();
    $username = $_POST['loginUsername'];
    $password = sha1($_POST['loginPassword']);

    $char = strtoupper(substr($username, -1));
    $query = "";
    switch ($char) {
        case 'S':
            $query = "SELECT * FROM student WHERE password='{$password}' AND indexNumber ='{$username}'";
            break;
        case 'T':
            $query = "SELECT * FROM teacher WHERE password='{$password}' AND indexNumber ='{$username}'";
            break;
        case 'O':
            $query = "SELECT * FROM owner WHERE password='{$password}' AND indexNumber ='{$username}'";
            break;
        default:
            echo "<script type='text/javascript'>alert('Invalid type user!'); fieldColorChange(document.getElementById('login_username'),'red');</script>";
            break;
    }

    if ($query != "") {
        $result_set = runQuery($query);
        if (mysqli_num_rows($result_set) == 1) {
            switch ($char) {
                case "S":
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['logged'] = true;
                    header("location: student.php"); // Redirecting To Other Page
                    break;
                case "T":
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['logged'] = true;
                    header("location: teacher.php"); // Redirecting To Other Page
                    break;
                case "O":
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['logged'] = true;
                    header("location: owner.php"); // Redirecting To Other Page
                    break;
                default:
                    echo "<script type='text/javascript'>alert('Invalid Index Number or Password !'); fieldColorChange(document.getElementById('login_username'),'red'); fieldColorChange(document.getElementById('login_password'),'red');</script>";
                    break;

            }
        }else{
            echo "<script type='text/javascript'>alert('Invalid Index Number or Password !'); fieldColorChange(document.getElementById('login_username'),'red'); fieldColorChange(document.getElementById('login_password'),'red');</script>";
        }
//window.location.href = 'login.php';
    }
}
if (isset($_POST['loginBtn'])) {
    submitOnclick();
}

if (isset($_GET['forgetPassword'])) {
    echo "forget?";
}
?>
</body>
</html>