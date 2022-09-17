<?php
if (isset($auth) && $auth == "register"){

    //Variables
    $error = false;
    
    //Validate fields
    $fields =  array ("fname" => ''.$_POST["fname"].'', "tel" => ''.$_POST["tel"].'', "email" => ''.$_POST["email"].'', "dob" => ''.$_POST["dob"].'', "pssd" => ''.$_POST["password"].'', "cpssd" => ''.$_POST["cpassword"].'');
    foreach($fields as $values) { 
        if (empty($values)) { $error = true; }
    }
    
    //Check if fields are empty
    if ($error) {
        echo "All fields are mandatory"; return 1;
    }
    
    //Validate name
    if (!preg_match("/^([a-zA-Z' ]+)$/", $fields["fname"])){print "Invalid username"; return 1;}
    
    //Validate contact no
    if(!preg_match('/^[0-9]{10}+$/', $fields["tel"])){print "Invalid contact no"; return 1;}
    $initial_no = array(0,1,2,3,4,5);
    foreach ($initial_no as $ino){
        if ($ino == substr($fields["tel"], 0, 1)){print "Invalid contact no"; return 1;}
    }
    
    //Validate email
    $domains = array('gmail.com', 'outlook.com', 'yahoo.in', 'yahoo.com', 'hotmail.com');
    $pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]*(" . implode('|', $domains) . ")$/i";
    if(!preg_match($pattern, $fields["email"])) {print "Temporary emails are not allowed"; return 1;}
    if(!filter_var($fields["email"], FILTER_VALIDATE_EMAIL)){print "Invalid email format"; return 1;}
    
    //Validate dob
    $today = date("Y-m-d");
    $diff = date_diff(date_create($fields["dob"]), date_create($today));
    if ($fields["dob"] > $today){
        print "Invalid Dob"; return 1;
    }
    if ($diff->format('%y') < "18"){
        print "Your age is less than 18"; return 1;
    }
    
    //Validate password
    $uppercase = preg_match('@[A-Z]@', $fields["pssd"]);
    $lowercase = preg_match('@[a-z]@', $fields["pssd"]);
    $number    = preg_match('@[0-9]@', $fields["pssd"]);
    $specialChars = preg_match('@[^\w]@', $fields["pssd"]);
    $length = strlen($fields["pssd"]);

    if (!$uppercase) { print "Password with atleast 1 uppercase letter"; return 1;}
    if (!$lowercase) { print "Password with atleast 1 lowercase letter"; return 1;}
    if (!$number) { print "Password with atleast 1 numerical value"; return 1;}
    if (!$specialChars) { print "Password with atleast 1 special character"; return 1;}
    if ($length < 8 || $length > 15) { print "Password in between 8 - 15 characters"; return 1;}
    
    //Confirm password
    if ($fields["pssd"] != $fields["cpssd"]){
        print "Password missmatch"; return 1;
    }
    
    //Require DB
    require("db.php");
    
    //Final filter
    $user = preg_replace('/[^A-Za-z0-9\-]/', '', $fields["fname"]);
    $contact = preg_replace('/[^A-Za-z0-9\-]/', '', $fields["tel"]);
    $mail = mysqli_real_escape_string($conn, $fields['email']);
    $dob = mysqli_real_escape_string($conn, $fields['dob']);
    $powd = mysqli_real_escape_string($conn, $fields['pssd']);
    
    //Check for previous data
    $sql = "SELECT email, contact FROM Dunch WHERE email = '$mail' OR contact='$contact'";
    if ($conn->query($sql)->num_rows > 0) {
        print "Either email or contactno is already in use"; return 1;
    }
    
    //Insert into DB
    $sql = "INSERT INTO Dunch (fullname, contact, email, dob, pssd, date) VALUES ('$user', '$contact', '$mail', '$dob', '$powd', '$today')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successfull";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
} else if (isset($auth) && $auth == "login"){
    //Require DB
    require("db.php");
    
    //Variables
    $mail = $_POST["usname"];
    $powd = $_POST["pssd"];
    
    //Check for data
    $sql = "SELECT email, pssd FROM Dunch WHERE email = '$mail' AND pssd='$powd'";
    if ($conn->query($sql)->num_rows > 0) {
        session_start();
        $_SESSION["dench_auth"] = "$mail";
        print "LoggedIn"; 
    } else {
        print "Credentials unfound"; return 1;
    }
} else if(isset($auth) && $auth == "logout") {
    session_start();
    $_SESSION["dench_auth"] = "";
    print "LoggedOut";
} else {
    print("Direct access not allowed");
}
?>
