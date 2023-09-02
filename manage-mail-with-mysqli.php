<?php
session_start();
include('includes/config.php');
//include('includes/checklogin.php');
//check_login();
error_reporting(0);

header('Content-Type: text/html; charset=utf-8');

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
        <title>MAIL-DATA</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
        <form method="post" class="content-wide" accept-charset="utf-8">
            <?php include('includes/header.php'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="color: green; font-weight: bold;">MAIL-DATA</h2>
                        </div>

                        <div class="panel-body">
                            <div class="block">
                                <label style="font-weight: bold; color: blue; font-size: medium;">NEW MAIL&nbsp;</label><a href="add-mail.php"><img title ="Add New Mail" src= "assets/images/add.png" width="30"></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="ok" id="ok" class="navitem" value="E X I T" formnovalidate>
                            </div>
                            <br>
                            <div class="block" style="border:1px solid brown; width: 975px">
                                <label style="font-weight: bold; color: green; font-size: medium;; width: 200px">Search Options:</label>          
                                <label for="fdate" style="font-weight: bold; color: blue; font-size: medium;; width: 110px">By From Date</label>                               
                                <input type="date" style="font-size: large;" name="fdate" id="fdate" required="required" onclick="ClearText()">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="tdate" style="font-weight: bold; color: blue; font-size: medium;; width: 110px">To Date</label>                               
                                <input type="date" style="font-size: large;" name="tdate" id="tdate" required="required" onclick="ClearText()">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="sch" id="sch" class="navitem" value="Refresh" formnovalidate>
                            </div>
                            <br>
                            <div>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 5%">ID</th>
                                            <th style="width: 10%">Letter No</th>
                                            <th style="width: 10%">Date Stamped</th>
                                            <th style="width: 10%">Reference No</th>
                                            <th style="width: 10%">Letter Date</th>
                                            <th style="width: 35%">Subject</th>
                                            <th style="color: blue; width: 15%">&nbsp;&nbsp;&nbsp;ACTIONS&nbsp;&nbsp;&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 5%">ID</th>
                                            <th style="width: 10%">Letter No</th>
                                            <th style="width: 10%">Date Stamped</th>
                                            <th style="width: 10%">Reference No</th>
                                            <th style="width: 10%">Letter Date</th>
                                            <th style="width: 35%">Subject</th>
                                            <th style="color: blue; width: 15%">&nbsp;&nbsp;&nbsp;ACTIONS&nbsp;&nbsp;&nbsp;</th>	
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $sql4 = "select * from tblmailmaster where IsPost='0' and IsDeleted='0' ORDER BY Id";
                                        $query = $DbConnect->prepare($sql4);
                                        $query->execute();
                                        $res = $query->get_result();
                                        $query->close();
                                        $DbConnect->close();
                                        $cnt = 1;
                                        while ($row = $res->fetch_object()) {
                                            ?>
                                            <tr>
                                                <td style="font-size: medium"><?php echo $cnt; ?></td>
                                                <td style="font-size: medium"><?php echo $row->Id; ?></td>
                                                <td style="font-size: medium"><?php echo $row->LetterNo; ?></td>
                                                <td style="font-size: medium"><?php echo $row->DateStamped; ?></td>
                                                <td style="font-size: medium"><?php echo $row->ReferenceNo; ?></td>
                                                <td style="font-size: medium"><?php echo $row->LetterDate; ?></td>
                                                <td style="font-size: medium"><?php echo $row->Subject; ?></td>
                                                <td>
                                                    <a href="edit-mail.php?id=<?php echo $row->Id; ?>"><img title ="EDIT" src= "assets/images/edit.png" width="30"></a>&nbsp;&nbsp;&nbsp;
                                                    <a href="delete-mail.php?delid=<?php echo $row->Id; ?>"><img title ="DELETE" src= "assets/images/delete.png" width="30"></a>&nbsp;&nbsp;&nbsp;
                                                    <a href="view-mail.php?id=<?php echo $row->Id; ?>"><img title ="POST" src= "assets/images/view.png" width="30"></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
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