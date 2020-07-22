<?php 
session_start();
require_once '../db/connection.php';
/**
 * お問い合わせリスト (管理者：全てのリスト、一般ユーザー：自分のお問い合わせリストだけ)
 * @var string $sql
 */
$sql = " SELECT * FROM inquiryinfo ";
if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] != '9'){
    $sql .= " WHERE user_no = {$_SESSION['userInfo']['user_no']} ";
}
$sql .= " ORDER BY inquiry_no DESC ";
$result = connection($sql);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>お問い合わせ | フリマシステム</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link href="../btcss/bootstrap.min.css" rel="stylesheet">
<link href="../btcss/mdb.min.css" rel="stylesheet">
<link href="../btcss/style.css" rel="stylesheet">
<link href="../btcss/addons/datatables2.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/user.css">

</head>
<body>
	<?php require_once '../menu/menunav.php';?>
	<div class="container">
    	<div class="row">
    		<div class="col-lg-3" style="height:100%">
    			<h1 class="my-4">お問い合わせ</h1>
    			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="listInquiryDiv-tab" data-toggle="pill" href="#listInquiryDiv" role="tab" aria-controls="listInquiryDiv" aria-selected="true">お問い合わせ内訳</a>
                    <?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] != '9'){ ?>
                    <a class="nav-link" id="insertInquiryFormDiv-tab" data-toggle="pill" href="#insertInquiryFormDiv" role="tab" aria-controls="insertInquiryFormDiv" aria-selected="false">お問い合わせする</a>
                    <?php }?>
                </div>
    		</div>	
	
        	<div class="col-lg-9">
        		<div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="listInquiryDiv" role="tabpanel" aria-labelledby="listInquiryDiv-tab">
                    	<h3 style="text-align:center; margin-top:20px;">お問い合わせ内訳</h3>
                		<table class="table">
                			<tr>
                				<th style="width:10%">No.</th>
                				<th style="width:40%">タイトル</th>
                				<th style="width:30%">登録日</th>
                				<th style="width:20%">返信</th>
                			</tr>
                			<?php 
                			if(mysqli_num_rows($result) > 0){
                			    while($data = mysqli_fetch_assoc($result)){
                			?>
                			<tr>
                				<td><?=$data['inquiry_no'] ?></td>
                					<?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] != '9'){?>
                					<td><a href="javascript:void(0)" onclick="inquiryModal('<?=$data['inquiry_no'] ?>')"><?=$data['inquiry_title'] ?></a></td>
                					<?php } else {?>
                					<td><a href="javascript:void(0)" onclick="inquiryReplyModal('<?=$data['inquiry_no'] ?>')"><?=$data['inquiry_title'] ?></a></td>
                					<?php }?>
                				<td><?=$data['inquiry_date'] ?></td>
                				<td><?php $data['inquiry_replycheck'] == '0' ? print "<span class='text-danger'>未返信</span>" : print "<span class='text-primary'>返信完了</span>" ?></td>
                			</tr>
                			<?php         
                			    }
                    			mysqli_free_result($result);
                			} else {
                			?>
                			<tr>
                				<td colspan="4" style="text-align:center;">お問い合わせ内訳はありません。</td>
                			</tr>
                			<?php 
                			}
                			?>
                		</table>
                    </div>
                    <?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] != '9'){ ?>
                    <div class="tab-pane fade" id="insertInquiryFormDiv" role="tabpanel" aria-labelledby="insertInquiryFormDiv-tab">
                    	<h3 style="text-align:center; margin-top:20px;">お問い合わせ</h3>
                		<form class="form-group" id="insertInquiryForm" name="insertInquiryForm" method="post">
                			<input type="hidden" id="userNo" name="userNo" value="<?=$_SESSION['userInfo']['user_no'] ?>">
                			<input type="hidden" id="userId" name="userId" value="<?=$_SESSION['userInfo']['user_id'] ?>">
                			<input type="hidden" id="userPhoneNumber" name="userPhoneNumber" value="<?=$_SESSION['userInfo']['user_phone'] ?>">
                			<input type="hidden" id="userEmail" name="userEmail" value="<?=$_SESSION['userInfo']['user_email'] ?>">
                			<div class="md-form">
                                <input  type="text" class="form-control" id="inquiryTitle" name="inquiryTitle" value="">
                                <label for="inquiryTitle">タイトルを入力してください。</label>
                            </div>
                            <div class="md-form">
                                <textarea class="md-textarea form-control" rows="5" id="inquiryContent" name="inquiryContent" style="overflow-y:scroll"></textarea>
                                <label for="inquiryContent">内容を入力してください。</label>
                            </div>

                        	<div style="text-align:right">
                        		<button type="button" class="btn btn-primary" onclick="insertInquiry(); return false;">お問い合わせする</button>
                        		<button type="button" class="btn btn-danger" onclick="#">取消</button>
                    		</div>
                		</form>
                    </div>
                    <?php }?>
                </div>
        	</div>
    	</div>
	</div>


<!-- お問い合わせ詳細内容(返信) -->
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
            	<?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_authority'] == '9'){ ?>
            	<button type="button" class="btn btn-success" id="replyButton" onclick="inquiryReplyContent();">返信する</button>
            	<?php }?>
           		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
            </div>
            
        </div>
    </div>
</div>


<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../js/inquiry.js"></script>
</body>
</html>