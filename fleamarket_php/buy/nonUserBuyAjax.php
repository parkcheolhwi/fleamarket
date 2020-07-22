<?php 
/**
 * 商品を購入してカートから該当する商品を削除する
 */
session_start();
/**
 * 
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

$nonUserBuy = array(
    'goodsNo' => mysqli_real_escape_string($conn, $_POST['goodsNo']),
    'nonUserName' => mysqli_real_escape_string($conn, $_POST['nonUserName']),
    'nonUserPassword' => mysqli_real_escape_string($conn, $_POST['nonUserPassword']),
    'nonUserEmail' => mysqli_real_escape_string($conn, $_POST['nonUserEmail']),
    'nonUserAddress' => mysqli_real_escape_string($conn, $_POST['nonUserAddress'])
);

$sql = "
        SELECT 
            *
            FROM 
                goods
            WHERE 
                goods_onsale = '1'
                AND goods_no = {$nonUserBuy['goodsNo']}
";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    echo "11";
    return;
}

$sql ="
    INSERT INTO
            nonuser
                (
                nonuser_no,
                nonuser_name,
                nonuser_password,
                nonuser_email,
                nonuser_address         
                )
            VALUES
                (
                NULL,
                '{$nonUserBuy['nonUserName']}',
                '{$nonUserBuy['nonUserPassword']}',
                '{$nonUserBuy['nonUserEmail']}',
                '{$nonUserBuy['nonUserAddress']}'
                )
";
mysqli_query($conn, $sql);
$nonuserNo = mysqli_insert_id($conn);
$sql ="
    INSERT INTO
            buy
                (
                buy_no,
                nonuser_no,
                goods_no,
                buy_createdate
                )
            VALUES
                (
                NULL,
                {$nonuserNo},
                {$nonUserBuy['goodsNo']},
                NOW()
                )
";

if(mysqli_query($conn, $sql)){
    $sql = "
            UPDATE
                goods
                SET
                   goods_onsale = '1'
                WHERE
                    goods_no = {$nonUserBuy['goodsNo']}
            ";
    
    if(mysqli_query($conn, $sql)){
        echo "1";
    }
}
?>