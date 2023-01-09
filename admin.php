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
    echo '<br>userid = ' . $_SESSION['id'] . '<br>';

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
    $sql7 = "SELECT COUNT(*) as count_calls FROM calls WHERE callhangup IS NULL;";

    $result = $conn->query($sql7);
    $data2 = $result->fetch_assoc();
    $activecallcount = $data2['count_calls'];

    $sql8 = "SELECT COUNT(*) as count_completed_calls FROM calls WHERE callhangup IS NOT NULL;";
    $result = $conn->query($sql8);
    $data3 = $result->fetch_assoc();
    $completedcallcount = $data3['count_completed_calls'];

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
        <h3>Number of active calls: <?php
        echo $activecallcount
        ?></h3>        
        </div>
        <div class="col container border">
        <h3>Successful calls last hour: </h3>


           
        </div>
        <div class="col container border">
        <h3>Successful calls last day: </h3>
        </div>

        <div class="col container border">
        <h3>Successful calls last week: <?php 
        echo $completedcallcount ?>
        </h3>
        </div>


    </div>
    <div class="row">
        <div class="col container border">

        </div>
        <div class="col container border">



        </div>

    </div>

</body>





</html>