<?php if(have_comments()) { ?>
    <div class="comments">
    	<h3 class="comments-title"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>
        <ul><?php wp_list_comments(array('avatar_size'=>64)); ?></ul>
    </div>
<?php } ?>
<?php comment_form(); ?>