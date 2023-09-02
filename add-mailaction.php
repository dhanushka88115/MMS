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
        header('location:manage-mailaction.php');
        exit();
    }

    if (isset($_POST['addmail'])) {                             //if (NULL !== filter_input(INPUT_POST, 'editmail')) { 
        if (NULL !== filter_input(INPUT_GET, 'id')) {           //if (isset($_GET['id'])) {
            $loguser = $_SESSION['login']; 
            $loguserId = $_SESSION['LogEmployeeId'];
            $MailId = intval(filter_input(INPUT_GET, 'id'));
            $actoff = intval(filter_input(INPUT_POST, 'actoff'));
            $action = intval(filter_input(INPUT_POST, 'action'));
            $letno = filter_input(INPUT_POST, 'letno');
            $actdate = filter_input(INPUT_POST, 'actdate');

            $sql = "SELECT * FROM tblmailmaster WHERE Id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                $sql4 = "INSERT INTO tblmailaction(MailId, ActionId, ActionOfficerId, FromActionOfficerId, ActionDate, CreatedBy, CreatedTime) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP())";
                $stmt = $DbConnect->prepare($sql4);
                $rc = $stmt->bind_param('iiiiss', $MailId, $action, $actoff, $loguserId, $actdate, $loguser);
                $stmt->execute();
                $stmt->close();
                $DbConnect->close();
                $msg = "Mail Action Information succesfully Added !";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Add Mail Action</title>

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
            $id = intval(filter_input(INPUT_GET, 'id'));  //$id = intval($_GET['id']);
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

                        <h2 style="color: blue;">Add Mail Action</h2>
                        <br>
                        <?php if ($error) { ?>
                            <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                        <?php } else if ($msg) { ?>
                            <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                        <?php } ?>

                        <div class="block">
                            <label for="id">ID</label>
                            <input style="background-color: whitesmoke; border-color: whitesmoke;" type="text" name="id" value="<?php echo $result->Id; ?>" disabled>
                            <label for="mailcat">Mail Category</label>                               
                            <select style="background-color: whitesmoke; border-color: whitesmoke;" name="mailcat" id="mailcat" required="required" onclick="ClearText()" disabled>
                                <option value="<?php echo $result->Category; ?>"><?php echo $result->Category; ?></option>
                            </select>   
                        </div>

                        <div class="block">
                            <label for="letno">Letter Number</label>
                            <input style="background-color: whitesmoke; border-color: whitesmoke;" type="text" name="letno" id="letno" value="<?php echo $result->LetterNo; ?>" disabled>
                            <label for="dstamp">Date Stamped</label>
                            <input style="background-color: whitesmoke; border-color: whitesmoke;" type="date" name="dstamp" id="dstamp" value="<?php echo $result->DateStamped; ?>" disabled>
                        </div>

                        <div class="block">
                            <label for="refno">Reference No of Letter</label>
                            <input style="background-color: whitesmoke; border-color: whitesmoke;" type="text" name="refno" id="refno" value="<?php echo $result->ReferenceNo; ?>" disabled>
                            <label for="dlet">Date of Letter</label>
                            <input style="background-color: whitesmoke; border-color: whitesmoke;" type="date" name="dlet" id="dlet" value="<?php echo $result->LetterDate; ?>" disabled>
                            <label for="mailtype">From Institute</label>
                            <select name="mailtype" id="mailtype" style="width: 130px; background-color: whitesmoke; border-color: whitesmoke;" required="required" onclick="ClearText()" disabled>
                                <option value="<?php echo $result->FromInstitute; ?>"><?php echo $result->FromInstitute; ?></option>
                            </select>   
                        </div>

                        <div class="block">
                            <label for="subject">Subject</label>
                            <input type="text" style="width: 950px; background-color: whitesmoke; border-color: whitesmoke;" name="subject" id="subject" value="<?php echo $result->Subject; ?>" required="required" onclick="ClearText()" disabled>
                        </div>

                        <div class="block" style="border:1px solid brown; background-color: thistle; width: 1125px">
                            <br>
                            <label for="actoff">To Action Officer</label>
                            <select style="width: 450px; background-color: white" name="actoff" id="actoff" required="required" onclick="ClearText()"> 
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
                            <br><br>
                            <label for="action">Action and Status</label>
                            <select style="width: 450px; background-color: white" name="action" id="action" required="required" onclick="ClearText()"> 
                                <option value="">SELECT</option>
                                <?php
                                $sql = "select * from tblactionstatus where Id<>'1'";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results3 = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results3 as $result3) {
                                        ?>
                                        <option value="<?php echo $result3->Id; ?>"><?php echo htmlentities($result3->ActionName); ?>&nbsp;-&nbsp;<?php echo htmlentities($result3->ActionStatus); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> 
                            <label for="actdate">Action Date</label>
                            <input type="date" style="font-size: large; background-color: white" name="actdate" id="actdate" value="" required="required" onclick="ClearText()">
                            <br><br>
                        </div>
                        <br><br>
                        <div class="relative">
                            <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>&nbsp;&nbsp;
                            <input type="submit" name="addmail" id="addmail" class="navitem" value="A D D">
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