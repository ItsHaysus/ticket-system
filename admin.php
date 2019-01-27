<html>
<head>
    <title>UTRGV Ticket System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style><?php include 'styles.css'?></style>
    <script>
        $(document).ready(function() {

            $('#example tr').click(function() {
                var href = $(this).find("a").attr("href");
                if(href) {
                    window.location = href;
                }
            });

        });
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

$sql = "SELECT ticketID, TicketFrom, TicketFromEmail, ticketName, ticketAssign, ticketMessege, ticketStatus, ticketCategory, ticketPriority FROM tickets where ticketStatus <> 'Completed'";
$numofTickets = mysqli_num_rows($result);


?>

<div id="container">
    <div id="header" class="text-center well utrgv">
        <header>
            <h1>Library Help Desk Tickets Admin Page</h1>
        </header>
    </div>

    <div id="body" class="center">
        <table id="example">
            <tr><th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Category</th>
            </tr>
                <?php
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){;
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                            echo "<td><a href='ticketedit.php'>Edit</a></td>";
                            echo "<td>" . $row['ticketID'] . "</td>";
                            echo "<td>" . $row['TicketFrom'] . "</td>";
                            echo "<td>" . $row['ticketName'] . "</td>";
                            echo "<td>" . $row['ticketStatus'] . "</td>";
                            echo "<td>" . $row['ticketCategory'] . "</td>";
                            echo "</tr>";
                        }
                        mysqli_free_result($result);
                    } else{
                        echo "No records matching your query were found.";
                    }
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }

                // Close connection
                mysqli_close($link);
                ?>
        </table>

    </div>

    <div id="footer" class="well text-center">
        <footer>

        </footer>
    </div>
</div>
</body>
</html>