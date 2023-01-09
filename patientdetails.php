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
        echo '<br>callid = ' . $_SESSION['callid'] . '<br>';
        $callid = $_SESSION["callid"];



        echo '<b>ON CALL </b> caller number: ' .$_SESSION["callnumber"];

        $current_clock_id = $_SESSION['clockid'];

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
        
if (isset($_GET['patient_details_submit'])) {
            $var_forename = $_GET["first_name_form"];
            $var_surname = $_GET["surname_form"];
            //$var_dob = $_GET["dob_form"];

            $sql = "INSERT INTO patient (firstname, lastname) VALUES ('$var_forename', '$var_surname');";

            if ($conn->query($sql) === TRUE) {
                echo '<br>Patient Details Entered';
                $patientid = $conn->insert_id;
                $sql2 = "UPDATE calls SET patient = $patientid WHERE id = $callid;";
                if ($conn->query($sql2) === TRUE) {
                    echo '<br>patientid added';
                    header("refresh:2;url=call.php");

                }
            }
            else {
                echo "Error: " . $conn->$error;
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
                        <form action="patientdetails.php" method="get">
                    <input type="submit" class="btn btn-primary float-end" name="clock_out_button" value="Clock Out">
</form>
                  
                    </div>
                </div>
                <div class="row">
                    <div class="col container border">
                        <h2>Enter new patient details</h2>
                        <form action="patientdetails.php" method="get">
                            <input type="text" name="first_name_form" placeholder="Forename">
                            <br>
                            <input type="text" name="surname_form" placeholder="Surname">
                            <br>
                            <input type="date" name="dob_form" placeholder="DOB">
                            <input type="submit" name="patient_details_submit" value="Enter details">
                        </form>
                                


                            
                    </div>
                <div class="col container border">
                    <h2>Search for current patient</h2>
                    <form action="search.php" method="get">
    <input type="text" name="search"><br>
    <input type ="submit" name="submit_button">
</form>
</div>


                </div>
                </div>           
           
        </body>

        
        
        
        
</html>