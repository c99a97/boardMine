<?php
    require_once "boardMine_header.php";
?>
<?php
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $db_res = mysqli_query($db_conn,"select * from COMMENT_INFO where comment_id=$_GET[comment_no]");
    $db_row = mysqli_fetch_row($db_res);
    if($db_row[2]=='anony'){
        $db_res = mysqli_query($db_conn,"select * from COMMENT_INFO where comment_id=$_GET[comment_no] and comment_pw=password('$_POST[c_pw]')");
        $db_row = mysqli_fetch_row($db_res);
        if(empty($db_row[0])){
            echo "<script>alert('비밀번호가 틀립니다.');</script>";
            echo "<script>location.href='./boardMine_view.php?text_no=$_GET[text_no]';</script>";
        }
    }else if($_SESSION[userID]!=$db_row[2]){
        echo "<script>alert('본인이 작성한 댓글이 아닙니다.');</script>";
        echo "<script>location.href='./boardMine_view.php?text_no=$_GET[text_no]';</script>";
    }
    $db_res = mysqli_query($db_conn,"update COMMENT_INFO set comment_kind=2 where comment_id=$_GET[comment_no]");
    $db_res = mysqli_query($db_conn,"update TEXT_INFO set text_comment=text_comment-1 where text_id=$db_row[1]");
    echo "<script>location.href='./boardMine_view.php?text_no=$_GET[text_no]';</script>";
?>
<?php
    require_once "boardMine_footer.php";
?>
