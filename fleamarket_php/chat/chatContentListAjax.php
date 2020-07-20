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
$chatListData = array(
    'fromID' => mysqli_real_escape_string($conn, $_POST['fromID']),
    'toID' => mysqli_real_escape_string($conn, $_POST['toID'])
);

$sql = "
    SELECT 
        * 
        FROM 
            chat 
        WHERE 
            ((fromID = '{$chatListData['fromID']}' AND toID = '{$chatListData['toID']}') 
            OR (fromID = '{$chatListData['toID']}' AND toID = '{$chatListData['fromID']}')) 
        ORDER BY 
            chatTime;
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