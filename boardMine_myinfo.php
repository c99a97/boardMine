<?php
	require_once "boardMine_header.php";
	require_once "boardMine_menubar.php";
?>
    </td></tr>
<?php
    if(empty($_SESSION[userID])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
		echo "<script>history.go(-1);</script>";
    }
	$db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $db_res = mysqli_query($db_conn,"select * from USER_INFO where user_id='$_SESSION[userID]'");
    $db_row = mysqli_fetch_row($db_res);
?>
    <tr><td class='tdGrayC' colspan='7' style='padding: 15px 0px;'>
        <b>내 정 보</b>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <b>아 이 디</b>
    </td><td class='tdLeftU' colspan='5' style='padding: 10px 5px;'>
        <?php echo $db_row[0];?>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <b>닉 네 임</b>
    </td><td class='tdLeftU' colspan='5' style='padding: 10px 5px;'>
        <?php echo $db_row[2];?>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <b>비밀번호 변경</b>
    </td><td class='tdLeftU' colspan='5' style='padding: 10px 5px;'>
<?php
    echo "<button class=butWhiteH' onclick=\"location.href='./boardMine_code.php?user_id= $_SESSION[userID]'\">변경하기</button>";
?>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <b>가입일자</b>
    </td><td class='tdLeftU' colspan='5' style='padding: 10px 5px;'>
        <?php echo $db_row[9];?>
    </td></tr>
    </table>
<?php
	require_once "boardMine_footerRemote.php";
	require_once "boardMine_footer.php";
?>
