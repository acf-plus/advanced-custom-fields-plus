<?php
/**
 * Module name: Events
 *
 * @package  ACF
 * @see README.md for details
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Register the needed fields for events.
 */
if ( function_exists( 'acf_add_local_field_group' ) ) {
	$acf_module = new FieldsBuilder( 'event_details', [ 'title' => __( 'Event Details', 'acf_plus' ) ] );
	$acf_module
		->addText( 'acf_event_start', [ 'label' => __( 'Start date', 'acf_plus' ) ] )
		->addText( 'acf_event_end', [ 'label' => __( 'End date', 'acf_plus' ) ] )
		->setLocation( 'post_type', '==', 'page' );
	acf_add_local_field_group( $acf_module->build() );
}

/**
 * Include partial of module
 *
 * @param mixed $content WordPress post content.
 *
 * @return mixed
 */
function acf_plus_event( $content ) {
	include __DIR__ . '/partial.php';
	return $content;
}
add_filter( 'the_content', 'acf_plus_event' );
