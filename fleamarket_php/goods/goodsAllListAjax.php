<?php
session_start();

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

$listGoodsData = array(
    'searchGoods' => mysqli_real_escape_string($conn, $_POST['searchGoods']),
    'goodsArea' =>mysqli_real_escape_string($conn, $_POST['goodsArea'])
);
     
$sql = "
        SELECT
            goods.*, goods_file.goods_filerealname
            FROM
                goods
            LEFT JOIN
                goods_file
                ON goods.goods_no = goods_file.goods_no
            WHERE
                goods.goods_title
                    LIKE '%{$listGoodsData['searchGoods']}%'
                AND goods.goods_check = '0'
                AND goods.goods_area 
                    LIKE '%{$listGoodsData['goodsArea']}%'
            ORDER BY 
                goods.goods_updatedate DESC;
                    
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
$jsonData = json_encode(array("result"=>$data, "userAuthority"=>isset($_SESSION['userInfo']) ? $_SESSION['userInfo']['user_authority'] : ""), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $jsonData;
?>