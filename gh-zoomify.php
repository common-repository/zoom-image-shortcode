<?php
/*
Plugin Name: Zoomify embed for WP
Plugin URI: https://wordpress.org/plugins/zoom-image-shortcode/
Description: This plugin allows you to embed zoomify images on any page or post using a shortcode
Version: 1.5.2
Author: Sander de Wijs
Author URI: https://www.degrinthorst.nl/
License: GPLv2
*/

// Exit when called directly
defined('ABSPATH') or die('Nope!');

define('GH_ZOOMIFY_BASE', plugin_dir_url(__FILE__));
define('GH_ZOOMIFY_PATH', plugin_dir_path(__FILE__));

// Load settings page
require_once('inc/gh-zoomify-settings.php');

/**
 * code for header css and JS
 */
function gh_zoomify_scripts_styles() {
	$uploadDir = wp_upload_dir();

	if (get_option('gh_zoomify_js') !== false && file_exists($uploadDir['basedir'] . "/gh-zoomify-embed/" . get_option('gh_zoomify_js'))) {
		$version_hash = wp_hash(get_option('gh_zoomify_js'), 'nonce');
		wp_enqueue_script('zoomify-js', "{$uploadDir['url']}/gh-zoomify-embed/" . get_option('gh_zoomify_js'), '', $version_hash, false);
	} else {
		wp_enqueue_script('zoomify-js', GH_ZOOMIFY_BASE . 'assets/js/ZoomifyImageViewerExpress-min.js', '', '1.0', false);
	}

	wp_enqueue_style('gh-zoomify', GH_ZOOMIFY_BASE . 'assets/css/zoomify-styles.css', '', '1.0');
}

add_action('wp_enqueue_scripts', 'gh_zoomify_scripts_styles');

/**
 * Add support for uploading zif files
 */
function add_zif_support($mime_types) {
	$mime_types['zif'] = 'image/tiff';
	$mime_types['js']  = 'text/plain';

	return $mime_types;
}

add_filter('upload_mimes', 'add_zif_support');


/**
 * @param $linkToFile
 * @param $options
 * @param $containerName
 *
 * @return string
 */
function zoomify_container_js($linkToFile, $options, $containerName) {
	if (in_array($options['zskinpath'], ['Default', 'Light', 'Dark'])) {
		$zSkinPath = GH_ZOOMIFY_BASE . 'assets/Skins/' . ucfirst($options['zskinpath']) . '/';
	} else {
		$zSkinPath = $options['zskinpath'];
	}

	unset($options['zskinpath']);

	$output = '<script type="text/javascript">Z.showImage("' . $containerName . '", "' . $linkToFile . '", "zSkinPath=' . $zSkinPath;
	if ( ! empty($options)) {
		foreach ($options as $optionName => $optionValue) {
			if ($optionValue == null) {
				continue;
			}
			$output .= '&';
			$output .= parseZoomifyParam($optionName) . '=' . $optionValue;
		}
	}

	$output .= '");</script>';

	return $output;
}

/**
 * code for shortcode
 *
 * @param $atts
 *
 * @return string
 */
function gh_zoomify_shortcode($atts) {
	$a = shortcode_atts(array (
		'file'              => 'filename',
		'zskinpath'         => 'Default',
		'zinitialzoom'      => null,
		'zinitialx'         => null,
		'zinitialy'         => null,
		'zminzoom'          => null,
		'zmaxzoom'          => null,
		'znavigatorvisible' => 1,
		'ztoolbarvisible'   => 1,
		'zslidervisible'    => 1,
		'zlogovisible'      => 1,
		'zfullpagevisible'  => 1,
		'zfullpageinitial'  => 0,
		'zprogressvisible'  => 1,
		'ztooltipsvisible'  => 1,
		'zcomparisonpath'   => null,
	), $atts);

	if ($a['file'] !== null) {
		$filePath = $a['file'];
		$uniqName = 'zoomifyContainer-' . strtolower(str_replace('.zif', '', substr($filePath, strrpos($filePath, '/') + 1)));
	} else {
		$filePath = null;
		$uniqName = 'zoomifyContainer-' . uniqid();
	}

	unset($a['file']);

	// Use the attachment link in the Zoomify JS
	$output = zoomify_container_js($filePath, $a, $uniqName);

	$output .= "<div id='{$uniqName}' class='zoomify-wrapper'></div>";

	return $output;
}

add_shortcode('zoomify', 'gh_zoomify_shortcode');

/**
 *  Helper functions
 */

/**
 * @param $param
 *
 * @return string
 */
function parseZoomifyParam($param) {
	$optionNames = array (
		'zskinpath'         => 'zSkinPath',
		'zinitialx'         => 'zInitialX',
		'zinitialy'         => 'zInitialY',
		'zinitialzoom'      => 'zInitialZoom',
		'zminzoom'          => 'zMinZoom',
		'zmaxzoom'          => 'zMaxZoom',
		'znavigatorvisible' => 'zNavigatorVisible',
		'ztoolbarvisible'   => 'zToolbarVisible',
		'zslidervisible'    => 'zSliderVisible',
		'zlogovisible'      => 'zLogoVisible',
		'zfullpagevisible'  => 'zFullPageVisible',
		'zfullpageinitial'  => 'zFullPageInitial',
		'zprogressvisible'  => 'zProgressVisible',
		'ztooltipsvisible'  => 'zTooltipsVisible',
		'zcomparisonpath'   => 'zComparisonPath',
		'ztoolbarsize'      => 'zToolbarSize',
	);

	if (isset($optionNames[ $param ])) {
		return $optionNames[ $param ];
	}

	return false;
}

/**
 * Set a custom upload dir
 */

/**
 * Change Upload Directory for Zoomify JS file
 */
function gh_zoomify_js_upload_dir($args) {
	// Check the post-type of the current post
	$args['path']    = $args['path'] . '/gh-zoomify-embed';
	$args['url']     = $args['url'] . '/gh-zoomify-embed';
	$args['basedir'] = $args['basedir'] . '/gh-zoomify-embed';
	$args['baseurl'] = $args['baseurl'] . '/gh-zoomify-embed';

	return $args;
}
