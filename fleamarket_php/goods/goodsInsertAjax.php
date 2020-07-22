<?php
/**
 * 商品を登録
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

$insertGoodsData = array(
    'userNo' => mysqli_real_escape_string($conn, $_POST['userNo']),
    'goodsTitle' => mysqli_real_escape_string($conn, $_POST['goodsTitle']),
    'goodsArea' => mysqli_real_escape_string($conn, $_POST['goodsArea']),
    'goodsPrice' => mysqli_real_escape_string($conn, $_POST['goodsPrice']),
    'goodsContent' => mysqli_real_escape_string($conn, $_POST['goodsContent']),
    'goodsCprice' => mysqli_real_escape_string($conn, $_POST['goodsPrice'] * 0.1)
);



$sql = "
   INSERT INTO
        goods
            (
            goods_no,
            user_no,
            goods_title,
            goods_price,
            goods_area,
            goods_content,
            goods_createdate,
            goods_updatedate,
            goods_cprice
            )
        VALUES
            (
            NULL,
            {$insertGoodsData['userNo']},
            '{$insertGoodsData['goodsTitle']}',
            {$insertGoodsData['goodsPrice']},
            '{$insertGoodsData['goodsArea']}',
            '{$insertGoodsData['goodsContent']}',
            NOW(),
            NOW(),
            {$insertGoodsData['goodsCprice']}
            )
";     
mysqli_query($conn, $sql);
$goodsId = mysqli_insert_id($conn);

if(isset($_FILES['goodsFile']) && $_FILES['goodsFile']['size'] != 0) {
      /* $baseDownFolder = "../upload/"; */
      $baseDownFolder = "D:\\PHP\\fleamarket_parkcheolhwi\\upload\\";   
    // 実際のファイル名
    $real_filename = $_FILES['goodsFile']['name'];
    
    // 拡張子のチェック
    $nameArr = explode(".",  $real_filename);
    $extension = $nameArr[sizeof($nameArr) - 1];
    
    // アップロードされつファイル名
    $tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension);
    
    if(!move_uploaded_file($_FILES["goodsFile"]["tmp_name"], $baseDownFolder.$tmp_filename) ) {
        echo 'image upload error';
    }
    
    $sql = "
            INSERT INTO
                goods_file
                (
                goods_fileno,
                goods_no,
                goods_filename,
                goods_filerealname,
                file_createdate,
                file_updatedate
                )
                VALUES
                    (
                    NULL,
                    {$goodsId},
                    '{$real_filename}',
                    '{$tmp_filename}',
                    NOW(),
                    NOW()
                    )
        ";
                    
        if(!mysqli_query($conn, $sql)){
            $errorMsg = "SQL実行に失敗しました。";
            $path = "index";
            header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
            exit;
        }
}


$sql = "
        SELECT
            goods.*, goods_file.goods_filerealname
            FROM
                goods
            LEFT JOIN
                goods_file
                ON goods.goods_no = goods_file.goods_no
            WHERE
                goods.goods_check = '0'
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
$jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $jsonData;

  




?>