<?php
	session_start();
	$LoginID = isset($_SESSION['LoginID']) ? $_SESSION['LoginID'] : "";
    // $csrftoken = $_SESSION['token'];
	if($LoginID == ""){
		echo "<script>window.alert('請先登入!');</script>";
		header("refresh:0;url=Login_test.php");
		die();
	}
    if(count($_FILES) <= 0){
        echo "<script>window.alert('請先選擇檔案!');</script>";
        header("refresh:0;url=index.php");
        die();
    }
    

    //取得上傳檔案資訊
    // $filename=$_FILES['upfile']['name'];
    // $tmpname=$_FILES['upfile']['tmp_name'];
    // $filetype=$_FILES['upfile']['type'];
    // $filesize=$_FILES['upfile']['size'];    
    // $file=NULL;
/* 接收表單資料 */

	$LoginID = $_SESSION['LoginID'];

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
    echo "<script>window.alert('inserting');</script>";
    // $sql = "INSERT INTO comment_board (id,say) VALUES ('$LoginID','$content')";

    //開啟圖片檔
    $file = fopen($_FILES["upfile"]["tmp_name"], "rb");
     // 讀入圖片檔資料
    $fileContents = fread($file, filesize($_FILES["upfile"]["tmp_name"])); 
      //關閉圖片檔
    fclose($file);
  //讀取出來的圖片資料必須使用base64_encode()函數加以編碼：圖片檔案資料編碼
    $fileContents = base64_encode($fileContents);


    // $imgData =addslashes(file_get_contents($_FILES['upfile']['tmp_name']));

    // if(isset($_FILES['image']['error'])){    
    //     if($_FILES['image']['error']==0){                                    
    //         $instr = fopen($tmpname,"rb");
    //         $file = addslashes(fread($instr,filesize($tmpname)));   
    //     }
    // }

    // $sql = "INSERT INTO output_images(imageType ,imageData) VALUES('{$imageProperties['mime']}', '{$imgData}')";

    $sql = "UPDATE `userlist` SET `PIC` = '$fileContents' WHERE id = '$LoginID'";

    if (mysqli_query($link, $sql)) {
        $insert = true;
    } 
    else {
        $insert = false;
    }
    
    if($insert){
    	echo "<script>window.alert('上傳成功');</script>"; 
    	header("refresh:0;url=index.php");
    }
    // header("Content-type: image/jpeg"); 
    // echo $imgData;

    // fclose($instr);
	mysqli_close($link);
	
?>