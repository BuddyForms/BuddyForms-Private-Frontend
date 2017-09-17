<?php
add_filter('buddyforms_admin_tabs', 'buddyforms_private_frontend_admin_tab', 10, 1);
function buddyforms_private_frontend_admin_tab($tabs){

	$tabs['private_frontend'] = 'Private Frontend Settings';

	return $tabs;
}

add_action( 'buddyforms_settings_page_tab', 'buddyforms_private_frontend_settings_page_tab' );
function buddyforms_private_frontend_settings_page_tab($tab){

	if($tab != 'private_frontend')
		return $tab;

	$private_frontend_settings = get_option( 'buddyforms_private_frontend_settings' ); ?>

	<div class="metabox-holder">
		<div class="postbox buddyforms-metabox">
			<div class="inside">
				<form method="post" action="options.php">

					<?php settings_fields( 'buddyforms_private_frontend_settings' );

					$private_post_types = isset( $private_frontend_settings['post_types'] ) ? $private_frontend_settings['post_types'] : array();
					?>

					<table class="form-table">
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Select Private Post Types')?>
							</th>
							<td>

								<?php
								// Get all allowed post types
								$post_types = buddyforms_get_post_types();
								unset( $post_types['bf_submissions'] );

								foreach( $post_types as $key => $post_type ){
									$value = isset( $private_post_types[$key] ) ? 'checked="checked"' : '';
									?><input <?php echo $value ?> type="checkbox" value="<?php echo $key ?>" name="buddyforms_private_frontend_settings[post_types][<?php echo $key ?>]"> <?php echo $post_type ?><?php
								}
								?>
                                <p>Select the post types you like to make private and only accessible for the author.</p>
							</td>

						</tr>
                        <tr valign="top">
                            <th scope="row" valign="top">
								<?php _e( 'Redirect to page if a user try to access a post directly he is not the author of or if he is logged off', 'buddyforms' ); ?>
                            </th>
                            <td>
								<?php

								$private_forbidden_page = isset( $private_frontend_settings['forbidden_page'] ) ? $private_frontend_settings['forbidden_page'] : '';

                                // Get all allowed pages
                                $all_pages = buddyforms_get_all_pages( 'id', 'settings' );

								if ( isset( $all_pages ) && is_array( $all_pages ) ) {
									echo '<select name="buddyforms_private_frontend_settings[forbidden_page]" id="buddyforms_forbidden_page">';
									$pages['none'] = 'No Redirect';
									foreach ( $all_pages as $page_id => $page_name ) {
										echo '<option ' . selected( $private_forbidden_page, $page_id ) . 'value="' . $page_id . '">' . $page_name . '</option>';
									}
									echo '</select>';
								}
								?>
                            </td>
                        </tr>
					</table>
					<?php submit_button(); ?>

				</form>
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
	<?php
}

add_action( 'admin_init', 'buddyforms_private_frontend_register_option' );
function buddyforms_private_frontend_register_option() {
	// creates our settings in the options table
	register_setting( 'buddyforms_private_frontend_settings', 'buddyforms_private_frontend_settings', 'buddyforms_private_frontend_settings_default_sanitize' );
}

// Sanitize the Settings
function buddyforms_private_frontend_settings_default_sanitize( $new ) {

		return $new;

}