<html>
	<head>
		<title>留言板</title>
		<?php
			session_start();
			$LoginID = isset($_SESSION['LoginID']) ? $_SESSION['LoginID'] : "";
			if($LoginID == ""){
				echo "<script>window.alert('請先登入!');</script>";
				header("refresh:0;url=Login_test.php");
				die();
			}
			$csrftoken = $_SESSION['token'];
			mysqli_close($link);
		?>
	</head>
	<body>
		<a href="view.php">觀看留言</a><p>
		<form name="form1" method="post" action="add.php">
				
				內容：<textarea rows=3 name="content" required></textarea><br>
			<input type="submit" name="Submit" value="送出">
			<?php echo "<input type='hidden' name='token' value='".$csrftoken."'>";?>
			<input type="Reset" name="Reset" value="重新填寫">
		</form>
	</body>
</html>