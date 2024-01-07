<?php
/**
 * Logic for handling protected downloads. Users are redirected to here.
 */
function download_pdf() {
	// Check if file exists in media.
	require_once 'wp-load.php';
	global $wpdb;
	$file     = $_GET['link'];
	$filename = basename( $url );
	$query    = "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE '%/$filename'";
	$count    = intval( $wpdb->get_var( $query ) );

	if ( $count > 1 and strpos( $file, '/wp-content/uploads/' ) === true && strpos( $file, 'php' ) === false && strpos( $file, 'txt' ) === false && strpos( $file, 'log' ) === false && strpos( $file, 'pdf' ) === true ) {
		// Handle download.
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: application/pdf' );
		header( 'Content-Disposition: attachment; filename=' . basename( $file ) );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . filesize( $file ) );
		ob_clean();
		flush();
		readfile( $file );
		exit;
	}
}
download_pdf();
