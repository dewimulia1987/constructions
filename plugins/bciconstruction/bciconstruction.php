<?php
/* 
Plugin Name: BCI Construction
Description: WordPress Developer Assignment Test
Version: 1.0
Author: Dewi Mulia
Author URI: https://degivi.id/dewimulia
*/
trait BciInstance {

	public static $instance = null;

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

class bci{
	use BciInstance;

	public function __construct(){
		add_action( 'init', array($this, 'init'));
		add_action( 'save_post',  array($this, 'constructions_save_postdata'), 10, 2);
		add_filter( 'manage_constructions_posts_columns',  array($this, 'set_custom_edit_constructions_columns') );
		add_action( 'manage_constructions_posts_custom_column' ,  array($this, 'custom_constructions_column'), 10, 2 );
		add_action( 'widgets_init', array($this, 'widget_register'));
		add_filter( 'widget_text', array($this, 'parse_shortcode'));
		add_shortcode( 'bci', array($this, 'parse_shortcode'));
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		add_action( 'wp_enqueue_scripts', array($this, 'frontend_scripts'), 0);
		add_action( 'wp_ajax_add_to_cart', array($this, 'add_to_cart'));
		add_action( 'wp_ajax_nopriv_add_to_cart', array($this, 'add_to_cart'));
		add_action( 'wp_ajax_remove_from_cart', array($this, 'remove_from_cart'));
		add_action( 'wp_ajax_nopriv_remove_from_cart', array($this, 'remove_from_cart'));
		add_action( 'wp_ajax_load_product', array($this, 'load_product'));
		add_action( 'wp_ajax_nopriv_load_product', array($this, 'load_product'));
		
	}

	function init(){
		$this->siteUrl = get_option('siteurl');
		if ( '/' != $this->siteUrl[strlen($this->siteUrl)-1]) $this->siteUrl .= '/';
		$this->pluginUrl = $this->siteUrl . PLUGINDIR . '/' . basename(dirname(__FILE__)) .'/';
		
		register_post_type( 'constructions',
			array(
				'labels' => array(
					'name' => 'BCI Constructions',
					'singular_name' => 'Constructions Items',
					'add_new' => 'Add New',
					'add_new_item' => 'Add Constructions Item',
					'edit' => 'Edit',
					'edit_item' => 'Edit Constructions Item',
					'new_item' => 'New Constructions Item',
					'view' => 'View',
					'view_item' => 'View Constructions Item',
					'search_items' => 'Search Constructions Item',
					'not_found' => 'Constructions not found',
					'not_found_in_trash' => 'No Constructions Item found in Trash',
					'parent' => 'Parent Constructions Item'
				),

				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'has_archive' => true,
				'capability_type' => 'post',
				'supports' => array('title', 'editor', 'thumbnail'),
				'rewrite' => array('slug' => 'constructions'),
				'query_var' => true,
				'register_meta_box_cb' => array($this, 'bci_meta_boxes')
			)
		);

		register_taxonomy( 'categories', array('constructions'), array(
			'hierarchical' => true, 
			'label' => 'Categories', 
			'singular_label' => 'Category', 
			'rewrite' => array( 'slug' => 'categories', 'with_front'=> false )
			)
		);
	}

	function frontend_scripts() {
		?>
		<script>
			var ajax_object = {"ajax_url":"<?php echo str_replace('\\','\\/',admin_url('admin-ajax.php')); ?>"};
			var cart = '<?php if($this->get_cart())echo '1';else echo '0'; ?>';
		</script>
		<?php
		wp_enqueue_script( 'frontend-scripts', $this->pluginUrl . 'assets/js/frontend-scripts.js', array(), '1.004', true );
	}

	function admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-sortable');
		wp_enqueue_script( 'custom-admin-scripts',  $this->pluginUrl . 'assets/js/admin.js', array(), '1', true  );
	}

	function bci_meta_boxes(){
		add_meta_box( 'constructions-meta-boxes', 'Details', array($this, 'create_constructions_metaboxes'), 'constructions', 'normal', 'core');
	}

