<?php 
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

$sql = "
        SELECT
            *
            FROM
                userinfo
            ORDER BY
                user_no
        ";
/**
 * SQLを実行しデータを取得する
 * @var unknown $result
 */
$result = mysqli_query($conn, $sql);
$return = array();
if(mysqli_num_rows($result) > 0){
    while($data = mysqli_fetch_assoc($result)){
        $return[] = array(
            'userNo'=> $data['user_no'], 
            'userId' => $data['user_id'],
            'userName' => $data['user_name'],
            'userCreateDate' => $data['user_createdate'],
            'userDeleteCheck' => $data['user_deletecheck']
        );
    }
}
header('Content-Type: application/json; charset=utf8');
$jsonData = json_encode(array("result"=>$return), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $jsonData;
?>