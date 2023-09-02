<?php
session_start();
include('includes/config.php');
error_reporting(0); // Turn off error reporting
//error_reporting(E_ERROR | E_WARNING | E_PARSE); // Report runtime errors
//error_reporting(E_ALL); // Report all errors
//ini_set("error_reporting", E_ALL); // Same as error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE); // Report all errors except E_NOTICE


if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (NULL !== filter_input(INPUT_POST, 'cancel')) {  //if (isset($_POST['cancel'])) {
        header('location:manage-mail.php');
        exit();
    }

    $loguser = trim($_SESSION['login']);
    $loguserId = $_SESSION['LogEmployeeId'];

    if (isset($_POST['deletemail'])) {
        if (isset($_GET['delid'])) {
            $delid = intval($_GET['delid']);
            $sql = "SELECT * FROM tblmailmaster WHERE Id=:id and IsDeleted='0'";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $delid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
                    $sql = "update tblmailmaster set IsDeleted='1', DeletedBy=:username, DeletedTime=CURRENT_TIMESTAMP() where Id=:id";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':id', $delid, PDO::PARAM_STR);
                    $query->bindParam(':username', $loguser, PDO::PARAM_STR);
                    $query->execute();

                    $msg = "Mail deleted succesfully !";
                    // echo "<script>alert('Mail Record Deleted Successfully!');</script>";
                }
            } else {
                $error = "Mail already deleted !";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Delete Mail</title>

            <link rel="stylesheet" href="css/home.css" type="text/css">

            <style type="text/css">
                .block label {
                    display: inline-block;
                    vertical-align: top;
                    width: 175px;
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
                    border-width: 1px; 
                    border-style: solid; 
                    background-color: whitesmoke; 
                    border-color: whitesmoke;
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
                    border-width: 1px; 
                    border-style: solid; 
                    background-color: whitesmoke; 
                    border-color: whitesmoke;
                }

                .block input[type=date]{
                    display: inline-block;
                    vertical-align: top;
                    width: 130px;
                    height: 30px;                  
                    font-size: large;
                    font-weight: normal;
                    text-align: left;
                    color: inherit;
                    border-width: 1px; 
                    border-style: solid; 
                    background-color: whitesmoke; 
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
            $id = filter_input(INPUT_GET, 'delid');  //$id = intval($_GET['delid']);
            $sql = "SELECT * from vwmailmaster where Id=:id";
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

                        <h2 style="color: blue;">Delete Mail</h2>
                        <br>
                        <?php if ($error) { ?>
                            <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                        <?php } else if ($msg) { ?>
                            <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                        <?php } ?>

                        <div class="block">
                            <label for="id">ID</label>
                            <!--<span>ID can't be changed.</span>-->
                            <input type="text" name="id" value="<?php echo $result->Id; ?>" disabled>
                        </div>

                        <div class="block">
                            <label for="letno">Letter Number</label>
                            <!--<span>Username can't be changed.</span>-->
                            <input type="text" name="letno" id="letno" value="<?php echo $result->LetterNo; ?>" disabled>
                            <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                            <label for="dstamp">Date Stamped</label>
                            <!--<span>Username can't be changed.</span>-->
                            <input type="date" name="dstamp" id="dstamp" value="<?php echo $result->DateStamped; ?>" disabled>
                            <label for="mailcat">Mail Category</label>                               
                            <select name="mailcat" id="mailcat" style="width: 140px" required="required" onclick="ClearText()" disabled>
                                <option value="<?php echo $result->Category; ?>"><?php echo $result->Category; ?></option>
                            </select>   

                        </div>

                        <div class="block">
                            <!--style="text-transform: capitalize"-->
                            <label for="refno">Reference No of Letter</label>
                            <input type="text" name="refno" id="refno" value="<?php echo $result->ReferenceNo; ?>" disabled>
                            <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                            <label for="dlet">Date of Letter</label>
                            <input type="date" name="dlet" id="dlet" value="<?php echo $result->LetterDate; ?>" disabled>
                            <label for="mailtype">From Institute</label>                               
                            <select name="mailtype" id="mailtype" style="width: 140px" required="required" onclick="ClearText()" disabled>
                                <option value="<?php echo $result->FromInstitute; ?>"><?php echo $result->FromInstitute; ?></option>
                            </select>   
                        </div>
                        <div class="block">
                            <label for="subject">Subject</label>
                            <input type="text" style="width: 960px; font-size: large;" name="subject" id="subject" value="<?php echo $result->Subject; ?>" required="required" onclick="ClearText()" disabled>
                        </div>
                        <!--                            
                        <div class="block">
                            <label for="tdesig">To Designation</label>
                            <input type="text" style="font-size: large;" name="tdesig" id="tdesig" value="<?php echo $result->ToDesig; ?>" required="required" onclick="ClearText()" disabled>
                            <label for="fdesig">From Designation</label>
                            <input type="text" style="font-size: large;" name="fdesig" id="fdesig" value="<?php echo $result->FromDesig; ?>" required="required" onclick="ClearText()" disabled>
                        </div>
                        -->
                        <div class="block">
                            <label for="fromactoff">From Action Officer</label>
                            <select name="fromactoff" id="fromactoff" required="required" onclick="ClearText()" disabled> 
                                <!--<option value="">SELECT</option>-->
                                <?php
                                $sql = "select * from vwuser where DesignationId='5'";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':loguserId', $loguserId, PDO::PARAM_STR);
                                $query->execute();
                                $results2 = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results2 as $result2) {
                                        ?>
                                        <option value="<?php echo $result2->Id; ?>"><?php echo htmlentities($result2->DesignationName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result2->FullName); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> 
                            <label for="branch">To Action Officer</label>
                            <select style="width: 450px" name="branch" id="branch" required="required" onclick="ClearText()" disabled> 
                                <option value="<?php echo $result->CurrentActionOfficerId; ?>"><?php echo $result->DesignationName; ?>&nbsp;-&nbsp;<?php echo htmlentities($result->FullName); ?></option>
                            </select> 
                        </div>
                        <br>
                        <div class="block">
                            <label for="action">Action and Status</label>
                            <select name="action" id="action" required="required" onclick="ClearText()" disabled> 
                                <option value="<?php echo $result->CurrentActionId; ?>"><?php echo htmlentities($result->ActionName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result->ActionStatus); ?></option>
                            </select> 

                            <label for="actdate">Action Date</label>
                            <input type="date" style="font-size: large;" name="actdate" id="actdate" value="<?php echo $result->CurrentActionDate; ?>" required="required" onclick="ClearText()" disabled>
                        </div>

                        <br><br>
                        <div class="relative">
                            <!--<p>&nbsp;</p>-->
                            <!--<button type="submit" class="navitem" name="cancel" id="cancel">Cancel</button>-->
                            <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>&nbsp;&nbsp;
                            <input type="submit" name="deletemail" id="deletemail" class="navitem" value="DELETE" onclick="return confirm('Do you want to delete the Mail, Are you sure?');">
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