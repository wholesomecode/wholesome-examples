<?php
/**
 * Site Health.
 *
 * Removal of the WordPress 'Site Health' feature.
 *
 * TODO:
 * - Reference Settings example (adding menu items).
 * - Reference Secure Access Denial of Pages (users
 *   can still access hidden items if they know the url).
 * - Reference adding and removing toolbar menu items (inc logo change)
 * - Menu item reordering.
 * - Prevent theme/plugin editing and upgrading on live server.
 *
 * @package wholesomecode/wholesome_examples
 */

 namespace WholesomeCode\WholesomeExamples\SiteHealth; // @codingStandardsIgnoreLine

/**
 * Setup.
 *
 * Run the hooks
 *
 * @return void
 */
function setup() : void {
	add_action( 'admin_init', __NAMESPACE__ . '\\remove_dashboard_widgets' );
	add_action( 'admin_menu', __NAMESPACE__ . '\\remove_submenus', 500 );
	add_action( 'network_admin_menu', __NAMESPACE__ . '\\network_remove_submenus', 500 );
}

/**
 * Remove Dashboard Widgets.
 *
 * Hides the dashboard widget for 'Site Health'.
 *
 * @return void
 */
function remove_dashboard_widgets() : void {
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); // Site Health.

	// @codingStandardsIgnoreStart

	/**
	 * Dashboard Widgets.
	 *
	 * Removing / Overriding / Adding Dashboard Widgets Example.
	 *
	 * You can remove all the WordPress dashboard widgets with the
	 * following commands snippets.
	 *
	 * You can also add your own widget, or remove and add (override) with 'add_meta_box'.
	 */
	// remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // Activity.
	// remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' ); // WordPress Events and News.
	// remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // At a Glance.
	// remove_meta_box( 'dashboard_quick_press', 'dashboard', 'normal' ); // Quick Draft.

	// Adding a dashboard widget.
	// add_meta_box(
	// 	'dashboard_widget',
	// 	esc_html__( 'Dahsboard Widget', 'wholesome-examples' ),
	// 	__NAMESPACE__ . '\\dashboard_widget',
	// 	'dashboard',
	// 	'normal',
	// 	'high'
	// );

	// Network dashboard widgets.
	// remove_meta_box( 'dashboard_primary', 'dashboard-network', 'normal' ); // WordPress Events and News.
	// remove_meta_box( 'network_dashboard_right_now', 'dashboard-network', 'normal' ); // Right Now.

	/**
	 * Welcome Panel.
	 *
	 * Removing / Extending / Changing the Welcome Panel.
	 *
	 * You can remove the Welcome Panel on the dashboard with 'remove_action'.
	 * You can also add your own welcome panel, or extend the
	 * existing welcome panel with 'add_action'.
	 */
	// remove_action( 'welcome_panel', 'wp_welcome_panel' );
	// add_action( 'welcome_panel', __NAMESPACE__ . '\\welcome_panel' );

	// @codingStandardsIgnoreEnd
}

/**
 * Remove Submenus.
 *
 * Hides the submenu for 'Site Health'.
 *
 * @return void
 */
function remove_submenus() : void {
	remove_submenu_page( 'tools.php', 'site-health.php' );

	// @codingStandardsIgnoreStart

	/**
	 * Remove Menu Items.
	 *
	 * Here are snippets to remove all top level menu items.
	 *
	 * Note that network menu items are removed via the `network_admin_menu` hook.
	 */
	// remove_menu_page( 'index.php' ); // Dashboard.
	// remove_menu_page( 'edit.php' ); // Posts.
	// remove_menu_page( 'upload.php' ); // Media.
	// remove_menu_page( 'edit.php?post_type=page' ); // Pages.
	// remove_menu_page( 'edit-comments.php' ); // Comments.
	// remove_menu_page( 'themes.php' ); // Appearance.
	// remove_menu_page( 'plugins.php' ); // Plugins.
	// remove_menu_page( 'users.php' ); // Users.
	// remove_menu_page( 'tools.php' ); // Tools.
	// remove_menu_page( 'options-general.php' ); // Settings.

	/**
	 * Remove Submenu Items.
	 *
	 * Here are snippets to remove all other submenu items.
	 *
	 * Note that network submenu items are removed via the `network_admin_menu` hook.
	 */
	// Dashboard.
	// remove_submenu_page( 'index.php', 'index.php' ); // Home.
	// remove_submenu_page( 'index.php', 'my-sites.php' ); // My Sites.

	// Posts.
	// remove_submenu_page( 'edit.php', 'edit.php' ); // Posts.
	// remove_submenu_page( 'edit.php', 'post-new.php' ); // Add New.
	// remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // Categories.
	// remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // Tags.

	// Media.
	// remove_submenu_page( 'upload.php', 'upload.php' ); // Library.
	// remove_submenu_page( 'upload.php', 'media-new.php' ); // Add New.

	// Pages.
	// remove_submenu_page( 'edit.php?post_type=page', 'edit.php?post_type=page' ); // All Pages.
	// remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' ); // Add New.

	// Appearance.
	// remove_submenu_page( 'themes.php', 'themes.php' ); // Themes.
	// remove_submenu_page( 'themes.php', add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 'customize.php' ) ); // Customizer.
	// remove_submenu_page( 'themes.php', 'widgets.php' ); // Widgets.
	// remove_submenu_page( 'themes.php', 'nav-menus.php' ); // Menus.
	// remove_submenu_page( 'themes.php', add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) . '&#038;' . urlencode( 'autofocus[control]' ) . '=background_image', 'customize.php' ) ); // Background.

	// Users.
	// remove_submenu_page( 'users.php', 'users.php' ); // All Users.
	// remove_submenu_page( 'users.php', 'user-new.php' ); // Add New.
	// remove_submenu_page( 'users.php', 'profile.php' ); // Your Profile.

	// Tools.
	// remove_submenu_page( 'tools.php', 'tools.php' ); // Available Tools.
	// remove_submenu_page( 'tools.php', 'import.php' ); // Import.
	// remove_submenu_page( 'tools.php', 'export.php' ); // Export.
	// remove_submenu_page( 'tools.php', 'export-personal-data.php' ); // Export Personal Data.

	// Settings.
	// remove_submenu_page( 'options-general.php', 'options-general.php' ); // General.
	// remove_submenu_page( 'options-general.php', 'options-writing.php' ); // Writing.
	// remove_submenu_page( 'options-general.php', 'options-reading.php' ); // Reading.
	// remove_submenu_page( 'options-general.php', 'options-discussion.php' ); // Discussion.
	// remove_submenu_page( 'options-general.php', 'options-media.php' ); // Media.
	// remove_submenu_page( 'options-general.php', 'options-permalink.php' ); // Permalinks.
	// remove_submenu_page( 'options-general.php', 'options-privacy.php' ); // Privacy.

	// @codingStandardsIgnoreEnd
}

