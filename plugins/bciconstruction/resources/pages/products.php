<?php
$args  = [
	'post_type'      => 'constructions',
	'posts_per_page' => 20,
	'paged'          => 1
];
if($category){
	$args['tax_query'] =  array(
        array (
            'taxonomy' => 'categories',
            'field' => 'slug',
            'terms' => $category,
        )
	);
}

$query = new WP_Query($args);

if ($query->have_posts()) { ?>

	<div id="product_list" class="grid-4 thumbview" data-column="4">
		<?php require('product_item.php'); ?>
	</div>

<?php
	if($query->max_num_pages > 1){ ?>
		<div class="load-more text-center"><a href="javascript:void(0)" class="button" id="load-more-product" data-max="<?php echo $query->max_num_pages; ?>" data-category="<?php echo $category; ?>" data-page="1">Load More</a></div>
	<?php }
} ?>