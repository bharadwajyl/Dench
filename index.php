<?php
session_start();
if (isset($_SESSION["dench_auth"])){
    //Require DB
    require_once __DIR__ . '/php/db.php';
    $session = $_SESSION["dench_auth"];
    $sql = "SELECT fullname FROM Dunch WHERE email = '$session'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
                <link rel="stylesheet" href="assets/css/main.css">
                <main class="flex">
                    <form class="padding_2x">
                        <h1 class="title">Welcome back '. $row["fullname"].' </h1>
                        <button onclick="event.preventDefault();Perform(0)">LogOut</button>
                    </form>
                </main>
                <script type="text/javascript" src="assets/js/main.js"></script>
                ';
        }
        return 1;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<!--TITLE-->
<title>Dench Infotech</title>

<!--SHORTCUT ICON-->
<link rel="shortcut icon" href="https://denchinfotech.in/public/uploads/favicon.png">

<!--META TAGS-->
<meta charset="UTF-8">
<meta name="language" content="ES">
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<!--FONT AWESOME-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!--AJAX-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<!--GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"> 

<!--STYLE SHEET-->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/animate.css">

</head>
<body>

<!--MAIN-->
<main class="flex">
    <form id="LogIn_form" class="padding_2x">
        <header>
            <h1 class="title">LogIn Form</h1>
        </header>
        <fieldset>
            <input type="text" placeholder="email" maxlength="70" name="usname" id="usname">
        </fieldset>
        <fieldset>
            <input type="password" placeholder="Password" maxlength="20" name="pssd" id="pssd">
        </fieldset>
        <fieldset>
            <button class="btn1" id="LogIn_btn" onclick="event.preventDefault();Perform('LogIn')">LogIn</button>
        </fieldset>
        <footer>
            Don't have an account? <a href="#Register_form">create one</a>
        </footer>
    </form> 
    
    <form id="Register_form" class="padding_2x">
        <header>
            <h1 class="title">Registration Form</h1>
            <i class="fa fa-times" title="close" onclick="Perform('close')"></i>
        </header>
        <fieldset>
            <input type="text" name="fname" id="fname" placeholder="Full name" maxlength="80">
        </fieldset>
        <fieldset class="flex">
            <input type="tel" name="tel" id="tel" placeholder="Mobile no" maxlength="15" class="flex-content">
            <input type="email" name="email" id="email" placeholder="Email" maxlength="80" class="flex-content">
        </fieldset>
        <fieldset>
            <input type="date" name="dob" id="dob" placeholder="Date of birth" class="dob">
        </fieldset>
        <fieldset class="flex">
            <input type="text" name="password" id="password" placeholder="Password" maxlength="20" class="flex-content">
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm password" maxlength="20" class="flex-content">
        </fieldset>
        <fieldset>
            <button class="btn2" id="Register_btn" onclick="event.preventDefault();Perform('Register')">Register</button>
        </fieldset>
    </form>
</main>

<!--JAVASCRIPT-->
<script type="text/javascript" src="assets/js/main.js"></script>

</body>
</html>
