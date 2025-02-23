<?php get_header(); ?>

<?php 
$logo = get_option('logo');
$blogname = get_option('blogname');

if(has_post_thumbnail($post->ID)) {
	$title_image = get_the_post_thumbnail_url($post->ID, 'full');
} else {
	$title_image = get_template_directory_uri() . '/assets/images/title_image.jpg';
}
?>

<div id="page-title" class="padding-top-40 padding-bottom-50">
	<h1 class="title font-serif font-size-40 font-weight-300 aligncenter">
		<?php $post = $posts[0]; ?>
        <?php if (is_category()) { ?>
            Kategori: <?php single_cat_title(); ?>
        <?php } elseif( is_tag() ) { ?>
            Tag: &#8216;<?php single_tag_title(); ?>&#8217;
        <?php } elseif (is_day()) { ?>
            Arsip: <?php the_time('F jS, Y'); ?>
        <?php } elseif (is_month()) { ?>
            Arsip: <?php the_time('F, Y'); ?>
        <?php } elseif (is_year()) { ?>
            Arsip: <?php the_time('Y'); ?>
        <?php } elseif (is_author()) { ?>
            Arsip: Author
        <?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
            Arsip: Blog
        <?php } else { ?>
            Artikel
        <?php } ?>
    </h1>
</div>

<article id="entry" class="group hasfloat padding-bottom-60" itemscope itemtype="http://schema.org/NewsArticle">

    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
    
    <div id="posts">
    
		<?php if (have_posts()): while (have_posts()): the_post(); $permalink = get_permalink($post->ID); ?>
        
            <div class="post">
    
                <div class="grid-25-75 thick">
                
                    <div class="column image" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <a class="centerimage back-light-grey-6" href="<?php echo $permalink; ?>" title="<?php echo $post->post_title; ?>">
                            <?php 
							$post_thumbnail = get_the_post_thumbnail_url($post->ID,'medium_large');
							if(!$post_thumbnail){
                                if(preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)) $post_thumbnail = $matches[1][0];
                            }
							if($post_thumbnail) { ?>
                            	<img class="fit-height" src="<?php echo $post_thumbnail; ?>" alt="<?php the_title(); ?>" />
							<?php } else { ?>
                            	<span class="placeholder color-light-grey-4"><i class="icon fa fa-camera-retro"></i></span>
                            <?php } ?>
                        </a>
                        <meta itemprop="url" content="<?php echo $first_img; ?>">
                        <meta itemprop="width" content="300">
                        <meta itemprop="height" content="200">
                    </div>
            
                    <div class="column overview">
                        
                        <h3 class="post-title" itemprop="headline">
							<a class="color-default color-first-hover" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <div class="post-excerpt margin-top-15 margin-bottom-15" itemprop="description">
                            <?php echo $degivirealty->limitwords(strip_tags($post->post_content), 60); ?>
                            <a class="url" href="<?php the_permalink(); ?>" title="Lebih lanjut">[Lebih lanjut]</a>
                        </div>
                        
                        <div class="post-meta font-size-14">
                            <span class="item date display-inline-block margin-right-10"><i class="icon fa fa-calendar-o"></i> <?php the_time('j M Y'); ?></span>
                            <span class="item author display-inline-block margin-right-10"><i class="icon fa fa-user-o"></i> <?php the_author_posts_link(); ?></span>
                            <span class="item category display-inline-block margin-right-10"><i class="icon fa fa-folder-open-o"></i> <?php the_category(', ') ?> </span>
                            <span class="item comment display-inline-block"><i class="icon fa fa-comments-o"></i> <?php comments_popup_link('0 comment', '1 comment', '% comments'); ?></span>
                        </div>
                        
                        <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                            	<meta itemprop="url" content="<?php echo $logo; ?>">
                                <meta itemprop="width" content="212">
                                <meta itemprop="height" content="44">
                            </div>
                            <meta itemprop="name" content="<?php echo $blogname; ?>">
                        </div>
                
                        <div itemprop="author" itemscope itemtype="https://schema.org/Person">
                        	<meta itemprop="name" content="Admin">
                         </div>
                
                        <meta itemprop="datePublished" content="<?php echo $post->post_date; ?>"/>
                        <meta itemprop="dateModified" content="<?php echo $post->post_date; ?>"/>

                    </div>

                </div>
            
            </div>
        
        <?php endwhile; endif; ?>
    
    </div>

</article>

<?php get_footer(); ?>