<?php
session_start();
include('includes/config.php');
error_reporting(0); // Turn off error reporting
//error_reporting(E_ERROR | E_WARNING | E_PARSE); // Report runtime errors
//error_reporting(E_ALL); // Report all errors
//ini_set("error_reporting", E_ALL); // Same as error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE); // Report all errors except E_NOTICE

header('Content-Type: text/html; charset=utf-8');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (NULL !== filter_input(INPUT_POST, 'cancel')) {          //if (isset($_POST['cancel'])) {
        header('location:manage-mail.php');
        exit();
    }

    $loguser = $_SESSION['login'];
    $loguserId = $_SESSION['LogEmployeeId'];

    if (isset($_POST['editmail'])) {         //if (NULL !== filter_input(INPUT_POST, 'editmail')) { 
        if (NULL !== filter_input(INPUT_GET, 'id')) {           //if (isset($_GET['id'])) {
            $id = intval(filter_input(INPUT_GET, 'id'));        //filter_input(INPUT_GET, 'id');
            $letno = filter_input(INPUT_POST, 'letno');         //$letno = $_POST['letno'];
            $dstamp = filter_input(INPUT_POST, 'dstamp');       //$dstamp = $_POST['dstamp'];
            $refno = filter_input(INPUT_POST, 'refno');         //$refno = $_POST['refno'];
            $dlet = filter_input(INPUT_POST, 'dlet');           //$dlet = $_POST['dlet'];
            $subject = filter_input(INPUT_POST, 'subject');     //$subject = $_POST['subject'];
            $tdesig = filter_input(INPUT_POST, 'tdesig');       //$tdesig = $_POST['tdesig'];
            $fdesig = filter_input(INPUT_POST, 'fdesig');       //$fdesig = $_POST['fdesig'];
            $mailcat = filter_input(INPUT_POST, 'mailcat');
            $mailtype = filter_input(INPUT_POST, 'mailtype');
            $actoff = filter_input(INPUT_POST, 'actoff');
            $action = filter_input(INPUT_POST, 'action');
            $actdate = filter_input(INPUT_POST, 'actdate');

            $sql = "SELECT * FROM tblmailmaster WHERE Id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                $sql = "update tblmailmaster set LetterNo=:letno, DateStamped=:dstamp, ReferenceNo=:refno, LetterDate=:dlet, Subject=:subject, ToDesig=:tdesig, FromDesig=:fdesig, Category=:mailcat, FromInstitute=:mailtype, CurrentActionId=:action, CurrentActionDate=:actdate, CurrentActionOfficerId=:actoff, UpdatedBy=:loguser, UpdatedTime=CURRENT_TIMESTAMP() where Id=:id";
                $query = $dbh->prepare($sql);
                $query->bindParam(':id', $id, PDO::PARAM_STR);
                $query->bindParam(':letno', $letno, PDO::PARAM_STR);
                $query->bindParam(':dstamp', $dstamp, PDO::PARAM_STR);
                $query->bindParam(':refno', $refno, PDO::PARAM_STR);
                $query->bindParam(':dlet', $dlet, PDO::PARAM_STR);
                $query->bindParam(':subject', $subject, PDO::PARAM_STR);
                $query->bindParam(':tdesig', $tdesig, PDO::PARAM_STR);
                $query->bindParam(':fdesig', $fdesig, PDO::PARAM_STR);
                $query->bindParam(':mailcat', $mailcat, PDO::PARAM_STR);
                $query->bindParam(':mailtype', $mailtype, PDO::PARAM_STR);
                $query->bindParam(':actoff', $actoff, PDO::PARAM_STR);
                $query->bindParam(':action', $action, PDO::PARAM_STR);
                $query->bindParam(':actdate', $actdate, PDO::PARAM_STR);
                $query->bindParam(':loguser', $loguser, PDO::PARAM_STR);
                $query->execute();

                $msg = "Mail Information succesfully Edited !";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Edit Mail</title>

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
                    font-size: large;
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
                    font-size: large;
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
            $id = filter_input(INPUT_GET, 'id');  //$id = intval($_GET['id']);
            $sql = "SELECT * from vwmailmaster where Id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
                    ?>
                    <form method="post" class="content-wide">
                        <?php include ('includes/header.php'); ?>
                        <h2 style="color: blue;">Edit Mail</h2>
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
                            <label for="letno">Letter Number</label>
                            <!--<span>Username can't be changed.</span>-->
                            <input type="text" name="letno" id="letno" value="<?php echo $result->LetterNo; ?>">
                            <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                            <label for="dstamp">Date Stamped</label>
                            <!--<span>Username can't be changed.</span>-->
                            <input type="date" name="dstamp" id="dstamp" value="<?php echo $result->DateStamped; ?>">
                            <label for="mailcat">Mail Category</label>                               
                            <select name="mailcat" id="mailcat" style="width: 140px" required="required" onclick="ClearText()">
                                <option value="<?php echo $result->Category; ?>"><?php echo $result->Category; ?></option>
                                <!--<option value="">SELECT</option>-->
                                <option value="Normal-Post">Normal-Post</option>
                                <option value="Registered-Post">Registered-Post</option>
                                <option value="By-Hand">By-Hand</option>
                            </select>   
                        </div>

                        <div class="block">
                            <!--style="text-transform: capitalize"-->
                            <label for="refno">Reference No of Letter</label>
                            <input type="text" name="refno" id="refno" value="<?php echo $result->ReferenceNo; ?>">
                            <label for="dlet">Date of Letter</label>
                            <input type="date" name="dlet" id="dlet" value="<?php echo $result->LetterDate; ?>">
                            <label for="mailtype">From Institute</label>
                            <select name="mailtype" id="mailtype" style="width: 140px" required="required" onclick="ClearText()">
                                <option value="<?php echo $result->FromInstitute; ?>"><?php echo $result->FromInstitute; ?></option>
                                <!--<option value="">SELECT</option>-->
                                <option value="PSC">PSC</option>
                                <option value="PubAd">PubAd</option>
                                <option value="MoF">MoF</option>
                                <option value="MoT">MoT</option>
                                <option value="OTHER">OTHER</option>
                            </select>   
                        </div>

                        <div class="block">
                            <label for="subject">Subject</label>
                            <input type="text" style="width: 960px;" name="subject" id="subject" value="<?php echo $result->Subject; ?>" required="required" onclick="ClearText()">
                        </div>
                        <!--<br>-->
                        <!--                        
                        <div class="block">
                            <label for="tdesig">To Designation</label>
                            <input type="text" name="tdesig" id="tdesig" value="<?php echo $result->ToDesig; ?>" required="required" onclick="ClearText()">
                            <label for="fdesig">From Designation</label>
                            <input type="text" name="fdesig" id="fdesig" value="<?php echo $result->FromDesig; ?>" required="required" onclick="ClearText()">
                        </div>
                        -->
                        <div class="block">
                            <label for="fromactoff">From Action Officer</label>
                            <select name="fromactoff" id="fromactoff" style="width: 385px" required="required" onclick="ClearText()"> 
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
                            <label for="actoff">To Action Officer</label>
                            <select name="actoff" id="actoff" style="width: 385px" required="required" onclick="ClearText()"> 
                                <option value="<?php echo $result->CurrentActionOfficerId; ?>"><?php echo $result->DesignationName; ?>&nbsp;-&nbsp;<?php echo htmlentities($result->FullName); ?></option>
                                <?php
                                $sql = "select * from vwuser";
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
                        </div>
                        <br>
                        <div class="block">
                            <label for="action">Action and Status</label>
                            <select name="action" id="action" required="required" onclick="ClearText()"> 
                                <?php
                                $sql = "select * from tblactionstatus where ActionStatus='STARTED'";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results3 = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results3 as $result3) {
                                        ?>
                                        <option value="<?php echo $result3->Id; ?>"><?php echo htmlentities($result3->ActionName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result->ActionStatus); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> 
                            <label for="actdate">Action Date</label>
                            <input type="date" style="font-size: large;" name="actdate" id="actdate" value="<?php echo $result->CurrentActionDate; ?>" required="required" onclick="ClearText()">
                        </div>
                        <br><br>
                        <div class="relative">
                            <!--<p>&nbsp;</p>-->
                            <!--<button type="submit" class="navitem" name="cancel" id="cancel">Cancel</button>-->
                            <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>
                            &nbsp;&nbsp;
                            <input type="submit" name="editmail" id="editmail" class="navitem" value="E D I T">
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