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
    if (NULL !== filter_input(INPUT_POST, 'cancel')) {          //if (isset($_POST['cancel'])) {
        header('location:manage-mail.php');
        exit();
    }

    $loguser = $_SESSION['login'];
    $loguserId = $_SESSION['LogEmployeeId'];

    if (isset($_POST['postmail'])) {                            //if (NULL !== filter_input(INPUT_POST, 'editmail')) { 
        if (NULL !== filter_input(INPUT_GET, 'id')) {           //if (isset($_GET['id'])) {
            $id = intval(filter_input(INPUT_GET, 'id'));        //filter_input(INPUT_GET, 'id');
            $actoff = filter_input(INPUT_POST, 'actoff'); 
            $fromactoff = filter_input(INPUT_POST, 'fromactoff'); 
            $action = filter_input(INPUT_POST, 'action');
            $actdate = filter_input(INPUT_POST, 'actdate');

            $sql = "SELECT * FROM tblmailmaster WHERE Id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                $sql4 = "INSERT INTO tblmailaction(MailId, ActionId, ActionOfficerId, FromActionOfficerId, ActionDate, CreatedBy, CreatedTime) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP())";
                $stmt = $DbConnect->prepare($sql4);
                $rc = $stmt->bind_param('iiiiss', $id, $action, $actoff, $fromactoff, $actdate, $loguser);
                $stmt->execute();
                $stmt->close();
                $DbConnect->close();

                $sql = "update tblmailmaster set IsPost='1', UpdatedBy=:loguser, UpdatedTime=CURRENT_TIMESTAMP() where Id=:id";
                $query = $dbh->prepare($sql);
                $query->bindParam(':id', $id, PDO::PARAM_STR);
                $query->bindParam(':loguser', $loguser, PDO::PARAM_STR);
                $query->execute();

                $msg = "Record succesfully Posted !";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>POST Mail</title>

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
            $id = filter_input(INPUT_GET, 'id');                //$id = intval($_GET['id']);
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
                        <h2 style="color: blue;">POST Mail</h2>
                        <br>
                        <?php if ($error) { ?>
                            <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                        <?php } else if ($msg) { ?>
                            <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                        <?php } ?>

                        <div class="block">
                            <label for="id">ID</label>
                            <!--<span>ID can't be changed.</span>-->
                            <input type="text" name="id" id="id" value="<?php echo $result->Id; ?>" disabled>
                        </div>

                        <div class="block">
                            <label for="letno">Letter Number</label>
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
                            <select style="background-color: greenyellow; width: 390px" name="fromactoff" id="fromactoff" required="required" onclick="ClearText()"> 
                                <?php
                                $sql = "select * from vwuser where DesignationId='5'";
                                $query = $dbh->prepare($sql);
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
                            <label for="actoff">To Action Officer</label>
                            <select style="background-color: greenyellow; width: 390px" name="actoff" id="actoff" required="required" onclick="ClearText()"> 
                                <option value="<?php echo $result->CurrentActionOfficerId; ?>"><?php echo $result->DesignationName; ?>&nbsp;-&nbsp;<?php echo htmlentities($result->FullName); ?></option>
                            </select> 
                        </div>
                        <br>
                        <div class="block">
                            <label for="action">Action and Status</label>
                            <select style="background-color: greenyellow" name="action" id="action" required="required" onclick="ClearText()"> 
                                <option value="<?php echo $result->CurrentActionId; ?>"><?php echo htmlentities($result->ActionName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result->ActionStatus); ?></option>
                            </select> 
                            <label for="actdate">Action Date</label>
                            <input type="date" style="font-size: large; background-color: greenyellow" name="actdate" id="actdate" value="<?php echo $result->CurrentActionDate; ?>" required="required" onclick="ClearText()">
                            <!--<span>[ Action Date can be changed ]</span>-->
                        </div>
                        <br><br>
                        <div class="relative">
                            <!--                            
                            <a href="manage-mail.php"><img src= "assets/images/exit_alt.png" height="40" width="125"></a>&nbsp;&nbsp;
                            <a href="edit-mail.php?id=<?php echo $result->Id; ?>"><img src= "assets/images/edit_alt.png" height="40" width="125"></a>&nbsp;&nbsp;
                            <a href="edit-mail.php?id=<?php echo $result->Id; ?>"><img src= "assets/images/post.png" height="40" width="125"></a>       
                            -->
                            <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>&nbsp;&nbsp;
                            <input type="submit" name="postmail" id="postmail" class="navitem" value="P O S T" onclick="return confirm('Please check Action Officer and Action are correct, Are you sure?');">
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