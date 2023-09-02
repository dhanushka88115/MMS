<?php
session_start();
include('includes/config.php');
//include('includes/checklogin.php');
//check_login();
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
}

if (isset($_POST['ok'])) {
    header('location:index.php');
    exit();
}

//unset($_POST['sch']);
?>

<!doctype html>
<html lang="en" class="no-js">

    <head>
        <title>VIEW-ACTIONS</title>
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

        <style>
            .relative {
                padding: 10px;
                position: relative;
                background-color: inherit;
                margin: 2px;
            } 
            .navitem {
                display: inline-block;
                width: 120px; 
                height: 30px; 
                text-align: center;
                border: gray;
                background-color: #E8562A;
                color: #fff;
                cursor: default;
                font-weight: bold;
                font-size: medium;
            }
        </style>

    </head>

    <body>
        <form method="post" class="content-wide">
            <?php include('includes/header.php'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="color: green; font-weight: bold;">VIEW-ACTIONS</h2>
                        </div>

                        <div class="panel-body">
                            <br>
                            <div class="block" style="border:1px solid brown; width: 1120px">
                                <label style="font-weight: bold; color: green; font-size: medium;; width: 200px">Search Options:</label>          
                                <label for="fdate" style="font-weight: bold; color: blue; font-size: medium;; width: 110px">By From Date</label>                               
                                <input type="date" style="font-size: large;" name="fdate" id="fdate" required="required" onclick="ClearText()">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="tdate" style="font-weight: bold; color: blue; font-size: medium;; width: 110px">To Date</label>                               
                                <input type="date" style="font-size: large;" name="tdate" id="tdate" required="required" onclick="ClearText()">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="sch" id="sch" class="navitem" value="Refresh" formnovalidate>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="ok" id="ok" class="navitem" value="E X I T" formnovalidate>
                            </div>
                            <br>
                            <div>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 10%">ID</th>
                                            <th style="width: 10%">Letter No</th>
                                            <th style="width: 10%">Date Stamped</th>
                                            <th style="width: 10%">Reference No</th>
                                            <th style="width: 10%">Letter Date</th>
                                            <th style="width: 35%">Subject</th>
                                            <th style="color: blue; width: 10%">&nbsp;&nbsp;&nbsp;ACTIONS&nbsp;&nbsp;&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 10%">ID</th>
                                            <th style="width: 10%">Letter No</th>
                                            <th style="width: 10%">Date Stamped</th>
                                            <th style="width: 10%">Reference No</th>
                                            <th style="width: 10%">Letter Date</th>
                                            <th style="width: 35%">Subject</th>
                                            <th style="color: blue; width: 10%">&nbsp;&nbsp;&nbsp;ACTIONS&nbsp;&nbsp;&nbsp;</th>	
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['sch'])) {
                                            if ((strlen($_POST['fdate']) != 0) || (strlen($_POST['tdate']) != 0)) {
                                                $sql = "select * from tblmailmaster where DateStamped>=:nfdate and DateStamped<=:ntdate and IsPost='1' and IsDeleted='0' ORDER BY DateStamped";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':nfdate', $_POST['fdate'], PDO::PARAM_STR);
                                                $query->bindParam(':ntdate', $_POST['tdate'], PDO::PARAM_STR);
                                            } else {
                                                $sql = "select * from tblmailmaster where IsPost='1' and IsDeleted='0' ORDER BY DateStamped";
                                                $query = $dbh->prepare($sql);
                                            }
                                        } else {
                                            $sql = "select * from tblmailmaster where IsPost='1' and IsDeleted='0' ORDER BY DateStamped";
                                            $query = $dbh->prepare($sql);
                                        }
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                ?>
                                                <tr>
                                                    <td style="font-size: medium"><?php echo $cnt; ?></td>
                                                    <td style="font-size: medium"><?php echo $result->Id; ?></td>
                                                    <td style="font-size: medium"><?php echo $result->LetterNo; ?></td>
                                                    <td style="font-size: medium"><?php echo $result->DateStamped; ?></td>
                                                    <td style="font-size: medium"><?php echo $result->ReferenceNo; ?></td>
                                                    <td style="font-size: medium"><?php echo $result->LetterDate; ?></td>
                                                    <td style="font-size: medium"><?php echo $result->Subject; ?></td>
                                                    <td>
                                                        <a href="view-mailtrack.php?id=<?php echo $result->Id; ?>"><img title ="POST" src= "assets/images/view.png" width="30"></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $cnt = $cnt + 1;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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