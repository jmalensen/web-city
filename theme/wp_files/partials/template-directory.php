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
                                     
<article class="directory__item <?php if(isset($anim_class)){ echo $anim_class; } ?>">
                    
    <div class="content">

        <h2 class="content__title"><?php the_field('directory_name'); ?></h2>
        <p class="content__contact"><?php the_field('directory_contact_name'); ?></p>

        <?php if(get_field('directory_description')): ?>
        <div class="content__description">

            <?php the_field('directory_description'); ?>

        </div>
        <?php endif; ?>

    </div>

    <div class="info">

        <ul>

            <?php if(get_field('directory_open_time')): ?>
                <li><span>&gt; <?php _e('Horaires : ','@@themeName'); ?></span> <?php the_field('directory_open_time'); ?></li>
            <?php endif; ?>

            <?php if(get_field('directory_phone')): ?>
                <li><span>&gt; <?php _e('Tél : ','@@themeName'); ?></span> <?php the_field('directory_phone'); ?></li>
            <?php endif; ?>

            <?php if(get_field('directory_fax')): ?>
                <li><span>&gt; <?php _e('Fax : ','@@themeName'); ?></span> <?php the_field('directory_fax'); ?></li>
            <?php endif; ?>

            <?php if(get_field('directory_mail')): ?>
                <li><span>&gt; <?php _e('Mail : ','@@themeName'); ?></span> <?php the_field('directory_mail'); ?></li>
            <?php endif; ?>

            <?php if(get_field('directory_adress')): ?>
                <li><span>&gt; <?php _e('Adresse : ','@@themeName'); ?></span> <?php the_field('directory_adress'); ?></li>
            <?php endif; ?>

            <?php if(get_field('directory_website')): ?>
                <li><span>&gt; <?php _e('Site web : ','@@themeName'); ?></span> <a href="<?php the_field('directory_website'); ?>"><?php the_field('directory_website'); ?></a></li>
            <?php endif; ?>

        </ul>

    </div>

</article>