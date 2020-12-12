<?php
	require_once "boardMine_header.php";
?>
<?php
    if(isset($_SESSION['userID'])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }if(empty($_POST[user_email])){
        echo "<script>alert('잘못된 경로로 접속하셨습니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $user_email = mysqli_real_escape_string($db_conn,$_POST[user_email]);
    $user_email = $user_email."@naver.com";

    $db_res = mysqli_query($db_conn,"select user_email,user_percode from USER_INFO where user_email='$user_email'");
    $db_row = mysqli_fetch_row($db_res);
    if(empty($db_row[0])){
        echo "<script>alert('가입하지 않은 이메일입니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
    }else if(isset($db_row[1])){
        echo "<script>alert('인증 진행 중인 이메일입니다.');</script>";
        echo "<script>location.href='./boardMine_index.php';</script>";
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
    $db_res = mysqli_query($db_conn,"update USER_INFO set user_percode='$randomString' where user_email='$user_email'");
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
    $mail->addAddress($user_email);
    $mail->Subject="BoardMine 비밀번호 찾기 인증메일입니다.";
    
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
