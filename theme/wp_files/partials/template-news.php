<a href="<?php the_permalink(); ?>" class="news__item">
                               
    <?php 
        if(get_field('news_list_img')){
            $image = get_field('news_list_img');
        }
        else{
            $image = get_field('option_img_default_news', 'option');
        }

        if( !empty($image) ):

            // thumbnail
            $size = 'quick_access_mobile';
            $thumb_mobile = $image['sizes'][ $size ];
            $size = 'quick_access_tall';
            $thumb_desktop = $image['sizes'][ $size ];

            $alt = $image['alt'];

    ?>
    <div class="imgDate">

        <picture>
            <source media="(max-width: 767px)" srcset="<?php echo $thumb_mobile; ?>">
            <source media="(min-width: 768px)" srcset="<?php echo $thumb_desktop; ?>">
            <img src="<?php echo $thumb_desktop; ?>" alt="<?php echo $alt; ?>" />
        </picture>

        <div class="cat">
            <?php
                $i = 0;
                foreach(get_the_category() as $catNews):
                    if($i < 2):
                        $catNews_url = add_query_arg('cat', $catNews->slug, $page_url);
            ?>

                <p class="cat__item"><?php echo $catNews->name; ?></p>

            <?php 
                    endif;
                    $i++;
                endforeach;
            ?>
        </div>

        <div class="imgDate__over"></div>
    </div>
    <?php endif; ?>

    <div class="content">

        <h3><?php the_title(); ?></h3>

        <?php $description = get_field('news_list_description');?>
        <p><?php echo $description;?></p>
        <div class="plus"></div>
    </div>
</a>