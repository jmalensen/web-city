<?php 
    if( get_field('banner_img') || get_field('banner_video') ):
        
        $bg_slide = '';

        if(get_field('banner_type') != 'video'){
            $image = get_field('banner_img');
            // thumbnail
            $size = 'banner';
            $thumb = $image['sizes'][ $size ];

            $bg_slide = "background-image: url('" . $thumb . "');";
        }
        
?>
<section class="banner" style="<?php echo $bg_slide; ?>">
   
    <?php if(get_field('banner_type') == 'video'): ?>
        
        <video class="banner__video" autoplay playsinline loop preload="auto" muted>
            <source src="<?php the_field('banner_video'); ?>" type="video/mp4">
        </video>
        
    <?php endif; ?>
    
    <div class="container">
        
        <div class="banner__content">
        
            <?php if(is_singular('event') || is_singular('post')): ?>
            
                <div class="banner__category">
                    
                    <?php foreach(get_the_category() as $cat): ?>
                        <span class="banner__info"><?php echo $cat->name; ?></span>
                    <?php endforeach; ?>
                    
                </div>

            <?php else: ?>
	        
                <?php if(get_field('banner_info')){ ?> <p class="banner__info"> <?php the_field('banner_info'); ?> </p> <?php } ?>
                
            <?php endif; ?>

            <h1 class="banner__title">
                
                <?php if(get_field('banner_title_1') || get_field('banner_title_2')): ?>

                    <span><?php the_field('banner_title_1'); ?></span>
                    <br>
                    <?php if(get_field('banner_title_2')){ ?> <span><?php the_field('banner_title_2'); ?></span> <?php } ?>
                    
                <?php else: ?>
                
                    <span><?php the_title(); ?></span>
                
                <?php endif; ?>

            </h1>
            
            <?php if(is_singular('event')): ?>
            
                <div class="banner__event">
                   
                    <span class="banner__info"><?php the_field('event_place'); ?></span>
                    
                    <?php if(get_field('event_begin_date')): ?>
                        <span class="banner__info"><?php the_field('event_begin_date'); ?>
                        <?php if(get_field('event_end_date')): ?>
                            - <?php the_field('event_end_date'); ?>
                        <?php endif; ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if(get_field('event_time')): ?><span class="banner__info"><?php the_field('event_time'); ?></span><?php endif; ?>
                </div>
            
            <?php endif; ?>
                
            <?php if(is_singular('post')): ?>
            
                <div class="banner__news">
                   
                    <span class="banner__info"><?php the_date('d M'); ?></span>
                    
                </div>
            
            <?php endif; ?>
            
        </div>
            
    </div>
    
</section>
<?php endif; ?>