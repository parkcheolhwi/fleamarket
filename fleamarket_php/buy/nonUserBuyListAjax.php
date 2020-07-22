<?php
/**
 *　
 */
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

$nonUserCheck = array(
    'nonUserEmail' => mysqli_real_escape_string($conn, $_POST['nonUserEmail']),
    'nonUserPassword' => mysqli_real_escape_string($conn, $_POST['nonUserPassword'])
);

$sql = "
        SELECT 
            *
            FROM
                nonuser
            WHERE 
                nonuser_email = '{$nonUserCheck['nonUserEmail']}'
                AND nonuser_password = '{$nonUserCheck['nonUserPassword']}' 
        ";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);
    $id = $data['nonuser_no'];
    $sql = "
            SELECT 
                goods.*, buy.buy_createdate, goods_file.goods_filerealname, nonuser.nonuser_name
                FROM
                    buy
                INNER JOIN
                    goods
                    ON 
                        buy.goods_no = goods.goods_no
                INNER JOIN
                    nonuser
                    ON
                        buy.nonuser_no = nonuser.nonuser_no
                LEFT JOIN
                    goods_file
                    ON 
                        goods.goods_no = goods_file.goods_no
                    WHERE
                        nonuser.nonuser_no = {$id} 
        ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        
        mysqli_free_result($result);
        mysqli_close($conn);
        header('Content-Type: application/json; charset=utf8');
        $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $jsonData;
    }
}else{
    echo "9";
}


?>