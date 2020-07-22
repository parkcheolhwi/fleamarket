<?php 

$conn = mysqli_connect(
    'localhost',
    'root',
    '123456',
    'fleamarket'
    );

/**
 * DB接続チェックする
 */
if(mysqli_connect_errno()){
    $errorMsg = "DB接続に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

$replyData = array(
    'inquiryNo' => mysqli_real_escape_string($conn, $_POST['replyNo']),
    'replyContent' => mysqli_real_escape_string($conn, $_POST['replyContent']) 
);

$sql = "
    UPDATE 
        inquiryinfo
        SET
            inquiry_replycheck = '1',
            inquiry_replycontent = '{$replyData['replyContent']}',
            inquiry_replydate = NOW()
        WHERE
            inquiry_no = {$replyData['inquiryNo']}
    ";
if(!mysqli_query($conn, $sql)){
    $errorMsg = "SQL実行に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

echo true;
?>