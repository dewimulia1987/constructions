<?php 
$count = 0;
while ($query->have_posts()) {
	$query->the_post();
	$post_id = get_the_ID();
	$price = get_post_meta($post_id, 'price', true);
	?>
		<div class="column item">
			<div class="container relative z-index-0 back-white">
				<div class="image">
					<a class="centerimage hover-zoom back-white" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php 
						if (has_post_thumbnail( $post_id ) ){ 
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' ); ?>
							<img class="fit-height" src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" />
						<?php } else { ?>
							<span class="placeholder color-light-grey-4"><i class="icon fa fa-camera-retro"></i></span>
						<?php } ?>
					</a>
				</div>
				<div class="overview padding-20">
					<h4 class="title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><strong><?php the_title(); ?></strong></a>
					</h4>
					<div class="details hasfloat padding-bottom-5 margin-top-10 margin-bottom-5 font-size-14">
						<div class="descriptions ellipsis"><?php the_excerpt(); ?>&nbsp;</div>
						<p><strong class="price"><?php echo 'Rp '. number_format($price); ?></strong></p>
					</div>
				</div>
			</div>
		</div>
<?php } ?>