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

$userNo = mysqli_real_escape_string($conn, $_POST['userNo']);
     
$sql = "
       SELECT 
            userinfo.* , goods.*, goods_file.goods_filerealname
            FROM 
                userinfo 
                INNER JOIN 
                    goods 
                    ON 
                        userinfo.user_no = goods.user_no
                LEFT JOIN
                    goods_file
                    ON goods.goods_no = goods_file.goods_no
 
                    WHERE userinfo.user_no = {$userNo}
                    ORDER BY goods.goods_createdate DESC;
        ";
$result = mysqli_query($conn, $sql);
$data = array();
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
}else{
    echo "9";
    return;
}
mysqli_free_result($result);
mysqli_close($conn);
header('Content-Type: application/json; charset=utf8');
$jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $jsonData;
?>