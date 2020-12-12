<?php
	require_once "boardMine_header.php";
?>
<?php
    if(isset($_SESSION['userID'])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }if(empty($_POST['signup_id'])||empty($_POST['signup_pw'])||empty($_POST['signup_nickname'])||empty($_POST['signup_email'])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }
    // DB 연결 후에 입력받은 값들이 중복되는지를 검사
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');

    $signup_id = mysqli_real_escape_string($db_conn,$_POST[signup_id]);
    $signup_pw = mysqli_real_escape_string($db_conn,$_POST[signup_pw]);
    $signup_nickname = mysqli_real_escape_string($db_conn,$_POST[signup_nickname]);
    $signup_email = mysqli_real_escape_string($db_conn,$_POST[signup_email]);
    $signup_email = $signup_email."@naver.com";

    $db_res = mysqli_query($db_conn,"select user_id from USER_INFO where user_id='$signup_id'");
    $db_row = mysqli_fetch_row($db_res);
    if(isset($db_row[0])){
        echo "<script>alert('이미 존재하는 아이디입니다.');</script>";
        echo "<script>history.go(-1);</script>";
    }
    $db_res = mysqli_query($db_conn,"select user_nickname from USER_INFO where user_nickname='$signup_nickname'");
    $db_row = mysqli_fetch_row($db_res);
    if(isset($db_row[0])){
        echo "<script>alert('이미 존재하는 닉네임입니다.');</script>";
        echo "<script>history.go(-1);</script>";
    }
    $db_res = mysqli_query($db_conn,"select user_email from USER_INFO where user_email='$signup_email'");
    $db_row = mysqli_fetch_row($db_res);
    if(isset($db_row[0])){
        echo "<script>alert('이미 가입한 이메일입니다.');</script>";
        echo "<script>history.go(-1);</script>";
    }
    // 이메일 검증을 위한 페이지 넘버생성
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    do{
        $randomString = '';
        for($i=0; $i<40; $i++){
            $randomString .= $characters[rand(0,$charactersLength-1)];
        }
        $db_res = mysqli_query($db_conn,"select user_percode from USER_INFO where user_percode='$randomString'");
    }while($db_row = mysqli_Fetch_row($db_res));
    // USER_INFO에 정보삽입
    $db_res = mysqli_query($db_conn,"insert into USER_INFO(user_id,user_pw,user_nickname,user_email,user_percode) values('$signup_id',password('$signup_pw'),'$signup_nickname','$signup_email','$randomString')");
?>
<?php
    // 메일전송
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    //require_once "vender/autoload.php";
    require_once "./PHPMailer/PHPMailer.php";
    require_once "./PHPMailer/SMTP.php";
    require_once "./PHPMailer/Exception.php";
    require_once "./PHPMailer/OAuth.php";
    require_once "./PHPMailer/POP3.php";


    $mail = new PHPMailer(true);
    // 서버셋팅
    $mail->isSMTP();
    $mail->SMTPDebug=SMTP::DEBUG_SERVER;

    $mail->Host="smtp.gmail.com";
    $mail->Port=587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth=true;
    $mail->Username="gwangjoon9408@gmail.com";
    $mail->Password="dkdkdk123!@#";
    $mail->CharSet="utf-8";
    // 메일전송
    $mail->setFrom("gwangjoon9408@gmail.com");
    $mail->addAddress($signup_email);
    $mail->Subject="BoardMine 회원가입 인증메일입니다.";
    
    $bodyMSG = "http://117.17.143.136/boardMine_code.php?per_code=".$randomString;
    $mail->Body= $bodyMSG;
    $mail->send();
    /*
    if(!$mail->send()){
        echo "Mesaage Could not be sent. Mailer Error: ".$mail->ErrorInfo;
    }else{
        echo "MSG sent!";
        echo "Mesaage Could not be sent. Mailer Error: ".$mail->ErrorInfo;
    }
    */
    echo "<script>location.href='./boardMine_index.php';</script>";
?>
<?php
	require_once "boardMine_footer.php";
?>
