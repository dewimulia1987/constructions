<div class="shopping-cart">
	<?php 
	$cart = $this->get_cart();
		if(!$cart){ ?>
		<p class="error text-center color-red font-weight-500"><em>Your cart is empty</em></p>
	<?php } 
	else{
		$total_price = 0;
		foreach($cart as $id=>$number){
			$item = get_post($id);
			$price = get_post_meta($id, 'price', true);
			$total_price += $number * $price;
			?>
			<div class="item" data-price="<?php echo $price; ?>" data-qty="<?php echo $number; ?>">
				<div class="buttons">
				  <a class="delete-btn" data-id="<?php echo $id; ?>"></a>
				</div>

				<div class="image">
					<a href="<?php echo get_permalink($id); ?>">
					<?php 
					if (has_post_thumbnail( $id ) ){ 
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' ); ?>
						<img src="<?php echo $image[0]; ?>" alt="<?php echo $item->post_title; ?>" />
					<?php } else { ?>
						<span class="placeholder color-light-grey-4"><i class="icon fa fa-camera-retro"></i></span>
					<?php } ?>
					</a>
				</div>

				<div class="description">
				  <span><?php echo $item->post_title; ?></span>
				</div>

				<div class="quantity">
				  <button class="plus-btn" type="button" name="button" data-id="<?php echo $id; ?>">
					<img src="<?php echo get_template_directory_uri().'/assets/images/plus.svg'; ?>"  />
				  </button>
				  <input type="text" class="qty" value="<?php echo $number; ?>">
				  <button class="minus-btn"  data-id="<?php echo $id; ?>" type="button" name="button" data-id="<?php echo $id; ?>">
					<img src="<?php echo get_template_directory_uri().'/assets/images/minus.svg'; ?>" />
				  </button>
				</div>

				<div class="price">Rp <?php echo number_format($price); ?></div>
			</div>
		<?php } ?>		
		<div class="item font-weight-500 padding-top-10">Total Price: Rp&nbsp;<span id="total-price"><?php echo number_format($total_price); ?></span></div>
	<?php } ?>
</div>