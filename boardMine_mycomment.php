<?php
	require_once "boardMine_header.php";
	require_once "boardMine_menubar.php";
?>
    </td></tr>
    <tr><td class='tdGrayC' colspan='7' style='padding: 10px 0px;'>
        <b>내 댓 글</b>
    </td></tr>
    <tr height='25px'>
        <th class='thGrayC' width='100' style='letter-spacing: 4px;'>순번</th>
        <th class='thGrayC' width='125' style='letter-spacing: 4px;'>닉네임</th>
        <th class='thGrayC' width='300' style='letter-spacing: 8px;'>대상 게시글</th>
        <th class='thGrayC' width='475' style='letter-spacing: 3px;'>댓글 내용</th>
        <th class='thGrayC' width='175' style='letter-spacing: 4px;'>일자</th>
        <th class='thGrayC' colspan='2' width='150' style='letter-spacing: 3px;'>아이피</th>
    </tr>
<?php
    if(empty($_SESSION[userID])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
		echo "<script>history.go(-1);</script>";
    }
    function addSearch($pageNo){
        $resultStr = "boardMine_mycomment.php?pageNo=".$pageNo;
        return $resultStr;
    }
    // 초기설정
    if(empty($_GET['pageNo'])){
        $pageNo = 1;
    }else{
        $pageNo = $_GET['pageNo'];
    }
    $howMany = 20;
	$db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $db_res = mysqli_query($db_conn,"select user_permission from USER_INFO where user_id='$_SESSION[userID]'");
    $db_row = mysqli_fetch_row($db_res);
    $user_per = $db_row[0];

    $db_res = mysqli_query($db_conn,"select count(*) from COMMENT_INFO where user_id='$_SESSION[userID]';");
    $db_row = mysqli_fetch_row($db_res);
    $row_num = $db_row[0];
    $calFrom = ($pageNo-1)*$howMany;
    if($calFrom+$howMany > $row_num){
        $calTo = ($row_num%$howMany);
    }else{
        $calTo = $howMany;
    }

    if($row_num < 1){
        echo "<tr><td class='tdCenterU' colspan='7'>현재 작성한 댓글이 없습니다.</td></tr>\n";
    }else{
        $count = 0;
        $db_res = mysqli_query($db_conn,"select * from COMMENT_INFO where user_id='$_SESSION[userID]' order by comment_id DESC LIMIT $calFrom,$calTo");
        while($db_row = mysqli_fetch_row($db_res)){
		    echo "<tr>";
    		for($i=0; $i<6; $i++){
    			if($i==2){
                    $text_id = $db_row[1];
                    $db_ress = mysqli_query($db_conn,"select text_kind,text_title from TEXT_INFO where text_id='$text_id'");
                    $db_roww = mysqli_fetch_row($db_ress);
                    if($db_roww[0]==2 || $db_roww[0]==3){
                        if($user_per==2)
                            echo "<td class='tdLeftU'><a href='boardMine_view.php?text_no=$db_row[1]'><font color='gray'><del>삭제된 글입니다.</del></font></a>";
                        else
                            echo "<td class='tdLeftU'><font color='gray'><del>삭제된 글입니다.</del></font>";
                    }else{
        				echo "<td class='tdLeftU'><a href='boardMine_view.php?text_no=$db_row[1]'>".$db_roww[1]."</a>";
                    }
                }else if($i==0){
                    echo "<td class='tdCenterU'>"."-";
                }else if($i==1){
                    echo "<td class='tdCenterU'>".$db_row[3];
                }else if($i==3){
                    echo "<td class='tdCenterU'><pre><font size='2'>".$db_row[8]."</font></pre>";
                }else if($i==4){
                    echo "<td class='tdCenterU'>".$db_row[6];
                }else if($i==5){
                    echo "<td class='tdCenterU'>".$db_row[7];
                }
                echo "</td>";
            }
            echo "</tr>\n";
        }
    }
    echo "<tr><td class='tdCenter' colspan='7'>";
    $pageMax = ceil($row_num/$howMany);
    $pgMax = floor(($pageMax-1)/10);
    $pgNow = floor(($pageNo-1)/10);
    if($pgMax < 0)
        $pgMax = 0;
    if($pgNow < 0)
        $pgNow = 0;
    if($pgNow != 0){
        echo "<button type='button' class='butWhiteH' onclick=\"location.href='".addSearch(1)."'\">처음</button>";
		echo "<button type='button' class='butWhiteH' onclick=\"location.href='".addSearch($pgNow*10-9)."'\">이전</button> ";
	}
	for($i=$pgNow*10+1; ($i<=$pgNow*10+10) && ($i<=$pageMax); $i++)
		echo "<u><a href=".addSearch($i).">".$i." </a></u>";
	if($pgNow != $pgMax){
		echo " <button type='button' class='butWhiteH' onclick=\"location.href='".addSearch($pgNow*10+11)."'\">다음</button>";
		echo " <button type='button' class='butWhiteH' onclick=\"location.href='".addSearch($pageMax)."'\">끝</button>";
	}
?>
    </td></tr>
    </table>
<?php
	require_once "boardMine_footerRemote.php";
	require_once "boardMine_footer.php";
?>
