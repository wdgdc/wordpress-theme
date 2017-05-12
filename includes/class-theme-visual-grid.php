<?php

class Theme_Visual_Grid {
	private static $show       = false;
	private static $meta_key   = 'theme_visual_grid';
	private static $body_class = 'visual-grid-active';

	private static $icons = array(
		'grid_off' => '<svg class="icon-grid-off" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24"><path fill="#A0A5AA" d="M15.984 20.016h1.453l-1.453-1.453v1.453zM14.016 20.016v-3.469l-0.563-0.563h-3.469v4.031h4.031zM8.016 14.016v-3.469l-0.563-0.563h-3.469v4.031h4.031zM8.016 20.016v-4.031h-4.031v4.031h4.031zM3.984 6.563v1.453h1.453zM9.984 12.563v1.453h1.453zM1.266 1.266l21.469 21.469-1.266 1.266-2.016-2.016h-15.469c-1.078 0-1.969-0.891-1.969-1.969v-15.469l-2.016-2.016zM15.984 3.984v4.031h4.031v-4.031h-4.031zM8.016 3.984h-1.453l-2.016-1.969h15.469c1.078 0 1.969 0.891 1.969 1.969v15.469l-1.969-2.016v-1.453h-1.453l-2.016-1.969h3.469v-4.031h-4.031v3.469l-1.969-2.016v-1.453h-1.453l-2.016-1.969h3.469v-4.031h-4.031v3.469l-1.969-2.016v-1.453z"></path></svg>',
		'grid_on'  => '<svg class="icon-grid-on" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24"><path fill="#A0A5AA" d="M20.016 8.016v-4.031h-4.031v4.031h4.031zM20.016 14.016v-4.031h-4.031v4.031h4.031zM20.016 20.016v-4.031h-4.031v4.031h4.031zM14.016 8.016v-4.031h-4.031v4.031h4.031zM14.016 14.016v-4.031h-4.031v4.031h4.031zM14.016 20.016v-4.031h-4.031v4.031h4.031zM8.016 8.016v-4.031h-4.031v4.031h4.031zM8.016 14.016v-4.031h-4.031v4.031h4.031zM8.016 20.016v-4.031h-4.031v4.031h4.031zM20.016 2.016c1.078 0 1.969 0.891 1.969 1.969v16.031c0 1.078-0.891 1.969-1.969 1.969h-16.031c-1.078 0-1.969-0.891-1.969-1.969v-16.031c0-1.078 0.891-1.969 1.969-1.969h16.031z"></path></svg>',
	);

	public static function init() {
		add_action( 'edit_user_profile_update', array( __CLASS__, 'edit_user_profile_update' ) );
		add_action( 'personal_options_update', array( __CLASS__, 'edit_user_profile_update' ) );
		add_action( 'personal_options', array( __CLASS__, 'personal_options' ) );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
		add_action( 'wp_ajax_toggle_visual_grid', array( __CLASS__, 'wp_ajax_toggle_visual_grid' ) );

		if ( ! is_admin() ) {
			add_action( 'admin_bar_menu', array( __CLASS__, 'admin_menu_bar' ), 99, 1 );
			add_action( 'wp_head', array( __CLASS__, 'wp_head' ) );
			add_action( 'wp_after_admin_bar_render', array( __CLASS__, 'wp_after_admin_bar_render' ), 99 );
		}
	}

	/**
	 * Save user fields
	 *
	 * @access public
	 * @action personal_options_update, edit_user_profile_update
	 */
	public static function edit_user_profile_update( $user_id ) {
		if ( current_user_can( 'edit_user', $user_id ) ) {
			update_user_meta( $user_id, self::$meta_key, ( ( isset( $_POST[ self::$meta_key ] ) ) ? '1' : '0' ) );
		}
	}

