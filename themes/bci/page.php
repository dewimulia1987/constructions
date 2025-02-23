<?php 
get_header();

if (is_front_page()) { 
	get_template_part('templates/homepage');
} 
else { 
	if (have_posts()): 
		while (have_posts()): the_post();
		
		$entry_class = 'group';
		if(get_post_meta($post->ID, 'enable_compact_container',true)) $entry_class .= ' compact';
		if(get_post_meta($post->ID, 'enable_narrow_container',true)) $entry_class .= ' narrow';
		if(get_post_meta($post->ID, 'disable_container',true) ) $entry_class .= ' full';
		
		if(has_post_thumbnail($post->ID)) {
			$title_image = get_the_post_thumbnail_url($post->ID, 'full');
		} else {
			$title_image = get_option('title_image');
		}	?>		
		<article id="entry" class="<?php echo $entry_class; ?> hasfloat  padding-top-100 padding-bottom-60">
			<h1 class="title font-serif font-size-40 font-weight-300 aligncenter">
				<?php the_title(); ?>
			</h1>
			<?php the_content(); ?>
		</article>
	<?php endwhile; 
	endif;
} 
get_footer(); ?>