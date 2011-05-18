<?php
class ReelWidget extends WP_Widget {
    /** constructor */
    
    function __construct(){
		$widget_ops = array( 'classname' => 'reelmultiple', 'description' => 'Display multiple reels' );
		$control_ops = array( 'width' => 505, 'height' => 350 );
		parent::__construct( false, 'Multiple Reel Widget',array(), $control_ops);
		
		}
    
    /*
    function ReelWidget() {
        parent::WP_Widget(false, $name = 'ReelWidget');
    }
    * */

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        
         	$instance = wp_parse_args( (array)$instance, array(
        	 'IR_Title' => '',
        	'IR_TextLength' => '125',
        	'IR_SameTime' => '3',
        	'IR_Height' => '140',
        	'IR_type' => 'widget',
        	'IR_random' =>'YES'        	       	
	
		) );
		
        
     //$instance= wp_parse_args($instance, array(   ));
     extract($instance);
       
    echo $before_widget.$before_title; 
    echo $IR_Title.$after_title;
      
  global $wpdb;
	
	
	
	
	
	if(!is_numeric($IR_SameTime)){ $IR_SameTime = 5; }
	if(!is_numeric($IR_Height)){ $IR_Height = 50; }
	if($IR_type == "" ) { $IR_type="widget"; }

