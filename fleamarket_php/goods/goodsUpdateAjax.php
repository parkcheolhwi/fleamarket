<?php
/**
 * 商品を更新する
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

$updateGoodsData = array(
    'goodsNo' => mysqli_real_escape_string($conn, $_POST['goodsNo']),
    'goodsTitle' => mysqli_real_escape_string($conn, $_POST['goodsTitle']),
    'goodsArea' => mysqli_real_escape_string($conn, $_POST['goodsArea']),
    'goodsPrice' => mysqli_real_escape_string($conn, $_POST['goodsPrice']),
    'goodsContent' => mysqli_real_escape_string($conn, $_POST['goodsContent'])
);
$sql = "
       UPDATE 
            goods
            SET
                goods_title = '{$updateGoodsData['goodsTitle']}',
                goods_price = {$updateGoodsData['goodsPrice']},
                goods_area = '{$updateGoodsData['goodsArea']}',
                goods_content = '{$updateGoodsData['goodsContent']}',
                goods_updatedate = NOW()
            WHERE
                goods_no = {$updateGoodsData['goodsNo']}
    ";



if(!mysqli_query($conn, $sql)){
    echo false;
}else{
    echo true;
}

?>