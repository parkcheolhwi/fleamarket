<?php

$conn = mysqli_connect(
    'localhost',
    'root',
    '123456',
    'fleamarket'
    );

if(mysqli_connect_errno()){
    $errorMsg = "DB接続に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

$userNo = mysqli_real_escape_string($conn, $_POST['userNo']);
$sql = "    
    SELECT 
        *, count(b.user_likecount) AS user_likecount, count(b.user_hatecount) AS user_hatecount 
        FROM 
            userinfo a 
            LEFT JOIN 
                like_hate_count b 
            ON 
                a.user_no = b.user_no
            WHERE
                a.user_no = {$userNo}    
            GROUP BY 
                a.user_no
                          
    ";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
header('Content-Type: application/json; charset=utf8');
$jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

echo $jsonData;
?>