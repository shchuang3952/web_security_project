<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>login</title>
	<meta charset="utf-8" />

    <style>
        h1,h2,label,button,a{font-family:'Microsoft JhengHei'}
    </style>
</head>
<body>
    <table style="height:100%; width:100%; text-align:center; " >
        <tr><td colspan="3" style="height:30%; text-align: center;" colspan="3"><h1 style="background-color: white;">歡迎:))))</h1></td> </tr>
        <tr> <td width="40%"></td> <td style="padding: 30px;"> <h2 style="background-color: white;">登入</h2> </td> <td width="40%"></td></tr>
        <tr>
            <td colspan="3">
                <form method="POST" action="Login_test.php">
                    <br /><br />
                    <label>帳號: </label> <input  type = "text" name ="LogID" required/> 
                    <br /><br />
                    <label>密碼: </label> <input type = "password" name ="LogPW" required/>
                    <br><br><br>
                    <button type="submit" name="submit">登入</button>
                </form>
            </td> 
             
        </tr>
        <tr>
            <td colspan="3" > 還沒有帳號? <a href="register_test.php">點我註冊</a> </td>
        </tr>
    </table>

<?php
    session_start();
    $LogID = isset($_POST[ "LogID" ]) ? $_POST[ "LogID" ] : "";
    $LogPW = isset($_POST[ "LogPW" ]) ? $_POST[ "LogPW" ] : "";
    $iserror = false;
    $IDexist = false;

    if ( isset( $_POST["submit"] ) )
    {
        ////////echo "sumbit OK";
        if ( $LogID == "" )
        {
            //$formerrors[ "regIDerror" ] = true;
            $iserror = true;
            echo "<script>window.alert('帳號不能為空白');</script>";
        } // end if

        if ( $LogPW == "" )
        {
            //$formerrors[ "regPWerror" ] = true;
            $iserror = true;    
            echo "<script>window.alert('密碼不能為空白');</script>";
        } // end if

        if ( !$iserror ){
            // $host="localhost"; // removed
            // $name="";
            // $pwd="";

            // $db="";

            // $con=mysqli_connect($host,$name,$pwd) or die("connection failed");
            
            // mysqli_select_db($con,$db) or die("db selection failed");
            $dbhost = $_SERVER['RDS_HOSTNAME'];
            $dbport = $_SERVER['RDS_PORT'];
            $dbname = $_SERVER['RDS_DB_NAME'];
            $charset = 'utf8' ;
            $username = $_SERVER['RDS_USERNAME'];
            $password = $_SERVER['RDS_PASSWORD'];


            // echo "<script>window.alert('connecting');</script>";
            // $con=mysqli_connect($host,$name,$pwd) or die("connection failed");
            $link = new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
            mysqli_query($link,"SET NAMES 'utf-8'");
            // echo "<script>window.alert('connection success');</script>";

            $result=mysqli_query($link,"SELECT id FROM userlist");        //user資料表名稱
            while($row=mysqli_fetch_assoc($result)){
                $tmpID[]=$row;
            }
            
            foreach($tmpID as $value){
                if($value['id'] == $LogID)
                {
                    $IDexist = true;
                } // end if
            }

            if($IDexist == false){
                echo "<script>window.alert('帳號不存在');</script>";
            }
            else{
                $result=mysqli_query($link,"SELECT pwd FROM userlist WHERE id = '$LogID'");        //user資料表名稱
                while($row=mysqli_fetch_assoc($result)){
                    $tmp[]=$row;
                }

                foreach($tmp as $value){
                    if($value['pwd'] == $LogPW){
                        $sql = "UPDATE `userlist` SET `counter` = `counter` + 1 WHERE id = '$LogID'";
                        mysqli_query($link, $sql);
                        echo "<script>window.alert('登入成功!');</script>";
                        setcookie("LoginID",$LogID) ;
                        $_SESSION['LoginID'] = $LogID;
                        $token = base64_encode(openssl_random_pseudo_bytes(32));
                        $_SESSION['token'] = $token;
                        header("refresh:0;url=index.php");
                    }
                    if($value['pwd'] != $LogPW){
                        echo "<script>window.alert('密碼錯誤');</script>";
                        //die();
                    }
                        
                }

            }
            
            mysqli_close($link);

        }
    }
?>

</body>
</html>
