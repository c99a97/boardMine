<?php
    require_once "boardMine_header.php";
?>
<?php
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');

    $text_no = mysqli_real_escape_string($db_conn,$_GET[text_no]);
    $ipaddr = $_SERVER[REMOTE_ADDR];
    $comment_contents = mysqli_real_escape_string($db_conn,$_POST[c_content]);
    if(isset($_SESSION[userNick])){
        $user_id = $_SESSION[userID];
        $user_nick = $_SESSION[userNick];
        $comment_pw = $user_id;
    }else{
        $user_id = "anony";
        $user_nick = mysqli_real_escape_string($db_conn,$_POST[c_id]);
        $ipaddr_arr = explode('.',$ipaddr);
        $user_nick = $user_nick." (".$ipaddr_arr[0]."."."$ipaddr_arr[1]".")";
        $comment_pw = mysqli_real_escape_string($db_conn,$_POST[c_pw]);
    }
    $db_res = mysqli_query($db_conn,"insert into COMMENT_INFO(text_id,user_id,user_nick,comment_pw,comment_ip,comment_contents) values('$text_no','$user_id','$user_nick',password('$comment_pw'),'$ipaddr','$comment_contents')");
    $db_res = mysqli_query($db_conn,"update TEXT_INFO set text_comment=text_comment+1 where text_id=$text_no");
    echo "<script>history.go(-1);</script>";
?>
<?php
    require_once "boardMine_footer.php";
?>
