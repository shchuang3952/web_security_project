<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>註冊</title>
	<meta charset="utf-8" />
</head>
<body>

    
    
    <table>
        <tr><td colspan="3" style="height:30%; text-align: center;" colspan="3"><h1 style="background-color: white;">歡迎:))))</h1></td> </tr>
        <tr> <td width="40%"></td> <td style="padding: 30px;"> <h2 style="background-color: white;">填寫簡單資料來註冊</h2> </td> <td width="40%"></td></tr>
        <tr>
            <td></td>
            <td>
                <form method="POST" action="register_test.php">
                    <label>帳號: </label> <input type = "text" name = "regID" required>
                    <br />
                    <label>密碼: </label> <input type = "password" name = "regPW" required>
                    <br>
                    <label>確認密碼: </label> <input type = "password" name = "regCH_PW" required>
                    <br>
                    <button type="submit" name="submit">確定</button> <a href="index.php">  返回首頁</a>
                </form>
                <p id="message"> </p>
            </td>
        </tr>
    </table>

    <?php

    $regID = isset($_POST[ "regID" ]) ? $_POST[ "regID" ] : "";
    $regPW = isset($_POST[ "regPW" ]) ? $_POST[ "regPW" ] : "";
    $regCH_PW = isset($_POST[ "regCH_PW" ]) ? $_POST[ "regCH_PW" ] : "";
    $iserror = false;
    $IDerror = false;

    if ( isset( $_POST["submit"] ) )
    {
        ////////echo "sumbit OK";
        if ( $regID == "" )
        {
            //$formerrors[ "regIDerror" ] = true;
            $iserror = true;
            echo "<script>window.alert('帳號不能為空白');</script>";
        } // end if

        if ( $regPW == "" )
        {
            //$formerrors[ "regPWerror" ] = true;
            $iserror = true;    
            echo "<script>window.alert('密碼不能為空白');</script>";
        } // end if

        if ( $regCH_PW == "" )
        {
            //$formerrors[ "regCH_PWerror" ] = true;
            $iserror = true;
            echo "<script>window.alert('確認密碼不能為空白');</script>";
        } // end if

        if( $regPW != $regCH_PW)
        {
            //$formerrors[ "check_pw_error" ] = true;
            $iserror = true;
            echo "<script>window.alert('確認密碼錯誤');</script>";
            
        } // end if

        if ( !$iserror )  {
            // $host=""; //remove critical id
            // $name="";
            // $pwd="";
            // $port="";
            // $db="";

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

            // mysqli_select_db($con,$db) or die("db selection failed");

            $result=mysqli_query($link,"SELECT id FROM userlist",MYSQLI_STORE_RESULT);        //user資料表名稱
            while($row=mysqli_fetch_assoc($result)){
                $tmp[]=$row;
            }

            //echo json_encode($tmp);
            
            foreach($tmp as $value){

                if($value['id'] == $regID)
                {
                    //$formerrors[ "check_id" ] = true;
                    $IDerror = true;
                    $iserror = true;
                    echo "<script>window.alert('帳號已被使用');</script>";
                } // end if
            }
            // echo "<script>window.alert('inserting...');</script>";
            if(!$IDerror){

                $sql = "INSERT INTO userlist (id,pwd) VALUES ('$regID','$regPW')";
                    if (mysqli_query($link, $sql)) {
                        $insertID = true;
                    } 
                    else {
                        $insertID = false;
                        echo "<script>window.alert('註冊失敗');</script>";
                        header("refresh:0;url=register_test.php");
                    }
                // $sqlBag = "INSERT INTO bag (id,money,food1,food2) VALUES ($regID,0,0,0)";
                //     if (mysqli_query($link, $sqlBag)) {
                //         $insertBAG = true;
                //     } 
                //     else {
                //         $insertBAG = false;
                //     }
                if($insertID){
                   echo "<script>window.alert('註冊成功  按確定後跳轉至登入頁面');</script>"; 
                   header("refresh:0;url=Login_test.php");
                }

            }
            mysqli_close($link);
        }
    }




    ?>
    
</body>
</html>
