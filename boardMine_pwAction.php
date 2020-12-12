<?php
	require_once "boardMine_header.php";
?>
<?php
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $per_code = mysqli_real_escape_string($db_conn,$_GET[per_code]);
    $user_id = mysqli_real_escape_string($db_conn,$_POST[user_id]);
    $user_cpw = mysqli_real_escape_string($db_conn,$_POST[user_cpw]);
    $user_pw = mysqli_real_escape_string($db_conn,$_POST[user_pw]);
    if($per_code==NULL){
        $db_res = mysqli_query($db_conn,"select user_id from USER_INFO where user_id='$_SESSION[userID]'and user_pw=password('$user_cpw')");
        $db_row = mysqli_fetch_row($db_res);
        if(isset($db_row[0])){
            $db_res = mysqli_query($db_conn,"update USER_INFO set user_pw=password('$user_pw') where user_id='$_SESSION[userID]'");
            echo "<script>alert('비밀번호 변경이 완료되었습니다.')</script>";
            echo "<script>location.href='./boardMine_index.php';</script>";
        }else{
            echo "<script>alert('현재 비밀번호를 틀리셨습니다.')</script>";
            echo "<script>location.href='./boardMine_index.php';</script>";
        }
    }else if($per_code!=NULL){
        $db_res = mysqli_query($db_conn,"select * from USER_INFO where user_percode='$per_code'");
        $db_row = mysqli_fetch_row($db_res);
        if(isset($db_row[0])){
            $db_res = mysqli_query($db_conn,"update USER_INFO set user_pw=password('$user_pw'), user_percode=NULL where user_percode='$per_code'");
    		echo "<script>alert('비밀번호 변경이 완료되었습니다.')</script>";
        	echo "<script>location.href='./boardMine_index.php';</script>";
        }else{
    		echo "<script>alert('에러로 인하여 비밀번호 변경이 중단되었습니다.')</script>";
        	echo "<script>location.href='./boardMine_index.php';</script>";
        }
    }
?>    
<?php
	require_once "boardMine_footer.php";
?>
