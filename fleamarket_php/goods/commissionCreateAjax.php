<?php 
/**
 * 手数料要請する
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

$commissionCreateData = $_POST['goodsNo'];
$sql = "
        UPDATE 
            goods
            SET
                goods_commission = '1'
            WHERE
                goods_no = {$commissionCreateData}
";


if(mysqli_query($conn, $sql)){
    echo true;
}else {
    echo false;
}
    
?>