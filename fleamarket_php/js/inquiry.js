/**
 * 一般ユーザーのお問い合わせする
 * @returns
 */
function insertInquiryCheck(){
	
	if(inquiryTitle == ''){
		alert('タイトルを入力してください。');
		$(this).find('[name=inquiryTitle]').focus();
		return false;
	}
	if(inquiryContent == ''){
		alert('内容を入力してください。');
		$(this).find('[name=inquiryContent]').focus();
		return false;
	}
	
	var formData = $("#insertInquiryForm").serialize();
	$.ajax({
		type : 'POST',
		url : './insertInquiryAjax.php',
		data : formData, 
		
		success : function(result){
			if(result){
				alert('お問い合わせしました。');
				location.href='./inquiry.php';
			}else{
				alert('失敗しました。');
				location.href='../index.php';
			}
		}
	});
}

/**
 * お問い合わせの詳細情報をMODALとして表示する
 * @param inquiryNo
 * @returns
 */
function inquiryModal(inquiryNo){

	$.ajax({
		type : "POST",
		url : "./detailInquiryAjax.php",
		data : {inquiryNo : inquiryNo},
		success : function(result){
			
			$('#myModalLabel').html(result['result']['inquiry_title']);
			$('#myModalContent').html(result['result']['inquiry_content']);
			
			if(result['result']['inquiry_replycheck'] == '0'){
				$('#myModalReplyContent').html('まだ返信されてないです。');
				$('#myModalReplyDate').html('');
			}else{				
				$('#myModalReplyContent').html(result['result']['inquiry_replycontent']);
				$('#myModalReplyDate').html(result['result']['inquiry_replydate']);
			}
			$('#centralModalSm').modal("show");
		}
	});  
}

/**
 * 管理者がお問い合わせの詳細情報を確認する
 * @param inquiryNo
 * @returns
 */
function inquiryReplyModal(inquiryNo){
	$.ajax({
		type : "POST",
		url : "./detailInquiryAjax.php",
		data : {inquiryNo : inquiryNo},
		success : function(result){
			
			$('#myModalLabel').html(result['result']['inquiry_title']);
			$('#myModalContent').html(result['result']['inquiry_content']);
			
			if(result['result']['inquiry_replycheck'] == '0'){
				$('#myModalReplyNo').val(result['result']['inquiry_no']);
				$('#myModalReplyContent').html('<textarea class="md-textarea form-control" rows="3" id="inquiry_replycontent" name="inquiry_replycontent"></textarea>');
				$('#myModalReplyDate').html('');
			}else{				
				$('#myModalReplyNo').val(result['result']['inquiry_no']);
				$('#myModalReplyContent').html(result['result']['inquiry_replycontent']);
				$('#myModalReplyDate').html(result['result']['inquiry_replydate']);
			}
			$('#centralModalSm').modal("show");
		}
	});  
}

function inquiryReplyContent(){
	var myModalReplyNo = $('#myModalReplyNo').val();
	var myModalReplyContent = $('#inquiry_replycontent').val();
	
	$.ajax({
		type : "POST",
		url : "./replyInquiryAjax.php",
		data :{
			replyNo : myModalReplyNo,
			replyContent : myModalReplyContent
		},
		success : function(result){
			alert(result);
		}
	});

}
