<?php
/**
 * Wholesome Examples
 *
 * Plugin Name:     Wholesome Examples
 * Plugin URI:      https://github.com/wholesomecode/wholesome-examples
 * Description:     Best Practice WordPress Examples.
 * Version:         0.1.0
 * Author:          Wholesome Code <hello@wholesomecode.ltd>
 * Author URI:      https://wholesomecode.ltd
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     wholesome-examples
 * Domain Path:     /languages
 *
 * @package         wholesomecode/wholesome_examples
 */

namespace WholesomeCode\WholesomeExamples; // @codingStandardsIgnoreLine

/**
 * Your main plugin.php file should include the plugin header comment
 * and any plugin constants (such as const FILE = __FILE__ for easiest
 * use of plugins_url() and related functions). It should load in any
 * namespace files, register any autoloaders, and handle the initial
 * hooking into WordPress.
 *
 * @see https://engineering.hmn.md/standards/structure/
 */
const PLUGIN_PREFIX = 'wholesomecode_wholesome_examples';
const PLUGIN_SLUG   = 'wholesomecode-wholesome-examples';
const ROOT_DIR      = __DIR__;
const ROOT_FILE     = __FILE__;

require_once ROOT_DIR . '/inc/main.php';

/**
 * Load Plugin
 *
 * Aside: Namespace Pattern
 *
 * File layout and namespacing lovingly borrowed from the
 * Human Made engineering handbook.
 *
 * TODO: document namespace choices in documentation/reference/namespace.md
 *
 * @see https://engineering.hmn.md/standards/style/php/#namespace-and-class-naming
 */
add_action( 'plugins_loaded', __NAMESPACE__ . '\\setup' );
