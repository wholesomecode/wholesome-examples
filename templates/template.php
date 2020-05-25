<?php
/**
 * Example Template File.
 *
 * Based on the TwentyTwenty theme file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="site-content" role="main">
	<article class="post-1 post type-post status-publish format-standard hentry category-uncategorized" id="post-1">
		<header class="entry-header has-text-align-center header-footer-group">
			<div class="entry-header-inner section-inner medium">
				<h1><?php esc_html_e( 'Example Template File', 'wholesome-code' ); ?></h1>
				<p><?php esc_html_e( 'Ideally this file should be in your theme.', 'wholesome-code' ); ?></p>
			</div>
		</header>
	</article>
</main><!-- #site-content -->

<?php get_footer(); ?>
