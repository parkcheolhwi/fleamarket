<?php
session_start();
/**
 * 商品詳細でコメントしてリストを表示する
 * @var unknown $conn
 */
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

$goodsCommentData = array(
    'goodsNo' => mysqli_real_escape_string($conn, $_POST['goodsNo']),
    'commentNo' => mysqli_real_escape_string($conn, $_POST['commentNo'])
);
$sql = "DELETE FROM goods_comment WHERE goods_comment_no = {$goodsCommentData['commentNo']}";

mysqli_query($conn, $sql);
echo $_SESSION['userInfo']['user_no'];

?>