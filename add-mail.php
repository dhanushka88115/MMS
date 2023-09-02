<?php
session_start();
include('includes/config.php');
//error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

header('Content-Type: text/html; charset=utf-8');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['cancel'])) {
        header('location:manage-mail.php');
    }

    $logusername = $_SESSION['login'];
    $loguserId = $_SESSION['LogEmployeeId'];

    if (isset($_POST['addmail'])) {
        $letno = $_POST['letno'];
        $stampdate = $_POST['stampdate'];
        $refno = $_POST['refno'];
        $letdate = $_POST['letdate'];
        $subject = $_POST['subject'];
        $tdesig = $_POST['tdesig'];
        $fdesig = $_POST['fdesig'];
        $mailcat = $_POST['mailcat'];
        $mailtype = $_POST['mailtype'];
        $actoff = $_POST['actoff'];
        $actdate = $_POST['actdate'];
        $action = $_POST['action'];

        $sql = "SELECT * FROM tblmailmaster WHERE LetterNo=:letno";
        $query = $dbh->prepare($sql);
        $query->bindParam(':letno', $letno, PDO::PARAM_STR);    // Can't use $DbConnect in this method get error 
        $query->execute();
        $cnt = $query->rowCount();
//        $query->close();  //when close get error 

        if ($cnt > 0) {
            $error = "Letter Number already exist !";
        } else {
            $sql4 = "INSERT INTO tblmailmaster(LetterNo, DateStamped, ReferenceNo, LetterDate, Subject, ToDesig, FromDesig, Category, FromInstitute, CurrentActionDate, CurrentActionId, CurrentActionOfficerId, CreatedBy, CreatedTime) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP())";
            $stmt = $DbConnect->prepare($sql4);
            $rc = $stmt->bind_param('ssssssssssiis', $letno, $stampdate, $refno, $letdate, $subject, $tdesig, $fdesig, $mailcat, $mailtype, $actdate, $action, $actoff, $logusername);
            $stmt->execute();
            $stmt->close();

            $DbConnect->close();
            $msg = "New Letter added succesfully !";
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>New Mail</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

            <link rel="stylesheet" href="css/home.css" type="text/css">        

            <script type="text/javascript">
                function ClearText()
                {
                    document.getElementById("p1").innerHTML = "";
                }
            </script>

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

        </head>
        <body>
            <form method="post" class="content-wide" accept-charset="utf-8">
                <?php include ('includes/header.php'); ?>
                <h2 style="color: blue;">New Mail</h2>
                &nbsp;
                <?php if ($error) { ?>
                    <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                <?php } else if ($msg) { ?>
                    <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                <?php } ?>
                <!--<br>-->
                <div class="block">
                    <label for="letno">Letter Number</label>
                    <input type="text" style="font-size: large;" name="letno" id="letno" required="required" onclick="ClearText()">
                    <label for="stampdate">Date Stamped</label>
                    <input type="date" style="font-size: large;" name="stampdate" id="stampdate" required="required" onclick="ClearText()">
                    <label for="mailcat">Mail Category</label>                               
                    <select name="mailcat" id="mailcat" style="width: 130px" required="required" onclick="ClearText()">
                        <option value="">SELECT</option>
                        <option value="Normal-Post">Normal-Post</option>
                        <option value="Registered-Post">Registered-Post</option>
                        <option value="By-Hand">By-Hand</option>
                    </select>
                </div>
                <div class="block">
                    <label for="tdesig">Reference No of Letter</label>
                    <input type="text" style="font-size: large;" name="refno" id="refno" required="required" onclick="ClearText()">
                    <label for="letdate">Date of Letter</label>
                    <input type="date" style="font-size: large;" name="letdate" id="letdate" required="required" onclick="ClearText()">
                    <label for="mailtype">Mail Institute</label>                               
                    <select name="mailtype" id="mailtype" style="width: 130px" required="required" onclick="ClearText()">
                        <option value="">SELECT</option>
                        <option value="PSC">PSC</option>
                        <option value="PubAd">PubAd</option>
                        <option value="MoF">MoF</option>
                        <option value="MoT">MoT</option>
                        <option value="OTHER">OTHER</option>
                    </select>
                </div>
                <div class="block">
                    <!--<p class="formfield">-->
                    <!--<label style="height: 60px;" for="subject">Subject</label>-->
                    <!--<textarea style="width: 950px; height: 60px; font-size: x-large; text-align: left; background-color: inherit" type="text" name="subject" id="subject" rows="2" required="required" onclick="ClearText()"></textarea>-->
                    <!--</p>-->
                    <label for="subject">Subject / Heading</label>
                    <input type="text" style="width: 950px; font-size: large;" name="subject" id="subject" required="required" onclick="ClearText()">
                </div>
                <!--
                <div class="block">
                    <label for="tdesig">To Designation</label>
                    <input type="text" style="font-size: large;" name="tdesig" id="tdesig" required="required" onclick="ClearText()">
                    <label for="fdesig">From Designation</label>
                    <input type="text" style="font-size: large;" name="fdesig" id="fdesig" required="required" onclick="ClearText()">
                </div>
                -->
                <div class="block">
                    <label for="fromactoff">From Action Officer</label>
                    <select name="fromactoff" id="fromactoff" style="width: 385px" required="required" onclick="ClearText()"> 
                        <?php
                        $sql = "select * from vwuser where DesignationId='5'";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                ?>
                                <option value="<?php echo $result->Id; ?>"><?php echo htmlentities($result->DesignationName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result->FullName); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select> 
                    <label for="actoff">To Action Officer</label>
                    <select name="actoff" id="actoff" style="width: 385px" required="required" onclick="ClearText()"> 
                        <option value="">SELECT</option>
                        <?php
                        $sql = "select * from vwuser";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                ?>
                                <option value="<?php echo $result->Id; ?>"><?php echo htmlentities($result->DesignationName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result->FullName); ?></option>
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
                        $results2 = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results2 as $result2) {
                                ?>
                                <option value="<?php echo $result2->Id; ?>"><?php echo htmlentities($result2->ActionName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result2->ActionStatus); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select> 
                    <label for="actdate">Action Date</label>
                    <input type="date" style="font-size: large;" name="actdate" id="actdate" required="required" onclick="ClearText()">
                </div>
                <br><br><br>
                <div class="relative">
                    <!--<p>&nbsp;</p>-->
                    <input type="submit" name="cancel" id="cancel" class="navitem" value="E X I T" formnovalidate>&nbsp;&nbsp;
                    <input type="reset" name="reset" id="reset" class="navitem" value="RESET">&nbsp;&nbsp;
                    <input type="submit" name="addmail" id="addmail" class="navitem" value="S A V E">
                </div>
            </form>

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