	function create_constructions_metaboxes( $meta_boxes ) {
		global $post;
		$gallery_data = get_post_meta( $post->ID, 'gallery_data', true );
		$price = get_post_meta($post->ID, 'price', true);
		$size = get_post_meta($post->ID, 'size', true);
		$color = get_post_meta($post->ID, 'color', true);
		$application_method = get_post_meta($post->ID, 'application_method', true);
		$material = get_post_meta($post->ID, 'material', true);
		$dimension = get_post_meta($post->ID, 'dimension', true);
		$weight = get_post_meta($post->ID, 'weight', true);
		?>
		<table class="widefat maintable" cellspacing="0" >
			<tr>
				<td>Price (IDR)</td>
				<td><input type="number" name="price" value="<?php echo $price; ?>"></td>
			</tr>
			<tr>
				<td>Size</td>
				<td><input type="text" class="widefat" name="size" value="<?php echo $size; ?>"></td>
			</tr>
			<tr>
				<td>Color</td>
				<td><input type="text" class="widefat" name="color" value="<?php echo $color; ?>"></td>
			</tr>
			<tr>
				<td>Material</td>
				<td><input type="text" class="widefat" name="material" value="<?php echo $material; ?>"></td>
			</tr>
			<tr>
				<td>Dimension</td>
				<td><input type="text" class="widefat" name="dimension" value="<?php echo $dimension; ?>"></td>
			</tr>
			<tr>
				<td>Application Method</td>
				<td><input type="text" class="widefat" name="application_method" value="<?php echo $application_method; ?>"></td>
			</tr>
			<tr>
				<td>Additional Images</td>
				<td>
					<ul class="bci-gallery">
					<?php
						$image_ids = ( $image_ids = get_post_meta( $post->ID, 'gallery_data', true ) ) ? $image_ids : array();					
						foreach( $image_ids as $i => &$id ) {
							$url = wp_get_attachment_image_url( $id, array( 80, 80 ) );
							if( $url ) {
								?>
								<li data-id="<?php echo $id ?>" style="float:left">
									<img src="<?php echo $url ?>" style="max-width:100px">
									<a href="#" class="bci-gallery-remove">&times;</a>
								</li>
								<?php
							} else {
								unset( $image_ids[ $i ] );
							}
						}
					?>
					</ul>
					<div class="clear"></div>
					<input type="hidden" id="gallery_data" name="gallery_data" value="<?php echo join( ',', $image_ids ) ?>" />
					<a href="#" class="button bci-upload-button">Add Images</a>
				</td>
			</tr>
		</table>
		<?php
	}

	function constructions_save_postdata( $post_id, $post_object ){
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )return;

		if ( 'revision' == $post_object->post_type )return;

		if ( 'constructions' != $_POST['post_type'] )return;

		if ( $_POST['gallery_data'] ){
			$gallery_data = explode(',',$_POST['gallery_data']);
			if(!update_post_meta( $post_id, 'gallery_data', $gallery_data ))add_post_meta( $post_id, 'gallery_data', $gallery_data );	
		}
		else{
			delete_post_meta( $post_id, 'gallery_data' );
		}