function network_remove_submenus() : void {
	// @codingStandardsIgnoreStart

	/**
	 * Remove Menu Items.
	 *
	 * Here are snippets to remove all network top level menu items.
	 */
	// remove_menu_page( 'index.php' ); // Dashboard.
	// remove_menu_page( 'sites.php' ); // Sites.
	// remove_menu_page( 'users.php' ); // Users.
	// remove_menu_page( 'themes.php' ); // Themes.
	// remove_menu_page( 'plugins.php' ); // Plugins.
	// remove_menu_page( 'settings.php' ); // Settings.

	/**
	 * Remove Submenu Items.
	 *
	 * Here are snippets to remove all network submenu items.
	 */
	// Dashboard.
	// remove_submenu_page( 'index.php', 'index.php' ); // Home.
	// remove_submenu_page( 'index.php', 'update-core.php' ); // Updates.
	// remove_submenu_page( 'index.php', 'upgrade.php' ); // Upgrade Network.

	// Sites.
	// remove_submenu_page( 'sites.php', 'sites.php' ); // All Sites.
	// remove_submenu_page( 'sites.php', 'site-new.php' ); // Add New.

	// Users.
	// remove_submenu_page( 'users.php', 'users.php' ); // All Users.
	// remove_submenu_page( 'users.php', 'user-new.php' ); // Add New.

	// Themes.
	// remove_submenu_page( 'themes.php', 'themes.php' ); // Installed Themes.
	// remove_submenu_page( 'themes.php', 'theme-install.php' ); // Add New.
	// remove_submenu_page( 'themes.php', 'theme-editor.php' ); // Add New.

	// Plugins.
	// remove_submenu_page( 'plugins.php', 'plugins.php' ); // Installed Plugins.
	// remove_submenu_page( 'plugins.php', 'plugin-install.php' ); // Add New.
	// remove_submenu_page( 'plugins.php', 'plugin-editor.php' ); // Plugin Editor.

	// Settings.
	// remove_submenu_page( 'settings.php', 'settings.php' ); // Network Settings.
	// remove_submenu_page( 'settings.php', 'setup.php' ); // Network Setup.

	// @codingStandardsIgnoreEnd
}

/**
 * Welcome Panel.
 *
 * A custom Welcome Panel example.
 */
function welcome_panel() : void {
	?>
	<a class="welcome-panel-close" href="http://wholesome-examples.test/wp-admin/?welcome=0" aria-label="<?php esc_attr_e( 'Dismiss the welcome panel', 'wholesome-examples' ); ?>"><?php esc_html_e( 'Dismiss', 'wholesome-examples' ); ?></a>
	<div class="welcome-panel-content">
		<h2><?php esc_html_e( 'Welcome to WordPress!', 'wholesome-examples' ); ?></h2>
		<p class="about-description"><?php esc_html_e( 'Here is a custom welcome message to get you started.', 'wholesome-examples' ); ?></p>
		<div class="welcome-panel-column-container">
			<div class="welcome-panel-column">
				<h3><?php esc_html_e( 'Column 1', 'wholesome-examples' ); ?></h3>
			</div>
			<div class="welcome-panel-column">
				<h3><?php esc_html_e( 'Column 2', 'wholesome-examples' ); ?></h3>
				<ul>
					<li><a href="#" class="welcome-icon welcome-write-blog"><?php esc_html_e( 'Example Link 1', 'wholesome-examples' ); ?></a></li>
				</ul>
			</div>
			<div class="welcome-panel-column welcome-panel-last">
				<h3><?php esc_html_e( 'Column 3', 'wholesome-examples' ); ?></h3>
				<ul>
					<li><a href="#" class="welcome-icon welcome-widgets"><?php esc_html_e( 'Example Link 2', 'wholesome-examples' ); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Dashboard Widget.
 *
 * A custom dashboard widget example.
 */
function dashboard_widget() : void {
	?>
	<p>
		<?php esc_html_e( 'Here is some custom widget text to get you started.', 'wholesome-examples' ); ?>
	</p>
	<?php
}
