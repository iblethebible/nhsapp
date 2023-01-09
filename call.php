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
        echo '<br>userid = ' . $_SESSION['id'].'<br>';


        echo '<b>ON CALL </b> caller number: ' .$_SESSION["callnumber"];

        $callid = $_SESSION["callid"];
        $current_clock_id = $_SESSION['clockid'];

        if (isset($_GET['clock_out_button'])) {
            //$current_clock_id = $_SESSION['clockid'];
            $sql6 = "UPDATE clocks SET clockout = NOW() WHERE id = $current_clock_id;";
            if ($conn->query($sql6) === TRUE) {
                header("refresh:1;url=index.html");
            } else {
                echo "Error clocking out please escalate to manager";
            }
        }

if (isset($_GET['end_call_button'])) {
    $sql = "UPDATE calls SET callhangup = NOW() WHERE id = $callid;"; 
    if ($conn->query($sql) === TRUE) {
                echo '<br>Call ended';
                header("refresh:2;url=home.php");
    }
    else {
        echo "Error: " . $conn->error;
    }
}
if (isset($_GET['submit_ambulance'])) {
            $sql2 = "UPDATE calls SET ambulancecalled = 1 WHERE id = $callid;";
            if ($conn->query($sql2) === TRUE) {
                echo '<br>AMBULANCE CALLED';
            }
            else {
                echo "Error: " . $conn->error;
            }
}
if(isset($_GET['priority_submit'])) {
    $var_priority = ($_GET['priority']);
    $sql3 = "UPDATE calls SET priority = $var_priority WHERE id = $callid;";
    if ($conn->query($sql3) === TRUE) {
        echo '<br>Priority updated';
    }
    else {
        echo "Error: " . $conn->error;
    }
}
if(isset($_GET['submit_nuisance'])) {
            $sql4 = "UPDATE calls SET ifnusiance = 1 WHERE id = $callid;";
            if ($conn->query($sql4) === TRUE) {
                echo '<br>Call marked as nuisance';
            }
            else {
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
                        <form action="call.php" method="get"> 
                        <input type="submit" class="btn btn-primary float-end" name="clock_out_button" value="Clock Out">
</form>
                    </div>
                </div>
                <div class="row">
                    <div class="col container border">
                       <?php 
                       echo '<h2> Call in progress: ' . $_SESSION["callnumber"];
                       
                       //***SELECT PATIENT DETAILS AND DISPLAY THEM */
                       ?>
                       <form action="call.php" method="get">
                       <input type="submit" class="btn btn-primary float-end" name="end_call_button" value="End Call">
</form>                 </form>


                            
                    </div>
                    <div class="col container border">
                        <form action="call.php" method="get">
                    <label for="priority">Change call priority:</label>
                    <select id="priority" name="priority">
                        <option value="1">Base level</option>
                        <option value="2">Supervisor</option>
                        <option value="3">General Nurse</option>
                        <option value="4">Mental Health Nurse</option>
                        <option value="5">Doctor</option>
                        
</select>
                    <input type="submit" name="priority_submit" value="Submit">
</form>
                </div>
                <div class="col container border">
                   
                    <form action="call.php" method="get">
                        <input type="submit" class="btn btn-danger" name="submit_ambulance" value="EMERGENCY AMBULANCE">
</form>
<form action="call.php" method="get">
                        <input type="submit" class="btn btn-warning" name="submit_nuisance" value="NUISANCE CALL">
</form>
</div>


                </div>
                <div class="row">
                    <div class="col container border">
                    <form action="call.php">    
                    <h2><label for="callernotes">Caller Notes</label></h2>
                        <textarea id="callernotes" name="callernotes" rows="10" cols="50"></textarea>
                        <br>
                        <input type="submit" value="Submit" name="submit_notes">
</form>
</div>
                    <div class="col container border">
                    <h2>AI Questions</h2>

                        
</div>

                </div>           
           
        </body>

        
        
        
        
</html>