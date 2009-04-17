<?php
/**
 * Feeds page
 *
 * @author Ryan McCue <cubegames@gmail.com>
 * @package Lilina
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require_once('admin.php');
require_once(LILINA_PATH . '/admin/includes/feeds.php');

$action     = ( isset($_REQUEST['action'] ) )? $_REQUEST['action'] : '';

/** Make sure we're actually adding */
switch($action) {
	case 'add':
		/** We need some sort of value here */
		if( !isset($_REQUEST['add_name']) )
			$_REQUEST['add_name'] = '';

		if(!isset($_REQUEST['add_url']))
			MessageHandler::add_error(_r('No URL specified'));
		else
			add_feed($_REQUEST['add_url'], $_REQUEST['add_name']);
	break;

	case 'remove':
		$remove_id  = ( isset($_REQUEST['remove']) ) ? htmlspecialchars($_REQUEST['remove']) : '';
		remove_feed($remove_id);
		break;

	case 'change':
		$change_name	= ( !empty($_REQUEST['change_name']) )	? htmlspecialchars($_REQUEST['change_name']) : '';
		$change_url		= ( !empty($_REQUEST['change_url']) )	? $_REQUEST['change_url'] : '';
		$change_id		= ( !empty($_REQUEST['change_id']) )	? (int) $_REQUEST['change_id'] : null;
		change_feed($change_id, $change_url, $change_name);
	break;
}
if(isset($_REQUEST['ajax']) && !isset($_REQUEST['list'])) {
	save_feeds();
	echo json_encode(array('errors' => MessageHandler::get_errors(), 'messages' => MessageHandler::get_messages()));
	die();
}
elseif(isset($_REQUEST['list']) && isset($_REQUEST['ajax'])) {
	die( feed_list_table() );
}


admin_header(_r('Feeds'));
?>
<h1><?php _e('Feeds'); ?></h1>
<h2><?php _e('Current Feeds'); ?></h2>
<table id="feeds_list" class="item-table">
	<thead>
		<tr>
		<th><?php _e('Feed Name'); ?></th>
		<th><?php _e('URL'); ?></th>
		<th><?php _e('Category'); ?></th>
		<?php do_action('admin-feeds-infocol-description'); ?>
		<th class="change-col"><?php _e('Edit Feed'); ?></th>
		<th class="remove-col"><?php _e('Remove Feed'); ?></th>
		<?php do_action('admin-feeds-actioncol-description'); ?>
		</tr>
	</thead>
	<tbody>
<?php
	feed_list_table();
?>
	</tbody>
</table>
<div id="changer" class="dialog">
	<form action="feeds.php" method="get" id="change_form">
		<fieldset id="change">
			<h2><?php _e('Edit Feed'); ?></h2>
			<div class="row">
				<label for="change_name"><?php _e('Name'); ?>:</label>
				<input type="text" name="change_name" id="change_name" />
			</div>
			<div class="row">
				<label for="change_url"><?php _e('Feed address (URL)'); ?>:</label>
				<input type="text" name="change_url" id="change_url" />
				<p class="sidenote"><?php _e('Example'); ?>: http://feeds.feedburner.com/lilina-news, http://getlilina.org</p>
			</div>
			<input type="hidden" name="action" value="change" />
			<input type="hidden" name="change_cat" value="" />
			<div id="changer_id" class="row">
				<label for="change_id"><?php _e('Feed ID'); ?>:</label>
				<input type="text" name="change_id" id="change_id" value="" />
			</div>
			<input type="submit" value="<?php _e('Save'); ?>" class="submit" />
			<p class="loading"><?php _e('Changing feed&hellip;') ?></p>
		</fieldset>
	</form>
</div>
<form action="feeds.php" method="get" id="add_form">
	<fieldset id="add">
		<h2><?php _e('Add Feed'); ?></h2>
		<div class="row">
			<label for="add_name"><?php _e('Name'); ?>:</label>
			<input type="text" name="add_name" id="add_name" />
			<p class="sidenote"><?php _e('If no name is specified, it will be taken from the feed'); ?></p>
		</div>
		<div class="row">
			<label for="add_url"><?php _e('Feed address (URL)'); ?>:</label>
			<input type="text" name="add_url" id="add_url" />
			<p class="sidenote"><?php _e('Example'); ?>: http://feeds.feedburner.com/lilina-news, http://getlilina.org</p>
		</div>
		<input type="hidden" name="action" value="add" />
		<input type="submit" value="<?php _e('Add'); ?>" class="submit" />
		<p class="loading"><?php _e('Adding feed&hellip;') ?></p>
	</fieldset>
</form>
<?php
admin_footer();
?>
