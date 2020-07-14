<?php 
session_start();

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

$sql = "
        SELECT
            *
            FROM
                inquiryinfo
            ORDER BY 
                inquiry_no DESC;
        ";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>お問い合わせ| フリマシステム</title>
<link href="../btcss/bootstrap.min.css" rel="stylesheet">
<link href="../btcss/mdb.min.css" rel="stylesheet">
<link href="../btcss/style.css" rel="stylesheet">
</head>
<body>
    
	<?php require_once '../menu/menunav.php';?>
	<div class="container">
    	<div class="row">
    		<div class="col-lg-3" style="height:100%">
    			<h1 class="my-4">お問い合わせ</h1>
    			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="adminListInquiryDiv-tab" data-toggle="pill" href="#adminListInquiryDiv" role="tab" aria-controls="adminListInquiryDiv" aria-selected="true">お問い合わせ内訳</a>
                </div>
    		</div>	
	
        	<div class="col-lg-9" style="margin-top:20px;">
        		<div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="adminListInquiryDiv" role="tabpanel" aria-labelledby="adminListInquiryDiv-tab">
                    	<h3 style="text-align:center; margin-top:20px;">お問い合わせ内訳</h3>
                		<table class="table">
                			<thead>
                    			<tr>
                    				<th style="width:10%">No.</th>
                    				<th style="width:40%">タイトル</th>
                    				<th style="width:30%">登録日</th>
                    				<th style="width:20%">返信</th>
                    			</tr>
                			</thead>
                			<tbody>
                				<?php 
                				if(mysqli_num_rows($result) > 0){
                				    while($data = mysqli_fetch_assoc($result)){
                				?>
                				<tr>
                					<td><?=$data['inquiry_no'] ?></td>
                					<td><a href="javascript:void(0)" onclick="inquiryReplyModal('<?=$data['inquiry_no'] ?>')"><?=$data['inquiry_title'] ?></a></td>
                					<td><?=$data['inquiry_date'] ?></td>
                					<td><?php $data['inquiry_replycheck'] == '0' ? print "<span class='text-danger'>未返信</span>" : print "<span class='text-primary'>返信完了</span>" ?></td>
                				</tr>
                				<?php         
                				    }
                				    mysqli_free_result($result);
                				    mysqli_close($conn);
                				} else {
                				?>
                				<tr>
                					<td colspan="4" style="text-align:center;">お問い合わせ内訳はありません。</td>
                				</tr>
                				<?php 
                				}
                				?>
                			</tbody>
            			</table>	
                    </div>
                </div>
        	</div>
    	</div>
	</div>




<!-- お問い合わせ詳細内容 -->
<div class="modal fade" id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<!-- タイトル -->
            	<input type="hidden" id="myModalReplyNo" name="myModalReplyNo">
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
                	<span style="float:right;" id="myModalReplyDate"></span>
                </div>
                <!-- 返信内容 -->
                <div id="myModalReplyContent"></div>
            </div>
            
            <div class="modal-footer">
            	<button type="button" class="btn btn-success" onclick="inquiryReplyContent();">Get it now</button>
           		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            
        </div>
    </div>
</div>
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../js/inquiry.js"></script>
    ​
</body>
</html>
