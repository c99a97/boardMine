<?php
	require_once "boardMine_header.php";
	require_once "boardMine_menubar.php";
?>
    </td></tr>
    <tr><td class='tdGrayC' colspan='7' style='padding: 10px 0px;'>
        <b>내 글</b>
    </td></tr>
    <tr height='25px'>
        <th class='thGrayC' width='100' style='letter-spacing: 4px;'>순번</th>
        <th class='thGrayC' width='125' style='letter-spacing: 4px;'>분류</th>
        <th class='thGrayC' width='475' style='letter-spacing: 8px;'>제목</th>
        <th class='thGrayC' width='200' style='letter-spacing: 3px;'>작성자</th>
        <th class='thGrayC' width='175' style='letter-spacing: 4px;'>일자</th>
        <th class='thGrayC' width='75' style='letter-spacing: 3px;'>조회수</th>
        <th class='thGrayC' width='75' style='letter-spacing: 3px;'>추천수</th>
    </tr>
<?php
    if(empty($_SESSION[userID])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
		echo "<script>history.go(-1);</script>";
    }
    function addSearch($pageNo){
        $resultStr = "boardMine_mytext.php?pageNo=".$pageNo;
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
?>
<?php
    // 아래 게시글 출력
    $db_res = mysqli_query($db_conn,"select count(*) from TEXT_INFO where text_owner='$_SESSION[userID]';");
    $db_row = mysqli_fetch_row($db_res);
    $row_num = $db_row[0];
    $calFrom = ($pageNo-1)*$howMany;
    if($calFrom+$howMany > $row_num){
        $calTo = ($row_num%$howMany);
    }else{
        $calTo = $howMany;
    }

    if($row_num < 1){
        echo "<tr><td class='tdCenterU' colspan='7'>현재 작성된 글이 없습니다.</td></tr>\n";
    }else{
        $db_res = mysqli_query($db_conn,"select text_id,text_classification,text_title,text_writer,text_time,text_view,text_recommend,text_comment,text_decommend,text_kind from TEXT_INFO where text_owner='$_SESSION[userID]' order by text_id DESC LIMIT $calFrom,$calTo");
        while($db_row = mysqli_fetch_row($db_res)){
		    echo "<tr>";
    		for($i=0; $i<7; $i++){
    			if($i==2){
                    if($db_row[9]==2 || $db_row[9]==3){
                        if($user_per==2)
                            echo "<td class='tdLeftU'><a href='boardMine_view.php?text_no=$db_row[0]'><font color='gray'><del>삭제된 글입니다.</del></font></a>";
                        else
                            echo "<td class='tdLeftU'><font color='gray'><del>삭제된 글입니다.</del></font>";
                    }else{
        				echo "<td class='tdLeftU'><a href='boardMine_view.php?text_no=$db_row[0]'>".$db_row[2]."</a>";
        				if($db_row[7]!=0)
        					echo "<font color='blue'>"." [".$db_row[7]."]</font>";
                        $db_ress=mysqli_query($db_conn,"select img_id from IMG_INFO where text_id='$db_row[0]'");
                        $db_roww=mysqli_fetch_row($db_ress);
                        if($db_roww[0]!=NULL)
                            echo "<img src='./img/img_icon.png' width='20' height='20'>";
                    }
                }else if($i==1){
                    $t_class= "";
                    if($db_row[1]==1)
                        $t_class = "잡 담";
                    else if($db_row[1]==2)
                        $t_class = "정 보";
                    else if($db_row[1]==3)
                        $t_class = "공 유";
                    else if($db_row[1]==0)
                        $t_class = "공 지";
                    echo "<td class='tdCenterU' style='padding:5px 0px;'>".$t_class;
                }else if($i==3){
    				echo "<td class='tdCenterU' style='letter-spacing: 2px;'>".$db_row[$i];
    			}else if($i==6){
    				echo "<td class='tdCenterU'>".($db_row[6]-$db_row[8]);
                }else{
                    echo "<td class='tdCenterU'>".$db_row[$i];
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
