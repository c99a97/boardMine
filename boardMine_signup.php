<?php
	require_once "boardMine_header.php";
	require_once "boardMine_menubar.php";
?>
    </td></tr>
<?php
    if(isset($_SESSION[userID])){
        echo "<script>alert('로그아웃 상태로 시도해주세요.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }
?>
    <form name='signup_form' class='formNoLine' method='post' action='boardMine_signupCheck.php'>
    <tr><td class='thGrayC' colspan='7' style='letter-spacing: 8px;'>
        <b>회원가입 / 기본정보</b>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='signup_id'><b>아이디</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 7 0 7 15px;'>
        <input type='text' id='signup_id' name='signup_id' class='inputNanum' style='width: 300px;' placeholder='아이디' pattern='^([a-z0-9_]).{5,20}$' required><br/>
        사용자 아이디는 6~20자 사이의 영문, 숫자 또는 _ 로 이루어져야 합니다.<br/>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='signup_pw'><b>비밀번호</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 7 0 7 15px;'>
        <input type='password' id='signup_pw' name='signup_pw' class='inputNanum' style='width: 300px;' placeholder='비밀번호' pattern='^([a-z0-9!@#$%^*_])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^*_]).{5,20}$' required><br/>
        사용자 비밀번호는 6~20자 사이의 영문, 숫자, 특수기호 ( !@#$%^*_ )로 이루어져야 합니다.
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='signup_pwc'><b>비밀번호 확인</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 7 0 7 15px;'>
        <input type='password' id='signup_pwc' name='signup_pwc' class='inputNanum' style='width: 300px;' placeholder='비밀번호' required><br>
        <div id='alert_pwsuccess'><font color='green'>비밀번호가 일치합니다.</font></div>
        <div id='alert_pwrefuse'><font color='red'>비밀번호가 일치하지 않습니다.</font></div>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='signup_nickname'><b>닉네임</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 7 0 7 15px;'>
        <input type='text' id='signup_nickname' name='signup_nickname' class='inputNanum' style='width: 300px;' placeholder='닉네임' pattern='[[!@#$%^&*()_-+=[]{}~?:;`\|<>\"].{1,8}$' required><br/>
        닉네임은 2~8자 사이의 한글, 영문, 숫자로 이루어져야 합니다.<br/>
        문제가 있는 닉네임은 임의로 변경될 수 있습니다.<br/>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='signup_email'><b>이메일 주소</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 7 0 7 15px;'>
        <input type='text' id='signup_email' name='signup_email' class='inputNanum' style='width: 215px;' placeholder='이메일' pattern='^([a-z0-9_]).{5,20}$' required>@naver.com<br/>
        네이버 메일로만 인증이 가능합니다. <br/>
    </td></tr>
    <tr><td class='tdGrayCH' colspan='2' style='letter-spacing: 2px;'>
        <label for='signup_emailc'><b>이메일 주소 확인</b></label>
    </td><td class='tdLeftU' colspan='5' style='padding: 7 0 7 15px;'>
        <input type='text' id='signup_emailc' name='signup_emailc' class='inputNanum' style='width: 215px;' placeholder='이메일' required>@naver.com<br/>
        <div id='alert_emsuccess'><font color='green'>이메일이 일치합니다.</font></div>
        <div id='alert_emrefuse'><font color='red'>이메일이 일치하지 않습니다.</font></div>
    </td></tr>
    <tr><td class='tdRightU' colspan='7' style='padding: 10 30px;'>
        <input type='submit' id='submit' class='butWhiteH' value='확인'>
        <button type='button' class='butWhiteH' onclick="history.go(-1)"> 취소</button>
    </td></tr>
    </form>
    </table>

    <script type="text/javascript">
        $(function(){
            $('div#alert_pwsuccess').hide();
            $('div#alert_pwrefuse').hide();
            $('div#alert_emsuccess').hide();
            $('div#alert_emrefuse').hide();
            $('input').keyup(function(){
                var signup_pw = $('input#signup_pw').val();
                var signup_pwc = $('input#signup_pwc').val();
                var signup_email = $('input#signup_email').val();
                var signup_emailc = $('input#signup_emailc').val();
                if(signup_pw!="" || signup_pwc!=""){
                    if(signup_pw == signup_pwc){
                        $('div#alert_pwsuccess').show();
                        $('div#alert_pwrefuse').hide();
                    }else{
                        $('div#alert_pwsuccess').hide();
                        $('div#alert_pwrefuse').show();
                    }
                }

                if(signup_email!="" || signup_emailc!=""){
                    if(signup_email == signup_emailc){
                        $('div#alert_emsuccess').show();
                        $('div#alert_emrefuse').hide();
                    }else{
                        $('div#alert_emsuccess').hide();
                        $('div#alert_emrefuse').show();
                    }
                }

                if((signup_email!="" && signup_email==signup_emailc)&&(signup_pw!="" && signup_pw==signup_pwc)){
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
