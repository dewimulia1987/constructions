<?php
$price = get_post_meta($post->ID, 'price', true);
$size = get_post_meta($post->ID, 'size', true);
$color = get_post_meta($post->ID, 'color', true);
$material = get_post_meta($post->ID, 'material', true);
$dimension = get_post_meta($post->ID, 'dimension', true);
$application_method = get_post_meta($post->ID, 'application_method', true);
$image_ids = ( $image_ids = get_post_meta( $post->ID, 'gallery_data', true ) ) ? $image_ids : array();

$details = array('Price' => $price, 'Size' => $size, 'Color' => $color, 'Material' => $material, 'Dimension' => $dimension, 'Application Method' => $application_method);

$photos = [];
$photo_urls = '';
if (has_post_thumbnail( $post->ID ) ){ 
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	$photos[] = $image[0];
	$photo_urls = $image[0].',';
}
foreach( $image_ids as $i => $id ) {
	$url = wp_get_attachment_image_url( $id );
	if( $url ){
		$photos[] = $url;
		$photo_urls .= $url.',';
	}
}
?>
<div class="grid-2">
	<div class="column">
		<div id="post-image">
			<div class="owl-carousel owl-slideshow mfp-gallery">
				<?php 
				if($photos){ 
					foreach( $photos as $url ) {?>
						<div class="image">
							<a class="centerimage" href="<?php echo $url ?>">
								<img class="fit-height" src="<?php echo $url ?>" alt="<?php echo $post->post_title ?>" />
							</a>
						</div>
						<?php 	
					}
				} ?>
			</div>
			<input type="hidden" id="photo_url" value="<?php echo $photo_urls; ?>">
		</div>
	</div>
	<div class="column">
		<div class="post-content">
			<?php the_content(); ?>
			<div id="specifications">
				<?php 
				foreach($details as $label => $value){ 
					if($value){ ?>
						<p class="item hasfloat padding-top-5 padding-bottom-5">
							<span class="field left font-weight-400"><?php echo $label; ?></span>
							<span class="value right"><?php echo ($label=='Price')?'Rp '.number_format($value):$value; ?></span>
						</p>
				<?php }
				} ?>
			</div>
			<div class="add-to-cart text-center">
				<a href="javascript:void(0)" id="add-to-cart-btn" class="button" data-id="<?php echo $post->ID; ?>">Add to Cart</a>
			</div>
			<div class="color-red padding-top-10 success_message text-center"></div>
		</div>
	</div>
</div>