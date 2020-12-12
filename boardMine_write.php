<?php
	require_once "boardMine_header.php";
    require_once "boardMine_menubar.php";
?>
    </td></tr>
<?php
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $db_res = mysqli_query($db_conn,"select user_permission from USER_INFO where user_id='$_SESSION[userID]'");
    $db_row = mysqli_fetch_row($db_res);
    $user_per = $db_row[0];
    $text_no = $_POST['text_no'];
    $db_res = mysqli_query($db_conn,"select * from TEXT_INFO where text_id='$text_no'");
    $db_row = mysqli_fetch_row($db_res);

    echo "<tr><td class='tdGrayC' colspan='7' height='25'>";
    echo "<b style='font-size:15px;'>글 쓰 기</b></td></tr>";
    echo "<form enctype='multipart/form-data' name='comment_form' class='formNoLine' method='POST' action='boardMine_writeAction.php?text_no=$text_no'>";
    if((isset($db_row[5])&& ($db_row[5]!=$_SESSION[userID])) || empty($_SESSION[userID])){
        echo "<tr><td class='tdLeftU' colspan='2' width='225' style='padding:0px 10px;'> 닉네임 : ";
        if(isset($db_row[0]))
            echo "<input type='text' id='t_id' name='t_id' class='inputNanum' placeholder='닉네임' value='$db_row[4]' readonly>";
        else
            echo "<input type='text' id='t_id' name='t_id' class='inputNanum' placeholder='닉네임' required>";
        echo "</td><td class='tdLeftU' colspan='5'> 비밀번호 : ";
        echo "<input type='password' id='t_pw' name='t_pw' class='inputNanum' placeholder='비밀번호 3~20자' pattern='^([a-z0-9!@#$%^*_]).{2,20}$' required>";
    }
    echo "</td></tr>";
    echo "<tr><td class='tdLeftU' colspan='7' style='padding:5px 10px;'>"; 
    echo "<select id='t_class' name='t_class'>";
    if(isset($_SESSION[userID])&& $user_per==2){
            echo "<option value='0'>공 지</option>";
    }
?>
    <option value='1' <?php if($db_row[2]==1) echo "selected"?>>잡 담</option>
    <option value='2' <?php if($db_row[2]==2) echo "selected"?>>정 보</option>
    <option value='3' <?php if($db_row[2]==3) echo "selected"?>>공 유</option>
    </select>
<?php
    echo "&nbsp<input type='text' id='t_title' name='t_title' class='inputNanum' style='width:900px;' placeholder='제목' value='$db_row[3]' required>";
    if($_GET[readonly]!=1 && isset($text_no)){
        echo " <input type='checkbox' name='readonly' value='1' checked='checked'>로그인 유저만 보도록!";
    }else if(isset($_SESSION[userID])){
        echo " <input type='checkbox' name='readonly' value='1'>로그인 유저만!";
    }
    echo "</td></tr>";
    echo "<tr><td class='tdLeftU' colspan='7' style='padding:10px;'>";
    echo "<textarea rows='20' cols='125' name='t_content' placeholder='본문 작성' required>$db_row[11]</textarea>";
    echo "</td></tr>";
    echo "<tr><td class='tdLeft' colspan='7' style='padding:10px;'>";
    echo "이미지 : <input type='file' name='upfile' id='upfile'>";
    echo "</td></tr>";
    echo "<tr><td class='tdCenter' colspan='7'>";
    echo "<input type='hidden' id='text_no' name='text_no' value='$text_no'>";
    echo "<input type='submit' class='butWhiteH' value='등록'> ";
    echo "<button type='button' class='butWhiteH' onclick=\"history.go(-1)\">취소</button></td></tr>";
    echo "</form>";
    echo "</tr></td>";
?>
    </table>
<?php
	require_once "boardMine_footerRemote.php";
	require_once "boardMine_footer.php";
?>
