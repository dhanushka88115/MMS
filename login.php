<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['cancel'])) {
    header('location:index.php');
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT Id,Username,Password,FullName,RoleId FROM tbluser WHERE Username=:username and Password=:password and IsDeleted='0'";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
//            $_SESSION['login'] = $_POST['username'];
            $_SESSION['LogEmployeeId'] = $result->Id;
            $_SESSION['login'] = $result->Username;
            $_SESSION['fname'] = $result->FullName;
            $_SESSION['RoleId'] = $result->RoleId;
//        $currentpage = $_SERVER['REQUEST_URI'];
            $currentpage = "index.php";
            echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
        }
    } else {
//        echo "<script>alert('Invalid Login Details');</script>";
        $error = "Invalid Username or Password !";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/home.css" type="text/css">  

        <script type="text/javascript">
            function ClearText()
            {
                document.getElementById("p1").innerHTML = "";
            }
        </script>

    </head>

    <body>
        <!--<div class="bg-img">-->
        <form method="post" class="content">
            <?php include('includes/header.php'); ?>
            <h2 style="color: blue;">Login</h2>
            <?php if ($error) { ?>
                <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
            <?php } ?>
            <br>
            <label for="username"><b>Username</b></label>
            <input type="text" style="font-size: large;" placeholder="Username" name="username" onclick="ClearText()" required="required">
            <label for="password"><b>Password</b></label>
            <input type="password" style="font-size: large;" placeholder="Enter Password" name="password" onclick="ClearText()" required="required">
            <div class="relative">             
                <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate autofocus>&nbsp;&nbsp;&nbsp;
                <input type="submit" class="navitem" name="login" value="LOGIN">
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
