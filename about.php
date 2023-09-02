<?php
session_start();
error_reporting(0);

if (isset($_POST['about'])) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>About Us</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/home.css" type="text/css">        
    </head>
    <style>
        div {
            text-align: justify;
            text-justify: inter-word;
            ​border: 1px solid black;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-right: 10px;
            margin-left: 10px;
            background-color: inherit;
        }

        .content-wide {
            max-width: 720px;
            margin: auto;
            background: white;
            padding: 10px;
        }

    </style>
    <body>
        <!--<div class="bg-img">-->
        <form method="post" class="content-wide">
            <?php include ('includes/header.php'); ?>
            <h2 style="color: blue;">About</h2>
            <div>
                <br>
                Mail Action Monitoring System (PassHat) is a web based Information System which facilitates to track the 
                flow of received letters and to monitor action & status of the distributed letters. It saves the information 
                of the letters electronically and provide status views of the particular letters. This software Designed 
                and Developed by the team of Sri Lanka Information and Communication Technology Service (SLICTS) on behalf 
                of the Department of Sri Lanka Railways according to the current user requirements.
            </div>
            <br>
            <div>
                Designed and Developed By:<br>
                <br>
                K.J.A.G.P. Jayawardena.<br>
                Assistant Director (ICT)<br>
                Data Processing Unit<br>
                Department of Sri Lanka Railways<br>
                Email: ictunit@railway.gov.lk<br>
                jayawardena.lk@gmail.com
            </div>
            <br>
            <div class="relative">
                <!--<p>&nbsp;</p>-->
                <input type="submit" name="about" id="about" class="navitem" value="OK">
            </div>
        </form>
        <!--</div>-->
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/chartData.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>

