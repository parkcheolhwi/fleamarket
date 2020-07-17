<?php 
session_start();
if(!isset($_SESSION['userInfo'])){
    echo "8";
    return;
}
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

$likeCountData = array(
    'userNo' => mysqli_real_escape_string($conn, $_POST['userNo']),
    'userINo' => mysqli_real_escape_string($conn, $_SESSION['userInfo']['user_no'])
);

$sql = "
    SELECT 
        user_likecount 
        FROM 
            like_hate_count 
        WHERE 
            user_no = {$likeCountData['userNo']}
            AND user_likecount = {$likeCountData['userINo']}
    ";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
    echo "9";
    return;
}else{
    $sql ="
            INSERT INTO
                like_hate_count
                    (
                    lhcount,
                    user_no,
                    user_likecount
                    )       
                VALUES
                    (
                    NULL,
                    {$likeCountData['userNo']},
                    {$likeCountData['userINo']}
                    )
            ";
    
    if(mysqli_query($conn, $sql)){
        $sql = "
                SELECT 
                    a.user_no, a.user_id, count(b.user_likecount) AS user_likecount, count(b.user_hatecount) as user_hatecount 
                    FROM 
                        userinfo a 
                    LEFT JOIN
                        like_hate_count b 
                    ON 
                        a.user_no = b.user_no  
                    WHERE 
                        a.user_no = {$likeCountData['userNo']}
                    GROUP BY
                         a.user_no";       
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
    }
}

?>