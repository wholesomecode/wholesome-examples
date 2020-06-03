<?php
/**
 * Class Custom JSON
 *
 * A class that implements WPSEO_Graph_Piece to allow us to inject any
 * JSON into the @graph of the Yoast SEO JSON LD script.
 */

namespace WholesomeCode\WholesomeExamples\YoastJSONLD; // @codingStandardsIgnoreLine

/**
 * Class Custom JSON
 */
class CustomJSON implements \WPSEO_Graph_Piece {

	/**
	 * A value object with context variables.
	 *
	 * @var WPSEO_Schema_Context
	 */
	public $context;

	/**
	 * The JSON to inject.
	 *
	 * @var [type]
	 */
	public $json;

	/**
	 * Constructor.
	 *
	 * @param WPSEO_Schema_Context $context Value object with context variables.
	 * @param string $json The JSON to inject.
	 */
	public function __construct( \WPSEO_Schema_Context $context, array $json ) {
		$this->context = $context;
		$this->json    = $json;
	}

	/**
	 * Is needed.
	 *
	 * Determines whether or not a piece should be added to the graph.
	 * As we are placing our guard before we call this class, always return true.
	 *
	 * @return bool
	 */
	public function is_needed() {
		return true;
	}

	/**
	 * Generate.
	 *
	 * Generate the Graph JSON.
	 *
	 * @return array $graph Custom JSON.
	 */
	public function generate() {
		return $this->json;
	}
}
