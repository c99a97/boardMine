<?php
    require_once "boardMine_header.php";
?>
<?php
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $db_res = mysqli_query($db_conn,"select * from TEXT_INFO where text_id=$_GET[text_no]");
    $db_row = mysqli_fetch_row($db_res);
    if($db_row[5]=='anony'){
        $db_res = mysqli_query($db_conn,"select * from TEXT_INFO where text_id=$_GET[text_no] and text_pw=password('$_POST[t_pw]')");
        $db_row = mysqli_fetch_row($db_res);
        if(empty($db_row[0])){
            echo "<script>alert('비밀번호가 틀립니다.');</script>";
            echo "<script>location.href='./boardMine_view.php?text_no=$_GET[text_no]';</script>";
        }
    }else if($_SESSION[userID]!=$db_row[5]){
        echo "<script>alert('본인이 작성한 글이 아닙니다.');</script>";
        echo "<script>location.href='./boardMine_view.php?text_no=$_GET[text_no]';</script>";
    }
    echo "<form method='POST' id='modify' action=\"boardMine_write.php?readonly='$db_row[2]'\">";
    echo "<input type='hidden' name='text_no' value=$_GET[text_no]>";
    echo "<script>document.forms['modify'].submit();</script>";
    echo "</form>";
?>
<?php
    require_once "boardMine_footer.php";
?>
