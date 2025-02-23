<?php
class bciwidgets_products extends WP_Widget
{
	// Create Multiple WordPress Widgets    
	function __construct()
    {
        parent::__construct('bciwidgets_products', __('BCI Product', 'bci_plugin'), array(
            'description' => __('BCI Products', 'bci_plugin')
        ));
    }   
    public function widget($args, $instance)
    {        
        $themes_template = get_template_directory() . "/resources/bci/widgets/products.php";
		if(file_exists($themes_template))require($themes_template);
		else require(dirname(dirname(dirname(__FILE__))).'/resources/widgets/products.php');
    }	
    // Create Instance and Assign Values
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Latest Items', 'bci_plugin');
        }        
        if (isset($instance['limit'])) {
            $limit = $instance['limit'];
        } else {
            $limit = __('3', 'bci_plugin');
        }
		
		$args = array(
		   'taxonomy' => 'categories',
		   'orderby' => 'name',
		   'order'   => 'ASC'
	     );

	    $cats = get_categories($args);
		   
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title');?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo esc_attr($title);?>" />
		 </p>
		 <p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"> <?php _e('Number of items');?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('limit');?>" name="<?php echo $this->get_field_name('limit');?>" type="text" value="<?php echo esc_attr($limit);?>" />
		 </p>
		 <p>
			<label for="<?=$this->get_field_id('cat')?>">Categories</label>
			<select name="<?=$this->get_field_name('cat')?>" id="<?=$this->get_field_id('cat'); ?>" class="widefat">
				<option value=""<?=selected($instance['cat'], '')?>>All</option>
				<?php foreach($cats as $cat) {	?>
					 <option value="<?php echo $cat->name; ?>" <?=selected($instance['cat_id'], $cat->name )?>><?php echo $cat->name; ?></option>
				<?php  } ?>
			</select>
	     </p>
		<?php
    }  
    // Updating widget replacing old instances with new
    function update($new_instance, $old_instance)
    {
    	$instance = array();
    	$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    	$instance['limit'] = intval($new_instance['limit']);
    	$instance['cat'] = $new_instance['cat'];
    	return $instance;
    }
}