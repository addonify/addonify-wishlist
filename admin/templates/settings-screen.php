<?php
/**
 * Admin template.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/admin/templates
 */

// direct access is disabled.
defined( 'ABSPATH' ) || exit;
?>

<div class="wrap">

	<h1><?php esc_html_e( 'Addonify Wishlist Options', 'addonify-wishlist' ); ?></h1>

	<div id="addonify-settings-wrapper">
			
		<ul id="addonify-settings-tabs">
			<li>
				<a href="<?php echo esc_url( $tab_url . 'settings' ); ?>" class="<?php echo ( ( 'settings' === $current_tab ) ? 'active' : '' ); ?>" > 
					<?php esc_html_e( 'Settings', 'addonify-wishlist' ); ?> 
				</a>
			</li>
			<li>
				<a href="<?php echo esc_url( $tab_url . 'styles' ); ?>" class="<?php echo ( ( 'styles' === $current_tab ) ? 'active' : '' ); ?>" > 
					<?php esc_html_e( 'Styles', 'addonify-wishlist' ); ?>
				</a>
			</li>
		</ul>

		<?php if ( 'settings' === $current_tab ) : ?>

			<!-- settings tabs -->
			<form method="POST" action="options.php">
			
				<!-- generate nonce -->
				<?php settings_fields( 'wishlist_settings' ); ?>

				<div class="addonify-content">
					<!-- display form fields -->

					<div class="addonify-section">
						<?php do_settings_sections( $this->settings_page_slug . '-general_options' ); ?>
					</div>

					<div class="addonify-section">
						<?php do_settings_sections( $this->settings_page_slug . '-button_settings' ); ?>
					</div>

					<div class="addonify-section">
						<?php do_settings_sections( $this->settings_page_slug . '-popup_options' ); ?>
					</div>

					<div class="addonify-section">
						<?php do_settings_sections( $this->settings_page_slug . '-sidebar_options' ); ?>
					</div>

					<div class="addonify-section">
						<?php do_settings_sections( $this->settings_page_slug . '-sidebar_btn_options' ); ?>
					</div>

				</div><!--addonify-settings-container-->

				<?php submit_button(); ?>

			</form>
		
		<?php elseif ( 'styles' === $current_tab ) : ?>

			<form method="POST" action="options.php">
			
				<?php settings_fields( 'wishlist_styles' ); ?>

				<div id="addonify-styles-container" class="addonify-content">

					<div id="addonify-style-options-container" class="addonify-section ">
						<?php do_settings_sections( $this->settings_page_slug . '-styles' ); ?>
					</div>

					<div id="addonify-content-colors-container" class="addonify-section">
						<?php do_settings_sections( $this->settings_page_slug . '-content-colors' ); ?>
					</div>
				</div>

				<?php submit_button(); ?>

			</form>

		<?php endif; ?>
	
	</div>
	
</div>
