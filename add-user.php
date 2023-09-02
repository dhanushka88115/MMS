<?php
session_start();
include('includes/config.php');
//error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['cancel'])) {
        header('location:manage-user.php');
    }
    if (isset($_POST['adduser'])) {
        $logusername = $_SESSION['login'];
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $gender = $_POST['gender'];
        $role = $_POST['role'];
        $desig = $_POST['desig'];
        $branch = $_POST['branch'];
        $newpassword = md5($_POST['newpassword']);
        $confirmpassword = md5($_POST['confirmpassword']);
        $datetime = date("d-m-Y h:m:s");

        $sql = "SELECT * FROM tbluser WHERE Username=:username";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($newpassword !== $confirmpassword) {
            $error = "Your new password and retype password not matched!";
        } elseif (($query->rowCount() > 0) && ($newpassword == $confirmpassword)) {
            $error = "Username already exist !";
        } elseif (($query->rowCount() <= 0) && ($newpassword == $confirmpassword)) {

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

            $sql4 = "INSERT INTO tbluser(Username, Password, FullName, Gender, RoleId, DesignationId, SectionId, CreatedBy, CreatedTime) VALUES(?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP())";
            $stmt = $DbConnect->prepare($sql4);
            $rc = $stmt->bind_param('ssssiiis', $username, $newpassword, $fullname, $gender, $role, $desig, $branch, $logusername);
            $stmt->execute();
            $stmt->close();
            $DbConnect->close();
            $msg = "New user added succesfully !";

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
            <title>Add User</title>

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
                    border-width: 3px; 
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
                <h2 style="color: blue;">Add User</h2>
                <br>
                <?php if ($error) { ?>
                    <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                <?php } else if ($msg) { ?>
                    <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                <?php } ?>

                <div class="block">
                    <label for="username">Username</label>
                    <!--<input type="text" name="username" id="username" value="<?php echo $result->Username; ?>" onclick="ClearText()" class="form-control" required="required" autofocus>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                    <input type="text" name="username" id="username" onclick="ClearText()" class="form-control" required="required" autofocus>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="fullname">Full Name</label>
                    <!--<input type="text" name="fullname" id="fullname" value="<?php echo $result->FullName; ?>"  onclick="ClearText()" class="form-control" required="required">-->
                    <input type="text" name="fullname" id="fullname" onclick="ClearText()" class="form-control" required="required">
                </div>

                <div class="block">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" onclick="ClearText()" required="required"> 
                        <option value="">SELECT</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="role">Role Name</label>
                    <select name="role" id="role" onclick="ClearText()" required="required"> 
                        <option value="">SELECT</option>
                        <?php
                        $sql = "select * from tblrole order by Id";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results2 = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results2 as $result2) {
                                ?>
                                <option value="<?php echo $result2->Id; ?>"><?php echo htmlentities($result2->RoleName); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select> 
                </div>
                <br>
                <div class="block">
                    <label for="desig">Designation Name</label>
                    <select name="desig" id="desig" onclick="ClearText()" required="required"> 
                        <option value="">SELECT</option>
                        <?php
                        $sql = "select * from tbldesignation order by DesignationName";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results2 = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results2 as $result2) {
                                ?>
                                <option value="<?php echo $result2->Id; ?>"><?php echo htmlentities($result2->DesignationName); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="branch">Branch Name</label>
                    <select name="branch" id="branch" onclick="ClearText()" required="required"> 
                        <option value="">SELECT</option>
                        <?php
                        $sql = "select * from tblsection order by SectionName";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                ?>
                                <option value="<?php echo $result->Id; ?>"><?php echo htmlentities($result->SectionName); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select> 
                </div>
                <br>
                <div class="block">
                    <label for="newpassword">New Password</label>
                    <input type="password" placeholder="" name="newpassword" id="newpassword" onclick="ClearText()" required="required">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="confirmpassword">Retype New Password</label>
                    <input type="password" placeholder="" name="confirmpassword" id="confirmpassword" onclick="ClearText()" required="required">
                </div>
                <br>
                <div class="relative">
                    <!--<p>&nbsp;</p>-->
                    <input type="submit" name="cancel" id="cancel" class="navitem" value="E X I T" formnovalidate>&nbsp;&nbsp;
                    <input type="reset"  name="reset" id="reset" class="navitem" value="RESET">&nbsp;&nbsp;
                    <input type="submit" name="adduser" id="adduser" class="navitem" value="S A V E">
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