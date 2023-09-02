<?php
session_start();
include('includes/config.php');
//include('includes/checklogin.php');
//check_login();
error_reporting(0);

if ((strlen($_SESSION['login']) == 0)) {
    header('location:index.php');
} else {
    if (isset($_POST['viewuser'])) {
	header('location:manage-actionstatus.php');
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
    	<title>View Action Status</title>
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

        </head>
        <body>

	    <?php
	    $id = intval($_GET['id']);
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

	    	    <h2 style="color: blue;">View Action Status</h2>
	    	    <br>
	    	    <div class="block">
	    		<label for="id">ID</label>
	    		<input type="text" name="id" value="<?php echo $result->Id; ?>" disabled>
	    	    </div>

	    	    <div class="block">
	    		<label for="actname">Action Name</label>
	    		<input type="text" name="actname" value="<?php echo $result->ActionName; ?>" disabled>
	    		<!--<span class="help-block m-b-none">ID can't be changed.</span>-->
	    	    </div>

		    <div class="block">
	    		<label for="actstat">Action Status</label>
	    		<input type="text" name="actstat" value="<?php echo $result->ActionStatus; ?>" disabled>
	    	    </div>
                    <br>
	    	    <div class="relative">
	    		<!--<button type="submit" class="navitem" name="cancel" id="cancel">Cancel</button>-->
	    		<input type="submit" name="viewuser" id="viewuser" class="navitem" value="EXIT">
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