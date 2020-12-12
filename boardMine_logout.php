<?php
	require_once "boardMine_header.php";
?>
<?php
	if(isset($_SESSION[userID])){
		echo "<script>alert('로그아웃 되었습니다.')</script>";
	}
	session_destroy();
	echo "<script>location.href='./boardMine_index.php';</script>";
?>
<?php
	require_once "boardMine_footer.php";
?>
