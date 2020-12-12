<?php
	require_once "boardMine_header.php";
?>
<!-- 로그인을 제대로 하는지 검토하는 페이지 -->
<?php
	if(isset($_SESSION[userID])||empty($_POST[userID])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
		echo "<script>setTimeout('location.href=\"./boardMine_index.php\"',100);</script>";
    }
	$db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
	// SQL Injection 방지 = mysqli_real_escape_string
	$userID = mysqli_real_escape_string($db_conn,$_POST[userID]);
	$userPW = mysqli_real_escape_string($db_conn,$_POST[userPW]);
	// 로그인 기록들을 로그로 남김
	$fname = "./log/login/user_login_".date("ymd").".log";
	$fd = fopen($fname,"a+");
	$time_now = date("Y-m-d H:i:s");
	$logstr = $time_now." # ".$userID." # ";
    // 사용자 게정이 가입 승인된 계정인지 확인
	$db_res = mysqli_query($db_conn,"select user_permission from USER_INFO where user_id='$userID'");
	$db_row = mysqli_fetch_row($db_res);
    if($db_row[0]==0){
	    $logstr = $logstr."NOT Permissioned ID\n";
		fwrite($fd,$logstr);
        echo "<script>alert('미승인 계정입니다. 이메일 인증 부탁드립니다.');</script>";
		echo "<script>setTimeout('location.href=\"./boardMine_index.php\"',100);</script>";
        exit();
    }
	// 사용자 계정이 잠긴 계정인지 확인
	$db_res = mysqli_query($db_conn,"select login_lockdate from USER_INFO where user_id='$userID'");
	$db_row = mysqli_fetch_row($db_res);
	if($db_row[0] != NULL){
        $time_now=date("Y-m-d H:i:s",time());
		$time_diff = strtotime($time_now)-strtotime($db_row[0]);
		if($time_diff < 300){
			$time_diff = 300-$time_diff;
			$logstr = $logstr."Locked ID\n";
			fwrite($fd,$logstr);
			echo "<script>alert('현재 잠긴 계정입니다. $time_diff 초 남았습니다.');</script>";
		    echo "<script>setTimeout('location.href=\"./boardMine_index.php\"',1000);</script>";
            exit();
		}
	}
	// 잠긴 계정이 아니라면, 비밀번호 비교
	$db_res = mysqli_query($db_conn,"select user_id, user_nickname from USER_INFO where user_id='$userID' and user_pw=password('$userPW')");
	$db_row = mysqli_fetch_row($db_res);
	if(isset($db_row[0])){
		// 로그인 성공시에 할 작업
		$_SESSION[userID] = $userID;
		$_SESSION[userNick] = $db_row[1];
		$logstr = $logstr."Login Success";
		$db_res = mysqli_query($db_conn,"update USER_INFO set login_fail=0, login_lock=0, login_lockdate=NULL where user_id='$userID'");
	}else{
		// 비밀번호가 틀렸다면, 존재하는 계정인가?
		$logstr = $logstr."Login Fail";
		$db_res = mysqli_query($db_conn,"select user_id, login_fail from USER_INFO where user_id='$userID'");
		$db_row = mysqli_fetch_row($db_res);
		if(isset($db_row[0])){
			if($db_row[1]==4){
				$db_res = mysqli_query($db_conn,"update USER_INFO set login_fail=0, login_lock=1, login_lockdate=now() where user_id='$userID'");
				$logstr = $logstr." LOCK";
			}else{
				$db_res = mysqli_query($db_conn,"update USER_INFO set login_fail=login_fail+1 where user_id='$userID'");
			}
		}
	}
	$logstr = $logstr."\n";
	fwrite($fd,$logstr);
	fclose($fd);
	mysqli_close($db_conn);
	// 로그인 결과에 따른 후처리
	if(isset($_SESSION[userID])){
		echo "<script>history.go(-1);</script>";
	}else{
		echo "<script>alert('없는 사용자이거나 비밀번호가 틀렸습니다.');</script>";
		echo "<script>setTimeout('history.go(-1)',100);</script>";
	}
?>
<?php
	require_once "boardMine_footer.php";
?>
