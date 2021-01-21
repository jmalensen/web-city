    <?php //------------PAGE TITLE-----------------------?>
    <div class="content-type">
        <?php
        if(get_the_ID() != '147'):
        ?>

            <?php
                $postTypeDetail = get_post_type();
                if($postTypeDetail != 'evenement' && $postTypeDetail != 'post'):
                ?>
                    <?php
                        if ( function_exists('yoast_breadcrumb') ) {
                             yoast_breadcrumb('<p class="breadcrumbs desktop">','</p>');
                        }
                    ?>
            <?php endif;?>

            <?php if(get_field('content_excerpt')) : ?>
                <div class="content-type__intro">
                    <?php the_field('content_excerpt'); ?>
                </div>
            <?php endif; ?>

            <?php //------------PAGE CONTENT-----------------------?>
            <?php if( have_rows('content_block') ): ?>
                <?php while ( have_rows('content_block') ) : the_row(); ?>
                    <?php //------------BLOCK CONTENT STANDARD-----------------------?>
                    <?php if( get_row_layout() == 'content_block_standard' ): ?>
                        <?php include( get_template_directory() . '/partials/standard-content-block.php'); ?>
                    <?php endif; ?>
                    <?php //------------END BLOCK CONTENT STANDARD-----------------------?>
                <?php endwhile; ?>
            <?php endif; ?>

        <?php else:?>
            <?php
                if ( function_exists('yoast_breadcrumb') ) {
                     yoast_breadcrumb('<p class="breadcrumbs desktop">','</p>');
                }
            ?>

            <h1 class="desktop"><?php the_title(); ?></h1>
            <div>
                <?php the_content();?>
            </div>
        <?php endif;?>
    </div>
    <?php //------------END PAGE CONTENT-----------------------?>