	$sSql = "select IR_path,IR_link,IR_target,IR_title,IR_desc from ".WP_MIR_TABLE." where 1=1 and IR_status='YES'";
	$sSql = $sSql . " and IR_widget_id='".$this->number."'";
	$sSql = $sSql . " and IR_type='".$IR_type."'";
	if($IR_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY IR_order"; }
	$IR_data = $wpdb->get_results($sSql);
	
	?>
    <style type="text/css">
	.IR-regimage img {
		float: left;
		vertical-align:bottom;
		padding: 3px;
	}
	</style>
    <?php
	if ( ! empty($IR_data) ) 
	{
		$IR_count = 0;
		$IRhtml = "";
		foreach ( $IR_data as $IR_data ) 
		{
			$IR_path = mysql_real_escape_string(trim($IR_data->IR_path));
			$IR_link = mysql_real_escape_string(trim($IR_data->IR_link));
			$IR_target = mysql_real_escape_string(trim($IR_data->IR_target));
			$IR_title = mysql_real_escape_string(trim($IR_data->IR_title));
			$IR_desc = mysql_real_escape_string(trim($IR_data->IR_desc));
			
			if(is_numeric($IR_TextLength))
			{
				if($IR_TextLength <> "" && $IR_TextLength > 0 )
				{
					$IR_desc = substr($IR_desc, 0, $IR_TextLength);
				}
			}
			
			$IR_Heights = $IR_Height."px";	
			
			$IRhtml = $IRhtml . "<div class='IR_div' style='height:$IR_Heights;padding:1px 0px 1px 0px;'>"; 
			
			if($IR_path <> "" )
			{
				$IRhtml = $IRhtml . "<div class='IR-regimage'>"; 
				$IRjsjs = "<div class=\'IR-regimage\'>"; 
				if($IR_link <> "" ) 
				{ 
					$IRhtml = $IRhtml . "<a href='$IR_link'>"; 
					$IRjsjs = $IRjsjs . "<a href=\'$IR_link\'>";
				} 
				$IRhtml = $IRhtml . "<img style='width:100px;height:100px' src='$IR_path' al='Test' />"; 
				$IRjsjs = $IRjsjs . "<img style=\'width:100px;height:100px\' src=\'$IR_path\' al=\'Test\' />";
				if($IR_link <> "" ) 
				{ 
					$IRhtml = $IRhtml . "</a>"; 
					$IRjsjs = $IRjsjs . "</a>";
				}
				$IRhtml = $IRhtml . "</div>";
				$IRjsjs = $IRjsjs . "</div>";
			}
			
			if($IR_title <> "" )
			{
				$IRhtml = $IRhtml . "<div style='padding-left:4px;'><strong>";	
				$IRjsjs = $IRjsjs . "<div style=\'padding-left:4px;\'><strong>";				
				if($IR_link <> "" ) 
				{ 
					$IRhtml = $IRhtml . "<a href='$IR_link'>"; 
					$IRjsjs = $IRjsjs . "<a href=\'$IR_link\'>";
				} 
				$IRhtml = $IRhtml . $IR_title;
				$IRjsjs = $IRjsjs . $IR_title;
				if($IR_link <> "" ) 
				{ 
					$IRhtml = $IRhtml . "</a>"; 
					$IRjsjs = $IRjsjs . "</a>";
				}
				$IRhtml = $IRhtml . "</strong></div>";
				$IRjsjs = $IRjsjs . "</strong></div>";
			}
			
			if($IR_desc <> "" )
			{
				$IRhtml = $IRhtml . "<div style='padding-left:4px;'>$IR_desc</div>";	
				$IRjsjs = $IRjsjs . "<div style=\'padding-left:4px;\'>$IR_desc</div>";	
			}
			
			$IRhtml = $IRhtml . "</div>";
			
			
			$IR_x = $IR_x . "IR{$this->number}[$IR_count] = '<div class=\'IR_div\' style=\'height:$IR_Heights;padding:1px 0px 1px 0px;\'>$IRjsjs</div>'; ";	
			$IR_count++;
		}
		
		$IR_Height = $IR_Height + 4;
		if($IR_count >= $IR_SameTime)
		{
			$IR_count = $IR_SameTime;
			$IR_Height_New = ($IR_Height * $IR_SameTime);
		}
		else
		{
			$IR_count = $IR_count;
			$IR_Height_New = ($IR_count  * $IR_Height);
		}

		?>
<div style="padding-top:8px;padding-bottom:8px;">
  <div style="text-align:left;vertical-align:middle;text-decoration: none;overflow: hidden; position: relative; margin-left: 3px; height: <?php echo $IR_height; ?>px;" id="IRHolder<?php echo $this->number ?>"> <?php echo $IRhtml; ?> </div>
</div>
<script type='text/javascript'>
function scrollIR<?php echo $this->number ?>() {
	objIR<?php echo $this->number ?>.scrollTop = objIR<?php echo $this->number ?>.scrollTop + 1;
	IR_scrollPos<?php echo $this->number ?>++;
	if ((IR_scrollPos<?php echo $this->number ?>%IR_heightOfElm<?php echo $this->number ?>) == 0) {
		IR_numScrolls<?php echo $this->number ?>--;
		if (IR_numScrolls<?php echo $this->number ?> == 0) {
			objIR<?php echo $this->number ?>.scrollTop = '0';
			IRContent<?php echo $this->number ?>();
		} else {
			if (IR_scrollOn<?php echo $this->number ?> == 'true') {
				IRContent<?php echo $this->number ?>();
			}
		}
	} else {
		setTimeout("scrollIR<?php echo $this->number ?>();", 10);
	}
}

var IRNum<?php echo $this->number ?> = 0;
/*
Creates amount to show + 1 for the scrolling ability to work
scrollTop is set to top position after each creation
Otherwise the scrolling cannot happen
*/
function IRContent<?php echo $this->number ?>() {
	var tmp_IR<?php echo $this->number ?> = '';

	w_IR<?php echo $this->number ?> = IRNum<?php echo $this->number ?> - parseInt(IR_numberOfElm<?php echo $this->number ?>);
	if (w_IR<?php echo $this->number ?> < 0) {
		w_IR<?php echo $this->number ?> = 0;
	} else {
		w_IR<?php echo $this->number ?> = w_IR<?php echo $this->number ?>%IR<?php echo $this->number ?>.length;
	}
	
	// Show amount of IR
	var elementsTmp_IR<?php echo $this->number ?> = parseInt(IR_numberOfElm<?php echo $this->number ?>) + 1;
	for (i_IR<?php echo $this->number ?> = 0; i_IR<?php echo $this->number ?> < elementsTmp_IR<?php echo $this->number ?>; i_IR<?php echo $this->number ?>++) {
		
		tmp_IR<?php echo $this->number ?> += IR<?php echo $this->number ?>[w_IR<?php echo $this->number ?>%IR<?php echo $this->number ?>.length];
		w_IR<?php echo $this->number ?>++;
	}

	objIR<?php echo $this->number ?>.innerHTML 	= tmp_IR<?php echo $this->number ?>;
	
	IRNum<?php echo $this->number ?> 			= w_IR<?php echo $this->number ?>;
	IR_numScrolls<?php echo $this->number ?> 	= IR<?php echo $this->number ?>.length;
	objIR<?php echo $this->number ?>.scrollTop 	= '0';
	// start scrolling
	setTimeout("scrollIR<?php echo $this->number ?>();", 2000);
}

</script>
 <!--
<script type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/information-reel/information-reel.js"></script>  
 -->
<script type="text/javascript">
		var IR<?php echo $this->number ?>	= new Array();
		var objIR<?php echo $this->number ?>	= '';
		var IR_scrollPos<?php echo $this->number ?> 	= '';
		var IR_numScrolls<?php echo $this->number ?>	= '';
		var IR_heightOfElm<?php echo $this->number ?> = '<?php echo $IR_Height; ?>'; // Height of each element (px)
		var IR_numberOfElm<?php echo $this->number ?> = '<?php echo $IR_count; ?>';
		var IR_scrollOn<?php echo $this->number ?> 	= 'true';
		function createIRScroll<?php echo $this->number ?>() 
		{
			<?php echo $IR_x; ?>
			objIR<?php echo $this->number ?>	= document.getElementById('IRHolder<?php echo $this->number ?>');
			objIR<?php echo $this->number ?>.style.height = (IR_numberOfElm<?php echo $this->number ?> * IR_heightOfElm<?php echo $this->number ?>) + 'px'; // Set height of DIV
			IRContent<?php echo $this->number ?>();
		}
		</script> 
<script type="text/javascript">
		createIRScroll<?php echo $this->number ?>();
		</script>
<?php
	}
	else
	{
		echo "<div style='padding-bottom:5px;padding-top:5px;'>No data available!</div>";
	}
               echo $after_widget;
        
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
return $new_instance;
	//$instance['title'] = strip_tags($new_instance['title']);
       
    }

