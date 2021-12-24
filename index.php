

<html>
<head>
	<?php
			session_start();
			$LoginID = isset($_SESSION['LoginID']) ? $_SESSION['LoginID'] : "";
			if($LoginID == ""){
				
				header("refresh:0;url=Login_test.php");
				die();
			}
			$dbhost = $_SERVER['RDS_HOSTNAME'];
            $dbport = $_SERVER['RDS_PORT'];
            $dbname = $_SERVER['RDS_DB_NAME'];
            $charset = 'utf8' ;
            $username = $_SERVER['RDS_USERNAME'];
            $password = $_SERVER['RDS_PASSWORD'];
            $link = new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
            $result=mysqli_query($link,"SELECT counter FROM userlist");
            $sum = 0;
            foreach($result as $tmp){
            	$sum += $tmp['counter'];
            }
            $result = mysqli_query($link,"SELECT counter FROM userlist WHERE id = '$LoginID'");
            foreach($result as $tmp){
            	$ttt = $tmp['counter'];
            }
            $csrftoken = $_SESSION['token'];
            // header("Content-type: image/jpeg"); 
            

		?>
</head>
<body>
  <h1>hey I'm Ken Chuang</h1>
  <h1>hello <?php echo htmlspecialchars($LoginID); ?></h1>
  <h2>這個網站總共被拜訪過 <?php echo $sum; ?> 次</h2>
  <h2>你總共拜訪過這個網站 <?php echo $ttt; ?> 次</h2>
  
  
  <h2><a href="view.php">留言板</a></h2>


  <h2>上傳你的照片</h2>
  <form id="form1" action="updatepic.php" method="POST" ENCTYPE="multipart/form-data">
    <input type = "file" name="upfile" id="upfile" onchange="check()">
    
    <input type = "submit" value="開始上傳">
  </form>
  <!-- <img src="getpic.php?id=" alt="img from db"/> -->
    <?php 
        
        $result1 = mysqli_query($link,"SELECT PIC FROM userlist WHERE id = '$LoginID'");
        
        foreach($result1 as $value){
            $img = $value['PIC'];
            echo "<img src='data:image/jpg;base64,".$img."'witdh='400' height='400'>";
            // echo $img;
        }
    ?>

  <img src="profilephoto.jpg" witdh="400" height="400"/>
  <h2><a href="logout.php">登出</a></h2>
  <!-- <h2>還沒有帳號? <a href="register_test.php">點我註冊</a></h2> -->
  <!----
  <?php
    //echo "Welcome!</br>You have entered this site {$count} time(s)!</br>";
    
    // echo "<br>";
    // foreach ($_COOKIE as $key=>$val) {
    //   echo "{$key} is {$val}<br>";
    // }
  ?>
  -->
  <script language="javascript" type="text/javascript">
  function check(){
        var aa=document.getElementById("upfile").value.toLowerCase().split('.');//以“.”分隔字符串
           // var aa=document.form1.userfile.value.toLowerCase().split('.');//
           
        if(document.getElementById("upfile").value==""){
            alert('圖片不能為空!');
            return false;
        }
        else{
            if(aa[aa.length-1]=='jpg'||aa[aa.length-1]=='jpeg')//判斷格式
            {
                var imagSize =  document.getElementById("upfile").files[0].size;
                //alert("圖片大小："+imagSize+"B")
                if(imagSize<1024*1024*5){
                        //alert("圖片大小在5M以內 你的檔案大小為:"+imagSize/(1024*1024)+"M");
                        return true;
                }
                else{
                  alert("圖片大小在5M以內 你的檔案大小為:"+imagSize/(1024*1024)+"M");
                  document.getElementById("form1").reset();
                  return false;
                }
            }
            else{
                alert('格式錯誤 請上傳.jpg檔');
                document.getElementById("form1").reset();
                return false;
            }
        }
    }
  </script>


  <?php 
  	mysqli_close($link);
  ?>
</body>
</html>