<?php 
/**
 * 商品を購入してカートから該当する商品を削除する
 */
session_start();
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

$goodsBuyData = $_POST['goodsNo'];
$sql = "
        SELECT 
            *
            FROM 
                goods
            WHERE 
                goods_onsale = '1'
                AND goods_no IN (
";
for($i = 0; $i < count($goodsBuyData); $i++){
    $sql .= $goodsBuyData[$i];
    if($i != count($goodsBuyData)-1) $sql .= " , ";
}
$sql .= " ) ";

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    echo "11";
    return;
}
if(!isset($_SESSION['userInfo'])){
    echo "9";
    return;
}
$sql ="
    INSERT INTO
            buy
                (
                buy_no,
                user_no,
                goods_no,
                buy_createdate          
                )
            VALUES
";

for($i = 0; $i < count($goodsBuyData); $i++){
    $sql .= "
                (
                NULL,
                {$_SESSION['userInfo']['user_no']},
                {$goodsBuyData[$i]},
                NOW()
                ) 
            ";
    if($i != count($goodsBuyData) -1) $sql .=", ";
}

if(mysqli_query($conn, $sql)){
    $sql = "
            UPDATE 
                goods 
                SET 
                   goods_onsale = '1' 
                WHERE  
                    goods_no in (
        ";
    for($i = 0; $i < count($goodsBuyData); $i++){
        $sql .= "
                {$goodsBuyData[$i]}
                
            ";
                if($i != count($goodsBuyData) -1){
                    $sql .=",";
                }else{
                    $sql .=")";
                }
    }
    mysqli_query($conn, $sql);
    
    $sql = "
            DELETE FROM 
                cart 
                WHERE 
                    goods_no in (
            ";
    for($i = 0; $i < count($goodsBuyData); $i++){
        $sql .= "
                {$goodsBuyData[$i]}

            ";
                if($i != count($goodsBuyData) -1){
                    $sql .=",";
                }else{
                    $sql .=")";
                }
    }
    
    if(mysqli_query($conn, $sql)){
        echo "1";    
    }else{
        echo "7";
    }
}else{
    echo "7";
}
?>