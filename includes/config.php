<?php
// DB credentials.
define('DB_HOST', 'localhost');
define('DB_USER', 'rootdb');
//define('DB_PASS', 'MySqlClient');
define('DB_PASS', 'My&q1P@$$w0rd');
define('DB_NAME', 'mail_track_slr_db');

// Establish database connection.
try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

//------------------------------------------------------------------------------------------------------------------------
$DbConnect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($DbConnect, "utf8");
// Check connection
if ($DbConnect->connect_error) {
    die("Connection failed: " . $DbConnect->connect_error);
} 

//------------------------------------------------------------------------------------------------------------------------
//$servername = "localhost";
//$username = "rootdb";
////$password = "MySqlClient"; //this is getting error as using double quot with $ sign on the Host
//$password = 'MySqlClient';
//$dbname = "mail_track_slr_db";
//try {
//    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//    $dbh->exec("set names utf8");
//    //set the PDO error mode to exception
//    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
//    echo "Error: " . "<br>" . $e->getMessage();
//}
?>