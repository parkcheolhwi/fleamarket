<?php 
session_start();

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

$sql = "
        SELECT
            a.*, count(b.user_likecount) AS user_likecount, count(b.user_hatecount) AS user_hatecount
            FROM
                (
                SELECT  
                    userinfo.*, 
                    COUNT(goods.goods_no) AS goodsCount 
                        FROM 
                            userinfo 
                            LEFT JOIN 
                                goods 
                                ON 
                                userinfo.user_no = goods.user_no 
                                GROUP BY userinfo.user_no
                ) a
			LEFT JOIN
				like_hate_count b
                ON 
                    a.user_no = b.user_no
            WHERE
                user_authority = '1'
			GROUP BY
				a.user_no
            ORDER BY
                user_no;
            
        ";
/**
 * SQLを実行しデータを取得する
 * @var unknown $result
 */
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員管理 | フリマシステム</title>
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
	<h2 class='mb-3' style="margin-top:100px;">会員管理</h2>
	<table id="dtBasicExample" class="table">
		<thead>
            <tr>
                <th class="th-sm" style="width:15%; text-align:center;">ID</th>
                <th class="th-sm" style="width:15%; text-align:center;">いいね</th>
                <th class="th-sm" style="width:15%; text-align:center;">悪い</th>
                <th class="th-sm" style="width:15%; text-align:center;">出品数</th>
                <th class="th-sm" style="width:20%; text-align:center;">登録日</th>
                <th class="th-sm" style="width:20%; text-align:center;">会員有無</th>
            </tr>
        </thead>
		
		<tbody>
            <?php 
                 if(mysqli_num_rows($result) > 0){
                    while($data = mysqli_fetch_assoc($result)){
            ?>
            <tr>
            	<td style="text-align:center"><a href="javascript:void(0);" onclick="userDetailModal('<?=$data['user_no'] ?>')" ><span class="text-primary"><?=$data['user_id']?></span></a></td>
                <td style="text-align:center"><?=$data['user_likecount'] ?></td>
                <td style="text-align:center"><?=$data['user_hatecount'] ?></td>
                <td style="text-align:center" class="text-primary"><a href="javascript:void(0);" onclick="userGoodsCountCheck('<?=$data['user_no'] ?>')"><span class="text-primary"><?=$data['goodsCount'] ?></span></a></td>
                <td style="text-align:center"><?=$data['user_createdate']?></td>
                <td style="text-align:center"><?php $data['user_deletecheck'] == '0' ? print "会員" : print "非会員"?></td>
            </tr>
            <?php 
                    }
                }
                mysqli_free_result($result);
                mysqli_close($conn);
            ?>
        </tbody>
	</table>
</div>



    <!-- 詳細情報MODAL -->
	<div class="modal" id="detailUserModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="detailUser" name="detailUser" method="post">
					<input type="hidden" id="userNo" name="userNo" value="<?=$data['user_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">詳細情報<span id="detailUserDeleteCheckModal"></span></h4>
                        <button type="button" class="close detailUserModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    	<div style="float : right;">
                    		登録日：<span id="detailUserCreatedateModal"></span>&nbsp;修正日：<span id="detailUserUpdatedateModal"></span>&nbsp;脱退日：<span id="detailUserDeletedateModal"></span>
                    	</div>
                    	<table class="table form-group">
                        	<tr>
                        		<td>ID：</td>
                        		<td id="detailUserIdModal" ></td>
                        		<td>いいね：<span id="detailUserLikeCountModal"></span></td>
                        		<td>悪い：<span id=detailUserHateCountModal></span></td>
                    		</tr>
                    		<tr>
                    			<td>名前：</td>
                    			<td id="detailUserNameModal" colspan="3"></td>
                			</tr>
                			<tr>
                    			<td>生年月日：</td>
                    			<td id="detailUserBirthModal" colspan="3"></td>
                    		</tr>
                    		<tr>
                    			<td>電話番号：</td>
                    			<td id="detailUserPhoneModal" colspan="3"></td>
                    		</tr>
                    		<tr>
                    			<td>E-メール：</td>
                    			<td id="detailUserEmailModal" colspan="3"></td>
                    		</tr>
                    		<tr>	
                				<td>住所：</td>
                				<td id="detailUserAddressModal" colspan="3"></td>
            				</tr>
                    	</table>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                   		<button type="button" class="btn btn-danger detailUserModalClose" data-dismiss="modal">取消</button>
                    </div>
				</form>	
			</div>
		</div>
	</div>
	
	
	<!-- 出品数のModal -->
	<div class="modal" id="userGoodsCountCheckModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="userGoodsCountCheckUserId"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
            		<div id="userGoodsCountCheckList"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
			</div>
		</div>
	</div>
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../js/user.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script type="text/javascript" src="../btjs/addons/datatables2.min.js"></script>
<script>
$(document).ready(function () {
	  $('#dtBasicExample').DataTable();
	  $('.dataTables_length').addClass('bs-select');
	});
</script>
</body>
</html>