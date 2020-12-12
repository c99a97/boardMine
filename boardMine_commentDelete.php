<?php
    require_once "boardMine_header.php";
    require_once "boardMine_menubar.php";
?>
    </td></tr>
    <tr><td class='tdGrayC' colspan='7' height='25'>
    <b style='font-size:14px;'>댓글 삭제</b>
    </td></tr>
    <tr><td class='tdCenterU' colspan='7'>
<?php
    echo "<form name='cdelete_form' class='formNoLine' method='POST' action='boardMine_commentDeleteAction.php?text_no=$_GET[text_no]&comment_no=$_GET[comment_no]'>";
?>
    <input type='password'name='c_pw' class='inputNanum' style='width:200px' placeholder='비밀번호 3~20자' pattern='^([a-z0-9!@#$%^*_]).{2,20}$' required>
    </td></tr>
    <tr><td class='tdCenter' colspan='7'>
    <input type='submit' class='butWhiteH' style='width:75px' value='확인'> 
    <button type='button' class='butWhiteH' style='width:75px' onclick="history.go(-1)">취소</button>
    </form>
    </td></tr>
    </table>
<?php
    require_once "boardMine_footer.php";
?>
