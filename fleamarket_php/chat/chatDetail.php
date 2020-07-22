<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>チャット|フリマシステム</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link href="../btcss/bootstrap.min.css" rel="stylesheet">
<link href="../btcss/mdb.min.css" rel="stylesheet">
<link href="../btcss/style.css" rel="stylesheet">
<link href="../btcss/addons/datatables2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
<link href="../css/user.css" rel="stylesheet">
<script>

function chatList(userId){
	$.ajax({
		type : 'post',
		url : './chatDetail.php',
		data : {user_id : userId},
		success : function(result){
			chatContentList(userId);
			$('#chatListForm').show();
		}
	}); 
}
function chatBox(toID){
	var fromID = '<?= $_SESSION['userInfo']['user_id']?>';
	$.ajax({
		type : 'POST',
		url : './chatBoxAjax.php',
		data : {fromID : fromID},
		success : function(result){
			var chatList = "";
			for(var i = 0; i < result['result'].length; i++){
				var userId = result['result'][i].fromID;
				if(userId == fromID) {
					userId = result['result'][i].toID;
				}
				chatList = chatList + '<div id=\''+userId+'\'>' + 
                            				'<a href="javascript:void(0);" onclick="chatList(\''+userId+'\')">'+
                            				'<div class="chat_list">' +
                            					'<div class="chat_people">' +
                            						'<div class="chat_img"><img src="../img/123.jfif" alt="sunil"></div>' +
                            						'<div class="chat_ib">' +
                            							'<h5>'+userId+' <span class="chat_date" id="'+userId+'ChatDate">'+result['result'][i].chatTime+'</span></h5>' +
                            							'<p id="'+userId+'ChatContent">'+result['result'][i].chatContent+'</p>' +
                            						'</div>' +
                            					'</div>' +
                            				'</div>' +
                            				'</a>' +
                            			'</div>';
			}
			$('.inbox_chat').html(chatList);
			$('.active_chat').removeClass('active_chat');
			$('#'+toID+'').toggleClass('active_chat');
		}
	});
	
}

