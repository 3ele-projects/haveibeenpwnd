<?php
/**
 * Plugin Name:     Haveibeenpwnd
 * Plugin URI:      www.lightweb-media.de
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Sebastian Weiss
 * Author URI:      www.lightweb-media.de
 * Text Domain:     haveibeenpwnd
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Haveibeenpwnd
 */

// Your code starts here.


class HaveIBeenPwned {
	private $have_i_been_pwned__options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'have_i_been_pwned__add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'have_i_been_pwned__page_init' ) );
	}

	public function have_i_been_pwned__add_plugin_page() {
		add_options_page(
			'have i been pwned?', // page_title
			'have i been pwned?', // menu_title
			'manage_options', // capability
			'have-i-been-pwned', // menu_slug
			array( $this, 'have_i_been_pwned__create_admin_page' ) // function
		);
	}

	public function have_i_been_pwned__create_admin_page() {
		$this->have_i_been_pwned__options = get_option( 'have_i_been_pwned__option_name' ); ?>

		<div class="wrap">
			<h2>have i been pwned?</h2>
            <p>Schützen Sie ihre Domain und Ihre Email Accounts</p>
            <p>Schützen Sie ihre Domain und Ihre Email Accounts</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'have_i_been_pwned__option_group' );
					do_settings_sections( 'have-i-been-pwned-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function have_i_been_pwned__page_init() {
		register_setting(
			'have_i_been_pwned__option_group', // option_group
			'have_i_been_pwned__option_name', // option_name
			array( $this, 'have_i_been_pwned__sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'have_i_been_pwned__setting_section', // id
			'Settings', // title
			array( $this, 'have_i_been_pwned__section_info' ), // callback
			'have-i-been-pwned-admin' // page
		);

		add_settings_field(
			'have_i_been_pwned_verification_0', // id
			'have-i-been-pwned-verification', // title
			array( $this, 'have_i_been_pwned_verification_0_callback' ), // callback
			'have-i-been-pwned-admin', // page
			'have_i_been_pwned__setting_section' // section
		);

		add_settings_field(
			'have_i_been_pwned_verification_value_1', // id
			'have-i-been-pwned-verification-value', // title
			array( $this, 'have_i_been_pwned_verification_value_1_callback' ), // callback
			'have-i-been-pwned-admin', // page
			'have_i_been_pwned__setting_section' // section
		);
	}

	public function have_i_been_pwned__sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['have_i_been_pwned_verification_0'] ) ) {
			$sanitary_values['have_i_been_pwned_verification_0'] = sanitize_text_field( $input['have_i_been_pwned_verification_0'] );
		}

		if ( isset( $input['have_i_been_pwned_verification_value_1'] ) ) {
			$sanitary_values['have_i_been_pwned_verification_value_1'] = $input['have_i_been_pwned_verification_value_1'];
		}

		return $sanitary_values;
	}

	public function have_i_been_pwned__section_info() {
		
	}

	public function have_i_been_pwned_verification_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="have_i_been_pwned__option_name[have_i_been_pwned_verification_0]" id="have_i_been_pwned_verification_0" value="%s">',
			isset( $this->have_i_been_pwned__options['have_i_been_pwned_verification_0'] ) ? esc_attr( $this->have_i_been_pwned__options['have_i_been_pwned_verification_0']) : ''
		);
	}

	public function have_i_been_pwned_verification_value_1_callback() {
		printf(
			'<input type="checkbox" name="have_i_been_pwned__option_name[have_i_been_pwned_verification_value_1]" id="have_i_been_pwned_verification_value_1" value="1" %s>',
			( isset( $this->have_i_been_pwned__options['have_i_been_pwned_verification_value_1'] ) && $this->have_i_been_pwned__options['have_i_been_pwned_verification_value_1'] === 'have_i_been_pwned_verification_value_1' ) ? 'checked' : ''
		);
	}

}
if ( is_admin() )
	$have_i_been_pwned_ = new HaveIBeenPwned();

function add_hibp_meta_tags() {
    $have_i_been_pwned__options = get_option( 'have_i_been_pwned__option_name' );
    if ($have_i_been_pwned__options):
        $have_i_been_pwned_verification = $have_i_been_pwned__options['have_i_been_pwned_verification_0'];
        $have_i_been_pwned_active = $have_i_been_pwned__options['have_i_been_pwned_verification_value_1'];
        if (isset($have_i_been_pwned_verification) && isset($have_i_been_pwned_active)):
            echo '<meta name="have-i-been-pwned-verification" value="'.$have_i_been_pwned_verification.'"> ';
        endif;
    endif;

    ?>

    <?php }
    add_action('wp_head', 'add_hibp_meta_tags');
