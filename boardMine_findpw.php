<?php
    require_once "boardMine_header.php";
    require_once "boardMine_menubar.php";
?>
    </td></tr>
    <tr><td class='tdGrayC' colspan='7' height='25'>
    <b style='font-size:14px;'>비 번 찾 기</b>
    </td></tr>
    <tr><td class='tdCenterU' colspan='7' style='padding:15px 0px;'>
<?php
    echo "<form name='tdelete_form' class='formNoLine' method='POST' action='boardMine_findpwAction.php'>";
?>
    <input type='text' name='user_email' class='inputNanum' style='width:200px' placeholder='이메일 6~20자' pattern='^([a-z0-9]).{5,20}$' required>@naver.com 
    <input type='submit' class='butWhiteH' style='width:75px' value='확인'> 
    <button type='button' class='butWhiteH' style='width:75px' onclick="history.go(-1)">취소</button>
    </form>
    </td></tr>
    </table>
<?php
    require_once "boardMine_footer.php";
?>
