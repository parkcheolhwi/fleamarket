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
    'goodsFile' => $_FILES['goodsFile']['tmp_name']
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
            goods_updatedate
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
            NOW()
            )
";
/* mysqli_query($conn, $sql);
$goodsId = mysqli_insert_id($conn);

$path = "../upload/".basename($_FILES['goodsFile']['name']);
move_uploaded_file($insertGoodsData['goodsFile'], $path);

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
                    '{$insertGoodsData['goodsFile']}',
                    '{$insertGoodsData['goodsFile']}',
                    NOW(),
                    NOW()
                    )
        "; */
            
if(!mysqli_query($conn, $sql)){
    $errorMsg = "SQL実行に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}
$sql = "
        SELECT
            *
            FROM
                goods
            WHERE
                goods_check = '0'
            ORDER BY
                goods_updatedate DESC;
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