/* チャット内容を登録する */
 function chatSubmit(){	 
		var fromID = '<?= $_SESSION['userInfo']['user_id']?>'; 
		var toID = $('#user_id').val();
		var chatContent = $('#chatContent').val();

		if(chatContent == ''){
			alert('内容を入力してください。');
			$('#chatContent').focus();
			return false;
		}
		
		$.ajax({
			type : 'POST',
			url : './chatContentCreateAjax.php',
			data : {
				fromID : fromID,
				toID : toID,
				chatContent : chatContent
			},
			success : function(result){
				if(result['result'].fromID == fromID){
					$('.msg_history').append(
							'<div class="outgoing_msg"></div>' +
							'<div class="sent_msg" style="width:51%;">' +
							'<p>'+result['result'].chatContent+'</p>' +
							'<span class="time_date">'+result['result'].chatTime+'</span>' +
							'</div>' +
							'</div>'
							);
				} 	else{
					$('.msg_history').append(
							'<div class="incoming_msg" style="float:left; width:51%">' +
							'<div class="incoming_msg_img" >'+
							'<img src="../img/123.jfif" alt="sunil">' +
							'</div>'+								
							'<div class="received_msg" >'+
							'<p style="margin-bottom:0px;">'+result['result'].fromID+'</p>' +
							'<div class="received_withd_msg" style="width: 100%;">'+
							'<p>'+result['result'].chatContent+'</p>'+
							'<span class="time_date">'+result['result'].chatTime+'</span>'+
							'</div>' +
							'</div>' +
							'</div>'
							);
				}
				
				$('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
				chatBox(result['result'].toID);
			}
		});
		$('#chatContent').val('');
	}

/* チャットリスト */
 function chatContentList(userId){
	 	$('.active_chat').removeClass('active_chat');
		$('#'+userId+'').toggleClass('active_chat');
		$('.msg_history').html('');
		
		var fromID = '<?= $_SESSION['userInfo']['user_id']?>'; 
		var toID = userId;
		
		$.ajax({
			type : 'POST',
			url : './chatContentListAjax.php',
			data : {
				fromID : fromID,
				toID : toID
			},
			success : function(result){
				
				if(result['result'][0].fromID == fromID){
					$('.msg_history').append('<input type="hidden" name="user_id" id="user_id" value=\''+result['result'][0].toID+'\'>');
				}else{
					$('.msg_history').append('<input type="hidden" name="user_id" id="user_id" value=\''+result['result'][0].fromID+'\'>');
				}
				
				for(var i = 1; i < result['result'].length; i++){
					if(result['result'][i].fromID == fromID){
						$('.msg_history').append(
								'<div class="outgoing_msg"></div>' +	
								'<div class="sent_msg" style="width:51%;">' +
								'<p>'+result['result'][i].chatContent+'</p>' +
								'<span class="time_date">'+result['result'][i].chatTime+'</span>' +
								'</div>' +
								'</div>'
								);
					} 	else{
						$('.msg_history').append(
								'<div class="incoming_msg" style="float:left; width:51%">' +
								'<div class="incoming_msg_img" >'+
								'<img src="../img/123.jfif" alt="sunil">' +
								'</div>'+								
								'<div class="received_msg" >'+
								'<p style="margin-bottom:0px;">'+result['result'][i].fromID+'</p>' +
								'<div class="received_withd_msg" style="width: 100%;">'+
								'<p>'+result['result'][i].chatContent+'</p>'+
								'<span class="time_date">'+result['result'][i].chatTime+'</span>'+
								'</div>' +
								'</div>' +
								'</div>'
								);
					}
				
					$('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
					
				}
				
			}
		
		}); 
}


</script>
</head>
<body>

	<?php require_once '../menu/menunav.php';?>
	

	<div class="container" style="margin-top: 50px">
		<hr>
		<div>
			<h4 class="text-dark font-weight-bold" style="float: left;">チャットリスト</h4>
		</div>

		<div class="messaging">
			<div class="inbox_msg">
				<div class="inbox_people">
					<div class="headind_srch">
						<div class="recent_heading">
							<h4>最近内訳</h4>
						</div>
						<div class="srch_bar">
							<div class="stylish-input-group">
								<input type="text" class="search-bar" placeholder="Search"> 
								<span class="input-group-addon">
									<button type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
								</span>
							</div>
						</div>
					</div>
					<div class="inbox_chat"></div>
				</div>
				<!-- メッセージ内容 -->	
				<form onsubmit="chatSubmit(); return false;" id="chatListForm" style="display:none;">
    				
					
    				<div class="mesgs">
    					<div class="msg_history"></div>
    					
    					<div class="type_msg">
    						<div class="input_msg_write">
    							
    							<input type="text" class="write_msg" placeholder="Type a message" name="chatContent" id="chatContent" />
    							<button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
    							
    						</div>
    					</div>
    				</div>
				</form>
			</div>
		</div>

	</div>


	<script src="../btjs/jquery.min.js"></script>
	<script src="../btjs/popper.min.js"></script>
	<script src="../btjs/bootstrap.min.js"></script>
	<script>

	/* 最近メッセージリストを表示します。 */
	 $(document).ready(function(){
		chatBox();
		<?php if(isset($_POST['user_id'])){?>
		$.ajax({
			type : 'POST',
			url : './createAjax.php',
			data : {
				toID :'<?=$_POST['user_id'] ?>',
				fromID : '<?=$_SESSION['userInfo']['user_id']?>' 
			},
			success : function(result){
				
				chatBox();
					
				chatList('<?=$_POST['user_id'] ?>');
				
				$('#chatListForm').show();
			}
		});
		<?php }?>
	}); 


	</script>
</body>
</html>