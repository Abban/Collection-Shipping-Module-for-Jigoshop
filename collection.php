<?php
/*
Name: Irish Shipping Module Integrating Fastway and An Post
Module URI: http://abandon.ie/
Description: This is a module made for Jigoshop integrates the An Post and Fastway shipping rates to find which sercive is doing it cheaper.
Author: Abban Dunne.
Version: 1.0
*/

class collection extends jigoshop_shipping_method {
	
	public function __construct() { 
        $this->id 			= 'collection';
        $this->enabled		= get_option('jigoshop_collection_enabled');
		$this->title 		= get_option('jigoshop_collection_title');
		$this->availability = get_option('jigoshop_collection_availability');
		$this->countries 	= get_option('jigoshop_collection_countries');
		
		if (isset($_SESSION['_chosen_method_id']) && $_SESSION['_chosen_method_id']==$this->id) $this->chosen = true;
		
		add_action('jigoshop_update_options', array(&$this, 'process_admin_options'));
		add_option('jigoshop_collection_availability', 'all');
		add_option('jigoshop_collection_title', 'Collection');
    } 
    
    public function calculate_shipping() {
    	$this->shipping_total 	= 0;
		$this->shipping_tax 	= 0;
    	
    	if ($_SESSION['_chosen_method_id'] == 'collection') :
			
		endif;	
    }
    
    public function collection_error_message(){
    	jigoshop::add_error( __('Sorry, the max weight we are able to ship is 6kg. Please edit your cart and try again.', 'jigoshop') );
    }
    
    public function admin_options() {
    	?>
    	<thead><tr><th scope="col" width="200px"><?php _e('Irish Shipping', 'jigoshop'); ?></th><th scope="col" class="desc">Collection based shipping.</th></tr></thead>
    	<tr>
	        <td class="titledesc"><?php _e('Enable Irish Shipping', 'jigoshop') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_collection_enabled" id="jigoshop_collection_enabled" style="min-width:100px;">
		            <option value="yes" <?php if (get_option('jigoshop_collection_enabled') == 'yes') echo 'selected="selected"'; ?>><?php _e('Yes', 'jigoshop'); ?></option>
		            <option value="no" <?php if (get_option('jigoshop_collection_enabled') == 'no') echo 'selected="selected"'; ?>><?php _e('No', 'jigoshop'); ?></option>
		        </select>
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('This controls the title which the user sees during checkout.','jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('Method Title', 'jigoshop') ?>:</td>
	        <td class="forminp">
		        <input type="text" name="jigoshop_collection_title" id="jigoshop_collection_title" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_collection_title')) echo $value; else echo 'Irish Shipping'; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><?php _e('Method available for', 'jigoshop') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_collection_availability" id="jigoshop_collection_availability" style="min-width:100px;">
		            <option value="all" <?php if (get_option('jigoshop_collection_availability') == 'all') echo 'selected="selected"'; ?>><?php _e('All allowed countries', 'jigoshop'); ?></option>
		            <option value="specific" <?php if (get_option('jigoshop_collection_availability') == 'specific') echo 'selected="selected"'; ?>><?php _e('Specific Countries', 'jigoshop'); ?></option>
		        </select>
	        </td>
	    </tr>
	    <?php
    	$countries = jigoshop_countries::$countries;
    	$selections = get_option('jigoshop_collection_countries', array());
    	?><tr class="multi_select_countries">
            <td class="titledesc"><?php _e('Specific Countries', 'jigoshop'); ?>:</td>
            <td class="forminp">
            	<div class="multi_select_countries"><ul><?php
        			if ($countries) foreach ($countries as $key=>$val) :
            			                    			
        				echo '<li><label><input type="checkbox" name="jigoshop_collection_countries[]" value="'. $key .'" ';
        				if (in_array($key, $selections)) echo 'checked="checked"';
        				echo ' />'. __($val, 'jigoshop') .'</label></li>';

            		endforeach;
       			?></ul></div>
       		</td>
       	</tr>
       	<script type="text/javascript">
		jQuery(function() {
			jQuery('select#jigoshop_collection_availability').change(function(){
				if (jQuery(this).val()=="specific") {
					jQuery(this).parent().parent().next('tr.multi_select_countries').show();
				} else {
					jQuery(this).parent().parent().next('tr.multi_select_countries').hide();
				}
			}).change();
		});
		</script>
    	<?php
    }
    
    public function process_admin_options() {
   		
   		if(isset($_POST['jigoshop_collection_enabled'])) update_option('jigoshop_collection_enabled', jigowatt_clean($_POST['jigoshop_collection_enabled'])); else @delete_option('jigoshop_collection_enabled');
   		
   		if(isset($_POST['jigoshop_collection_title'])) update_option('jigoshop_collection_title', jigowatt_clean($_POST['jigoshop_collection_title'])); else @delete_option('jigoshop_collection_title');
   		
   		if(isset($_POST['jigoshop_collection_availability'])) update_option('jigoshop_collection_availability', jigowatt_clean($_POST['jigoshop_collection_availability'])); else @delete_option('jigoshop_collection_availability');
	    
	    if (isset($_POST['jigoshop_collection_countries'])) $selected_countries = $_POST['jigoshop_collection_countries']; else $selected_countries = array();
	    update_option('jigoshop_collection_countries', $selected_countries);
   		
    }
    	
}

function add_collection_method( $methods ) {
	$methods[] = 'collection'; return $methods;
}

add_filter('jigoshop_shipping_methods', 'add_collection_method' );