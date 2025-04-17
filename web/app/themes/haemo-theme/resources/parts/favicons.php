<?php
/**
 * Theme favicons
 *
 * @category WordPress theme
 * @package haemo
 */

?>
<!-- Favicons
	================================================== -->
<link
	rel="apple-touch-icon"
	sizes="180x180"
	href="<?php echo app()->env->assets_url('favicons/apple-touch-icon.png'); ?>"
>
<link
	rel="icon"
	sizes="512x512"
	href="<?php echo app()->env->assets_url('favicons/android-chrome-512x512.png'); ?>"
/>
<link
	rel="icon"
	sizes="192x192"
	href="<?php echo app()->env->assets_url('favicons/android-chrome-192x192.png'); ?>"
/>
<link
	rel="icon"
	type="image/png"
	sizes="32x32"
	href="<?php echo app()->env->assets_url('favicons/favicon-32x32.png'); ?>"
/>
<link
	rel="icon"
	type="image/png"
	sizes="16x16"
	href="<?php echo app()->env->assets_url('favicons/favicon-16x16.png'); ?>"
/>
<link
	rel="manifest"
	href="<?php echo app()->env->assets_url('favicons/site.webmanifest'); ?>"
/>
