<?php
/**
 * Page
 *
 * @package YYThemes
 */

get_header();

if ( !yy_import( 'archive' ) ) {?>
<div class="yy-main">
    <div class="yy-group">
        <div class="container">
        	<div class="row">
        		<div class="col-md-12">
        		    <div class="post">
        		        <h1 class="post-title"><a href="<?php the_permalink(); ?>"
            				title="<?php the_title(); ?>"><?php the_title(); ?></a>
            			</h1>
            			<div class="post-content"><?php the_content(); ?></div>
        		    </div>
    				<?php comments_template(); ?>
        		</div>
        	</div><!-- row -->
        </div>
    </div><!-- yy-group -->
</div><!-- yy-main -->
	<?php
}

get_footer();
