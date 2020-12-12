<?php
	require_once "boardMine_header.php";
?>
<?php
    // 함수 선언 및 정의
    function addSearch($pageNo){
        global $howMany, $searchHow, $searchWhat;
        $resultStr = "boardMine_index.php?pageNo=".$pageNo;
        if($howMany!=NULL && $HowMany!=10){
            $resultStr = $resultStr."&list_no=".$howMany;
        }
        if($searchHow!=NULL && $searchWhat!=NULL){
            $resultStr = $resultStr."&method=".$searchHow."&search=".$searchWhat;
        }
        return $resultStr;
    }
?>
<?php
    // 초기설정
    if(empty($_GET['pageNo'])){
        $pageNo = 1;
    }else{
        $pageNo = $_GET['pageNo'];
    }
    if(empty($_GET['list_num'])){
        $howMany = 20;
    }else{
        $howMany = $_GET['list_num'];
    }
    if($howMany!=20 && $howMany!=30 && $howMany!=50 && $howMany!=100){
        $howMany = 20;
    }
    if(isset($_GET['method'])&&isset($_GET['search'])){
        $searchHow = $_GET['method'];
        $searchWhat = $_GET['search'];
        $searchStr = NULL;
        switch($searchHow){
            case how_title:
                $searchStr = "where text_title like \"%".$searchWhat."%\" and";
                break;
            case how_contents:
                $searchStr = "where text_contents like \"%".$searchWhat."%\" and";
                break;
            case how_writer:
                $searchStr = "where text_writer like \"%".$searchWhat."%\" and";
                break;
            case how_class:
                if($searchWhat=='공지')
                    $searchWhat=0;
                else if($searchWhat=='잡담')
                    $searchWhat=1;
                else if($searchWhat=='정보')
                    $searchWhat=2;
                else if($searchWhat=='공유')
                    $searchWhat=3;
                else{
                    $searchHow = NULL;
                    $searchWhat = NULL;
                    $searchStr = "where ";
                    break;
                }
                $searchStr = "where text_classification like \"%".$searchWhat."%\" and";
                break;
            default:
                $searchHow = NULL;
                $searchWhat = NULL;
                $searchStr = "where ";
        }
    }else{
        $searchHow = NULL;
        $searchWhat = NULL;
        $searchStr = "where ";
    }
?>
<?php
    require_once "boardMine_menubar.php";
?>
        <form name='line_num' class='formNoLine' method='GET' action='boardMine_index.php'>
            출력 게시물 개수 :
            <select onchange="this.form.submit()" id='list_num' name='list_num'>
                <option value='20'>20개</option>
                <option value='30' <?php if($howMany==30) echo "selected"?>>30개</option>
                <option value='50' <?php if($howMany==50) echo "selected"?>>50개</option>
                <option value='100'<?php if($howMany==100) echo "selected"?>>100개</option>
            </select>
        </form>
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
    // 공지글 출력
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $db_res = mysqli_query($db_conn,"select user_permission from USER_INFO where user_id='$_SESSION[userID]'");
    $db_row = mysqli_fetch_row($db_res);
    $user_per = $db_row[0];

    $db_res = mysqli_query($db_conn,"select text_id,text_classification,text_title,text_writer,text_time,text_view,text_recommend,text_comment,text_decommend from TEXT_INFO where text_classification=0");
    while($db_row = mysqli_fetch_row($db_res)){
        echo "<tr>";
        for($i=0; $i<7; $i++){
            if($i==2){
                echo "<td class='tdGrayL' height='25'><a href='boardMine_view.php?text_no=$db_row[0]'><b>".$db_row[2]."</b></a>";
                $db_ress=mysqli_query($db_conn,"select img_id from IMG_INFO where text_id='$db_row[0]'");
                $db_roww=mysqli_fetch_row($db_ress);
                if(isset($db_roww[0]))
                    echo "<img src='./img/img_icon.png' width='20' height='20'>";
                if($db_row[7]!=0)
                    echo "<font color='blue'>"." [".$db_row[7]."]</font>";
            }else if($i==0){
                echo "<td class='tdGrayC'>-";
            }else if($i==1){
                echo "<td class='tdGrayC'>공 지";
            }else if($i==3){
                echo "<td class='tdGrayC' style='letter-spacing: 1.5px;'>".$db_row[$i];
    		}else if($i==6){
    		    echo "<td class='tdGrayC'>".($db_row[6]-$db_row[8]);
            }else{
                echo "<td class='tdGrayC'>".$db_row[$i];
            }
            echo "</td>";
        }
        echo "</tr>\n";
    }
    // 아래 게시글 출력
    $db_res = mysqli_query($db_conn,"select count(*) from TEXT_INFO $searchStr text_classification not in('0');");
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
        $db_res = mysqli_query($db_conn,"select text_id,text_classification,text_title,text_writer,text_time,text_view,text_recommend,text_comment,text_decommend,text_kind from TEXT_INFO $searchStr text_classification not in('0') order by text_id DESC LIMIT $calFrom,$calTo;");
        while($db_row = mysqli_fetch_row($db_res)){
		    echo "<tr>";
    		for($i=0; $i<7; $i++){
    			if($i==2){
                    if($db_row[9]==2 || $db_row[9]==3){
                        if($user_per==2)
                            echo "<td class='tdLeftU'><a href='boardMine_view.php?text_no=$db_row[0]'><font color='gray'><del>삭제된 글입니다.</del></font></a>";
                        else
                            echo "<td class='tdLeftU'><font color='gray'><del>삭제된 글입니다.</del></font>";
                    }else if($db_row[9]==0 && empty($_SESSION[userID])){
                        echo "<td class='tdLeftU'><font color='gray'>비공개 글입니다. 로그인 유저만 볼 수 있습니다.</font>";
                    }else{
        				echo "<td class='tdLeftU'><a href='boardMine_view.php?text_no=$db_row[0]'>".$db_row[2]."</a>";
                        $db_ress=mysqli_query($db_conn,"select img_id from IMG_INFO where text_id='$db_row[0]'");
                        $db_roww=mysqli_fetch_row($db_ress);
                        if($db_roww[0]!=NULL)
                            echo "<img src='./img/img_icon.png' width='20' height='20'>";
        				if($db_row[7]!=0)
        					echo "<font color='blue'>"." [".$db_row[7]."]</font>";
                    }
                }else if($i==1){
                    $t_class= "";
                    if($db_row[1]==1)
                        $t_class = "잡 담";
                    else if($db_row[1]==2)
                        $t_class = "정 보";
                    else if($db_row[1]==3)
                        $t_class = "공 유";
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
?>
    <tr height='75px'><td class='tdCenter' colspan='5'>
        <form name='search_form' class='formNoLine' method='GET' action='boardMine_index.php'>
            <select name='method' size='0'>
                <option value='how_title'>TITLE</option>
                <option value='how_contents'>CONTENTS</option>
                <option value='how_writer'>WRITER</option>
                <option value='how_class'>CLASS</option>
            </select>
            <input type='text' name='search' style='width: 500px;'>
            <input type='submit' class='butWhiteH' style='letter-spacing: 4px;' value='검색'>
        </form>
    </td><td class='tdCenter' colspan='2'>
        <button type='button' class='butWhiteH' style='letter-spacing: 3px;' onclick="location.href='boardMine_write.php'">글작성</button>
    </td></tr>
    <tr><td class='tdCenter' colspan=7'>
<?php
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
    mysqli_close($db_conn);
    require_once "boardMine_footerRemote.php";
	require_once "boardMine_footer.php";
?>
