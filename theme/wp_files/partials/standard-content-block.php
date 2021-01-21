<div class="content-type__row">

    <?php //------------TITLE-----------------------?>
    <div class="content-type__subtitle">
        <h2><?php the_title(); ?></h2>
    </div>
    
    <?php if(get_sub_field('content_block_standard_intro')) : ?>
    <div class="content-type__intro">
        <?php the_sub_field('content_block_standard_intro'); ?>
    </div>
    <?php endif; ?>
    <?php if( have_rows('content_block_standard_content') ): ?>
        <?php while( have_rows('content_block_standard_content') ) : the_row(); ?>
            <div class="content-type__item">
                <?php if(get_row_layout() == 'content_block_standard_text') : ?>
                    <?php //------------TEXT-----------------------?>
                    <div class="content-type__text">
                        <?php the_sub_field('content_block_standard_text_wysiwyg'); ?>
                    </div>
                <?php elseif(get_row_layout() == 'content_block_standard_image') : ?>
                    <?php //------------IMAGE-----------------------?>
                    <?php
                        // VARIABLES
                        $image = get_sub_field('content_block_standard_image_file');

                        // RENDERING
                        render_block_image($image);
                    ?>
                <?php elseif(get_row_layout() == 'content_block_standard_button') : ?>
                    <?php //------------BUTTON-----------------------?>
                    <?php
                    // VARIABLES
                    $type_external = get_sub_field('content_block_standard_button_type') === 'extern' ? true : false;
                    $label = get_sub_field('content_block_standard_button_label');
                    if($type_external) {
                        $link = get_sub_field('content_block_standard_button_external_link');
                    } else {
                        $link = get_sub_field('content_block_standard_button_internal_link');
                    }

                    // RENDERING
                    render_button($type_external, $label, $link);
                    ?>
                <?php elseif(get_row_layout() == 'content_block_standard_youtube'):?>
                    <?php //------------YOUTUBE-----------------------?>
                
                    <?php
                        $video_id = get_sub_field('content_block_standard_youtube_id');
                        $url = 'https://www.youtube.com/embed/' . $video_id . '?&rel=0';
                    ?>
                    <div class="content-type__video">
                        <iframe src="<?php echo  $url; ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php elseif(get_row_layout() == 'content_block_standard_note'):?>
                    <?php //------------NOTE-----------------------?>
                
                    <?php
                        $title = get_sub_field('content_block_standard_note_title');
                        $content = get_sub_field('content_block_standard_note_content');
                    ?>
                    <div class="content-type__note">
                        <h2><?php echo $title;?></h2>
                        <div class="content-type__note__content">
                            <?php echo $content;?>
                        </div>
                    </div>
                <?php elseif(get_row_layout() == 'content_block_standard_download'):?>
                    <?php //------------DOWNLOAD-----------------------?>
                
                    <?php $title = get_sub_field('content_block_standard_download_title'); ?>
                    <div class="content-type__download">
                        <h2><?php echo $title;?></h2>
                        <div class="contain-file">
                    <?php
                        if( have_rows('content_block_standard_download_repeater') ):
                            while ( have_rows('content_block_standard_download_repeater') ) : the_row();
                                $file = get_sub_field('content_block_standard_download_file');
                    ?>
                
                            <div class="content-type__download__file">
                                <a href="<?php echo $file['url'];?>" title="<?php echo $file['name'];?>" target="_blank"><div class="icon-download"></div></a>
                                <a href="<?php echo $file['url'];?>" title="<?php echo $file['name'];?>" target="_blank" class="legend"><?php echo $file['title'];?></a>
                            </div>
                
                    <?php
                            endwhile;
                        endif;
                    ?>
                        </div>
                    </div>
                <?php elseif(get_row_layout() == 'content_block_standard_directory'):?>
                    <?php //------------DIRECTORY-----------------------?>
                
                    <div class="content-type__directory">
                    <?php
                        if( have_rows('content_block_standard_directory_repeater') ):
                            while ( have_rows('content_block_standard_directory_repeater') ) : the_row();
                                $structure = get_sub_field('content_block_standard_directory_repeater_structure');
                                $post = $structure;
                                setup_postdata( $post ); 
                    ?>
                        
                        <article class="directory__item">
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
                
                    <?php
                                wp_reset_postdata();
                            endwhile;
                        endif;
                    ?>
                    </div>
                
                <?php elseif(get_row_layout() == 'content_block_standard_contact'):?>
                    <?php //------------CONTACT-----------------------?>
                
                    <div class="content-type__contact">
                        <?php $title = get_sub_field('content_block_standard_contact_title'); ?>
                        <h2><?php echo $title;?></h2>
                        <div class="contain-contact">
                    <?php
                        if( have_rows('content_block_standard_contact_repeater') ):
                            while ( have_rows('content_block_standard_contact_repeater') ) : the_row();
                                $picture = get_sub_field('content_block_standard_contact_photo');
                                $name = get_sub_field('content_block_standard_contact_name');
                                $fonction = get_sub_field('content_block_standard_contact_fonction');
                    ?>
                    
                            <div class="content-type__contact__one">
                                <picture>
                                    <img src="<?php echo $picture['url']; ?>" alt="<?php echo $picture['alt']; ?>" />
                                </picture>
                                <p class="name">
                                    <?php echo $name; ?>
                                </p>
                                <p class="fonction">
                                    <?php echo $fonction; ?>
                                </p>
                            </div>
                    <?php
                            endwhile;
                        endif;
                    ?>
                        </div> 
                    </div>
                
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
    
</div>