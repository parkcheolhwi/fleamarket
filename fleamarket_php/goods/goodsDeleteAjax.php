<?php 
/**
 * 商品を削除する
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

$goodsDeleteData = array(
    'goodsNo' => mysqli_real_escape_string($conn, $_POST['goodsNo']),
    'userPassword' => mysqli_real_escape_string($conn, $_POST['userPassword'])
    
);

$sql = "
        SELECT
            b.user_password
            FROM
                goods a
            INNER JOIN
                userinfo b
            ON
                a.user_no = b.user_no
            WHERE
                a.goods_no = {$goodsDeleteData['goodsNo']}
        ";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);
    if($data['user_password'] != $goodsDeleteData['userPassword']){
        echo false;
    }else{
        $sql = "
                UPDATE 
                    goods
                    SET
                        goods_check = '1'
                    WHERE
                        goods_no = {$goodsDeleteData['goodsNo']}
            ";
        mysqli_query($conn, $sql);
        echo true;
    }
}
mysqli_free_result($result);
mysqli_close($conn);
?>