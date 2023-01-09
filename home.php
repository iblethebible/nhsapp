<!DOCTYPE html>
<html>
    <head>
        <?php
        session_start();
if (!isset($_SESSION['loggedin'])) {
	header('location: index.html');
	exit;
}
        include 'connectdb.php';
        echo '<br>userid = ' . $_SESSION['id'];

        $userid = $_SESSION['id'];

        $sql00 = "INSERT INTO clocks (clockin, userid) VALUE (NOW(), '$userid');";
        if ($conn->query($sql00) === TRUE) {
            echo $userid . ' Clocked In';
            $current_clock_id = $conn->insert_id;
            $_SESSION["clockid"] = $current_clock_id;
            
        }
        else 'Clock in error raise to manager';

        if (isset($_GET['clock_out_button'])) {
            //$current_clock_id = $_SESSION['clockid'];
            $sql6 = "UPDATE clocks SET clockout = NOW() WHERE id = $current_clock_id;";
            if ($conn->query($sql6) === TRUE) {
                header("refresh:1;url=index.html");
            } 
            else {
                echo "Error clocking out please escalate to manager";
            }
        }

        if (isset($_GET['new_call_submit'])) {
            $var_callnumber = $_GET["phone_number_form"];
            $_SESSION["callnumber"] = $var_callnumber;
            $sql = "INSERT INTO calls (phone_number, timeofcall, priority) VALUES ('$var_callnumber', NOW(), '1');";


            if ($conn->query($sql) === TRUE) {
                echo '<br>number added to call table';
                $last_call_id = $conn->insert_id;
                $_SESSION["callid"] = $last_call_id;
                
            }
                $sql2 = "INSERT INTO call_to_staff (userid, callid) VALUES ($userid, $last_call_id);";
                if ($conn->query($sql2) === TRUE) {

                    $last_id = $conn->insert_id;
                    echo "<br>call_to_staff id is: " . $last_id;
                }
            $sql3 = "UPDATE calls SET call_to_staff = $last_id WHERE id = $last_call_id;";
                    if ($conn->query($sql3) === TRUE) {
                        header("refresh:2;url=patientdetails.php");
                        $call_to_staff_id = $conn->insert_id;                    } else {
                        echo "Error: " . $conn->error;
                    }
            
                }
                
        
       
        
            
        




?>
        <title>NHS 111</title>
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="css/main.css" rel="stylesheet">
    </head>
        <body>       
             
                <div class="row">
                <div class="col-2">
                    <div class="jumbotron jumbotron-fluid">
                    <h1 class="display-4 bg-primary text-white">NHS 111</h1>
                    <p class="lead text-primary">Taking calls and taxpayer money</p>
                    </div>
                    </div>
                    <div class="col-10">        
                        <form action="home.php" method="get">               
                    <input type="submit" class="btn btn-primary float-end" name="clock_out_button" value="Clock Out">
            </form>   
                </div>
                </div>
                <div class="row">
                    <div class="col container border">
                        <form action="home.php" method="get">
                            <input type="number" name="phone_number_form" placeholder="Phone Number">
                            <input type="submit" name="new_call_submit" value="New Call">
                        </form>
                                


                            
                    </div>



                </div>
                </div>           
           
        </body>

        
        
        
        
</html>