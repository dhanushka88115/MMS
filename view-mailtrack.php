<?php
session_start();
include('includes/config.php');
error_reporting(0);                                     // Turn off error reporting
//error_reporting(E_ERROR | E_WARNING | E_PARSE);       // Report runtime errors
//error_reporting(E_ALL);                               // Report all errors
//ini_set("error_reporting", E_ALL);                    // Same as error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);                   // Report all errors except E_NOTICE

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (NULL !== filter_input(INPUT_POST, 'cancel')) {
        header('location:manage-mailtrack.php');
        exit();
    }

    $loguser = $_SESSION['login'];
    $loguserId = $_SESSION['LogEmployeeId'];

    if (isset($_POST['postmail'])) {
        if (NULL !== filter_input(INPUT_GET, 'id')) {
            $id = intval(filter_input(INPUT_GET, 'id'));
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>VIEW-ACTIONS</title>

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
                    font-size: large;
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
            $id = filter_input(INPUT_GET, 'id');
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
                        <h2 style="color: blue;">VIEW-ACTIONS</h2>
                        <br>
                        <?php if ($error) { ?>
                            <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                        <?php } else if ($msg) { ?>
                            <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                        <?php } ?>

                        <div class="block">
                            <label for="id">Mail ID</label>
                            <input type="text" name="id" id="id" value="<?php echo $result->Id; ?>" disabled>
                        </div>
                        <div class="block">
                            <label for="letno">Letter Number</label>
                            <input type="text" name="letno" id="letno" value="<?php echo $result->LetterNo; ?>" disabled>
                            <label for="dstamp">Date Stamped</label>
                            <input type="date" name="dstamp" id="dstamp" value="<?php echo $result->DateStamped; ?>" disabled>
                            <label for="mailcat">Mail Category</label>                               
                            <select name="mailcat" id="mailcat" style="width: 140px" required="required" onclick="ClearText()" disabled>
                                <option value="<?php echo $result->Category; ?>"><?php echo $result->Category; ?></option>
                            </select>   
                        </div>
                        <div class="block">
                            <label for="refno">Reference No</label>
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
                        <br>
                        <div>
                            <table id="vwtable" class="display table table-striped table-bordered table-hover" cellspacing="3" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <!--<th style="width: 10%">Mail ID</th>-->
                                        <!--<th style="width: 10%">Letter No</th>-->
                                        <!--<th style="width: 15%">Reference No</th>-->
                                        <th style="width: 10%">Action Date</th>
                                        <th style="width: 30%">From Officer</th>
                                        <th style="width: 25%">Action</th>
                                        <th style="width: 30%">To Officer</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <!--<th style="width: 10%">Mail ID</th>-->
                                        <!--<th style="width: 10%">Letter No</th>-->
                                        <!--<th style="width: 15%">Reference No</th>-->
                                        <th style="width: 10%">Action Date</th>
                                        <th style="width: 30%">From Officer</th>
                                        <th style="width: 25%">Action</th>
                                        <th style="width: 30%">To Officer</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql = "select * from vwactionstatusfinal where MailId=:id ORDER BY Id";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':id', $id, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                            ?>
                                            <tr>
                                                <td style="font-size: medium"><?php echo $cnt; ?></td>
                                                <!--<td style="font-size: medium"><?php echo $result->MailId; ?></td>-->
                                                <!--<td style="font-size: medium"><?php echo $result->LetterNo; ?></td>-->
                                                <!--<td style="font-size: medium"><?php echo $result->ReferenceNo; ?></td>-->
                                                <td style="font-size: medium"><?php echo $result->ActionDate; ?></td>
                                                <td style="font-size: medium"><?php echo $result->FromDesignationName; ?></td>
                                                <td style="font-size: medium"><?php echo $result->ActionName; ?></td>
                                                <td style="font-size: medium"><?php echo $result->ToDesignationName; ?></td>
                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br><br>
                        <div class="relative">
                            <input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>&nbsp;&nbsp;
                            <!--<input type="submit" name="postmail" id="postmail" class="navitem" value="P O S T" onclick="return confirm('After POSTING record cannot be changed, Are you sure?');">-->
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