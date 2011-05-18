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
		
		//ajax hooks
		add_action( 'wp_ajax_save-data', array($this,'save_data' ));		
		}
		
		
		// Ajax Functions
		
		function save_data(){
			global $wpdb;
			
			$data = array('IR_path', 'IR_link', 'IR_target', 'IR_title', 'IR_desc', 'IR_type', 'IR_status', 'IR_order');
			
			$data = array_combine($data, $_REQUEST['data'] );
			extract($data);
			$widget_id = (int)$_REQUEST['id'] ;
			
			if(! $this -> exists_in_table($widget_id) ):
			
			$result = $wpdb -> insert('wp_multiple_reel',
					array(
					    'IR_widget_id' => $widget_id,
					     'IR_path' => $IR_path,
					     'IR_link' => $IR_link,
					     'IR_target' => $IR_path,
					     'IR_title' => $IR_title,
					     'IR_desc' => $IR_desc,
					     'IR_order' => $IR_order,
					     'IR_status' => $IR_status,
					     'IR_type' => $IR_type,
					     'IR_date' => 0					
					
					    ),
					array('%d', '%s','%s', '%s','%s','%s','%d','%s','%s','%d', )	
				 );
			
			else:
			
			
			endif;
			
			var_dump($result);
			
			exit;			
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
		$sSql = $sSql . "PRIMARY KEY ( `IR_id` ),";
		$sSql = $sSql . "key `widget_id` ( `IR_widget_id` )";
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
		if( strstr($_SERVER['REQUEST_URI'], 'multiple-reel' )  ){
				if(is_admin()):	
						wp_admin_css( 'widgets' );
						wp_enqueue_script('admin-widgets');			
						wp_enqueue_script('reel_admin_script',plugins_url('/' , __FILE__).'js/script.js');
						wp_register_style('admin_reel_css', plugins_url('/' , __FILE__).'css/style.css', false, '1.0.0');
						wp_enqueue_style('admin_reel_css');
			    endif;
    
         }
	
		
			}
			
			function front_scripts(){
				if(!(is_admin())){
				//wp_enqueue_script('jquery');
				wp_enqueue_script('add_video_script',plugins_url('/' , __FILE__).'js/script_front.js');
				//wp_enqueue_script('jcarousel-front',plugins_url('/' , __FILE__).'js/jquery.jcarousel.min.js');
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
	
	
	
	function operate($wiarray){
		$widgets = array();
		//$wiarray = get_option('widget_reelwidget');
		
		//var_dump($wiarray);
		//var_dump(get_option('sidebars_widgets'));
	
		foreach($wiarray as $key => $value){
		if(empty($value))
		  unset($wiarray[$key]);
		 //elseif(is_numeric($key))
		   //$widgets[]=$key;
	      }
	     update_option('widget_reelwidget',$wiarray);
	      
	      //var_dump($widgets);
	      
	      $all_widgets=get_option('sidebars_widgets');
	      
	      foreach($all_widgets as $cat => $sidebar)
			  if($cat != 'wp_inactive_widgets' && !empty($sidebar) && is_array($sidebar))
			    foreach($sidebar as $widget_name)
			        if( strstr( $widget_name,'reelwidget' ) )
			          $widgets[] = trim( str_replace('reelwidget-', '', $widget_name ));
			            
			  
		//var_dump($widgets); 
		
		return $widgets;
		
		}
	
	
	
	
	
	
	
	
	function OptionsPage( ){
		global $wpdb;
		
	        $cur_widgets = get_option('widget_reelwidget');
            $widgets = $this -> operate($cur_widgets);
			  
			  
	      
	      foreach($widgets as $widget):
	     // $result = $wpdb -> get_results("SELECT IR_path,IR_link,IR_title FROM wp_multiple_reel where IR_widget_id='$widget'",'ARRAY_N' );
	      extract($cur_widgets[$widget]);
	            
		?>
  <div  class='wrap' style="width:60%">		
     <div class="widget" style="width:100%">	
	   
	   <div class="widget-top">	   
		 <div class="widget-title-action">
			<a class="widget-action"></a>
	     </div>
		
		<div class="widget-title"><h4><?php echo $IR_Title ?><span class="in-widget-title"></span></h4></div>
		
	</div><!-- end of widget top -->

	<div class="widget-inside">
	
	<!-- Start of table -->
	<table id='table<?php echo $widget; ?>' width="100%">
      <tr>
        <td colspan="2" style='width:100%' align="left" valign="middle">Enter image url:</td>
      </tr>
      <tr>
        <td colspan="2" style='width:100%' align="left" valign="middle"><input style='width:100%' name="IR_path<?php echo $widget; ?>" type="text" id="IR_path<?php echo $widget; ?>" value=""  /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter target link:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input style='width:100%' name="IR_link<?php echo $widget; ?>" type="text" id="IR_link<?php echo $widget; ?>" value=""  /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter target option:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="IR_target<?php echo $widget; ?>" type="text" id="IR_target<?php echo $widget; ?>" value="_blank"  />
          ( _blank, _parent, _self, _new )</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter image title:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input style='width:100%' name="IR_title<?php echo $widget; ?>" type="text" id="IR_title<?php echo $widget; ?>" value=""  /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter image description:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><textarea style='width:100%' name="IR_desc<?php echo $widget; ?>" type="text" id="IR_desc<?php echo $widget; ?>" value="" > </textarea></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter gallery type (This is to group the images):</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="IR_type<?php echo $widget; ?>" type="text" id="IR_type<?php echo $widget; ?>" value="widget"  /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle">
                    
            <select name="IR_status<?php echo $widget; ?>" id="IR_status<?php echo $widget; ?>">
            <option value='YES'>Yes</option>
            <option value='NO'>No</option>
          </select>
          
         </td>
        <td width="78%" align="left" valign="middle"><input name="IR_order<?php echo $widget; ?>" type="text" id="IR_order<?php echo $widget; ?>" size="10" value="" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom">
       
      	<div class="alignleft">
              <input name="publish<?php echo $widget; ?>" lang="publish" class="button-primary" id='publish<?php echo $widget; ?>' value="Save" type="submit" />
               <input name="cancel<?php echo $widget; ?>" lang="publish" class="button-primary"  value="Cancel" type="button" /></td>
               <div class='messageBox'></div>
          	</div>
          </td>
      </tr>
      
    </table>
    
    <!-- end of upper part -->

	

<!--
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

	</div>
-->
   <br class="clear">
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
        function exists_in_table($id){
			global $wpdb;
			//$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
			$result=$wpdb->get_results( "SELECT IR_id FROM wp_multiple_reel where  IR_widget_id='$id'" );
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
