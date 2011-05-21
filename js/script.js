

(function($){
	
	$.fn.IRcheckData = function(id){		
		var test = true;	
		
		 if( $('#table'+ id +' textarea').val() == '' )return false;	
				
		$('#table'+ id +' input').each(function(i){
        if( $(this).val() == '')
			test = false;
         });
         return test;
			
	};
	
	
	$.fn.IRcancelData = function(id){
		$('#table'+ id +' textarea').val('');
		
		$('#table'+ id +' input').each(function(i){			
			if( $(this).val() != 'Save' && $(this).val() != 'Cancel'
			&& $(this).val() != '_blank' && $(this).val() != 'widget' 
			&& $(this).val() != 'Update' && $(this).attr('type') != 'hidden'  )
			$(this).val(''); 
			 
			 });
			 $('#publish'+id).val('Save');
			 
			 if($('#irId').length != 0) $('#irId').remove();
	 };
	 
	 $.fn.IRactionGet = function(e){
		e.preventDefault();
		var buttonId = $(this).parents('.widefat').attr('id');
				
		buttonId = Number(buttonId.replace('linkHolder',''));		
		
		 
		var id=($(this).attr('class'));
		
		var tr =$(this).parent().parent();
		
		switch($(this).text()){
			
			case 'Edit':
			$(this).parent().append('<input type="hidden" '+ 'value="'+id+'" id="irId"' +'/>');
			   $.ajax(
		    {
			type : "post",
			dataType : 'json',
			url : ajaxurl,
		    timeout : 5000,
		    
		    data : {
			 'action':'save-data',
			 'id' : id,			
			 'job' : 'edit'			 
			  
			},
			
		success: function(data){
		var IR_path = data['IR_path'];
		$( '#'+'IR_path'+buttonId).val(IR_path);
		
		var IR_link = data['IR_link'];
		$( '#'+'IR_link'+buttonId).val(IR_link);
		
		var IR_target = data['IR_target'];
		$( '#'+'IR_target'+buttonId).val(IR_target);
		
		var IR_title = data['IR_title'];
		$( '#'+'IR_title'+buttonId).val(IR_title);
		
		var IR_desc = data['IR_desc'];
		$( '#'+'IR_desc'+buttonId).val(IR_desc);
		
		var IR_type = data['IR_type'];
		$( '#'+'IR_type'+buttonId).val(IR_type);
		
		var IR_status = data['IR_status'];
		$( '#'+'IR_status'+buttonId).val(IR_status);
		
		var IR_order = data['IR_order'];
		$( '#'+'IR_order'+buttonId).val(IR_order);
		
		$('#publish'+buttonId).val('Update');
			
		//$('.messageBox').html(data);
			//$('#linkHolder'+buttonId).append(data);
			}
	       });
			
			 break;
			
			case 'Delete':
		    $.ajax(
		    {
			type : "post",
			url : ajaxurl,
		    timeout : 5000,
		    
		    data : {
			 'action':'save-data',
			 'id' : id,			
			 'job' : 'delete'			 
			  
			},
			
		success: function(data){
			//$('.messageBox').html(data);
			tr.remove();
			//$('#linkHolder'+buttonId).append(data);
			}
	       });
			
						
			break;
			
			};
		
		}
		
	
		

})(jQuery);


jQuery(document).ready(function($){
	
	$('.actionGet a').bind('click',$.fn.IRactionGet);
		
		
	
	$('.button-primary').click(function(){
		
	
		
		var buttonId = ($(this).attr('value') == 'Save' || $(this).attr('value') == 'Update' ) ? 
		$(this).attr('name').replace('publish', '') : $(this).attr('name').replace('cancel', ''); 
		
		
		

		
		var IR_path = $( '#'+'IR_path'+buttonId).val();
		var IR_link = $( '#'+'IR_link'+buttonId).val();
		var IR_target = $( '#'+'IR_target'+buttonId).val();
		var IR_title = $( '#'+'IR_title'+buttonId).val();
		var IR_desc = $( '#'+'IR_desc'+buttonId).val();
		var IR_type = $( '#'+'IR_type'+buttonId).val();
		var IR_status = $( '#'+'IR_status'+buttonId).val();
		var IR_order = $( '#'+'IR_order'+buttonId).val();

		
		// sending this way works only in Ajax
var test = new Array(IR_path, IR_link, IR_target, IR_title, IR_desc, IR_type, IR_status, IR_order);
		
	     
		
		switch( $(this).attr('value') ){
			
			case 'Save':
				if ($.fn.IRcheckData(buttonId) == false){ 
				alert('You need to fill all the fields');
				return;
				}
			
			$.ajax(
		    {
			type : "post",
			url : ajaxurl,
		    timeout : 5000,
		    
		    data : {
			 'action':'save-data',
			 'id' : buttonId,
			 'data' : test,
			 'job' : 'save'			 
			  
			},
			
		success: function(data){
			$.fn.IRcancelData(buttonId);
			$('#linkHolder'+buttonId).append(data);
			//$('#message'+buttonId).html('Information Saved Successfully');
			//rebind
			$('.actionGet a').bind('click',$.fn.IRactionGet);
			
			
			}
	       });			
			
			break;
			
			case 'Update':
				if ($.fn.IRcheckData(buttonId) == false){ 
				alert('You need to fill all the fields');
				return;
				}
			
			var irId = $('#irId').attr('value');
				$.ajax(
		    {
			type : "post",
			url : ajaxurl,
		    timeout : 5000,
		    
		    data : {
			 'action':'save-data',
			 'id' : buttonId,
			 'irId' : irId,
			 'data' : test,
			 'job' : 'update'			 
			  
			},
			
		success: function(data){
			//$('.messageBox').html(data);
			jQuery( '.'+ irId + ':first' ).parent().parent().remove();
			$('#linkHolder'+buttonId).append(data);
			
			$.fn.IRcancelData(buttonId);
			//rebind
			$('.actionGet a').bind('click', $.fn.IRactionGet);
			}
	       });	
			
			
			break;
			
			case 'Cancel':
			
			$.fn.IRcancelData(buttonId);
			
			
			break;
			
			
			}//endof switch
		
		
		});
		
		
	

	
	});
