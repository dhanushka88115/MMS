<?php
session_start();
include('includes/config.php');
//include('includes/checklogin.php');
//check_login();
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['cancel'])) {
        header('location:manage-action-status.php');
    }

    if (isset($_POST['delactstat'])) {
        if (isset($_GET['delid'])) {
            $delid = intval($_GET['delid']);
            $loguser = trim($_SESSION['login']);
            $sql = "SELECT * FROM tblactionstatus WHERE Id=:id and IsDeleted='0'";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $delid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if (($query->rowCount() > 0)) {
                foreach ($results as $result) {
                    $sql = "update tblactionstatus set IsDeleted='1', DeletedBy=:username, DeletedTime=CURRENT_TIMESTAMP() where Id=:id";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':id', $delid, PDO::PARAM_STR);
                    $query->bindParam(':username', $loguser, PDO::PARAM_STR);
                    $query->execute();

                    $msg = "Action Status deleted succesfully !";
                    // echo "<script>alert('User Record Deleted Successfully!');</script>";
                    // header('location:manage-user.php');
                }
            } else {
                $error = "Action Status already deleted !";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Delete Action Status</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
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
                .block input[type=text]{
                    display: inline-block;
                    vertical-align: top;
                    width: 320px;
                    height: 30px;                  
                    font-size: medium;
                    font-weight: normal;
                    text-align: left;
                    color: inherit;
                    background-color: whitesmoke;
                    border-width: 1px; 
                    border-style: solid; 
                    border-color: whitesmoke;
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
            $id = intval($_GET['delid']);
            $sql = "SELECT * from tblactionstatus where Id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;

            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
                    ?>
                    <form method="post" class="content-wide">
                        <?php include ('includes/header.php'); ?>

                        <h2 style="color: blue;">Delete Action Status</h2>
                        <br>
                        <?php if ($error) { ?>
                            <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                        <?php } else if ($msg) { ?>
                            <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                        <?php } ?>

                        <div class="block">
                            <label for="id" class="label-bold">ID</label>
                            <input type="text" name="id" value="<?php echo $result->Id; ?>" disabled>
                        </div>

                        <div class="block">
                            <label for="username">Action Name</label>
                            <input type="text" name="username" value="<?php echo $result->ActionName; ?>" disabled>
                        </div>

                        <div class="block">
                            <label for="gender">Action Status</label>
                            <input type="text" name="fullname" value="<?php echo $result->ActionStatus; ?>" disabled>
                        </div>
                        <br>
                        <div class="relative">
                            <!--<button type="submit" class="navitem" name="cancel" id="cancel">Cancel</button>-->
                            <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>&nbsp;&nbsp;
                            <input type="submit" name="delactstat" id="delactstat" class="navitem" value="D E L E T E" onclick="return confirm('Do you want to delete the user, Are you sure?');">
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