<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Search form template
*			   @@themeDescription
*/
?>

<form class="search-form" role="search" method="get" action="<?php bloginfo('url');?>">
    <div class="closeBtn">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </div>
    <div class="containS">
        <input type="text" name="s" placeholder="<?php _e('Rechercher', '@@themeName');?>"/>
        <span class="submitBtn"><?php _e('OK', '@@themeName');?></span>
    </div>
</form>