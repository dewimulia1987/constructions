<!DOCTYPE html>
<html class="no-js" lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> | <?php is_page('home') ? bloginfo('description') : wp_title(''); ?></title>
    <?php wp_head(); ?>
</head>

<body id="<?php body_css_id(); ?>" <?php body_class(); ?>>
    <div id="page" class="<?php page_class(); ?>">
        <main id="main">
            <header id="header" role="banner"<?php echo(is_front_page() ? ' class="front"' : ''); ?>>
				<div class="group hasfloat">
					<div class="logo left" itemscope itemtype="//schema.org/Organization">
						<?php 
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
						<a itemprop="url" class="valign" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
							<div class="holder full">
								<img class="display-block" itemprop="logo" src="<?php echo $logo[0] ?>" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" />
							</div>
						</a>
					</div>
					<div id="header-utilities" class="right">
						<div class="toggling left hidden">
							<div class="valign">
								<div class="holder full">
									<a class="toggle toggle-menu color-second" data-toggle="main-menu" href="javascript:void(0);" title="Open Main Menu">
										<span class="icon left ti-menu"></span>
									</a>
								</div>
							</div>
						</div>
						<div id="menu" class="left" role="navigation" data-toggle="main-menu">
							<div class="valign">
								<div class="holder full">
									<?php wp_nav_menu( array(
										'theme_location' => 'primary', 
										'container' => false, 
										'menu_class' => 'menu') 
									); ?>
									
								</div>
							</div>
						</div>
						<div class="cart-icon valign left">
							<div class="holder">
								<div class="position-relative cart-menu">
									<a href="<?php echo site_url('cart/'); ?>"><i class="icon ti-shopping-cart"></i></a>
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</header>								

            <div id="content">
