<?php
    require_once "boardMine_header.php";
?>
<?php
    if(empty($_SESSION['userID'])){
        echo "<script>history.go(-1);</script>";
    }else{
        $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
        mysqli_query($db_conn,'set names utf8');
        $text_no = mysqli_real_escape_string($db_conn,$_GET[text_no]);
        $commend_ud = mysqli_real_escape_string($db_conn,$_GET[commend_ud]);

        $db_res = mysqli_query($db_conn,"select * from COMMEND_INFO where text_id=$text_no and user_id='$_SESSION[userID]'");
        $db_row = mysqli_fetch_row($db_res);
        if(isset($db_row[0])){
            echo "<script>alert('이미 추천한 게시글입니다')</script>";
            echo "<script>history.go(-1);</script>";
        }else{
            $db_res = mysqli_query($db_conn,"insert into COMMEND_INFO(text_id,user_id,commend_ud,commend_ip) values('$text_no','$_SESSION[userID]','$commend_ud','$_SERVER[REMOTE_ADDR]')");
            $db_row = mysqli_fetch_row($db_res);
            if($commend_ud==1){
                $db_res = mysqli_query($db_conn,"update TEXT_INFO set text_recommend=text_recommend+1 where text_id='$text_no'");
            }else if($commend_ud==-1){
                $db_res = mysqli_query($db_conn,"update TEXT_INFO set text_decommend=text_decommend+1 where text_id='$text_no'");
            }
            echo "<script>history.go(-1);</script>";
        }
    }
?>
<?php
    require_once "boardMine_footer.php";
?>
