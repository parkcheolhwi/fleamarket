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

$deleteCartData = mysqli_real_escape_string($conn, $_POST['cartNo']);


#カートにデータがあるかチェックする
$sql = "SELECT * FROM cart WHERE cart_no = {$deleteCartData}";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0) {
        $sql = "
            DELETE 
                FROM
                    cart
                WHERE 
                    cart_no = {$deleteCartData}
            ";
        if(!mysqli_query($conn, $sql)){
            echo "9";
            return;
        }else{
            echo "1";
            return;
        }
    } else{
        echo "9";
        return;
    }
    mysqli_free_result($result);
    mysqli_close($conn);
}


?>