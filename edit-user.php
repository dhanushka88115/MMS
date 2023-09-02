<?php
session_start();
include('includes/config.php');
// Turn off error reporting
//error_reporting(0);
//
// Report runtime errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Report all errors
//error_reporting(E_ALL);
// Same as error_reporting(E_ALL);
//ini_set("error_reporting", E_ALL);
// Report all errors except E_NOTICE
//error_reporting(E_ALL & ~E_NOTICE);


if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['cancel'])) {
        header('location:manage-user.php');
    }

    if (isset($_POST['edituser'])) {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $loguser = $_SESSION['login'];
            $branch = $_POST['branch'];
            $desig = $_POST['desig'];
            $fullname = $_POST['fullname'];
            $gender = $_POST['gender'];
            $sql = "SELECT * FROM tbluser WHERE Id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                $sql = "update tbluser set FullName=:fullname, Gender=:gender, DesignationId=:desig, SectionId=:branch, UpdatedBy=:loguser, UpdatedTime=CURRENT_TIMESTAMP() where Id=:id";
                $query = $dbh->prepare($sql);
                $query->bindParam(':id', $id, PDO::PARAM_STR);
                $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->bindParam(':desig', $desig, PDO::PARAM_STR);
                $query->bindParam(':branch', $branch, PDO::PARAM_STR);
                $query->bindParam(':loguser', $loguser, PDO::PARAM_STR);
                $query->execute();

                $msg = "User Information succesfully Edited !";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Edit User</title>
            <!--    	<meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
                    <link rel="stylesheet" href="css/font-awesome.min.css">
                    <link rel="stylesheet" href="css/bootstrap.min.css">
                    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
                    <link rel="stylesheet" href="css/bootstrap-social.css">
                    <link rel="stylesheet" href="css/bootstrap-select.css">
                    <link rel="stylesheet" href="css/fileinput.min.css">
                    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
                    <link rel="stylesheet" href="css/style.css">-->

            <link rel="stylesheet" href="css/home.css" type="text/css">

            <style type="text/css">
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
            <?php
            $id = intval($_GET['id']);
            $sql = "SELECT * from vwuser where Id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
                    ?>
                    <form method="post" class="content-wide">
                        <?php include ('includes/header.php'); ?>

                        <h2 style="color: blue;">Edit User</h2>
                        <br>
                        <?php if ($error) { ?>
                            <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                        <?php } else if ($msg) { ?>
                            <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                        <?php } ?>

                        <div class="block">
                            <label for="id">ID</label>
                            <!--<span>ID can't be changed.</span>-->
                            <input style="background-color: whitesmoke; border-color: whitesmoke;" type="text" name="id" value="<?php echo $result->Id; ?>" disabled>
                        </div>

                        <div class="block">
                            <label for="username">Username</label>
                            <!--<span>Username can't be changed.</span>-->
                            <input style="background-color: whitesmoke; border-color: whitesmoke;" type="text" name="username" id="username" value="<?php echo $result->Username; ?>" disabled>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="username">Full Name</label>
                            <!--<span>Username can't be changed.</span>-->
                            <input type="text" name="fullname" id="fullname" value="<?php echo $result->FullName; ?>">
                        </div>

                        <div class="block">
                            <!--style="text-transform: capitalize"-->
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" onclick="ClearText()" required="required"> 
                                <option value="<?php echo $result->Gender; ?>"><?php echo $result->Gender; ?></option>
                                <!--<option value="">SELECT</option>-->
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select> 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="desig">Role Name</label>
                            <select name="desig" id="desig" onclick="ClearText()" required="required"> 
                                <option value="<?php echo $result->RoleId; ?>"><?php echo $result->RoleName; ?></option>
                                <!--<option value="">SELECT</option>-->
                                <?php
                                $sql = "select * from tblrole order by RoleName";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results2 = $query->fetchAll(PDO::FETCH_OBJ);
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
                                <option value="<?php echo $result->DesignationId; ?>"><?php echo $result->DesignationName; ?></option>
                                <!--<option value="">SELECT</option>-->
                                <?php
                                $sql = "select * from tbldesignation order by DesignationName";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results3 = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results3 as $result3) {
                                        ?>
                                        <option value="<?php echo $result3->Id; ?>"><?php echo htmlentities($result3->DesignationName); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="branch">Branch Name</label>
                            <select name="branch" id="branch" onclick="ClearText()" required="required"> 
                                <option value="<?php echo $result->SectionId; ?>"><?php echo $result->SectionName; ?></option>
                                <!--<option value="">SELECT</option>-->
                                <?php
                                $sql = "select * from tblsection order by SectionName";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results4 = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results4 as $result4) {
                                        ?>
                                        <option value="<?php echo $result4->Id; ?>"><?php echo htmlentities($result4->SectionName); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> 
                        </div>
                        <br><br>
                        <div class="relative">
                            <!--<p>&nbsp;</p>-->
                            <!--<button type="submit" class="navitem" name="cancel" id="cancel">Cancel</button>-->
                            <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>&nbsp;&nbsp;
                            <input type="submit" name="edituser" id="edituser" class="navitem" value="E D I T">
                        </div>
                    </form>
                    <?php
                }
            }
            ?>

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