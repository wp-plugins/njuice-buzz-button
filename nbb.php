<?php
/*
Plugin Name: Njuice Buzz Button
Plugin URI: http://njuice.com/button/
Description: This is a Google Buzz button that anyone can use on their site or blog to share news. It has a live "firehose" counter connected to it. This means that the count is not based on clicks on the actual button (like other services out there) but on the actual share count in the whole of Google Buzz. So no matter how and where people share your links to Buzz they will be counted.
Version: 1.0.0
Author: Njuice
Author URI: http://njuice.com/
*/

function nbb_admin_menu() {
	add_options_page('Njuice Buzz Button', 'Buzz Button', 8, basename(__FILE__), 'nbb_admin_page');
}

function nbb_admin_init(){
    if(function_exists('register_setting')){
		register_setting('nbb-settings', 'nbb_type');
        register_setting('nbb-settings', 'nbb_position');
		register_setting('nbb-settings', 'nbb_location');
		
		register_setting('nbb-settings', 'nbb_display_home');
		register_setting('nbb-settings', 'nbb_display_post');
		register_setting('nbb-settings', 'nbb_display_page');
		register_setting('nbb-settings', 'nbb_display_archive');
		register_setting('nbb-settings', 'nbb_display_search');
		register_setting('nbb-settings', 'nbb_display_tag');
		register_setting('nbb-settings', 'nbb_display_feed');
		
		register_setting('nbb-settings', 'nbb_share');
		register_setting('nbb-settings', 'nbb_color');
	}
}

function nbb_admin_page() {
	$type = get_option('nbb_type');
	$position = get_option('nbb_position');
	$location = get_option('nbb_location');
	$share = get_option('nbb_share');
	$color = get_option('nbb_color');
	?>
	<div class="wrap">
	<h2>Njuice Buzz Button settings</h2>
	<form method="post" action="options.php">
	<?php
	if(function_exists('settings_fields')){
		settings_fields('nbb-settings');
	} else {
		wp_nonce_field('update-options');
		?>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="nbb_type,nbb_position,nbb_location,nbb_display_home,nbb_display_post,nbb_display_page,nbb_display_archive,nbb_display_search,nbb_display_tag,nbb_display_feed,nbb_share,nbb_color" />
		<?php
	}
	?>
	<table class="form-table">
	
	<tr>
		<th scope="row" valign="top">Show button on</th>
		<td>
			<input type="checkbox" name="nbb_display_home" value="true"<?php if(get_option('nbb_display_home') == 'true') echo ' checked="checked"';?> /> Homepage<br />
			<input type="checkbox" name="nbb_display_post" value="true"<?php if(get_option('nbb_display_post') == 'true') echo ' checked="checked"';?> /> Posts<br />
			<input type="checkbox" name="nbb_display_page" value="true"<?php if(get_option('nbb_display_page') == 'true') echo ' checked="checked"';?> /> Pages<br />
			<input type="checkbox" name="nbb_display_archive" value="true"<?php if(get_option('nbb_display_archive') == 'true') echo ' checked="checked"';?> /> Archives<br />
			<input type="checkbox" name="nbb_display_search" value="true"<?php if(get_option('nbb_display_search') == 'true') echo ' checked="checked"';?> /> Search results<br />
			<input type="checkbox" name="nbb_display_tag" value="true"<?php if(get_option('nbb_display_tag') == 'true') echo ' checked="checked"';?> /> Tag pages<br />
			<input type="checkbox" name="nbb_display_feed" value="true"<?php if(get_option('nbb_display_feed') == 'true') echo ' checked="checked"';?> /> Feeds<br />
		</td>
	</tr>
	
	<tr>
		<th scope="row" valign="top">Type</th>
		<td>
			<div>
				<input type="radio" name="nbb_type" value="normal"<?php if($type == 'normal') echo ' checked="checked"';?> /> <img style="vertical-align: middle;" src="http://s.njuice.com/img/buzz_normal_icon.png" width="50" height="59" alt="Buzz normal" />
			</div>
			<br />
			<div>
				<input type="radio" name="nbb_type" value="small"<?php if($type == 'small') echo ' checked="checked"';?> /> <img style="vertical-align: middle;" src="http://s.njuice.com/img/buzz_small_icon.png" width="93" height="17" alt="Buzz small" />
			</div>
			<br/>
			<div>
				<input type="radio" name="nbb_type" value="simple"<?php if($type == 'simple') echo ' checked="checked"';?> /> <img style="vertical-align: middle;" src="http://s.njuice.com/img/buzz_simple_icon.png" width="73" height="17" alt="Buzz simple" />
			</div>
			<br />
			Pick color for the count on small/simple button <input type="text" name="nbb_color" value="<?php echo $color ?>" maxlength="7" style="width:80px;" />
		</td>
	</tr>

	<tr>
		<th scope="row" valign="top">Position</th>
		<td>
			<select name="nbb_position" style="width:150px;">
				<option value="before"<?php if($position == 'before') echo ' selected="selected"';?>>Before content</option>
				<option value="after"<?php if($position == 'after') echo ' selected="selected"';?>>After content</option>
			</select>
			
			<select name="nbb_location" style="width:75px;">
				<option value="left"<?php if($location == 'left') echo ' selected="selected"';?>>Left</option>
				<option value="right"<?php if($location == 'right') echo ' selected="selected"';?>>Right</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<th scope="row" valign="top">Share method</th>
		<td>
			<select name="nbb_share" style="width:150px;">
				<option value="gmail"<?php if($share == 'gmail') echo ' selected="selected"';?>>Gmail</option>
				<option value="reader"<?php if($share == 'reader') echo ' selected="selected"';?>>Google Reader</option>
			</select>
		</td>
	</tr>
	
	</table>
	<p class="submit"><input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /></p>
	</form>
	</div>
	<?
}

