<?php 
session_start();
require_once '../db/connection.php';
require_once './goods.inc';

$model = new GoodsModel();
$model->getForm();

switch($model->getGoodsCmd()){
    case "list":
        goodsList();
        break;
    case "delete":
        goodsDelete();
        break;
    case "insert":
        goodsInsert();
        break;
    case "update":
        goodsUpdate();
        break;
    case "commissionCreate":
        goodsCommissionCreate();
        break;
}
function goodsCommissionCreate(){
    global $model;
    $sql = " UPDATE goods SET goods_commission = '1' WHERE goods_no = {$model->getGoodsNo()} ";

    connection($sql) ? print true : print false;
}

function goodsUpdate(){
    global $model;
    $sql ="SELECT * FROM goods WHERE goods_no = {$model->getGoodsNo()} AND goods_onsale = '1'";
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        echo "9";
        return;
    }
    
    $sql = " UPDATE
                goods
                SET
                    goods_title = '{$model->getGoodsTitle()}',
                    goods_price = {$model->getGoodsPrice()},
                    goods_area = '{$model->getGoodsArea()}',
                    goods_content = '{$model->getGoodsContent()}',
                    goods_updatedate = NOW(),
                    goods_cprice = {$model->getGoodsCprice()}
                WHERE
                    goods_no = {$model->getGoodsNo()}
             ";
    
    if(!connection($sql)){
        echo "999";
    }else{
        
        if(isset($_FILES['goodsFile']) && $_FILES['goodsFile']['size'][0] != 0) {
            
            $sql = "SELECT * FROM goods_file WHERE goods_no = {$model->getGoodsNo()}";
            $result = connection($sql);
            if(mysqli_num_rows($result) > 0){
                while($data = mysqli_fetch_assoc($result)){
                $goodsFileRealName = $data['goods_filerealname'];
                unlink("D:\\PHP\\fleamarket_parkcheolhwi\\upload\\".$goodsFileRealName);
                }
                $sql = "DELETE FROM goods_file WHERE goods_no = {$model->getGoodsNo()}";
               connection($sql);
            }
            
            // $baseDownFolder = "../upload/";
            $baseDownFolder = "D:\\PHP\\fleamarket_parkcheolhwi\\upload\\";
            
            
            $sql = " INSERT INTO goods_file(goods_fileno, goods_no, goods_filename, goods_filerealname, file_createdate, file_updatedate) VALUES ";
            for($i = 0; $i < count($_FILES['goodsFile']['name']); $i++){
                $real_filename = $_FILES['goodsFile']['name'][$i];
                
                // 拡張子のチェック
                $nameArr = explode(".",  $real_filename);
                $extension = $nameArr[sizeof($nameArr) - 1];
                
                // アップロードされつファイル名
                $tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension);
                
                if(!move_uploaded_file($_FILES["goodsFile"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
                    echo 'image upload error';
                }
                
                $sql .= " (NULL, {$model->getGoodsNo()}, '{$real_filename}', '{$tmp_filename}', NOW(), NOW()) ";
               if($i != count($_FILES['goodsFile']['name']) - 1) $sql .= ", ";
            }
            
            
            if(!connection($sql)){
                $errorMsg = "SQL実行に失敗しました。";
                $path = "index";
                header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
                exit;
            }
        }
        
        echo "1";
    }
}
function goodsInsert(){
    global $model;
    $sql = " INSERT INTO goods(goods_no, user_no, goods_title, goods_price, goods_area, goods_content, goods_createdate, goods_updatedate, goods_cprice)
                        VALUES(NULL, {$model->getUserNo()}, '{$model->getGoodsTitle()}', {$model->getGoodsPrice()}, '{$model->getGoodsArea()}', '{$model->getGoodsContent()}', NOW(), NOW(), {$model->getGoodsCprice()}) ";
            
    $goodsId = getIdConnection($sql);
    
    if(isset($_FILES['goodsFile']) && $_FILES['goodsFile']['size'][0] != 0) {
        $baseDownFolder = "D:\\PHP\\fleamarket_parkcheolhwi\\upload\\";
        $sql = " INSERT INTO goods_file(goods_fileno, goods_no, goods_filename, goods_filerealname, file_createdate, file_updatedate) VALUES ";
        
        for($i = 0; $i < count($_FILES['goodsFile']['name']); $i++){
            $real_filename = $_FILES['goodsFile']['name'][$i];
            
            // 拡張子のチェック
            $nameArr = explode(".",  $real_filename);
            $extension = $nameArr[sizeof($nameArr) - 1];
            
            // アップロードされつファイル名
            $tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension);
            
            if(!move_uploaded_file($_FILES["goodsFile"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
                echo 'image upload error';
            }
            
            $sql .= " (NULL, {$goodsId}, '{$real_filename}', '{$tmp_filename}', NOW(), NOW()) ";
            if($i != count($_FILES['goodsFile']['name']) - 1) $sql .= ", ";
        }
        if(!connection($sql)){
            $errorMsg = "SQL実行に失敗しました。";
            $path = "index";
            header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
            exit;
        }
    }
            
            
            
            
    $sql = " SELECT goods.*, goods_file.goods_filerealname FROM goods
                LEFT JOIN goods_file ON goods.goods_no = goods_file.goods_no
                WHERE goods.goods_no = {$goodsId} ";
    
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){$data = mysqli_fetch_assoc($result);}            
    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
}

function goodsDelete(){
    global $model;
    $sql = " SELECT b.user_password FROM goods a
                INNER JOIN userinfo b ON a.user_no = b.user_no
                WHERE a.goods_no = {$model->getGoodsNo()} ";
    $result = connection($sql);
    
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        if($data['user_password'] != $model->getUserPassword()){
            echo false;
        }else{
            $sql = " UPDATE goods SET goods_check = '1' WHERE goods_no = {$model->getGoodsNo()} ";
            connection($sql);
            echo true;
        }
    }
}
function goodsList(){
    global $model;
    $sql = " SELECT goods.*, goods_file.goods_filerealname FROM goods
                    LEFT JOIN goods_file ON goods.goods_no = goods_file.goods_no
                    WHERE goods.goods_title LIKE '%{$model->getSearchGoods()}%'
                        AND goods.goods_check = '0'
                        AND goods.goods_area LIKE '%{$model->getGoodsArea()}%'
                        GROUP BY
                            goods.goods_no
                        ORDER BY
                            goods.goods_updatedate DESC;
                
        ";
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $model->setGoodsList($row);
        }
    }
    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$model->getGoodsList(), "userAuthority"=>isset($_SESSION['userInfo']) ? $_SESSION['userInfo']['user_authority'] : ""), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
}

?>