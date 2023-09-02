<?php
session_start();
include('includes/config.php');
//error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['cancel'])) {
        header('location:manage-actionstatus.php');
    }
    if (isset($_POST['addaction'])) {
        $logusername = $_SESSION['login'];
        $actname = $_POST['actname'];
        $actstat = $_POST['actstat'];
        $datetime = date("d-m-Y h:m:s");

        $sql = "SELECT * FROM tblactionstatus WHERE ActionName=:actname";
        $query = $dbh->prepare($sql);
        $query->bindParam(':actname', $actname, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            $error = "Action Name already exist !";
        } else {

//            $sql1 = "INSERT INTO  tbluser(Username, Password, FullName, Gender, RoleId, DesignationId, SectionId, CreatedBy, CreatedTime) VALUES(:username, :newpassword, :fullname, :gender, :role, :desig, :branch, :logusername, CURRENT_TIMESTAMP())";
//            $sql2 = "INSERT INTO tbluser(Username, Password, FullName, Gender, RoleId, DesignationId, SectionId, CreatedBy, CreatedTime) VALUES(:username, :newpassword, :fullname, :gender, :role, :desig, :branch, :logusername, :datetime)";
//            $sql3 = "INSERT INTO tbluser(Username, Password, FullName, Gender, RoleId, DesignationId, SectionId, CreatedBy, CreatedTime) VALUES(:username, :newpassword, :fullname, :gender, :role, :desig, :branch, :logusername)";
//            $query = $dbh->prepare($sql2);
//            $query->bindParam(':username', $username, PDO::PARAM_STR);
//            $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
//            $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
//            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
//            $query->bindParam(':role', $role, PDO::PARAM_STR);
//            $query->bindParam(':desig', $desig, PDO::PARAM_STR);
//            $query->bindParam(':branch', $branch, PDO::PARAM_STR);
//            $query->bindParam(':logusername', $logusername, PDO::PARAM_STR);
//            $query->bindParam(':datetime', $datetime, PDO::PARAM_STR);
//            $dbh->exec($sql1);  //   OR   $query->execute();
//            $lastInsertId = $dbh->lastInsertId();
//            if ($lastInsertId) {
//                $msg = "New user added succesfully !";
//            } else {
//                $error = "Something went wrong. Please try again !";
//            }
//        $query->close();
//        $dbh->close();

            $sql4 = "INSERT INTO tblactionstatus(ActionName, ActionStatus, CreatedBy, CreatedTime) VALUES(?,?,?,CURRENT_TIMESTAMP())";
            $stmt = $DbConnect->prepare($sql4);
            $rc = $stmt->bind_param('sss', $actname, $actstat, $logusername);
            $stmt->execute();
            $stmt->close();
            $DbConnect->close();
            $msg = "New Action added succesfully !";

//            if ($DbConnect->query($sql4) === TRUE) {
//                $msg = "New user added succesfully !";
//            } else {
//                $error = "NOTE:" . $DbConnect->error;
//            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Add Action Status</title>

            <!--    	
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
            <link rel="stylesheet" href="css/bootstrap-social.css">
            <link rel="stylesheet" href="css/bootstrap-select.css">
            <link rel="stylesheet" href="css/fileinput.min.css">
            <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
            <link rel="stylesheet" href="css/style.css">
            -->
            <!--<link rel="stylesheet" href="css/style_todo.css">-->
            <link rel="stylesheet" href="css/home.css" type="text/css">

            <style>
                .block label {
                    display: inline-block;
                    vertical-align: top;
                    width: 170px;
                    height: 30px;                  
                    font-size: medium;
                    font-weight: normal;
                    text-align: left;
                    color: green;
                    background-color: #c1e2b3;
                    border-width: 4px; 
                    border-style: solid; 
                    border-color: #c1e2b3;
                }

                .block select {
                    display: inline-block;
                    vertical-align: top;
                    width: 320px;
                    height: 30px;                  
                    font-size: medium;
                    font-weight: normal;
                    text-align: left;
                    color: inherit;
                    background-color: inherit;
                    border-width: 1px; 
                    border-style: solid; 
                    border-color: inherit;
                }

                .block input[type=text]{
                    display: inline-block;
                    vertical-align: top;
                    width: 550px;
                    height: 30px;                  
                    font-size: medium;
                    font-weight: normal;
                    text-align: left;
                    color: inherit;
                    background-color: inherit;
                    border-width: 1px; 
                    border-style: solid; 
                    border-color: inherit;
                }

                .block input[type=password]{
                    display: inline-block;
                    vertical-align: top;
                    width: 320px;
                    height: 30px;                  
                    font-size: medium;
                    font-weight: normal;
                    text-align: left;
                    color: inherit;
                    background-color: inherit;
                    border-width: 1px; 
                    border-style: solid; 
                    border-color: inherit;
                }

                .block input[type=date]{
                    display: inline-block;
                    vertical-align: top;
                    width: 130px;
                    height: 30px;                  
                    font-size: medium;
                    font-weight: normal;
                    text-align: left;
                    color: inherit;
                    background-color: inherit;
                    border-width: 1px; 
                    border-style: solid; 
                    border-color: inherit;
                }
            </style>

            <script type="text/javascript">
                function ClearText()
                {
                    document.getElementById("p1").innerHTML = "";
                }
            </script>

        </head>
        <body>
            <form method="post" class="content-wide">
                <?php include ('includes/header.php'); ?>
                <!--<div class="header">-->
                <h2 style="color: blue;">Add Action Status</h2>
                <br>
                <?php if ($error) { ?>
                    <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                <?php } else if ($msg) { ?>
                    <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                <?php } ?>

                <div class="block">
                    <label for="actname">Action Name</label>
                    <input type="text" name="actname" onclick="ClearText()" class="form-control" required="required" autofocus>
                </div>

                <div class="block">
                    <label for="actstat">Action Status</label>
                    <select name="actstat" onclick="ClearText()" required="required"> 
                        <option value="">SELECT</option>
                        <option value="STARTED">STARTED</option>
                        <option value="PENDING">PENDING</option>
                        <option value="COMPLETED">COMPLETED</option>
                    </select>
                </div>
                <br><br>
                <div class="relative">
                    <!--<p>&nbsp;</p>-->
                    <input type="submit" name="cancel" id="cancel" class="navitem" value="E X I T" formnovalidate>&nbsp;&nbsp;
                    <input type="reset"  name="reset" id="reset" class="navitem" value="RESET">&nbsp;&nbsp;
                    <input type="submit" name="addaction" id="adduser" class="navitem" value="S A V E">
                </div>
            </form>

            <!--Back to top-->
            <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
            <!--/Back to top--> 

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
<?php } ?>