<?php
/**
 * カートボタンを押すとカートに格納される
 */
session_start();
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

if(!isset($_SESSION['userInfo'])){
    echo "8";
    return;
}

$insertCartData = array(
    'goodsNo' => mysqli_real_escape_string($conn, $_POST['goodsNo']),
    'userINo' => $_SESSION['userInfo']['user_no']
);

$sql = "
        SELECT
            *
            FROM
                goods
            WHERE
                goods_onsale = '1'
                AND goods_no = {$insertCartData['goodsNo']}
";


$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    echo "11";
    return;
}


# カートにデータがあるとリターンする
$sql = "SELECT * FROM cart WHERE goods_no = {$insertCartData['goodsNo']} AND user_no = {$insertCartData['userINo']}";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0) {
        echo "9";
        return;
    }
}

# 商品情報を持って来て登録する
$sql = " SELECT * FROM goods WHERE goods_no = {$insertCartData['goodsNo']} ";

if($result = mysqli_query($conn, $sql)){
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    $sql = "
        INSERT INTO
            cart
                (
                cart_no,
                user_no,
                goods_no,
                cart_createdate
                )
            VALUES
                (
                NULL,
                {$insertCartData['userINo']},
                {$data['goods_no']},
                NOW()
                )
        ";
    mysqli_query($conn, $sql);
    echo "1";
}else{
    echo "0";
}


?>