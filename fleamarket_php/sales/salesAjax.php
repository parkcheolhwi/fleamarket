<?php 
session_start();
require_once '../db/connection.php';
require_once './sales.inc';

$model = new SalesModel();

$model -> getForm();

if(!isset($_SESSION['userInfo'])){
    echo "8";
    return;
}


$date = "";
if($model->getYear() != "") $date .= $model->getYear();
if($model->getMonth() != "") {
    if(strlen($model->getMonth()) == 1){
        $month = "0".$model->getMonth();
    }
    $date .= "-".$month."-";
}

#ユーザーがあるとユーザーに関する売り上げ、管理者なら全ての情報
$sql = "
        SELECT
            buy.buy_no,
            buy.buy_createdate,
            goods.goods_no,
            goods.goods_title,
            goods.goods_area,
            goods.goods_price,
            goods.goods_commission,
            goods.goods_cprice,
            userinfo.*,
            goods_file.goods_filerealname
                FROM
                    buy
                    INNER JOIN
                        goods
                        ON buy.goods_no = goods.goods_no
                    INNER JOIN
                        userinfo
                        ON goods.user_no = userinfo.user_no
                    LEFT JOIN
                        goods_file
                        ON goods.goods_no = goods_file.goods_no
                WHERE
                    goods.goods_commission = '1'
                    AND buy.buy_createdate
                        LIKE '%{$date}%'
                        
        ";

if($_SESSION['userInfo']['user_authority'] == 1){
    $sql .= " AND userinfo.user_no = {$model->getUserNo()} ";
}
$sql .= "
    ORDER BY
        buy.buy_createdate DESC
    ";

#リストとリターンする
$result = connection($sql);
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $model->setSalesList($row);
    }
}
header('Content-Type: application/json; charset=utf8');
$jsonData = json_encode(array("result"=>$model->getSalesList()), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $jsonData;


?>