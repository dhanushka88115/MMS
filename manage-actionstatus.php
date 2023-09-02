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
        <title>MANAGE-ACTION-STATUS</title>
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
                            <h2 style="color: green; font-weight: bold;">MANAGE-ACTION-STATUS</h2>
                        </div>

                        <div class="panel-body">
                            <div class="block">
                                <label style="font-weight: bold; color: blue; font-size: medium;">NEW ACTION STATUS&nbsp;</label><a href="add-actionstatus.php"><img title ="Add New Mail" src= "assets/images/add.png" width="30"></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="ok" id="ok" class="navitem" value="E X I T" formnovalidate>
                            </div>
                            <br>
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="1" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">#</th>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 50%">Action Name</th>
                                        <th style="width: 20%">Action Status</th>
                                        <th style="color: blue; width: 10%">&nbsp;&nbsp;&nbsp;ACTIONS&nbsp;&nbsp;&nbsp;</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width: 10%">#</th>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 50%">Action Name</th>
                                        <th style="width: 20%">Action Status</th>
                                        <th style="color: blue; width: 10%">&nbsp;&nbsp;&nbsp;ACTIONS&nbsp;&nbsp;&nbsp;</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql = "select * from tblactionstatus where IsDeleted='0' ORDER BY Id";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                            ?>
                                            <tr>
                                                <td style="font-size: medium"><?php echo $cnt; ?></td>
                                                <td style="font-size: medium"><?php echo $result->Id; ?></td>
                                                <td style="font-size: medium"><?php echo $result->ActionName; ?></td>
                                                <td style="font-size: medium"><?php echo $result->ActionStatus; ?></td>
                                                <td>
                                                    <a href="view-actionstatus.php?id=<?php echo $result->Id; ?>"><img title ="VIEW" src= "assets/images/view.png" width="30"></a>&nbsp;&nbsp;&nbsp;
                                                    <a href="edit-actionstatus.php?id=<?php echo $result->Id; ?>"><img title ="EDIT" src= "assets/images/edit.png" width="30"></a>&nbsp;&nbsp;&nbsp;
                                                    <a href="delete-actionstatus.php?delid=<?php echo $result->Id; ?>"><img title ="DELETE" src= "assets/images/delete.png" width="30"></a>
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