	public static function personal_options() {
		self::$show = get_user_meta( get_current_user_id(), self::$meta_key, true );
		$checked = ( ! empty( self::$show ) ) ? ' checked' : '';
		?>
			<table class="form-table">
				<tr>
					<th>Visual Grid</th>
					<td>
						<label for="<?php echo self::$meta_key; ?>">
							<input type="checkbox" name="<?php echo self::$meta_key; ?>" id="<?php echo self::$meta_key; ?>" value="1"<?php echo $checked; ?>>
							Show Visual Grid when viewing site
						</label>
					</td>
				</tr>
			</table>
		<?php
	}

	public static function body_class( $classes ) {
		if ( is_user_logged_in() ) {
			self::$show = get_user_meta( get_current_user_id(), self::$meta_key, true );
			if ( ! empty( self::$show ) ) {
				$classes = array_merge( $classes, array( self::$body_class ) );
			}
		}
		return $classes;
	}

	public static function admin_menu_bar( $wp_admin_bar ) {
		if ( ! is_admin() ) {
			$wp_admin_bar->add_node( array(
				'id'    => 'visual-grid',
				'title' => '<span>Visual Grid</span>' . self::$icons['grid_on'] . self::$icons['grid_off'],
				'href'  => '#toggle-visual-grid',
				'meta'  => array(
					'class' => 'visual-grid-toggle',
					'title' => 'Toggle Visual Grid',
				),
				'parent' => 'top-secondary',
			) );
		}
	}

	public static function wp_head() {
		?>
			<style type="text/css">
				body:not(.<?php echo self::$body_class; ?>)::before { display:none; }
				#wp-admin-bar-visual-grid svg { display:inline-block; vertical-align:middle; height:16px; width:16px; margin-left:3px; margin-top:-3px; }
				#wp-admin-bar-visual-grid .icon-grid-on { display:none; }
				body.<?php echo self::$body_class; ?> #wp-admin-bar-visual-grid .icon-grid-off { display:none; }
				body.<?php echo self::$body_class; ?> #wp-admin-bar-visual-grid .icon-grid-on { display:inline; }
				@media (max-width: 782px) {
					#wpadminbar #wp-admin-bar-visual-grid { display: block; width: 52px; text-align: center; }
					#wpadminbar #wp-admin-bar-visual-grid svg { height: 28px; width: 28px; }
					#wpadminbar #wp-admin-bar-visual-grid span { display: none; }
				}
			</style>
		<?php
	}

	public static function wp_after_admin_bar_render() {
		?>
			<script>
				(function(node) {
					var shown  = <?php echo self::$show ? 'true' : 'false'; ?>;
					var xhruri = '<?php echo admin_url( 'admin-ajax.php' ) . '?' . http_build_query( array( 'action' => 'toggle_visual_grid' ) ); ?>';
					if (node.addEventListener && node.classList) {
						node.addEventListener('click', function(e) {
							e.preventDefault();
							var xhr = new XMLHttpRequest();
							shown = (shown === true) ? false : true;
							xhr.open('POST', xhruri + '&<?php echo self::$meta_key; ?>=' + shown);
							xhr.send();
							document.body.classList.toggle('<?php echo self::$body_class; ?>');
							document.body.focus();
						});
					} else {
						node.parentNode.parentNode.removeChild(node.parentNode);
					}
				})(document.querySelector('#wp-admin-bar-visual-grid > a'));
			</script>
		<?php
	}

	public static function wp_ajax_toggle_visual_grid() {
		if ( isset( $_GET[ self::$meta_key ] ) && ! empty( $_GET[ self::$meta_key ] ) ) {
			$shown = ( isset( $_GET[ self::$meta_key ] ) && $_GET[ self::$meta_key ] === 'true' ) ? '1' : '0';
			update_user_meta( get_current_user_id() , self::$meta_key, $shown );
			return wp_send_json_success( ( $shown ) ? 'activated' : 'deactivated' );
		}

		return wp_send_json_error();
	}
}
