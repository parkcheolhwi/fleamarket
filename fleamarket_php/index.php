<?php 
session_start();
require_once './db/connection.php';
require_once './inquiry/inquiry.inc';
require_once './goods/goods.inc';


# 最近みた商品のセッションを生成
if(!isset($_SESSION['recentlyViewedGoods'])) $_SESSION['recentlyViewedGoods'] = array();


/**
 * 商品リストを検索して表示
 * @var unknown $conn
 */
$conn = mysqli_connect(
    'localhost',
    'root',
    '123456',
    'fleamarket'
    );
# 商品リスト
$goodsModel = new GoodsModel();
$goodsModel -> indexGoodsList();


/**
 * ログインすると最近みた商品とお問い合わせのリストも表示する
 */
if(isset($_SESSION['userInfo'])){
    
    #お問い合わせリスト
    $inquiryModel = new InquiryModel();
    $inquiryModel -> processing();
    
    /**
     * 最近みた商品のリスト
     * @var integer $i
     */
    $i = 0;
    if(isset($_SESSION['recentlyViewedGoods'])){
    $recentlyViewedGoodsSql = " SELECT  goods.goods_title, goods.goods_no, goods_file.goods_filerealname FROM goods
                                    LEFT JOIN goods_file ON goods.goods_no = goods_file.goods_no 
                                        WHERE goods.goods_no IN ( ";
        foreach($_SESSION['recentlyViewedGoods'] as $value){
            $recentlyViewedGoodsSql .= $value;
            if(++$i != count($_SESSION['recentlyViewedGoods'])) $recentlyViewedGoodsSql .= ", ";
        }
        $recentlyViewedGoodsSql .= " ) ";
        
        $i = 0;
        $recentlyViewedGoodsSql .= "  GROUP BY goods.goods_no ORDER BY FIELD(goods.goods_no, ";
        $recentlyViewedGoodsReverse = array_reverse($_SESSION['recentlyViewedGoods']);
        foreach($recentlyViewedGoodsReverse as $value){
            $recentlyViewedGoodsSql .= $value;
            if(++$i != count($recentlyViewedGoodsReverse)) $recentlyViewedGoodsSql .= ", ";
        }
        $recentlyViewedGoodsSql .= " ) ";
        
        $recentlyViewedGoodsList = mysqli_query($conn, $recentlyViewedGoodsSql);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フリマシステム</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link href="./btcss/bootstrap.min.css" rel="stylesheet">
<link href="./btcss/mdb.min.css" rel="stylesheet">
<link href="./btcss/style.css" rel="stylesheet">
<link href="./btcss/addons/datatables2.min.css" rel="stylesheet">
<link rel="stylesheet" href="./css/user.css">
</head>
<body>

	<?php require_once './menu/menunav.php';?>
	

	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1>フリマシステム</h1>
			<p>フリマシステムは。。。。。</p>
		</div>
	</div>
	
	<div class="container">
		
		<!-- 商品リスト-->
		<hr>
		<div>
    		<h4 class="text-dark font-weight-bold" style="float:left;">商品リスト</h4>
    		<?php count($goodsModel->getGoodsList()) > 4 ? print "<span style='float:right;'><a href='./goods/goodsList.php'>もっと見る</a></span>" : print ""?>
		</div>
		<?php 
		for($i = 0; $i < count($goodsModel->getGoodsList()); $i++){
		    $img = $goodsModel->getGoodsList()[$i]['goods_filerealname'];
		    if($goodsModel->getGoodsList()[$i]['goods_filerealname'] == null) $img = "noImg.jpg";
		?>
		<div style="clear: both; display: flex;flex-direction: row">
    		<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">
    			<img src="./upload/<?=$img?>" style="max-height: 74px; max-width: 74px">
    		</div>
    		<div style="margin: 2px; padding: 5px; flex: 0 1 70%;">
        		<h5 style="margin:0" class="text-dark font-weight-bold"><a href="./goods/goodsDetail.php?goods_no=<?=$goodsModel->getGoodsList()[$i]['goods_no'] ?>"><?=$goodsModel->getGoodsList()[$i]['goods_title'] ?></a></h5>
        		<p style="margin-bottom:10px"><span class="text-dark font-weight-bold"><?=$goodsModel->getGoodsList()[$i]['goods_price'] ?>円</span></p>
        		<p style="margin:0"><span class="text-dark"><?=$goodsModel->getGoodsList()[$i]['goods_content'] ?></span></p>
    		</div>
    		<div style="margin: 2px; padding: 5px; flex: 0 1 20%;">
        		<p style="margin:0">修正日：<?=$goodsModel->getGoodsList()[$i]['goods_updatedate'] ?></p>
        		<p style="margin-bottom:10px">登録日：<?=$goodsModel->getGoodsList()[$i]['goods_createdate'] ?></p>
    		</div>
		</div> 
		<?php if($i==4) break;}?>
		
		
		
		
		
		
		<?php 
		if(isset($_SESSION['userInfo'])){
		?>
		<div style="width:100%; height:400px;">
			<!-- ユーザーの最近見た商品リスト -->
			
			<div style="width:48%; float:left;"><hr>
        		<div >
            		<h4 class="text-dark font-weight-bold" style="float:left;">最近見た商品</h4>
        		</div>
        		<div style="clear:both;">
        			<?php 
        			$recentlyViewedGoodsCount = 0;
        			if(count($_SESSION['recentlyViewedGoods']) != 0){
        			    if(mysqli_num_rows($recentlyViewedGoodsList) > 0){
        			     while($row = mysqli_fetch_assoc($recentlyViewedGoodsList)){
        			         if($recentlyViewedGoodsCount++ == 10) break;
        			 ?>
        			 <div style="float:left; margin-right : 10px;">
    					<div>
                			 <a href="./goods/goodsDetail.php?goods_no=<?=$row['goods_no'] ?>">
                			 	<img src="./upload/<?php $row['goods_filerealname'] != null ? print $row['goods_filerealname'] : print "noImg.jpg" ?>" style="max-height: 63px; max-width: 90px">
                			 </a>
            			 </div>
            			 <div>
            			 <?=$row['goods_title'] ?>
            			 </div>
        			 </div>
        			 <?php       
            			    } #while文
            			} # if文
        			} else {
        			?>
        			商品がありません。
        			<?php 
        			}
        			?>
				</div>
			</div>
			<?php }?>
			<?php if(isset($_SESSION['userInfo']) && count($inquiryModel->getInquiryList()) > 0){?>
			<!-- ユーザーのお問い合わせリスト -->
		    <div style="width:48%; float:right;">
    			<hr>
        		<div>
            		<h4 class="text-dark font-weight-bold" style="float:left;">お問い合わせリスト</h4>
            		<?php $inquiryModel->getInquiryList() > 5 ? print "<span style='float:right;'><a href='./inquiry/inquiry.php'>もっと見る</a></span>" : print ""?>
        		</div>
    			<table class="table table-hover">
    					<?php 
    					   for($i = 0; $i < 5; $i++){
    					       $inquiryModel->getInquiryList()[$i]['inquiry_replycheck'] == '0'? $replyCheck="<span class='text-danger'>未返信</span>" : $replyCheck = "<span class='text-success'>返信完了</span>";
    					?>
						<tr>
    						<td style="width:70%"><a href="javascript:void(0)" onclick="inquiryModal('<?= $inquiryModel->getInquiryList()[$i]['inquiry_no'] ?>')"><?= $inquiryModel->getInquiryList()[$i]['inquiry_title'] ?>(<?= $replyCheck ?>)</a></td>
    						<td style="width:30%"><?= $inquiryModel->getInquiryList()[$i]['inquiry_date'] ?></td>
    					</tr>
    					<?php }?>
            		    
    		    	
    			</table>
    		</div>
    		<?php 
    		}
    		mysqli_close($conn);
    		?>
		</div>
	</div>
	
	<!-- お問い合わせ詳細内容 -->
    <div class="modal fade" id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<!-- タイトル -->
            	<input type="hidden" id="inquiryNo" name="inquiryNo">
                <h4 class="modal-title w-100" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
            	<!-- 内容 -->
                <div id="myModalContent"></div>
                <hr>
                <div>
                	<span class="text-success">返信：</span>
                	<!-- 返信日 -->
                	<span style="float:right;" id="myModalReplyDate" ></span>
                </div>
                <!-- 返信内容 -->
                
                <?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] == '9'){ ?>
                	<div id="myModalReplyContentText"></div>
                <?php } else {?>
                	<div id="myModalReplyContent"></div>
                <?php }?>
            </div>
            
            <div class="modal-footer">
            	<?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] == '9'){ ?>
            		<button type="button" class="btn btn-success" id="replyButton" onclick="inquiryReplyContent();">返信する</button>
            	<?php }?>
           		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
            </div>
            
        </div>
    </div>
</div>

<script src="./btjs/jquery.min.js"></script>
<script src="./btjs/popper.min.js"></script>
<script src="./btjs/bootstrap.min.js"></script>	
<script src="./btjs/fleamarket.js"></script>
</body>
</html>