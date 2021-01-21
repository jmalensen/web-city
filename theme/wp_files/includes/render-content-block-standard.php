<?php
function render_block_image($image) {
	if(!$image)
		return false;
	?>

	<picture class="content-type__image">
        <source 
            srcset="<?php echo $image['sizes']['content_full_mobile']; ?> 1x, <?php echo $image['sizes']['content_full_mobile_retina']; ?> 2x"
            media="(max-width: 768px)">
        <source 
            srcset="<?php echo $image['sizes']['content_half_tablet']; ?>"
            media="(max-width: 992px)">
        <img src="<?php echo $image['sizes']['content_half_desktop']; ?>" alt="<?php echo $image['alt']; ?>">
	</picture>

	<?php
}

function render_button($external = false, $label, $link) {
	if(!$label || !$link)
		return
	?>
	<div class="content-type__button">
		<a href="<?php echo $link; ?>" <?php if($external) echo "target='_blank'"; ?>>
            <?php echo $label; ?>
		</a>
	</div>
	<?php
}