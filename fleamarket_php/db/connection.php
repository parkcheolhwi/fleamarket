<?php
/**
 * DB接続する関数
 * @param $sql
 * @return 
 */
function connection($sql){
    $url = "localhost";
    $root = "root";
    $pass = "123456";
    $db = "fleamarket";

    if ($conn = mysqli_connect($url, $root, $pass, $db)) {
        
    $result = mysqli_query($conn, $sql) or die ("SQL文実行に失敗しました。SQL{$sql}");
    
    mysqli_close($conn);
    
    return $result;
    
    } else {
        $errorMsg = "DB接続に失敗しました。";
        $path = "./index.php";
        header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    }
}

/**
 * insert文を実行し該当するnoを返す
 * @param $sql
 * @return 
 */
function quizdbConnectionGetAutoIncrement($sql){
    $url = "localhost";
    $root = "root";
    $pass = "root123";
    $db = "quizdb";
    
    if ($conn = mysqli_connect($url, $root, $pass, $db)) {
        
        mysqli_query($conn, $sql) or die ("SQL文実行に失敗しました。SQL{$sql}");
        
        $no = mysqli_insert_id($conn);
        
        mysqli_close($conn);
        
        return $no;
        
    } else {
        $errorMsg = "DB接続に失敗しました。";
        $path = "start.php";
        header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    }   
}
?>