    /** @see WP_Widget::form */
    function form($instance) {
		//var_dump($instance);
			
        	$instance = wp_parse_args( (array)$instance, array(
        	'IR_Title' => '',       	
        	'IR_Height' => '140',
        	'IR_SameTime' => '3',
        	'IR_TextLength' => '125',
        	'IR_type' => 'widget',
        	'IR_random' =>'YES'
        	       	
	
		) );
		//extract($instance);
		 // var_dump($instance);
        ?>
        <!--start of widget -->
      
        
        <p>Title:<br/><input  style="width: 200px;" type="text" value="<?php echo $instance['IR_Title'] ?>" 
        name="<?php echo  $this->get_field_name('IR_Title') ?>" id="<?php echo  $this->get_field_id('IR_Title') ?>" /></p>
	
	<p>
	<label for="<?php echo $this->get_field_id('IR_Height'); ?>"><?php echo 'Height' ?>:</label>
	<br/><input  style="width: 100px;" type="text" value="<?php echo $instance['IR_Height'] ?>" 
	name="<?php echo  $this->get_field_name('IR_Height') ?>" id="<?php echo  $this->get_field_id('IR_Height') ?>" /> (YES/NO)</p>
	
	<p>Same Time Display:<br/><input  style="width: 100px;" type="text" value="<?php echo $instance['IR_SameTime'] ?>"
	 name="<?php echo  $this->get_field_name('IR_SameTime') ?>" id="<?php echo  $this->get_field_id('IR_SameTime') ?>" /> (YES/NO)</p>
	
	<p>Text Length:<br/><input  style="width: 100px;" type="text" value="<?php echo $instance['IR_TextLength'] ?>"
	 name="<?php echo  $this->get_field_name('IR_TextLength') ?>" id="<?php echo  $this->get_field_id('IR_TextLength') ?>" /> (YES/NO)</p>

	<p>Fallery Group:<br/><input  style="width: 100px;" type="text" value="<?php echo $instance['IR_type'] ?>"
	 name="<?php echo  $this->get_field_name('IR_type') ?>" id="<?php echo  $this->get_field_id('IR_type') ?>" /> </p>
	
	<p>Random Option:<br/><input  style="width: 100px;" type="text" value="<?php echo $instance['IR_random']?>" 
	name="<?php echo  $this->get_field_name('IR_random') ?>" id="<?php echo  $this->get_field_id('IR_random') ?>" /> (YES/NO)</p>

	
        
        
        <!--end of widget -->
        
        
        
        
        <?php 
    }

}
