	<!-- 로그인 / 회원정보 -->
	<table class='tbNoBorder' align='center'>
	<tr style='background-color: #D5D5D5' height='25'><td class='tdCenter' colspan='2' width='225'>
        <p class='pHs' style='color:#404040'>기말고사 프로젝트! BoardMine~</p>
    </td><td class='tdRight' colspan='5' width='1000' style='padding-right: 10px;'>
<?php
	if(isset($_SESSION[userID])){
        echo "<p class='pH'>";
        echo "<a href='boardMine_myinfo.php'>내 정보</a>";
        echo "<font color='gray'> | </font> ";
        echo "<a href='boardMine_mytext.php'>내 글</a>";
        echo "<font color='gray'> | </font> ";
        echo "<a href='boardMine_mycomment.php'>내 댓글</a>";
        echo "<font color='gray'> | </font> ";
        echo $_SESSION[userNick];
        echo "</p>\n";
        echo "<p class='pHs'>";
        echo " 님 환영합니다! </p>\n";
		echo "<button type='button' class='butWhite' onclick=\"location.href='boardMine_logout.php'\">";
		echo "<p class='pHs'>로그아웃</p>";
		echo "</button>\n";
	}else{
        echo "<p class='pH'>";
        echo "<a href='boardMine_signup.php'>회원가입</a>";
        echo "<font color='gray'> | </font> ";
        echo "<a href='boardMine_findpw.php'>비번찾기</a>";
        echo "<font color='gray'> | </font> ";
		echo "<form name='login_form' class='formNoLine' method='post' action='boardMine_loginCheck.php'>";
		echo "<input type='text' name='userID' class='inputNanum' placeholder='아이디' required>";
        echo "<font color='gray'> | </font> ";
		echo "<input type='password' name='userPW' class='inputNanum' placeholder='비밀번호' required>";
        echo "<font color='gray'> | </font> ";
		echo "<input type='submit' class='butWhiteH' value='로그인'>";
		echo "</form>";
        echo "</p>";
	}
?>
	</td></tr>
    <tr height='50px'><td class='tdCenter' colspan='2'>
        <a href='boardMine_index.php'><img src='img/boardmine.jpg' alt='boardmine' width='200' height='30'></a>
    </td><td class='tdRight' colspan='5' style='vertical-align: bottom; padding-right: 10px;'>
