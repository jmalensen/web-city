<footer class="mainFooter">
    
    <div class="mainFooter__primary">

        <div class="container">

            <div class="row">

                <div class="logo col-md-3 col-sm-6 hidden-xs">
                    
                    <img src="<?php the_field('option_footer_logo', 'option'); ?>" alt="<?php _e('Logo ville de Bruz', '@@themeName'); ?>">
                    
                </div>
                
                <div class="contact col-md-3 col-sm-6 col-xs-12">
                    
                    <h2><?php the_field('option_footer_contact_title', 'option'); ?></h2>
                    
                    <?php the_field('option_footer_contact_info', 'option'); ?>
                    
                    <?php if(have_rows('option_footer_social', 'option')): ?>
                    <div class="contact__social">
                        <?php while(have_rows('option_footer_social', 'option')): the_row(); 

                            $social_icon = get_sub_field('option_footer_social_icon', 'option');
                            if($social_icon):
                        ?>

                            <a href="<?php the_sub_field('option_footer_social_link', 'option'); ?>" target="_blank" title="<?php echo $social_icon['alt']; ?>">
                                <?php echo file_get_contents($social_icon['url']); ?>
                            </a>

                        <?php endif; endwhile;?>
                    </div>
                    <?php endif; ?>
                    
                    
                </div>
                
                <div class="horaire col-md-4 col-sm-6 col-xs-12">
                    
                    <h3><?php the_field('option_footer_horaire_title', 'option'); ?></h3>
                    
                    <?php the_field('option_footer_horaire_info', 'option'); ?>
                    
                </div>
                
                <div class="nav-footer col-md-2 col-sm-6 col-xs-12">
                    
                    <?php
                        wp_nav_menu( array(
                            'theme_location'    => 'footer-main-nav',
                            'depth'             => 1,
                            'menu_class'        => '',
                            'container' 		=> '',
                        ));
                    ?>
                    
                </div>

            </div>

        </div>
	
	</div>
	
    <div class="mainFooter__secondary">
        
        <?php
            wp_nav_menu( array(
                'theme_location'    => 'footer-secondary-nav',
                'depth'             => 1,
                'menu_class'        => '',
                'container' 		=> '',
            ));
        ?>
        
    </div>
	
</footer>