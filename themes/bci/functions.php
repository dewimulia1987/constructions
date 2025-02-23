<?php
add_action(
    'after_setup_theme',
    function () {
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        );
        add_theme_support(
            'custom-logo',
            [
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            ]
        );
        register_nav_menus([
            'primary'   => esc_html__('Primary Menu', 'bci'),
        ]);
    }
);

add_action( 'wp_enqueue_scripts', 'theme_styles', 0 );
add_action( 'wp_enqueue_scripts', 'theme_scripts', 1 );
add_action( 'widgets_init', 'widget_sidebars' );
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpt_length( $length ) {
	return 8;
}


//CSS files
function theme_styles() {	
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css', array(), '1.00' );
	wp_enqueue_style( 'settings-style', get_template_directory_uri().'/assets/css/settings.css', array(), '1.00' );
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Libre+Baskerville:400,700', array(), null );
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), null );
	wp_enqueue_style( 'themify-icons', get_template_directory_uri().'/assets/fonts/themify-icons/themify-icons.css', array(), null );
	wp_enqueue_style( 'animate-css', get_template_directory_uri().'/assets/css/animate.css' );
	if(is_single() || is_front_page())wp_enqueue_style( 'owl-carousel-style', get_template_directory_uri() . '/assets/css/owl.carousel.css', array(), null );
	if(is_single()){
		wp_enqueue_style('magnific-style', get_template_directory_uri().'/assets/css/magnific-popup.css', array(), null );
	}
}

//JS files
function theme_scripts() {
	if (!is_admin()) wp_deregister_script( 'l10n' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.00.18', true );
	wp_enqueue_script( 'wow-js', get_template_directory_uri() . '/assets/js/wow.min.js');
	if(is_single() || is_front_page())wp_enqueue_script( 'owl-carousel-scripts', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, true );
	if(is_single()){
		wp_enqueue_script( 'magnific-scripts', get_template_directory_uri().'/assets/js/jquery.magnific-popup.min.js', array(), null, true );
	}
}

//Widget areas
function widget_sidebars() {
	register_sidebar( array(
		'name' => 'Home',
		'id' => 'products',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="section-title">',
		'after_title' => '</h3>'
	) );
	register_sidebar( array(
		'name' => 'Header',
		'id' => 'news',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="section-title">',
		'after_title' => '</h3>'
	) );
}

//Body id
function body_css_id() {
	global $post, $wpdb;
	if (is_404()) { echo "fourOfour"; }
	elseif ( is_front_page() ) { echo "home"; }
	elseif ( is_home() || is_category() || is_archive() || is_search() || is_single() || is_date() ) { echo "blog"; }
	elseif (is_page()) {
		$parent_name = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = '$post->post_parent;'");
		echo $post->post_name;
	} else { echo 'notes'; }
}

//#page class
function page_class() {
	global $post, $ddrealty;
	$pagetype = 'page-'.$post->post_name;
	if(is_front_page())
		$pagetype .= ' homepage';
	elseif(is_home() || is_category()|| is_archive() || is_search() || is_author() || is_page_template('template_blog.php'))
		$pagetype.=' post-page post-index';
	elseif(is_single())
		$pagetype.=' post-page post-single default';
	else
		$pagetype .= ' default';
	echo $pagetype;
}
