<?php
session_start();
if(!isset($_SESSION['userInfo']) || $_SESSION['userInfo']['user_authority'] != 9){
    echo "8";
    return;
}
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


$salesData = array(
    'salesYear' => mysqli_real_escape_string($conn, $_POST['year']),
    'salesMonth' => mysqli_real_escape_string($conn, $_POST['month'])
);
$date = "";
if($salesData['salesYear'] != "") $date .= $salesData['salesYear'];
if($salesData['salesMonth'] != "") {
    if(strlen($salesData['salesMonth']) == 1){
        $salesData['salesMonth'] = "0".$salesData['salesMonth'];
    }
    $date .= "-".$salesData['salesMonth']."-";
}

$sql = "
        SELECT 
            buy.buy_no, 
            buy.buy_createdate, 
            goods.goods_title, 
            goods.goods_area, 
            goods.goods_price, 
            goods.goods_commission, 
            goods.goods_cprice, 
            userinfo.*,
            goods_file.goods_filerealname
                FROM 
                    buy 
                    INNER JOIN
                        goods 
                        ON buy.goods_no = goods.goods_no 
                    INNER JOIN 
                        userinfo 
                        ON goods.user_no = userinfo.user_no
                    LEFT JOIN
                        goods_file
                        ON goods.goods_no = goods_file.goods_no
                WHERE
                    goods.goods_commission = '1'
                    AND buy.buy_createdate 
                        LIKE '%{$date}%'
                ORDER BY
                    buy.buy_createdate DESC
        ";

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