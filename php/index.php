<?php
if (isset($_POST["FormType"])){
    $type = strtolower($_POST["FormType"]);
    switch($type){
        case"login": case"register": case"logout":
            Call::Authentication($type);
    }
} else {
    print($_POST["FormType"]);
}

class Call{
    public function Authentication($auth){
        try{
            include("Authentication.php");
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
?>
