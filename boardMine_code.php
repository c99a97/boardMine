<?php
    require_once "boardMine_header.php";
    require_once "boardMine_menubar.php";
?>
    </td></tr>

<?php
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $per_code = mysqli_real_escape_string($db_conn,$_GET[per_code]);
    $db_res = mysqli_query($db_conn,"select * from USER_INFO where user_percode='$per_code'");
    $db_row = mysqli_fetch_row($db_res);
    
    if(isset($db_row[0]) && $db_row[4]==0){
        echo "<tr><td class='tdGrayC' colspan='7' height='25'>";
        echo "<b style='font-size:15px;'>회 원 가 입</b></td></tr>";
        $db_res = mysqli_query($db_conn,"update USER_INFO set user_permission='1',user_percode=NULL  where user_percode='$per_code'");
        echo "<tr><td class='tdCenterU'colspan='7' style='padding:20px 10px;>";
        echo "<font size='4'>";
        echo "회원가입에 성공하셨습니다!<br>";
        echo "잠시 후 메인페이지로 이동합니다.<br>";
        echo "</font>";
        echo "<script>setTimeout('location.href=\"./boardMine_index.php\"',3000);</script>";
        echo "</td></tr>";
    }
?>
    <tr><td class='tdGrayC' colspan='7' height='25'>
    <b style='font-size:15px;'>비 번 찾 기</b></td></tr>
    <form name='findpw_form' class='formNoLine' method='post' action='boardMine_pwAction.php?<?php if($per_code!=NULL){echo "per_code=$per_code";}?>'>
<?php
    if(isset($_GET[user_id])){
        $user_id = mysqli_real_escape_string($db_conn,$_GET[user_id]);
        echo "<tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>";
        echo "<input type='hidden' name='user_id' value='$user_id'>";
        echo "<label for='user_cpw'><b>현재 비밀번호</b></label>";
        echo "</td><td class='tdLeftU' colspan='5' style='padding: 10px 5px;'>";
        echo "<input type='password' id='user_cpw' name='user_cpw' class='inputNanum' style='width: 300px;' placeholder='비밀번호' pattern='^([a-z0-9!@#$%^*_])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^*_]).{5,20}$' required>";
        echo "</td></tr>";
    }
?>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='user_pw'><b>비밀번호</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 10px 5px;'>
        <input type='password' id='user_pw' name='user_pw' class='inputNanum' style='width: 300px;' placeholder='비밀번호' pattern='^([a-z0-9!@#$%^*_])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^*_]).{5,20}$' required><br/>
        사용자 비밀번호는 6~20자 사이의 영문, 숫자, 특수기호 ( !@#$%^*_ )로 이루어져야 합니다.
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='user_pwc'><b>비밀번호 확인</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 10px 5px;'>
        <input type='password' id='user_pwc' name='user_pwc' class='inputNanum' style='width: 300px;' placeholder='비밀번호' required><br>
        <div id='alert_pwsuccess'><font color='green'>비밀번호가 일치합니다.</font></div>
        <div id='alert_pwrefuse'><font color='red'>비밀번호가 일치하지 않습니다.</font></div>
    </td></tr>
    <tr><td class='tdRightU' colspan='7' style='padding: 10 30px;'>
        <input type='submit' id='submit' class='butWhiteH' value='확인'>
        <button type='button' class='butWhiteH' onclick="location.href='117.17.143.136/boardMine_index.php'"> 취소</button>
    </td></tr>
    </form>
    </table>

    <script type="text/javascript">
        $(function(){
            $('div#alert_pwsuccess').hide();
            $('div#alert_pwrefuse').hide();
            $('input').keyup(function(){
                var user_pw = $('input#user_pw').val();
                var user_pwc = $('input#user_pwc').val();
                if(user_pw!="" || user_pwc!=""){
                    if(user_pw == user_pwc){
                        $('div#alert_pwsuccess').show();
                        $('div#alert_pwrefuse').hide();
                    }else{
                        $('div#alert_pwsuccess').hide();
                        $('div#alert_pwrefuse').show();
                    }
                }
                if(user_pw!="" && user_pw==user_pwc){
                    $('#submit').removeAttr('disabled');
                }else{
                    $('#submit').attr('disabled','disabled');
                }
            });
        });
   </script>
<?php
	require_once "boardMine_footerRemote.php";
	require_once "boardMine_footer.php";
?>