function nbb_insert_button($content) {
	global $post;
	
	// Check if user wishes to remove button from this content
	if(strpos($content, "[NOBUZZBUTTON]") !== FALSE) {
		return str_replace("[NOBUZZBUTTON]", "", $content);
	}
	
	// Check if user has manually inserted button tag
	$buttontag = (strpos($content, "[BUZZBUTTON]") !== FALSE);
	
	if(!$buttontag) {
		// Exit if showing button is disabled for current page type
		if(is_home() && get_option('nbb_display_home') != 'true')
			return $content;
		else if(is_single() && get_option('nbb_display_post') != 'true')
			return $content;
		else if(is_page() && get_option('nbb_display_page') != 'true')
			return $content;
		else if(is_archive() && get_option('nbb_display_archive') != 'true')
			return $content;
		else if(is_search() && get_option('nbb_display_search') != 'true')
			return $content;
		else if(is_tag() && get_option('nbb_display_tag') != 'true')
			return $content;
		else if(is_feed() && get_option('nbb_display_feed') != 'true')
			return $content;
	}
	
	
	$type = get_option('nbb_type');
	
	// Use image button in feeds
	if(is_feed()) {
		$button = '<a href="http://button.njuice.com/go.php?type=gmail&title=' . urlencode(get_the_title()) . '&url=' . urlencode(get_permalink()) . '" target="_blank"><img src="http://button.njuice.com/buzz?url=' . urlencode(get_permalink()) . '&title=' . urlencode(get_the_title()) . '&type=image" border="0" /></a>';
	} else {
		// Set iframe dimensions based on button type
		if($type == "small") {
			$width = 120;
			$height = 18;
		} else if($type == "simple") {
			$width = 80;
			$height = 18;
		} else {
			$width = 50;
			$height = 59;
		}
		
		$button = '<iframe src="http://button.njuice.com/buzz?url=' . urlencode(get_permalink()) . '&title=' . urlencode(get_the_title()) . '&size=' . $type . '&share=' . get_option('nbb_share') . '&color=' . urlencode(get_option('nbb_color')) . '" height="' . $height . '" width="' . $width . '" frameborder="0" scrolling="no" style="' . (get_option('nbb_location') == 'left' ? 'float: left; margin-right: 10px;': 'float: right; margin-left: 10px;' ) . '"></iframe>';
	}
	
	$position = get_option('nbb_position');
	
	if(!$buttontag) {
		if($position == "before")
			return $button . $content;
		else
			return $content . $button;
	} else {
		return str_replace("[BUZZBUTTON]", $button, $content);
	}
}

add_filter('the_content', 'nbb_insert_button');

if(is_admin()) {
    add_action('admin_menu', 'nbb_admin_menu');
	add_action('admin_init', 'nbb_admin_init');
}


function nbb_activation() {
	add_option('nbb_type', 'normal');
	add_option('nbb_position', 'before');
	add_option('nbb_location', 'right');
	
	add_option('nbb_display_home', 'true');
	add_option('nbb_display_post', 'true');
	add_option('nbb_display_page', 'true');
	add_option('nbb_display_archive', 'true');
	add_option('nbb_display_search', 'true');
	add_option('nbb_display_tag', 'true');
	add_option('nbb_display_feed', 'true');
	
	add_option('nbb_share', 'gmail');
	add_option('nbb_color', '#000000');
}

register_activation_hook(__FILE__, 'nbb_activation');
?>