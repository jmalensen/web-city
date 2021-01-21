<?php

if(isset($i)){
    
    switch($i){
        case 0:
            $anim_class = 'first';
            break;
        case 1:
            $anim_class = 'second';
            break;
        case 2:
            $anim_class = 'third';
            break;
        case 3:
            $anim_class = 'fourth';
            break;
        default:
            $anim_class = 'first';
    }
    
}

?>

<a href="<?php the_permalink(); ?>" class="event__item event__item--horizontal <?php if(isset($anim_class)){ echo $anim_class; } ?>">
                    
    <?php 

        if(get_field('event_list_img')){
            $image = get_field('event_list_img');
        } else{
            $image = get_field('option_img_default_event', 'option');
        }

        if( !empty($image) ):

            // thumbnail
            $size = 'event_list';
            $thumb_desktop = $image['sizes'][ $size ];

            $alt = $image['alt'];

    ?>
    <div class="visualTime">
        <div class="visual">

            <img src="<?php echo $thumb_desktop; ?>" alt="<?php echo $alt; ?>">

            <div class="visual__over"></div>

        </div>

        <time class="<?php if(get_field('event_end_date')){ echo 'double'; } ?>">
            <span><?php echo str_replace(' ', '<small>', get_field('event_begin_date')) . '</small>';  ?></span>
            <?php if(get_field('event_end_date')): ?>
                <span><?php echo str_replace(' ', '<small>', get_field('event_end_date')) . '</small>';  ?></span>
            <?php endif; ?>
        </time>

    </div>
    <?php endif; ?>

    <div class="content">

        <h2><?php the_title(); ?></h2>

        <p class="place"><?php the_field('event_place'); ?></p>

        <?php if(get_field('event_time')): ?><p class="time"><?php the_field('event_time'); ?></p><?php endif; ?>

        <div class="cat">

            <?php foreach(get_the_category() as $cat): ?>
                <span><?php echo $cat->name; ?></span>
            <?php endforeach; ?>

        </div>

        <div class="plus"></div>

    </div>

</a>