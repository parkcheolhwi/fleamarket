<?php 
/**
 * 商品詳細でコメントしてリストを表示する
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

$goodsNoComment = mysqli_real_escape_string($conn, $_POST['goodsNo']);

    $sql = "
            SELECT
                a.*, userinfo.user_id
                FROM (
                    SELECT
                        goods_comment.*
                    FROM
                        goods
                    INNER JOIN
                        goods_comment
                        ON
                            goods.goods_no = goods_comment.goods_no
                    ) a
                    INNER JOIN
                        userinfo
                        ON
                            a.user_no = userinfo.user_no
                        WHERE
                            goods_no = {$goodsNoComment}
                    ORDER BY
                        goods_comment_createdate DESC;
                        
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