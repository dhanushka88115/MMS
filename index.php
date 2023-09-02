<?php
session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>PassHat Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                background-color: wheat;
            }

            .navbar {
                overflow: hidden;
                background-color: #333;
            }

            .navbar a {
                float: left;
                font-size: 16px;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            .dropdown {
                float: left;
                overflow: hidden;
            }

            .dropdown .dropbtn {
                font-size: 16px;  
                border: none;
                outline: none;
                color: white;
                padding: 14px 16px;
                background-color: inherit;
                font-family: inherit;
                margin: 0;
            }

            .navbar a:hover, .dropdown:hover .dropbtn {
                background-color: red;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                width: max-content;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            .dropdown-content a {
                float: none;
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                text-align: left;
            }

            .dropdown-content a:hover {
                background-color: #ddd;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }

            /*-----------------------------------------------------------*/
            body {font-family: Arial, Helvetica, sans-serif}
            * {box-sizing: border-box;}

            .bg-img {
                /* The image used */
                background-image: url("assets/images/banner-image1.jpg");
                min-height: 380px;
                /* Center and scale the image nicely */
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                /* Needed to position the navbar */
                position: relative;
            }

            /* Position the navbar container inside the image */
            .container {
                position: absolute;
                margin: 0px;
                width: auto;
            }

            /* The navbar */
            .topnav {
                overflow: hidden;
                background-color: #333;
            }

            /* Navbar links */
            .topnav a {
                float: left;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }

            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }

        </style>
    </head>
    <body>
        <?php include ('includes/header.php'); ?>
        <div class="bg-img">
            <div class="container">
                <div class="navbar">
                    <a href="index.php">HOME</a>
                    <?php if (strlen($_SESSION['login']) !== 0) { ?>
                        <a href="about.php">ABOUT</a>
                        <a href="manage-mailaction.php">MY-MAILBOX</a>
                        <a href="manage-mailtrack.php">VIEW-ACTIONS</a>
                        <a href="manage-mail.php">MAIL-DATA</a>
                        <div class="dropdown">
                            <button class="dropbtn">MANAGE-OPTIONS<i class="fa fa-caret-down"></i></button>
                            <div class="dropdown-content">
                                <a href="index.php">MANAGE-DESIGNATIONS</a>
                                <!--<a href="index.php">MANAGE-SUB-DEPARTMENTS</a>-->
                                <a href="index.php">MANAGE-BRANCHES</a>
                                <a href="manage-user.php">MANAGE-USER-ACCOUNTS</a>
                                <a href="manage-actionstatus.php">MANAGE-ACTION-STATUS</a>
                            </div>
                        </div>
                        <a href="update-password.php">CHANGE-PASSWORD</a>
                        <a href="logout.php">LOGOUT</a>
                        <!--<a href="#">NEW MAIL</a> This Part is added by Dhanushka and commeted to add New Menu-->
                        <!--<a href="#">NEW MAIL</a>-->
                        <!--    		    
                        <div class="dropdown">
                        <button style="color: yellow; font-size: large; background-color: #333; border-color: #333;" class="dropbtn">[<?php echo strtolower($_SESSION['login']) ?>]
                        <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                        <a href="update-password.php">PASSWORD</a>
                        <a href="logout.php">LOGOUT</a>
                        </div>
                        </div> 
                        -->
                    <?php } else { ?>
                        <a href="login.php">LOGIN</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php include ('includes/footer.php'); ?>
    </body>
</html>
