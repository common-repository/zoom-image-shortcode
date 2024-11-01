<?php
/**
 * Register menu page
 */
function gh_zoomify_settings() {
	add_menu_page(
		'Zoomify settings',
		'Zoomify',
		'manage_options',
		'zoomify-settings',
		'zoomify_settings_page',
		'dashicons-plus',
		100
	);
}

add_action('admin_menu', 'gh_zoomify_settings');

// Extra settings

/**
 *
 */
function gh_zoomify_site_settings_init() {
	add_settings_section(
		'gh_zoomify_setting_section',
		'Zoomify JS file upload',
		'gh_zoomify_setting_section_callback_function',
		'zoomify-settings'
	);

	add_settings_field(
		'gh_zoomify_js',
		'Zoomify JS file',
		'gh_zoomify_callback_function',
		'zoomify-settings',
		'gh_zoomify_setting_section'
	);

	add_settings_field(
		'gh_zoomify_version',
		'Zoomify version',
		'gh_zoomify_version_callback_function',
		'zoomify-settings',
		'gh_zoomify_setting_section'
	);

	register_setting( 'zoomify-settings', 'gh_zoomify_js', 'gh_zoomify_handle_file_upload' );
	register_setting( 'zoomify-settings', 'gh_zoomify_version');
}

/**
 *
 */
function gh_zoomify_setting_section_callback_function() {
	echo 'Upload Zoomify JS';
}

/**
 * @param $option
 *
 * @return mixed
 */
function gh_zoomify_handle_file_upload()
{
	if(!empty($_FILES["gh_zoomify_js"]["tmp_name"]) && $_FILES["gh_zoomify_js"]["tmp_name"] !== '')
	{
		add_filter( 'upload_dir', 'gh_zoomify_js_upload_dir' );
		$uploadDir = wp_upload_dir();

		if(!file_exists($uploadDir['basedir'])) {
			mkdir($uploadDir['basedir']);
		}

		$oldJs = gh_zoomify_find_js($uploadDir);

		if(!empty($oldJs)) {
			unlink($uploadDir['basedir'] . '/' . $oldJs[2]);
		}

		wp_handle_upload($_FILES["gh_zoomify_js"], array('test_form' => FALSE));
		remove_filter( 'upload_dir', 'gh_zoomify_js_upload_dir' );
		return $_FILES["gh_zoomify_js"]["name"];
	}
	return get_option('gh_zoomify_js');
}

add_action( 'admin_init', 'gh_zoomify_site_settings_init' );

/**
 *  Display the input field for uploading Zoomify JS
 */
function gh_zoomify_callback_function()
{
	?>
    <input type="file" id="gh_zoomify_js" name="gh_zoomify_js" value="<?php echo get_option('gh_zoomify_js');?>"/>
	<?php echo get_option('gh_zoomify_js'); ?>
    <p>Upload your Zoomify Viewer script file here. This file is included with the Zoomify software.</p>
	<?php
}

/**
 *  Display the input field to select Zoomify version
 */
function gh_zoomify_version_callback_function()
{
	if(get_option('gh_zoomify_version') === false) {
		$option = 'express';
	} else {
		$option = get_option('gh_zoomify_version');
	}

	?>
    <select name="gh_zoomify_version" id="gh_zoomify_version">
        <option value="express" <?php echo ($option == 'express') ? 'selected' : '' ?>>Express</option>
        <option value="pro" <?php echo ($option == 'pro') ? 'selected' : '' ?>>Pro</option>
        <option value="enterprise" <?php echo ($option == 'enterprise') ? 'selected' : '' ?>>Enterprise</option>
    </select>
    <p>Set this option to enable specific options for your Zoomify version.</p>
    <p><i>Options for Enterprise, Pro and Express will be added in future versions. You can help by sending me an
            <a href="mailto:info@degrinthorst.nl">email</a> with the options you want to have added first. Please provide the parameters and their default values. These can be found in the Zoomify documentation. Adding all 200+ options will be a big task, so help me start with the options you actually use!</i></p>
	<?php
}

/**
 * Display HomeShow Actions menu page
 */
function zoomify_settings_page()
{
	?>
    <div id="homeShowImportsWrapper" class="wrap">
        <h1>Zoomify embed settings</h1>
        <hr>
        <form method="POST" action="options.php" enctype="multipart/form-data">
			<?php
			settings_fields( 'zoomify-settings' );
			do_settings_sections( 'zoomify-settings' );
			submit_button();
			?>
        </form>
    </div>

	<?php
}

/**
 * @param array $dir
 *
 * @return array|false
 */
function gh_zoomify_find_js(array $dir)
{
	return array_diff(scandir($dir['basedir']), array('.', '..'));
}
