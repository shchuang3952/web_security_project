<?php
	session_start();
	$LoginID = isset($_SESSION['LoginID']) ? $_SESSION['LoginID'] : "";
    $csrftoken = $_SESSION['token'];
	if($LoginID == ""){
		echo "<script>window.alert('請先登入!');</script>";
		header("refresh:0;url=Login_test.php");
		die();
	}
    if($csrftoken != $_POST["token"]){
        echo "<script>window.alert('請先登入!');</script>";
        session_destroy();
        header("refresh:0;url=Login_test.php");

        die();
    }
/* 接收表單資料 */
	$LoginID = $_SESSION['LoginID'];
	$no=$_POST["no"];
/* 將欄位資料加入資料庫 */
	$dbhost = $_SERVER['RDS_HOSTNAME'];
    $dbport = $_SERVER['RDS_PORT'];
    $dbname = $_SERVER['RDS_DB_NAME'];
    $charset = 'utf8' ;
    $username = $_SERVER['RDS_USERNAME'];
    $password = $_SERVER['RDS_PASSWORD'];


    //echo "<script>window.alert('connecting');</script>";
    // $con=mysqli_connect($host,$name,$pwd) or die("connection failed");
    $link = new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
    mysqli_query($link,"SET NAMES 'utf-8'");
    //echo "<script>window.alert('connection success');</script>";
    //echo "<script>window.alert('inserting');</script>";

    ////////////////////////////////////////////////////////

    $sql = "UPDATE `comment_board` SET `toshow` = 'Y' WHERE id = '$LoginID' AND counter = $no";
    if (mysqli_query($link, $sql)) {
        $insert = true;
    } 
    else {
        $insert = false;
        echo "<script>window.alert('恢復留言失敗');</script>"; 
        header("refresh:0;url=view.php");
    }
    if($insert){
    	echo "<script>window.alert('恢復留言成功');</script>"; 
    	header("refresh:0;url=view.php");
    }
	mysqli_close($link);
	
?>