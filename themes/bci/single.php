<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()): the_post(); 

	if(has_post_thumbnail($post->ID)) {
		$title_image = get_the_post_thumbnail_url($post->ID, 'full');
	} else {
		$title_image = get_template_directory_uri() . '/assets/images/title_image.jpg';
	} ?>
	
    <div id="page-title" class="padding-top-60 padding-bottom-50">
        <div class="group">
            <h1 class="title font-serif font-size-40 font-weight-300 aligncenter">
                <?php the_title(); ?>
            </h1>
        </div>
    </div>
    
    <article id="entry" class="group padding-bottom-60">
    	<div id="post">
			<?php if($post->post_type == 'constructions'){ ?>
				<?php get_template_part('templates/product_detail'); ?>
			<?php } else { ?>
			<div class="post-content hasfloat padding-right-60">
				<?php the_content(); ?>
			</div>
			<div class="post-meta font-size-14">
				<span class="item date display-inline-block margin-right-10"><i class="icon fa fa-calendar-o"></i> <?php the_time('j M Y'); ?></span>
				<span class="item author display-inline-block margin-right-10"><i class="icon fa fa-user-o"></i> <?php the_author_posts_link(); ?></span>
				<span class="item category display-inline-block margin-right-10"><i class="icon fa fa-folder-open-o"></i> <?php the_category(', ') ?> </span>
			</div>
			<?php } ?>
        </div>
    </article>
    
<?php endwhile; endif; ?>

<?php get_footer(); ?>