<?php 
session_start();

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
/*
 * 商品リスト
 */
$goodsListSql = "
        SELECT 
            goods.*, goods_file.goods_filerealname
            FROM 
                goods
            LEFT JOIN
                goods_file
                ON 
                    goods.goods_no = goods_file.goods_no
                WHERE
                    goods.goods_onsale = '0'
                    AND goods.goods_check = '0'
                ORDER BY 
                    goods.goods_updatedate DESC
        ";
$goodsList = mysqli_query($conn, $goodsListSql);

/**
 * ログインすると最近みた商品とお問い合わせのリストも表示する
 */
if(isset($_SESSION['userInfo'])){
    /**
     * お問い合わせのリスト
     * @var Ambiguous $inquiryListSql
     */
    $inquiryListSql = "
            SELECT
                inquiry_title, inquiry_date, inquiry_replycheck, inquiry_no
                FROM
                    inquiryinfo
                WHERE
                    user_no = {$_SESSION['userInfo']['user_no']}
                ORDER BY 
                    inquiry_date DESC
                ";
    $inquiryList = mysqli_query($conn, $inquiryListSql);
    
    
    /**
     * 最近みた商品のリスト
     * @var integer $i
     */
    $i = 0;
    if(isset($_SESSION['recentlyViewedGoods'])){
    $recentlyViewedGoodsSql = "
                    SELECT 
                        goods.goods_title, goods.goods_no, goods_file.goods_filerealname
                            FROM
                                goods
                            LEFT JOIN
					           goods_file
                                ON goods.goods_no = goods_file.goods_no
                            WHERE 
                                goods.goods_no 
                              IN (
                    ";
        foreach($_SESSION['recentlyViewedGoods'] as $value){
            $recentlyViewedGoodsSql .= $value;
            if(++$i != count($_SESSION['recentlyViewedGoods'])) $recentlyViewedGoodsSql .= ", ";
        }
        $recentlyViewedGoodsSql .= " ) ";
        
        $i = 0;
        $recentlyViewedGoodsSql .= "  ORDER BY FIELD(goods.goods_no, ";
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
    		<?php mysqli_num_rows($goodsList) > 5 ? print "<span style='float:right;'><a href='./goods/goodsList.php'>もっと見る</a></span>" : print ""?>
		</div>
	
		<?php 
		if(mysqli_num_rows($goodsList) > 0){
		    $count = 0;
		    while($row = mysqli_fetch_assoc($goodsList)){
		        if($count == 5) break;
		        if($row['goods_filerealname'] == null) $row['goods_filerealname'] = "noImg.jpg";
		?>
		<div style="clear: both; display: flex;flex-direction: row">
    		<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">
    			<img src="./upload/<?=$row['goods_filerealname']?>" style="max-height: 74px; max-width: 74px">
    		</div>
    		<div style="margin: 2px; padding: 5px; flex: 0 1 70%;">
        		<h5 style="margin:0" class="text-dark font-weight-bold"><a href="./goods/goodsDetail.php?goods_no=<?=$row['goods_no'] ?>"><?=$row['goods_title'] ?></a></h5>
        		<p style="margin-bottom:10px"><span class="text-dark font-weight-bold"><?=$row['goods_price'] ?>円</span></p>
        		<p style="margin:0"><span class="text-dark"><?=$row['goods_content'] ?></span></p>
    		</div>
    		<div style="margin: 2px; padding: 5px; flex: 0 1 20%;">
        		<p style="margin:0">修正日：<?=$row['goods_updatedate'] ?></p>
        		<p style="margin-bottom:10px">登録日：<?=$row['goods_createdate'] ?></p>
    		</div>
		</div> 
		<?php 
		      $count++;
		    }
		    mysqli_free_result($goodsList);
		}
		?>
		
		
		
		
		
		<?php 
		if(isset($_SESSION['userInfo']) && mysqli_num_rows($inquiryList) > 0){
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
			
			
			<!-- ユーザーのお問い合わせリスト -->
		    <div style="width:48%; float:right;">
    			<hr>
        		<div>
            		<h4 class="text-dark font-weight-bold" style="float:left;">お問い合わせリスト</h4>
            		<?php mysqli_num_rows($inquiryList) > 5 ? print "<span style='float:right;'><a href='./inquiry/inquiry.php'>もっと見る</a></span>" : print ""?>
        		</div>
    			<table class="table table-hover">
            		    <?php 
            		        $count = 0;
                		    while($row = mysqli_fetch_assoc($inquiryList)){
                		        $row['inquiry_replycheck'] == '0' ? $row['inquiry_replycheck']="<span class='text-danger'>未返信</span>" : $row['inquiry_replycheck'] = "<span class='text-success'>返信完了</span>";
                		        if($count == 5) break;
                		?>
    					<tr>
    						<td style="width:70%"><a href="javascript:void(0)" onclick="inquiryModal('<?=$row['inquiry_no'] ?>')"><?=$row['inquiry_title'] ?>(<?=$row['inquiry_replycheck'] ?>)</a></td>
    						<td style="width:30%"><?=$row['inquiry_date'] ?></td>
    					</tr>
                		<?php 
                		  $count++;
            		    } #while文
            		    mysqli_free_result($inquiryList);
            		    ?>
    		    	
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
                    <h4 class="modal-title w-100" id="myModalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                	<!-- 内容 -->
                    <div id="myModalContent"></div><hr>
                    
                    <!-- 返信 -->
                    <div>
                    	<span class="text-success">返信：</span>
                    	<span style="float:right;" id="myModalReplyDate"></span>
                    </div>
                    
                    <!-- 返信内容 -->
                    <div id="myModalReplyContent"></div>
                </div>
                
                <div class="modal-footer">
               		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script src="./btjs/jquery.min.js"></script>
<script src="./btjs/popper.min.js"></script>
<script src="./btjs/bootstrap.min.js"></script>	
<script src="./js/inquiry.js"></script>
</body>
</html>