<?php
	session_start();
		$LoginID = isset($_SESSION['LoginID']) ? $_SESSION['LoginID'] : "";
		if($LoginID == ""){
			echo "<script>window.alert('請先登入!');</script>";
			header("refresh:0;url=Login_test.php");
			die();
		}

	$LoginID = $_SESSION['LoginID'];
	$csrftoken = $_SESSION['token'];
	// $content=$_POST["content"];
/* 將欄位資料加入資料庫 */
	$dbhost = $_SERVER['RDS_HOSTNAME'];
    $dbport = $_SERVER['RDS_PORT'];
    $dbname = $_SERVER['RDS_DB_NAME'];
    $charset = 'utf8' ;
    $username = $_SERVER['RDS_USERNAME'];
    $password = $_SERVER['RDS_PASSWORD'];


    echo "<script>window.alert('connecting');</script>";
    // $con=mysqli_connect($host,$name,$pwd) or die("connection failed");
    $link = new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
    mysqli_query($link,"SET NAMES 'utf-8'");
    echo "<script>window.alert('connection success');</script>";

    // $sql = "SELECT PIC FROM userlists WHERE id ='$LoginID'";
    // $result = mysqli_query($link,$sql);

    // $data = mysqli_fetch_array($result['PIC']);

    if(isset($_GET['id'])) {
    	$id = $_GET['id'];
		$sql = "SELECT PIC FROM userlist WHERE id= '$id' ";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);
		
		$img = $row['PIC'];
		// header("Content-type: image/jpeg"); 
		echo base64_decode($img);

	}


    
    
    mysqli_close($link);
?>