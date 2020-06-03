<?php
/**
 * Yoast JSON LD.
 *
 * Extend the @graph area of the Yoast JSON LD script.
 *
 * @package wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples\YoastJSONLD; // @codingStandardsIgnoreLine

use const WholesomeCode\WholesomeExamples\ROOT_DIR;

/**
 * Setup.
 *
 * Run the hooks.
 *
 * @return void
 */
function setup() : void {

	// If Yoast SEO is not installed, bail.
	if ( ! function_exists( 'wpseo_auto_load' ) ) {
		return;
	}

	/**
	 * Class Custom JSON.
	 *
	 * Load a class to allow us to inject JSON into the Yoast SEO JSON LD area.
	 */
	require_once ROOT_DIR . '/inc/yoast-json-ld/class-custom-json.php';

	// Use in development, to see formatted json in header.
	// add_filter( 'yoast_seo_development_mode', '__return_true' ); // @codingStandardsIgnoreLine

	// Alter page type.
	add_filter( 'wpseo_schema_webpage_type', __NAMESPACE__ . '\\page_type' );

	// Add pieces.
	add_filter( 'wpseo_schema_graph_pieces', __NAMESPACE__ . '\\add_graph_pieces', 11, 2 );
}

/**
 * Page Type.
 *
 * @param string $page_type The current page type.
 * @return void
 */
function page_type( $page_type ) {
	if ( is_page( 'faq' ) ) {
		$page_type = 'FAQPage';
	}
	return $page_type;
}

/**
 * Add Graph Pieces.
 *
 * Adds Schema pieces to the Yoast SEO JSON LD @graph.
 *
 * @param array                 $pieces  Graph pieces to output.
 * @param \WPSEO_Schema_Context $context Object with context variables.
 *
 * @return array $pieces Graph pieces to output.
 */
function add_graph_pieces( $pieces, $context ) {
	global $post;

	// If not the FAQ page, bail. (Example guard).
	if ( ! is_page( 'faq' ) ) {
		return $pieces;
	}

	// FAQs could come from any source. Let's use an array as an example.
	$faqs = [
		[
			'question' => 'Question 1',
			'answer'   => 'Answer 1',
		],
		[
			'question' => 'Question 2',
			'answer'   => 'Answer 2',
		],
	];

	// Build up the FAQs.
	foreach ( $faqs as $faq ) {
		$json[] = [
			'@context'       => 'http://schema.org',
			'@type'          => 'Question',
			'text'           => $faq['question'],
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => $faq['answer'],
			],
		];

		// Append new pieces to @graph.
		$pieces[] = new CustomJSON( $context, $json );
	}

	// Return the graph pieces.
	return $pieces;
}
