<?php 
/**
 * 商品リストを検索して表示
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

$cartBuyCheckData = $_POST['goodsNo'];

$sql = "
        SELECT
            cart.cart_no, cart.user_no, cart.cart_createdate, goods.*
            FROM
                cart
            INNER JOIN
                goods
            ON
                cart.goods_no = goods.goods_no
            WHERE
        ";
for($i = 0; $i < count($cartBuyCheckData); $i++){
    $sql .= "goods.goods_no = ".$cartBuyCheckData[$i];
    if($i != count($cartBuyCheckData)-1) $sql .= " OR ";
}



$result = mysqli_query($conn, $sql);
$data = array();
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
}
mysqli_free_result($result);
mysqli_close($conn);
header('Content-Type: application/json; charset=utf8');
$jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $jsonData;
?>