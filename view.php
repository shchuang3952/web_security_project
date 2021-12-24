<html>
	<head>
		<title>列出所有留言</title>
		<?php
			session_start();
			$LoginID = isset($_SESSION['LoginID']) ? $_SESSION['LoginID'] : "";
			$csrftoken = $_SESSION['token'];
			if($LoginID == ""){
				echo "<script>window.alert('請先登入!');</script>";
				header("refresh:0;url=Login_test.php");
				die();
			}
			mysqli_close($link);
		?>
	</head>
	<body>
		<p><a href="commentboard.php">寫寫留言</a></p>
		<p><a href="index.php">回首頁</a></p>
		<?php
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
		/* 查詢欄位資料 */
			$sql="SELECT * FROM comment_board ORDER BY counter";  //從guestbook讀取資料並依no欄位做遞減排序
			$result=mysqli_query($link,$sql);
			/* 顯示資料庫資料 */
			echo "<br>";
			while ($row=mysqli_fetch_row($result))
			{
				if($row[4] == "Y"){
					echo "訪客姓名:".htmlspecialchars($row[0]);
					echo "<br>";
					$result1 = mysqli_query($link,"SELECT PIC FROM userlist WHERE id = '$row[0]'");
        
			        foreach($result1 as $value){
			            $img = $value['PIC'];
			            echo "<img src='data:image/jpg;base64,".$img."'witdh='50' height='50'>";
			            // echo $img;
			       	}
					
					echo "<br>留言內容:".htmlspecialchars(nl2br($row[1]));

					echo "<br>留言時間:".$row[3];

					if($row[0] == $LoginID){
						echo "<form method='POST' action='delete.php'>
								<input type='hidden' name='no' value='".$row[2]."'>
								<input type='hidden' name='token' value='".$csrftoken."'>
								<input type = 'submit' name='delete' value='刪除留言'>
							</form>";
					}
					
				}
				else{
					echo "訪客姓名:".htmlspecialchars($row[0]);
					echo "<br>";
					$result1 = mysqli_query($link,"SELECT PIC FROM userlist WHERE id = '$row[0]'");
        
			        foreach($result1 as $value){
			            $img = $value['PIC'];
			            echo "<img src='data:image/jpg;base64,".$img."'witdh='50' height='50'>";
			            // echo $img;
			       	}
					
					echo "<br>留言內容: <此內容已經被本人刪除>";

					echo "<br>留言時間:".$row[3];
					if($row[0] == $LoginID){
						echo "<form method='POST' action='recover.php'>
								<input type='hidden' name='no' value='".$row[2]."'>
								<input type='hidden' name='token' value='".$csrftoken."'>
								<input type = 'submit' name='recover' value='恢復留言'>
							</form>";
					}
				}
				echo "<hr>";
			}
			// echo "共".mysqli_num_rows($result)."筆留言";
			mysqli_close($link);
		?>
	</body>
</html>