<?php
	require_once "boardMine_header.php";
    require_once "boardMine_menubar.php";
?>
    </td></tr>
<?php
    $db_conn = mysqli_Connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $text_no = $_GET['text_no'];
    $db_res = mysqli_query($db_conn,"select user_permission from USER_INFO where user_id='$_SESSION[userID]'");
    $db_row = mysqli_fetch_row($db_res);
    $user_per = $db_row[0];
    $db_res = mysqli_query($db_conn,"select img_name from IMG_INFO where text_id='$text_no'");
    $db_row = mysqli_fetch_row($db_res);
    $img_name = $db_row[0];

    $db_res = mysqli_query($db_conn,"update TEXT_INFO set text_view=text_view+1 where text_id=$text_no");
    $db_res = mysqli_query($db_conn,"select * from TEXT_INFO where text_id=$text_no");
    $db_row = mysqli_fetch_row($db_res);
    if(empty($db_row[0])){
        echo "<script>alert('존재하지 않는 게시글입니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }else if($db_row[2]==2 && $user_per!=2){
        echo "<script>alert('삭제된 게시글입니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }else if($db_row[2]==3 && $user_per!=2){
        echo "<script>alert('관리자에 의하여 삭제된 게시글입니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }else if($db_row[2]==0 && empty($_SESSION[userID])){
        echo "<script>alert('로그인 유저만 볼 수 있는 게시글입니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }
    echo "<tr><td class='tdGrayL' colspan='3' style='padding: 15px;'>";
    echo "<b style='font-size:22px;'>$db_row[3]</b>";
    echo "</td><td class='tdGrayR' colspan='4' style='padding-right: 20px;'>";
    echo $db_row[6];
    echo "</td></tr>";
    echo "<tr><td class='tdLeftU' colspan='3' style='padding: 10px 15px;'>";
    echo "작성자: ".$db_row[4];
    echo "</td><td class='tdRightU' colspan='4' style='padding-right: 20px;'>";
    echo "조회수 <b>".$db_row[7]."</b>";
    echo " 추천수 <b>".($db_row[8]-$db_row[9])."</b>";
    echo " 댓글 <b>".$db_row[10]."</b>";
    echo "</td></tr>";
    echo "<tr><td class='tdLeftU' colspan='7' style='padding: 15px;'>";
    echo "<pre><font size='4'>".$db_row[11]."</font></pre>";
    echo "</td></tr>";
    if(isset($img_name)){        
        echo "<tr><td class='tdCenter' colspan='7' style='padding: 20px;'>";
        echo "<img src=$img_name>";
        echo "</td></tr>";
    }
    echo "<tr><td class='tdCenterU' colspan='7' style='padding: 30px 0px;'>";
    echo "<b><font size='5' color='blue'><label for='recommend'>".$db_row[8]."</label></font>";
    echo "<a id='recommend' href='boardMine_commend.php?text_no=$text_no&commend_ud=1'> <img src='img/recommend.png' alt='recommend' width='30' height='30'></a>";
    echo "&nbsp&nbsp";
    echo "<a id='decommend' href='boardMine_commend.php?text_no=$text_no&commend_ud=-1'><img src='img/decommend.png' alt=decommend' width='30' height='30'></a>";
    echo "<font size='5' color='red'><label for='decommend'> ".$db_row[9]."</label></font></b>";
    echo "</td></tr>";
    echo "<tr><td class='tdLeft' style='padding:5px 15px;'><input type='button' class='butWhiteH' value='이전 글' onclick=\"location.href='boardMine_view.php?text_no=".($text_no-1)."'\">";
    echo "</td><td class='tdCenter' style='padding-right: 80px;' colspan='5'>";
    echo "<input type='button' class='butWhiteH' value='글작성' onclick=\"location.href='boardMine_write.php'\"> ";

    if($db_row[5]=='anony'){
        echo "<input type='button' class='butWhiteH' value='글수정' onclick=\"location.href='boardMine_modify.php?text_no=$text_no'\"> ";
    }else if($_SESSION[userID]==$db_row[5]){
        echo "<input type='button' class='butWhiteH' value='글수정' onclick=\"location.href='boardMine_modifyAction.php?text_no=$text_no'\"> ";
    }else{
        echo "<input type='button' class='butWhiteH' value='글수정' disabled='disabled'> ";
    }

    if($db_row[5]=='anony'){
        echo "<input type='button' class='butWhiteH' value='글삭제' onclick=\"location.href='boardMine_delete.php?text_no=$text_no'\">";
    }else if(($_SESSION[userID]==$db_row[5]) || $user_per==2){
        echo "<input type='button' class='butWhiteH' value='글삭제' onclick=\"location.href='boardMine_deleteAction.php?text_no=$text_no'\">";
    }else{
        echo "<input type='button' class='butWhiteH' value='글삭제' disabled='disabled'>";
    }
    echo "</td><td class='tdRight' style='padding:5px 15px;'><input type='button' class='butWhiteH' value='다음 글' onclick=\"location.href='boardMine_view.php?text_no=".($text_no+1)."'\">";
    echo "</td></tr>";

    // 댓글 표시
    echo "<tr><td class='tdGrayC' colspan='7' height='25'>";
    echo "<b style='font-size:14px;'>댓&nbsp&nbsp&nbsp글</b></td></tr>";
    $db_res = mysqli_query($db_conn, "select count(*) from COMMENT_INFO where text_id=$text_no and comment_kind not in('2')");
    $db_row = mysqli_fetch_row($db_res);
    if($db_row[0]==0){
        echo "<tr><td class='tdCenterU' colspan='7' height='30'>";
        echo "현재 작성된 댓글이 없습니다.";
        echo "</td></tr>";
    }else{
        $db_res = mysqli_query($db_conn, "select * from COMMENT_INFO where text_id=$text_no and comment_kind not in('2')");
        while($db_row = mysqli_fetch_row($db_res)){
            echo "<tr><td class='tdCenterU' colspan='2' width='225' height='25'>";
            echo $db_row[3];
            echo "</td><td class='tdLeftU' colspan='2' width='600' style='padding: 0px 10px;'>";
            echo "<pre><font size='3'>".$db_row[8]."</font></pre>";
            echo "</td><td class='tdCenterU' colspan='2' width='200'>";
            echo $db_row[6];
            echo "</td><td class='tdCenterU' width='150'>";
            if($db_row[2]=='anony'){
                echo "<input type='button' class='butWhiteH' value='X' onclick='location.href=\"boardMine_commentDelete.php?text_no=$text_no&comment_no=$db_row[0]\"'>";
            }else if($db_row[2]==$_SESSION[userID]){
                echo "<input type='button' class='butWhiteH' value='X' onclick='location.href=\"boardMine_commentDeleteAction.php?text_no=$text_no&comment_no=$db_row[0]\"'>";
            }else{
                echo "<input type='button' class='butWhiteH' value='X' disabled='disabled'>";
            }
            echo "</td></tr>";
        }
    }
    echo "<tr><td class='tdGrayC' colspan='7' style='padding: 5px 0px;'>";
    echo "<b style='font-size:15px;'>댓 글 작 성</b></td></tr>";
    echo "<form name='comment_form' class='formNoLine' method='POST' action='boardMine_comment.php?text_no=$text_no'>";
    if(isset($_SESSION[userID])){
        echo "<tr><td class='tdCenterU' colspan='6' style='padding:10px 0px;'>";
        echo "<textarea rows='2' cols='100' name='c_content' placeholder='댓글 작성' required></textarea>";
        echo "</td><td class='tdCenterU' width='150'>";
        echo "<input type='submit' class='butWhiteH' value='등록'></td></tr>";
    }else{
        echo "<tr><td class='tdCenterU'><input type='text' id='c_id' name='c_id' class='inputNanum' placeholder='닉네임' required>";
        echo "</td><td class='tdCenterU' rowspan='2' colspan='5' style='padding: 5px 0px;'>";
        echo "<textarea rows='3' cols='90' name='c_content' placeholder='댓글 작성' required></textarea>";
        echo "</td><td class='tdCenterU' rowspan='2' width='150'>";
        echo "<input type='submit' class='butWhiteH' value='등록'></td></tr>";
        echo "<tr><td class='tdCenter'><input type='password' id='c_pw' name='c_pw' class='inputNanum' placeholder='비밀번호 3~20자' pattern='^([a-z0-9!@#$%^*_]).{2,20}$' required>";
        echo "</td></tr>";
    }
    echo "</form>";
?>
    </table>
<?php
	require_once "boardMine_footerRemote.php";
	require_once "boardMine_footer.php";
?>
