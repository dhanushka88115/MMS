<?php
session_start();
include('includes/config.php');
error_reporting(0);

if ((strlen($_SESSION['login']) == 0) || (isset($_POST['cancel']))) {
    header('location:index.php');
} else {
    if (isset($_POST['cancel'])) {
	header('location:index.php');
    }

    if (isset($_POST['chngpwd'])) {
	$username = $_SESSION['login'];
	$password = md5($_POST['oldpassword']);
	$newpassword = md5($_POST['newpassword']);
	$confirmpassword = md5($_POST['confirmpassword']);
	$sql = "SELECT Password FROM tbluser WHERE Username=:username and Password=:password";
	$query = $dbh->prepare($sql);
	$query->bindParam(':username', $username, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);

	if (($query->rowCount() > 0) && ($newpassword == $confirmpassword)) {
	    $con = "update tbluser set Password=:newpassword where Username=:username";
	    $chngpwd1 = $dbh->prepare($con);
	    $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
	    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
	    $chngpwd1->execute();
	    $msg = "Your password succesfully changed !";
	} elseif (($query->rowCount() <= 0) && ($newpassword == $confirmpassword)) {
	    $error = "Your current password is not correct !";
	} elseif (($query->rowCount() <= 0) && ($newpassword !== $confirmpassword)) {
	    $error = "Your new password and retype password not matched!";
	}
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
    	<title>Change Password</title>

    	<link rel="stylesheet" href="css/home.css" type="text/css">

    	<style>
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

    	    .block input[type=password]{
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

    	    .content-wide {
    		max-width: 720px;
    		margin: auto;
    		background: white;
    		padding: 10px;
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
	    $username = $_SESSION['login'];
	    $sql = "SELECT * from tbluser where Username=:username";
	    $query = $dbh->prepare($sql);
	    $query->bindParam(':username', $username, PDO::PARAM_STR);
	    $query->execute();
	    $results = $query->fetchAll(PDO::FETCH_OBJ);
	    $cnt = 1;

	    if ($query->rowCount() > 0) {
		foreach ($results as $result) {
		    ?>
	    	<form method="post" class="content-wide">
			<?php include ('includes/header.php'); ?>
	    	    <h2 style="color: blue;">Change Password</h2>
	    	    <br>
			<?php if ($error) { ?>
			    <div class="errorWrap" id="p1" style="color: red"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
			<?php } else if ($msg) { ?>
			    <div class="succWrap" id="p1" style="color: green"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
			<?php } ?>

	    	    <div class="block">
	    		<label for="id">Username</label>
	    		<input type="text" name="id" style="background-color: whitesmoke; border-color: whitesmoke;" value="<?php echo $result->Username; ?>" disabled>
	    		<!--<span class="help-block m-b-none">Username can't be changed.</span>-->
	    	    </div>

	    	    <div class="block">
	    		<label for="username">Full Name</label>
	    		<input type="text" name="username" style="background-color: whitesmoke; border-color: whitesmoke;" value="<?php echo $result->FullName; ?>" disabled>
	    		<!--<span class="help-block m-b-none">ID can't be changed.</span>-->
	    	    </div>

	    	    <div class="block">
	    		<label for="oldpassword">Current Password</label>
	    		<input type="password" placeholder="" name="oldpassword" id="oldpassword" onclick="ClearText()" required="required" autofocus>
	    	    </div>

	    	    <div class="block">
	    		<label for="newpassword">New Password</label>
	    		<input type="password" placeholder="" name="newpassword" id="newpassword" onclick="ClearText()" required="required">
	    	    </div>

	    	    <div class="block">
	    		<label for="confirmpassword">Retype New Password</label>
	    		<input type="password" placeholder="" name="confirmpassword" id="confirmpassword" onclick="ClearText()" required="required">
	    	    </div>
	    	    <br>
	    	    <div class="relative">
	    		<input type="submit" name="cancel" id="cancel" class="navitem" value="EXIT" formnovalidate>&nbsp;&nbsp;
	    		<input type="submit" name="chngpwd" id="chngpwd" class="navitem" value="U P D A T E">
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