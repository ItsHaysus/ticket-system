<?php
include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($db,$_POST['username']);
    $mypassword = mysqli_real_escape_string($db,$_POST['password']);

    $sql = "SELECT ID FROM users WHERE username = '$myusername' and passcode = '$mypassword'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $active = $row['active'];

    $count = mysqli_num_rows($result);

    if($count == 1) {
        session_register("myusername");
        $_SESSION['login_user'] = $myusername;

        header("location: http://www.google.com/");
        exit;
    }else {
        $error = "Your Login Name or Password is invalid";
    }
}
?>
<html>

<head>
    <title>UTRGV Ticket System</title>
</head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<body>
<div id="header" class="text-center well">
    <header>
        <h1>Welcome to UTRGV Ticket System</h1>
    </header>
</div>

<div align = "center">
            <form action = "" method = "post">
                <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                <input type = "submit" value = " Submit "/><br />
            </form>
</div>
<div id="fooder" class="well text-center">
    <footer>

    </footer>
</div>
</body>
</html>