		if(!update_post_meta( $post_id, 'price', $_POST['price'] ))add_post_meta( $post_id, 'price', $_POST['price'] );
		if(!update_post_meta( $post_id, 'size', $_POST['size'] ))add_post_meta( $post_id, 'size', $_POST['size'] );
		if(!update_post_meta( $post_id, 'color', $_POST['color'] ))add_post_meta( $post_id, 'color', $_POST['color'] );
		if(!update_post_meta( $post_id, 'material', $_POST['material'] ))add_post_meta( $post_id, 'material', $_POST['material'] );
		if(!update_post_meta( $post_id, 'dimension', $_POST['dimension'] ))add_post_meta( $post_id, 'dimension', $_POST['dimension'] );
		if(!update_post_meta( $post_id, 'application_method', $_POST['application_method'] ))add_post_meta( $post_id, 'application_method', $_POST['application_method'] );
	}

	function set_custom_edit_constructions_columns($columns) {
		unset( $columns['date'] );
		$columns['image'] 		= __( 'Image' );
		$columns['price'] 		= __( 'Price (IDR)' );
		$columns['category'] 	= __( 'Category' );
		return $columns;
	}

	function custom_constructions_column( $column, $post_id ) {
		switch ( $column ) {
			case 'image' :
				$post_thumbnail = get_the_post_thumbnail_url( $post_id );
				if($post_thumbnail){
					echo "<img src='$post_thumbnail' style='max-width:100px'>";
				}
			break;
			case 'category' :
				$terms = get_the_terms($post_id, 'categories' );
				if ($terms && ! is_wp_error($terms)) :
					$tslugs_arr = array();
					foreach ($terms as $term) {
						$tname_arr[] = $term->name;
					}
					$terms_name_str = join( ", ", $tname_arr);
				endif;
				echo $terms_name_str;
			break;
			case 'price' :
				echo number_format(intval(get_post_meta( $post_id , 'price' , true )));
			break;
		}
	}

	function widget_register(){
		$including_files = true;
		foreach (glob(__DIR__.'/src/widgets/*.php') as $file){

			$result = include($file);
			if ($result === false)continue;

			$class_name = 'bciwidgets_'.basename($file, '.php');
			$this->widgets[] = $class_name;

			register_widget($class_name);
		}
	}

	function parse_shortcode($attributes, $content = null){
        extract(shortcode_atts(array(
             'template' => '',
             'category' => ''
          ), $attributes));

        $shortcode_string = "";
		if(empty($template))return;
		
        ob_start();
		$themes_template = get_template_directory() . "/resources/pages/".$template.".php";
		if(file_exists($themes_template))require_once($themes_template);
		else require_once(dirname(__FILE__)."/resources/pages/".$template.".php");
		$shortcode_string=ob_get_clean();
		
		$shortcode_string = apply_filters("bci_shortcode", $shortcode_string, $attributes, $content);

        return $shortcode_string;
    }

	function get_cart(){
		if(isset($_COOKIE['bci_cart'])){
			return ($_COOKIE['bci_cart'])?unserialize($_COOKIE['bci_cart']):array();
		}
		else return array();
	}

	function add_to_cart(){		
		header('Content-Type: application/json');

		if (empty($_REQUEST['id'])){
			echo '-1';
			wp_die();
		}

		$cart = $this->get_cart();
		$id = $_REQUEST['id'];
		if(isset($cart[$id]))$cart[$id] += 1;
		else $cart[$id] = 1;
		setcookie("bci_cart" , serialize($cart), time()+(60*60*24*42), COOKIEPATH, COOKIE_DOMAIN,0);
		
		echo 1;
	}

	function remove_from_cart(){
		header('Content-Type: application/json');

		if (empty($_REQUEST['id'])){
			echo '-1';
			wp_die();
		}

		$cart = $this->get_cart();
		$id = $_REQUEST['id'];
		if(isset($_REQUEST['delete_all']))unset($cart[$id]);
		else if($cart[$id] > 1)$cart[$id] -= 1;
		else unset($cart[$id]);
		setcookie("bci_cart" , serialize($cart), time()+(60*60*24*42), COOKIEPATH, COOKIE_DOMAIN,0);
		
		echo 1;
	}

	function calculate_cart($cart){
		if($cart){
			$total_price = 0;
			foreach($cart as $id=>$number){
				$item = get_post($id);
				$price = get_post_meta($id, 'price', true);
				$total_price += $number * $price;
			}
			echo number_format($total_price);
		}
		else echo -1;
	}

	function load_product(){
		header('Content-Type: application/json');		
		if (empty($_REQUEST['page'])){
			echo '-1';
			wp_die();
		}

		$args  = [
			'post_type'      => 'constructions',
			'posts_per_page' => 20,
			'paged'          => $_REQUEST['page']
		];
		if($_REQUEST['category']){
			$args['tax_query'] =  array(
				array (
					'taxonomy' => $_REQUEST['category'],
					'field' => 'slug',
					'terms' => $category,
				)
			);
		}
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			ob_start();
			require('resources/pages/product_item.php');
			$html = ob_get_clean();
			wp_send_json(['html' => $html]);
		}
	}
	
} //endsclass

$bci = bci::getInstance();
?>