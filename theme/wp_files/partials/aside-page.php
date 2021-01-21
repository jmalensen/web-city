<?php

$ancestors = get_post_ancestors( $post->ID );
$page_parent = end( $ancestors ) ? end( $ancestors ) : get_the_ID();

$args_subpages = array(
	'post_parent' => $page_parent,
	'post_type'   => 'page', 
	'numberposts' => -1,
	'post_status' => 'publish',
    'order' => 'ASC'
);

$subpages = get_children( $args_subpages );

?>
<aside class="aside-page items<?php if(!$subpages) echo ' hidden-xs hidden-sm'; ?>">
	<p class="aside-page__title ancestor">
        <?php echo get_the_title($page_parent); ?>
        <span class="arrow">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </span>
    </p>
    
	<div class="aside-page__list-pages">
        <?php // SUBPAGE LVL 1?>
        <?php if($subpages) : ?>
            <ul>
            <?php foreach ( $subpages as $subpage ) : ?>
                
                <?php
                    $args_subpages_element = array(
                        'post_parent' => $subpage->ID,
                        'post_type'   => 'page', 
                        'numberposts' => -1,
                        'post_status' => 'publish',
                        'order' => 'ASC'
                    );

                    $elementSubpages = get_children( $args_subpages_element );
                ?>
                
                <li class="onepage">
                    
                    <?php if($subpage->ID != get_the_ID() && !in_array($subpage->ID, $ancestors)) : ?>
                    <a href="<?php echo get_the_permalink( $subpage->ID ); ?>" class="onepage__link">
                    <?php else : ?>
                        <span class="onepage__link current">
                    <?php endif; ?>

                        <span class="onepage__link__innerText">
                        <?php echo $subpage->post_title; ?>
                        </span>
                            
                        <?php if($elementSubpages): ?>
                        <span class="arrow">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </span>
                        <?php endif; ?>
                            
                    <?php if($subpage->ID != get_the_ID() && !in_array($subpage->ID, $ancestors)) : ?>
                    </a>
                    <?php else : ?>
                        </span>
                    <?php endif; ?>
                    
                    
                    <?php // SUBPAGE LVL 2?>
                    <?php if($elementSubpages) : ?>
                        <ul class="submenuaside">
                            <?php foreach ( $elementSubpages as $elementSubpage ) : ?>

                            <li class="onesubpage">
                                <?php if($elementSubpage->ID != get_the_ID()) : ?>
                                <a href="<?php echo get_the_permalink( $elementSubpage->ID ); ?>" class="onesubpage__link">
                                <?php else : ?>
                                    <span class="onesubpage__link current">
                                <?php endif; ?>

                                    <?php echo $elementSubpage->post_title; ?>

                                <?php if($elementSubpage->ID != get_the_ID()) : ?>
                                </a>
                                <?php else : ?>
                                    </span>
                                <?php endif; ?>
                            </li>

                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
                
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
	</div>

</aside>