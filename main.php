<?php   

/*
Plugin Name: Multiple Reel
Plugin URI: http://sabirul-mostofa.blogspot.com
Description: Add As many information reel in your sidebar(Extended From the Information Reel Plugin by Gopi.R. URL- 
http://www.gopiplus.com/work/2011/04/16/wordpress-plugin-information-reel/)
Version: 1.0
Author: Sabirul Mostofa
Author URI: http://sabirul-mostofa.blogspot.com
*/

require_once('widget.php');

global $wpdb;
define("WP_MIR_TABLE", $wpdb->prefix . "multiple_reel");

//var_dump(get_option('widget_reelwidget'));
//exit;


$multipleReel = new multipleReel();

if(isset($multipleReel)) {
	//add_action('init', array($multipleReel,'redirect'), 1);
	add_action('admin_menu', array($multipleReel,'CreateMenu'),50);
	add_action('widgets_init', create_function('', 'return register_widget("ReelWidget");'));	
	//add_action('sidebar_admin_setup', array($multipleReel,'delete_record_from_db'));
	
}

   
class multipleReel{
	
	function __construct(){
		add_action('admin_enqueue_scripts' , array($this,'add_scripts'));
		add_action('wp_print_scripts' , array($this,'front_scripts'));
        add_action('wp_print_styles',array($this,'front_css'));		
		register_activation_hook(__FILE__, array($this, 'create_table'));		
		}
		
		
	function create_table() {
	
	global $wpdb;

	if($wpdb->get_var("show tables like '". WP_MIR_TABLE . "'") != WP_MIR_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_MIR_TABLE . "` (";
		$sSql = $sSql . "`IR_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`IR_widget_id` INT NOT NULL default -1,";
		$sSql = $sSql . "`IR_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`IR_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`IR_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`IR_title` VARCHAR( 200 ) NOT NULL ,";
		$sSql = $sSql . "`IR_desc` VARCHAR( 1024 ) NOT NULL ,";
		$sSql = $sSql . "`IR_order` INT NOT NULL ,";
		$sSql = $sSql . "`IR_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`IR_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`IR_date` INT NOT NULL ,";
		$sSql = $sSql . "PRIMARY KEY ( `IR_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_MIR_TABLE . "` (`IR_path`, `IR_link`, `IR_target` , `IR_title` , `IR_desc` , `IR_order` , `IR_status` , `IR_type` , `IR_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/100x100/100x100_1.jpg','http://www.gopiplus.com/work/','_blank','Gopiplus.com','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.','1', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_MIR_TABLE . "` (`IR_path`, `IR_link`, `IR_target` , `IR_title` , `IR_desc` , `IR_order` , `IR_status` , `IR_type` , `IR_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/100x100/100x100_2.jpg','http://www.gopiplus.com/work/','_blank','Gopiplus.com','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.','2', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_MIR_TABLE . "` (`IR_path`, `IR_link`, `IR_target` , `IR_title` , `IR_desc` , `IR_order` , `IR_status` , `IR_type` , `IR_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/100x100/100x100_3.jpg','http://www.gopiplus.com/work/','_blank','Gopiplus.com','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.','3', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = "INSERT INTO `". WP_MIR_TABLE . "` (`IR_path`, `IR_link`, `IR_target` , `IR_title` , `IR_desc` , `IR_order` , `IR_status` , `IR_type` , `IR_date`)"; 
		$sSql = $sSql . "VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/100x100/100x100_4.jpg','http://www.gopiplus.com/work/','_blank','Gopiplus.com','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.','4', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	

}
		
		function delete_record_from_db(){
			
			
			if( $_REQUEST['delete_widget'] == 1 && $_REQUEST['id_base'] == 'reelwidget'){
				
				$widget_id = $_REQUEST['multi_number'] ;
				if(!is_numeric($widget_id))
				$widget_id = trim( str_replace('reelwidget-', '', $_REQUEST['widget-id']) ) ;
				exit;
				
			//Remove From Database
			
				}
				else
				return;
		
		//for working ajax 
		}
		
	function add_scripts(){
		//if(preg_match('/multipleReel/',$_SERVER['REQUEST_URI']) || preg_match('/wpManageVideo/',$_SERVER['REQUEST_URI'])){
				if(is_admin()):	
				wp_admin_css( 'widgets' );
			wp_enqueue_script('admin-widgets');
			wp_enqueue_script('jquery');
            wp_enqueue_script('reel_admin_script',plugins_url('/' , __FILE__).'js/script.js');	
            wp_localize_script('reel_admin_script', 'reelMultiple',
array(
'ajaxurl'=>admin_url('admin-ajax.php'),
'pluginurl' => plugins_url('/' , __FILE__)

)
);	

  wp_register_style('admin_reel_css', plugins_url('/' , __FILE__).'css/style.css', false, '1.0.0');
  wp_enqueue_style('admin_reel_css');
  endif;
    
 //}
	
		
			}
			
			function front_scripts(){
				if(!(is_admin())){
				wp_enqueue_script('jquery');
				wp_enqueue_script('add_video_script',plugins_url('/' , __FILE__).'js/script_front.js');
				wp_enqueue_script('jcarousel-front',plugins_url('/' , __FILE__).'js/jquery.jcarousel.min.js');
			     }
			}
				
				
				
			function front_css(){					
					if(!(is_admin())):
					wp_enqueue_style('reel_front', plugins_url('/' , __FILE__).'css/style_front.css');
					endif;
			}
			
		

	function CreateMenu(){
		//add_submenu_page('theme-options.php','Add From YouTube','Add From YouTube','activate_plugins','multipleReel',array($this,'OptionsPage'));
	   add_options_page('Multiple Reel', 'wp-multilple-reel', 'administrator', __FILE__, array($this, 'OptionsPage'));


	}
	
	
	
	
	
	
	
	
	
	
	function OptionsPage( ){
		
		$widgets = array();
		$wiarray = get_option('widget_reelwidget');
		
		var_dump($wiarray);
		var_dump(get_option('sidebars_widgets'));
	
		foreach($wiarray as $key => $value){
		if(empty($value))
		  unset($wiarray[$key]);
		 elseif(is_numeric($key))
		   $widgets[]=$key;
	      }
	     update_option('widget_reelwidget',$wiarray);
	      
	      var_dump($widgets);
	      foreach($widgets as $widget):
	      extract($wiarray[$widget]);
	            
		?>
  <div style="width:60%">		
     <div class="widget">	
	   <div class="widget-top">
	   
		<div class="widget-title-action">
			<a class="widget-action"></a>
		</div>
		
		<div class="widget-title"><h4><?php echo $IR_Title ?><span class="in-widget-title"></span></h4></div>
		
		</div>

	<div class="widget-inside">
	<form method="post" action="">
	<div class="widget-content">
		<p><label for="widget-search-2-title">Title: <input type="text" value="" name="widget-search[2][title]" id="widget-search-2-title" class="widefat"></label></p>
	</div>


	<div class="widget-control-actions">
		<div class="alignleft">
		<a href="#remove" class="widget-control-remove">Delete</a> |
		<a href="#close" class="widget-control-close">Close</a>
		</div>
		<div class="alignright">
		<img alt="" title="" class="ajax-feedback " src="<?php echo esc_url( admin_url( 'images/wpspin_dark.gif' ) ); ?>" style="visibility: hidden;">
		<input type="submit" value="Save" class="button-primary" id="saveMIR" >		</div>
		<br class="clear">
	</div>
	</form>
	</div>


</div>
</div>

	
		<?php
		
		endforeach;
	
	}//endof options page
	
	
	/*
 * SUBMENU PAGE Manage Video
 * 
 * */	
	
	function videoManage(){
	?>
		<div style="text-align:center;margin 15px 0"> <h3>Manage Video Playlist</h3></div>
		<div class="wrap">
					<table class="widefat">
						<thead>
							<tr>
								<th>Video Title</th>
								<th>Thumbnail</th>
								<th>Status</th>
								<th>Action</th>
								<th>Remove</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Video Title</th>
								<th>Thumbnail</th>
								<th>Status</th>
								<th>Action</th>
								<th>Remove</th>
							</tr>
						</tfoot>
						<tbody>
							
						<?php
						global $wpdb;
						$result = $wpdb->get_results( "SELECT video_title,video_id,video_stat FROM wp_video_list",ARRAY_N );			 
						foreach($result as $single):
						$title = $single[0];
						$id= $single[1];
						$stat = $single[2];
						$image = 'http://i.ytimg.com/vi/'.$id.'/1.jpg';
						
						echo '<td>',$title,'</td>';
						echo '<td>','<img src="'.$image.'"/>','</td>';
						
						if($stat == 1)
						echo '<td>',Active,'</td>';
						else 
						echo '<td>',Suspended,'</td>'; 
						
						if($stat == 1)
						echo '<td><button id="',$id,'" class="action">Suspend</button></td>'; 
						else 
						echo '<td><button id="',$id,'" class="action">Add</button></td>';
						
						echo '<td><button class="remove">Remove</button></td></tr>';
						
						endforeach;
							
						?>
						
							
						</tbody>
					</table>
				</div>
		

<?php
       }// end of video manage submenu page
       
       
       
     
		   
		   
	
   
 
   
   
   
   //Crude functions
        function exists_in_table($video_id){
			global $wpdb;
			//$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
			$result=$wpdb->get_results( "SELECT video_title FROM wp_video_list where  video_id='$video_id'" );
			if(empty($result))return false;
			else return true;			

			}
			
		function insert(){
			
			}
			
		function delete($vido_id){
				
				}
				
		function suspend(){			
			
		}
		
	
	  


}


?>
