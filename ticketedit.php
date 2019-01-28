<html>
<head>
    <title>UTRGV Ticket System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style><?php include 'styles.css'?></style>
    <script>
    </script>
</head>
<body>
<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ){
    header("location: login.php");
    exit;
}
if($_SESSION["role"] !==1){
    echo "Only administrator accounts can edit tickets";
    header("location: login.php");
    exit;
}

//get data from database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id8499309_jesus');
define('DB_PASSWORD', '12qwaszx');
define('DB_NAME', 'id8499309_ticketdatabase');

$link = mysqli_connect("localhost", "id8499309_jesus", "12qwaszx", "id8499309_ticketdatabase");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$idNumber = $_GET['id'];

$sql = "SELECT ticketID, TicketFrom, TicketFromEmail, ticketName, ticketAssign, ticketMessege, ticketStatus, ticketCategory, ticketPriority FROM tickets where ticketID = '$idNumber'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$from =  $row['TicketFrom'];
$email = $row['TicketFromEmail'];
$ticketName = $row['ticketName'];
$assigned = $row['ticketAssign'];
$description=$row['ticketMessege'];
$description="<pre>" . $description . "</pre>";
$status = $row['ticketStatus'];
$category =$row['ticketCategory'];
$priority = $row['ticketPriority'];

mysqli_close($link);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newassigned = $_POST["element_5"];
    $newstatus = $_POST["element_6"];
    $newcategory = $_POST["element_7"];
    $newpriority = $_POST["element_8"];
     UploadFiles($newassigned,$newstatus,$newcategory,$newpriority,$idNumber);
     sendMail($newassigned,$newstatus,$subject,$email,$from);
    if( !headers_sent() ){
        header("Location: admin.php");
    }else{
        ?>
        <script type="text/javascript">
            document.location.href="admin.php";
        </script>
        Ticket updated
        Redirecting to <a href="admin.php">admin page</a>
        <?php
    }
    die();
}

function UploadFiles($newassigned1,$newstatus1,$newcategory1,$newpriority1,$id1)
{
    $servername = "localhost";
    $username = "id8499309_jesus";
    $password = "12qwaszx";
    $database = "id8499309_ticketdatabase";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE `tickets` SET 
       `ticketAssign` = '$newassigned1', 
       `ticketStatus` = '$newstatus1', 
       `ticketCategory` = '$newcategory1', 
       `ticketPriority` = '$newpriority1' 
       where ticketID = '$id1'";

    if (mysqli_query($conn, $sql)) {
       // echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

    function sendMail($newassigned1,$newstatus1,$subject1,$email1,$name1){

        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email1))
        {
            show_error("E-mail address not valid");
        }

        $subject ="Your Ticket Has Been Updated: ". $subject1;
        $content = "
        <div class='text-center'>
                <h1 style='background-color: #DB350F;margin:0;'>Hello $name1!</h1>
                <h1 style='background-color: #DB350F;margin:0;'>Your Ticket Has Been Updated</h1>
                <div style='background-color: whitesmoke;margin:0;'>
                <h2 style='margin:0;'>Assigned to <p style='color: blue'>$newassigned1</p></h2> 
                <h2 style='margin:0;'>Status changed to: <p style='color: blue'>$newstatus1</p></h2>
                </div>
            </div>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


        $headers .= 'From: <Systems@DONOTREPLY.com>' . "\r\n";

        mail($email1,$subject,$content,$headers);
    }

?>

<div id="container">
    <div id="header" class="text-center well utrgv">
        <header>
            <h1>Library Help Desk Tickets Admin Page</h1>
        </header>
    </div>

    <div id="body" class="center container-fluid well">
        <form id="form_46625" class="appnitro" method="post" action="">
            <div class="form_description">
                <h2>Ticket number: <?php echo $idNumber?></h2>
            </div>
            <ul>

                    <label class="description" for="element_2">From: <?php echo $from ?> </label><br/>
                    <label class="description" for="element_3">Email: <?php echo $email ?> </label><br/>
                    <label class="description" for="element_5">Assigned To </label>
                    <div>
                        <select class="element select medium" id="element_5" name="element_5">
                            <option value="<?php echo $assigned ?>" selected="selected"><?php echo $assigned ?></option>
                            <option value="None">None</option>
                            <option value="Jesus Sanchez">Jesus Sanchez</option>
                            <option value="Narda Mendoza">Narda Mendoza</option>
                            <option value="Ezequiel Melgoza">Ezequiel Melgoza</option>

                        </select>
                    </div>
                    <label id="description" class="description" for="element_4">Description:</label>
                        <div><?php echo $description ?></div>
                    <label class="description" for="element_6">Status </label>
                    <div>
                        <select class="element select medium" id="element_6" name="element_6">
                            <option value="<?php echo $status ?>" selected="selected"><?php echo $status ?></option>
                            <option value="Not Started">Not Started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Hold">Hold</option>
                            <option value="Completed">Completed</option>

                        </select>
                    </div>
                    <label class="description" for="element_7">Category </label>
                    <div>
                        <select class="element select medium" id="element_7" name="element_7">
                            <option value="<?php echo $category ?>" selected="selected"><?php echo $category ?></option>
                            <option value="OCLab">OCLab</option>
                            <option value="Staff">Staff</option>
                            <option value="ILS">ILS</option>
                            <option value="Facilities">Facilities</option>
                        </select>
                    </div>
                    <label class="description" for="element_8">Priority </label>
                    <div>
                        <select class="element select medium" id="element_8" name="element_8">
                            <option value="<?php echo $priority?>" selected="selected"><?php echo $priority?></option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <input type="hidden" name="form_id" value="46625">
                    <input id="saveForm" class="button_text" type="submit" name="submit" value="Update">
            </ul>
        </form>
    </div>

    <div id="footer" class="well text-center">
        <footer>

        </footer>
    </div>
</div>
</body>
</html>