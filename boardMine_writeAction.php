<?php
    require_once "boardMine_header.php";
?>
<?php
    $db_conn = mysqli_connect("localhost","cswin","cswin","boardMine");
    mysqli_query($db_conn,'set names utf8');
    $text_no = $_POST[text_no];
    $db_res = mysqli_query($db_conn,"select text_owner from TEXT_INFO where text_id='$text_no'");
    $db_row = mysqli_fetch_row($db_res);
    $text_owner = $db_row[0];

    $ipaddr = $_SERVER[REMOTE_ADDR];
    $text_contents = $_POST[t_content];
    $text_title = $_POST[t_title];
    $readonly = $_POST[readonly];
    if(empty($readonly))
        $readonly=1;
    else
        $readonly=0;
    if(empty($text_no)){
        if(isset($_SESSION[userNick])){
            $user_id = $_SESSION[userID];
            $user_nick = $_SESSION[userNick];
            $text_pw = $user_id;
        }else{
            $user_id = "anony";
            $user_nick = $_POST[t_id];
            $ipaddr_arr = explode('.',$ipaddr);
            $user_nick = $user_nick." (".$ipaddr_arr[0]."."."$ipaddr_arr[1]".")";
            $text_pw = $_POST[t_pw];
        }
        $db_res = mysqli_query($db_conn,"insert into TEXT_INFO(text_title,text_owner,text_writer,text_pw,text_ip,text_contents,text_classification,text_kind) values('$text_title','$user_id','$user_nick',password('$text_pw'),'$ipaddr','$text_contents','$_POST[t_class]',$readonly)");
    }else{
        if($text_owner == 'anony'){
            $text_pw = $_POST[t_pw];
        }else{
            $text_pw = $user_id;
        }
        $db_res = mysqli_query($db_conn,"update TEXT_INFO set text_title='$text_title',text_pw=password('$text_pw'),text_ip='$ipaddr',text_contents='$text_contents',text_classification='$_POST[t_class]',text_kind=$readonly where text_id='$text_no'");
    }

    if($_FILES['upfile']['name']!=NULL){
        $file_name=$_FILES['upfile']['name'];
        $file_size=$_FILES['upfile']['size'];
        $save_dir='./img/upload/';

        $file_time=time();
        $real_name=$file_name;
        $m=array_pop(explode(".",$real_name));

        if(($m!="bmp")&&($m!="rle")&&($m!="dib")&&($m!="jpg")&&($m!="gif")&&($m!="png")&&($m!="tif")&&($m!="tiff")&&($m!="raw")){
            echo "<script>alert('이미지 파일 형식이 잘못됐습니다.');</script>";
            echo "<script>location.href='./boardMine_index.php';</script>";
            exit();
        }

        $file_Name="img_".$file_time.".".$m;
        $file_url=$save_dir.$file_Name;

        if(!move_uploaded_file($_FILES['upfile']['tmp_name'],$file_url)){
            die("이미지 업로드에 실패했습니다.");
        }

        $db_res=mysqli_query($db_conn,"select img_id,img_name from IMG_INFO where text_id=$text_no");
        $db_row=mysqli_fetch_row($db_res);
        if($db_row[0]!=NULL){
            $res=mysqli_query($db_conn,"delete from IMG_INFO where img_id='$db_row[0]");
            unlink($db_row[1]);
        }
        $real_name=addslashes($real_name);
        $db_res=mysqli_query($db_conn,"insert into IMG_INFO(img_ip,img_name,img_real,text_id) values('$_SERVER[REMOTE_ADDR]','$file_url','$real_name','$text_no')");
    }
    echo "<script>location.href='./boardMine_index.php';</script>";
?>
<?php
    require_once "boardMine_footer.php";
?>
