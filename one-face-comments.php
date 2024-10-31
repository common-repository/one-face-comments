<?php
/*
Plugin Name: One-Face Comments
Plugin URI: http://wordpress.org/extend/plugins/one-face-comments/
Description: Allows visitors to leave comments via One-Face authorization service.
Version: 1.6-trunk
Author: Sergey Biryukov
Author URI: http://sergeybiryukov.ru/
*/

function oneface_display() {
?>
<script type="text/javascript"><!--
function one_face_login(personals)
{
	var commentform = document.getElementById('commentform');
	commentform.author.value = personals.nickname;
	commentform.email.value = personals.email;
	commentform.url.value = personals.site;
}
//-->
</script>
<?
	$options = get_option('oneface_settings');
	if ( $options['swfobject'] ) {
?>
<div id="oneface">&nbsp;</div>
<script type="text/javascript"><!--
var so = new SWFObject("<?php echo $options['oneface_url']; ?>", "", "<?php echo $options['width']; ?>", "<?php echo $options['height']; ?>", "6", "<?php echo $options['background']; ?>");
so.addParam('wmode', 'transparent');
so.addParam('allowScriptAccess', 'always');
so.write("oneface");
//-->
</script>
<?
	} else {
?>
<div id="oneface">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<?php echo $options['width']; ?>" height="<?php echo $options['height']; ?>" align="middle">
	<param name="allowScriptAccess" value="always" />
	<param name="movie" value="<?php echo $options['oneface_url']; ?>" />
	<param name="quality" value="high" />
	<param name="wmode" value="transparent" />
<embed src="<?php echo $options['oneface_url']; ?>" quality="high" width="<?php echo $options['width']; ?>" height="<?php echo $options['height']; ?>" name="loginer" wmode="transparent" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>
<?
	}
}
add_action('comment_form', 'oneface_display');

function oneface_head() {
	$options = get_option('oneface_settings');
	if ( $options['swfobject'] && (is_single() || is_page()) )
		wp_enqueue_script('oneface-swfobject', plugins_url('swfobject.js', __FILE__), false, '1.5');
}
add_action('wp', 'oneface_head');

function oneface_add_default_options() {
	$options = get_option('oneface_settings');
	$options['default_url'] = 'http://core.one-face.ru:8000/one-face/loginer.swf';

	if ( empty($options['oneface_url']) ) {
		$options['oneface_url'] = $options['default_url'];
		$options['width'] = 200;
		$options['height'] = 100;
		$options['background'] = '#FFFFFF';
		$options['swfobject'] = true;
	}

	add_option('oneface_settings', $options);

	if ( function_exists('register_uninstall_hook') )
		register_uninstall_hook(__FILE__, 'oneface_remove_default_options');
}
register_activation_hook(__FILE__, 'oneface_add_default_options');

function oneface_remove_default_options() {
	delete_option('oneface_settings');
}
if ( !function_exists('register_uninstall_hook') )
	register_deactivation_hook(__FILE__, 'oneface_remove_default_options');

function oneface_show_options_page() {
	$options = get_option('oneface_settings');
	if ( !empty($_POST['submit_oneface_settings']) ) {
		$options['oneface_url'] = $_POST['oneface_url'];
		$options['width'] = $_POST['width'];
		$options['height'] = $_POST['height'];
		$options['background'] = $_POST['background'];
		$options['swfobject'] = isset($_POST['swfobject']) ? true : false;
		update_option('oneface_settings', $options);
	}
?>
<?php if ( !empty($_POST) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'one-face') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2><?php _e('One-Face Comments Options', 'one-face'); ?></h2>
<form method="post" action="">

<p>
<label for="oneface_url"><?php _e('One-Face block URL:', 'one-face'); ?></label>
<input type="text" name="oneface_url" value="<?php echo $options['oneface_url']; ?>" size="65" /> | <a href="http://one-face.ru/webmaster-reference.htm"><?php _e('Block examples', 'one-face'); ?></a><br />
<?php printf(__('(Default: %s)', 'one-face'), $options['default_url']); ?>
</p>

<p>
<label for="width"><?php _e('Width:', 'one-face'); ?></label>
<input type="text" name="width" value="<?php echo $options['width']; ?>" size="2" />
<label for="height"><?php _e('Height:', 'one-face'); ?></label>
<input type="text" name="height" value="<?php echo $options['height']; ?>" size="2" />
<label for="background"><?php _e('Background color:', 'one-face'); ?></label>
<input type="text" name="background" value="<?php echo $options['background']; ?>" size="7" />
</p>

<p>
<label for="swfobject"><?php _e('Use SWFObject script to insert?', 'one-face'); ?></label>
<input type="checkbox" name="swfobject" value="<?php echo $options['swfobject']; ?>" <?php if ( $options['swfobject'] ) echo 'checked="checked"'; ?> /><br />
</p>

<input type="hidden" name="action" value="update" />

<p class="submit">
<input type="submit" name="submit_oneface_settings" value="<?php _e('Update Options &raquo;', 'one-face'); ?>" />
</p>

</form>
</div>
<?php
}

function oneface_add_options_page() {
	add_options_page(__('One-Face Comments', 'one-face'), __('One-Face Comments', 'one-face'), 'administrator', __FILE__, 'oneface_show_options_page');
}
add_action('admin_menu', 'oneface_add_options_page');

function oneface_init() {
	load_plugin_textdomain('one-face', PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)), dirname(plugin_basename(__FILE__)));
}
add_action('init', 'oneface_init');
?>