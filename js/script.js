
jQuery(document).ready(function($){
	
	$('.button-primary').click(function(){
		
		var buttonId = ($(this).attr('value') == 'Save') ? 
		$(this).attr('name').replace('publish', '') : $(this).attr('name').replace('cancel', ''); 
		
		
		
		var IR_path = $( '#'+'IR_path'+buttonId).val();
		var IR_link = $( '#'+'IR_link'+buttonId).val();
		var IR_target = $( '#'+'IR_target'+buttonId).val();
		var IR_title = $( '#'+'IR_title'+buttonId).val();
		var IR_desc = $( '#'+'IR_desc'+buttonId).val();
		var IR_type = $( '#'+'IR_type'+buttonId).val();
		var IR_status = $( '#'+'IR_status'+buttonId).val();
		var IR_order = $( '#'+'IR_order'+buttonId).val();
		
		var vars = new Array();
		vars['IR_path'] = IR_path;
		vars['IR_link'] = IR_link;
		vars['IR_target'] = IR_target;
		vars['IR_title'] = IR_title;
		vars['IR_desc'] = IR_desc;
		vars['IR_type'] = IR_type;
		vars['IR_status'] = IR_status;
		vars['IR_order'] = IR_order;
		
		
		// sending this way works only in Ajax
var test = new Array(IR_path, IR_link, IR_target, IR_title, IR_desc, IR_type, IR_status, IR_order);
		
	     
		
		switch( $(this).attr('value') ){
			
			case 'Save':
			
			$.ajax(
		    {
			type : "post",
			url : ajaxurl,
		    timeout : 5000,
		    data : {
			 'action':'save-data',
			 'id' : buttonId,
			 'data' : test			 
			  
			},
			
		success: function(data){
			$('.messageBox').html(data);
			}
	       });			
			
			break;
			
			case 'Cancel':
			
			
			break;
			
			
			}//endof switch
		
		
		});
	

	
	});
