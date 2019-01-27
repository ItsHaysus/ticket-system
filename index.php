<html>
<head>
    <title>UTRGV Ticket System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style><?php include 'styles.css'?></style>
</head>
<body>
<?php
// define variables and set to empty values
$nameErr = $emailErr = $subjectErr = $categoryErr = $priorityErr  =$success="";
$name = $email = $Subject = $Description = $category = $priority = "";
$status = "Not Started";
$check1 =$check2=$check3=$check4=$check5=$check6 = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["Name"])) {
        $nameErr = "Name is required";
    } else {
        $name = $_POST['Name'];
        $check1 = true;
    }

    if (empty($_POST["Email"])) {
        $emailErr = "Email is required";
    } else {
        $email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
        $check2 = true;

    }
    if (empty($_POST["Subject"])) {
        $subjectErr = "Subject is required";
    } else {
        $Subject = check_input($_POST["Description"]);
        $check3 = true;

    }

    if (empty($_POST["Description"])) {
        $Description = "";
    } else {
        $Description  = $_POST["Description"];


        $check4 = true;
    }

    if (empty($_POST["formCategory"])) {
        $categoryErr = "Category is required";
    } else {
        $category = $_POST['formCategory'];
        $check5 = true;
    }

    if (empty($_POST["formPriority"])) {
        $priorityErr = "Priority is required";
    } else {
        $priority = $_POST['formPriority'];
        $check6 = true;
    }
    if ($check1 == true && $check2 == true && $check3 == true && $check4 == true && $check5 == true && $check6 == true) {
        UploadFiles($name, $email, $Subject, $Description, $category, $priority, $status);
        $success = "Ticket Successfully Created";
        sendMail();
    }
}

function UploadFiles($name1,$email1,$subject1,$description1,$category,$priority,$status)
{
    $servername = "localhost";
    $username = "id8499309_jesus";
    $password = "12qwaszx";
    $database = "id8499309_ticketdatabase";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = ("INSERT INTO `tickets`(`TicketFrom`, `TicketFromEmail`, `ticketName`, `ticketMessege`, `ticketStatus`, `ticketCategory`, `ticketPriority`) VALUES ('$name1','$email1','$subject1','$description1','$status','$category','$priority')");
    if ($conn->query($sql) === TRUE) {
        $success = "Ticket created successfully";
    } else {
        $success = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
function sendMail(){
    $yourname = check_input($_POST['Name']);
    $email    = check_input($_POST['Email']);
    $message  = check_input($_POST["Description"]);
    $subject = check_input($_POST['Subject']);

    $myemail  = "jesus.a.sanchez01@utrgv.edu,$email";

    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
    {
        show_error("E-mail address not valid");
    }

    $subject ="New Ticket: ". $subject;
    $content = "Hello! 
A New Ticket has been submitted by $yourname


Description:
$message
";
    $headers = "MIME-Version: 1.0" . "\r\n";

    $headers .= 'From: <Systems@DONOTREPLY.com>' . "\r\n";

    mail($myemail,$subject,$content,$headers);
}
/* Functions we used */
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{
    ?>
    <html>
    <body>

    <b>Please correct the following error:</b><br />
    <?php echo $myError; ?>

    </body>
    </html>
    <?php
    exit();
}
?>

<div id="container">
    <div id="header" class="text-center well utrgv">
        <header>
            <h1>Library Help Desk Tickets</h1>
            <a href="login.php" class="btn btn-success">Log in to manage tickets</a>
        </header>
    </div>
<div id="body">
    <div style="text-align: center;">
        <div style="display: inline-block; text-align: left;">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> " method = "post">
                <label>Name</label><span class="error">* <?php echo $nameErr;?></span><br/>
                <input type = "text" name = "Name" class = "box" value="<?php echo $name;?>"/><br />
                <label>Email</label><span class="error">* <?php echo $emailErr;?></span><br/>
                <input type = "text" name = "Email" class = "box" value="<?php echo $email;?>"/><br />
                <label>Subject</label><span class="error"><?php echo $subjectErr;?>*</span><br/>
                <input type = "text" name = "Subject" class = "box" value="<?php echo $Subject;?>"/><br />
                <label>Description</label><br/>
                <textarea name="Description" rows="5" cols="40"><?php echo $Description;?></textarea><br />
                <label>Category</label><span class="error">* <?php echo $categoryErr;?></span>
                <select name="formCategory">
                    <option value="">Select...</option>
                    <option value="OCLab">OClab</option>
                    <option value="Staff">Staff</option>
                    <option value="ILS">ILS</option>
                    <option value="Facilities">Facilities</option>
                </select>
                <label>Priority</label><span class="error">* <?php echo $priorityErr;?></span>
                <select name="formPriority">
                    <option value="">Select...</option>
                    <option value="L">Low...</option>
                    <option value="M">Medium</option>
                    <option value="H">High</option>
                </select><br />
                <input type="submit" name="test" id="test" value="Create Ticket" /><br/>
            </form>
        </div>
    </div>
    <div id="success" class="success text-center">
        <h2 class=""><?php echo $success;?></h2>
    </div>
</div>
    <div id="footer" class="well text-center">
        <footer>

        </footer>
    </div>
</div>
</body>
</html>