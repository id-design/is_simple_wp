<?php
/**
 * Options to customize IS Simple Wordpress Theme.
 *
 * @package		WordPress
 * @subpackage	IS Simple
 * @since		IS Simple 1.0
 */


/**
 * Require Theme Options Class
 *
 * @since	IS Simple 1.0
 */
require_once get_template_directory() . '/inc/classes/class-theme-options.php';


if ( ! function_exists( 'issimple_theme_options' ) ) :
/**
 * IS Simple Theme Options Setup
 *
 * @since	IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_theme_options() {
	$settings = new ISSimple_Theme_Options(
		'issimple-settings',			// Slug/ID of the Settings Page (Required)
		'IS Simple Theme Settings',		// Settings page name (Required)
		'manage_options'				// Page capability (Optional) [default is manage_options]
	);

	$settings->set_tabs( array(
		array(
			'id' => 'issimple_general_options',					// Slug/ID of the Settings tab (Required)
			'title' => __( 'General Settings', 'issimple' ),	// Settings tab title (Required)
		),
		array(
			'id' => 'issimple_style_options',					// Slug/ID of the Settings tab (Required)
			'title' => __( 'Style Settings', 'issimple' ),	// Settings tab title (Required)
		)
	) );

	$default_footer_text = sprintf(
		__( '&copy; %1$d %2$s - %3$s %4$s %5$s %6$s %7$s.', 'issimple' ),
		date( 'Y' ),
		do_shortcode( '[home-link]' ),
		__( 'All rights reserved.', 'issimple' ),
		__( 'Powered by', 'issimple' ),
		sprintf( __( '<a href="%s" rel="nofollow" target="_blank">%s</a>', 'issimple' ),
			'https://github.com/id-design/is_simple_wp',
			'ID Design' ),
		__( 'on', 'issimple' ),
		sprintf( __( '<a href="%s" rel="nofollow" target="_blank">%s</a>', 'issimple' ),
			'http://wordpress.org/',
			'WordPress' )
	);

	$settings->set_fields( array(
		'issimple_general_fields_section' => array(													// Slug/ID of the section (Required)
			'tab'		=> 'issimple_general_options',												// Tab ID/Slug (Required)
			'title'		=> __( 'General options to customize IS Simple WP Theme.', 'issimple' ),	// Section title (Required)
			'fields'	=> array(																	// Section fields (Required)
				// Footer text.
				array(
					'id'			=> 'issimple_options_footer_text',
					'label'			=> __( 'Footer Text', 'issimple' ),
					'type'			=> 'textarea',
					'default'		=> $default_footer_text,
					'description'	=> __( 'Type the copyright text appears in the footer.', 'issimple' )
				)
			)
		),
		'issimple_style_fields_section' => array(													// Slug/ID of the section (Required)
			'tab'		=> 'issimple_style_options',												// Tab ID/Slug (Required)
			'title'		=> __( 'Style options to customize IS Simple WP Theme.', 'issimple' ),		// Section title (Required)
			'fields'	=> array(																	// Section fields (Required)
				// Header Navbar Style
				array(
					'id'			=> 'issimple_header_navbar_style',
					'label'			=> __( 'Header Navbar Style', 'issimple' ),
					'type'			=> 'select',
					'default'		=> 'navbar-inverse',
					'options'		=> array(
						'navbar-default' => __( 'Navbar Default', 'issimple' ),
						'navbar-inverse' => __( 'Navbar Inverse', 'issimple' )
					),
					'description'	=> __( 'Select the Header Navbar Style you want.', 'issimple' )
				),
				// Header Navbar Fixing
				array(
					'id'			=> 'issimple_header_navbar_fixing',
					'label'			=> __( 'Header Navbar Fixing', 'issimple' ),
					'type'			=> 'select',
					'default'		=> 'navbar-fixed-top',
					'options'		=> array(
						'none'				=> __( 'None', 'issimple' ),
						'navbar-static-top'	=> __( 'Navbar Static Top', 'issimple' ),
						'navbar-fixed-top'	=> __( 'Navbar Fixed Top', 'issimple' )
					),
					'description'	=> __( 'Select the Header Navbar Fixing you want.', 'issimple' )
				)
			)
		)
	) );
}
endif; // issimple_theme_options
add_action( 'init', 'issimple_theme_options', 1 );


/**
 * Bootstrap Navbar Style to header navigation
 *
 * @since	IS Simple 1.0
 *
 * @return	string	Bootstrap Navbar Style Class
 */
function bootstrap_header_navbar_style() {
	global $issimple_style_options;

	$navbar_style = $issimple_style_options['issimple_header_navbar_style'];
	$navbar_style = ( isset( $navbar_style ) ) ? esc_attr( $navbar_style ) : 'navbar-inverse';

	return apply_filters( 'issimple_header_navbar_style', $navbar_style );
}


/**
 * Bootstrap Navbar Fixing to header navigation
 *
 * @since	IS Simple 1.0
 *
 * @return	string	Bootstrap Navbar Fixing Class
 */
function bootstrap_header_navbar_fixing() {
	global $issimple_style_options;

	$navbar_fixing = $issimple_fixing_options['issimple_header_navbar_fixing'];

	if ( isset( $navbar_fixing ) ) {
		$navbar_fixing =  ( $navbar_fixing != 'none' ) ? esc_attr( $navbar_fixing ) : '';
	} else {
		$navbar_fixing = 'navbar-fixed-top';
	}

	return apply_filters( 'issimple_header_navbar_fixing', $navbar_fixing );
}


/**
 * Adiciona o menu de personalização do tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 *//*
function issimple_options_menu_pages() {
	// Menu de Opções Gerais
	add_theme_page(
		__( 'IS Simple General Options', 'issimple' ),	// Título da página
		__( 'IS Simple Options', 'issimple' ),			// Título do menu
		'edit_theme_options',							// Capacidade
		'issimple_general_options_page',						// Termo único do Menu
		'issimple_general_options_page_screen'//,				// Função de exibição
		//'',												// Ícone
		//61												// Posição
	);
	/*
	// Menu de Estilos
	add_submenu_page(
		'issimple_general_options_page',						// Termo único do menu pai
		__( 'IS Simple Style Options', 'issimple' ),	// Título da página
		__( 'Style Options', 'issimple' ),			// Título do sub-menu
		'edit_theme_options',							// Capacidade
		'issimple_style_options_page',						// Termo único do sub-menu
		'issimple_style_options_page_screen'					// Função de exibição
	);*//*
}
add_action( 'admin_menu', 'issimple_options_menu_pages' );


/**
 * Registro das opções do menu de personalização do tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 *//*
function issimple_options_init(){
	// Registro das configurações
	register_setting(
		'issimple_general_options',	// Grupo de opções
		'issimple_theme_options'		// Nome da opção
		//'issimple_options_validate'	// Função para validar opções
	);
	
	/**
	 * Seção de Opções Gerais
	 * ----------------------------------------------------------------------------
	 *//*
	add_settings_section(
		'issimple_general_options_page_section',			// Id
		__( 'General Options', 'issimple' ),	// Título
		'issimple_general_settings_section_callback',		// Função para exibição da seção
		'issimple_general_options'						// Grupo de opções em que a seção é exibida
	);
	
	// Texto do rodapé
	add_settings_field(
		'issimple_options_footer_text',							// Id
		__( 'Custom footer-text', 'issimple' ),			// Título
		'issimple_textarea_field_render',							// Função de exibição do campo
		'issimple_general_options',								// Grupo de opções em que o campo é exibido
		'issimple_general_options_page_section',					// Seção de opções em que o campo é exibido
		array(												// Argumentos do campo
			'id'			=> 'issimple_options_footer_text',
			'desc'			=> __( 'Type your custom copyright text displayed on footer', 'issimple' ),
			'field_class'	=> 'large-text',
			'rows'			=> 3,
			'default'		=> sprintf( __( '&copy; %1$d %2$s - %3$s %4$s %5$s %6$s %7$s.', 'issimple' ),
									date( 'Y' ),
									do_shortcode( '[home-link]' ),
									__( 'All rights reserved.', 'issimple' ),
									__( 'Powered by', 'issimple' ),
									sprintf( __( '<a href="%s" rel="nofollow" target="_blank">%s</a>', 'issimple' ),
										'https://github.com/id-design/is_simple_wp',
										'ID Design' ),
									__( 'on', 'issimple' ),
									sprintf( __( '<a href="%s" rel="nofollow" target="_blank">%s</a>', 'issimple' ),
										'http://wordpress.org/',
										'WordPress' ) )
		)
	);
}
add_action( 'admin_init', 'issimple_options_init' );


/**
 * Função para exibição da seção de opções gerais do tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 *//*
function issimple_general_settings_section_callback( $arg ) {
	echo $output = '<p>' . __( 'General options to customize IS Simple theme.', 'issimple' ) . '</p>';
}


/**
 * Função para a exibição de textarea gerais
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 *//*
function issimple_textarea_field_render( $args ) {
	global $issimple_options;
	
	$id			= ( $args['id'] ) ? $args['id'] : '';
	$slug		= 'issimple_theme_options[' . $id . ']';
	$desc		= $args['desc'];
	$class		= ( $args['field_class'] ) ? 'class="' . $args['field_class'] . '" ' : '';
	$cols		= ( $args['cols'] ) ? $args['cols'] : 50;
	$rows		= ( $args['rows'] ) ? $args['rows'] : 10;
	$default	= $args['default'];
	$value		= $issimple_options[ $id ];
	
	if ( ! isset( $value ) ) $value = $default;
	
	$field_output  = '<textarea id="' . esc_attr( $slug ) . '" name="' . esc_attr( $slug ) . '" ' . $class . 'cols="' . esc_attr( $cols ) . '" rows="' . esc_attr( $rows ) . '">';
	$field_output .= esc_textarea( $value );
	$field_output .= '</textarea>';
	
	if ( $desc ) :
		$field_output .= '<p id="' . esc_attr( $slug ) . '-description" class="description">' . $desc .'</p>';
	endif;
	
	if ( $default ) :
		$field_output .= '<p id="' . esc_attr( $slug ) . '-default"><strong>Default: </strong>' . esc_html( $default ) . '</p>';
		
		add_filter( 'default_option_' . $id, $default, 10, 1 );
	endif;
	
	echo $field_output;
}


/**
 * Cria a página de opções gerais do tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 *//*
function issimple_general_options_page_screen() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	
	?>
	<div class="wrap">
		<?php
			$current_tab = ( ! empty( $_GET['tab'] ) ) ? $_GET['tab'] : 'issimple_general_options';
			$current = ( $current_tab == 'issimple_general_options' ) ? ' nav-tab-active' : '';
		?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=issimple_general_options_page&amp;tab=issimple_general_options" class="nav-tab issimple_general_options<?php echo $current; ?>">Opções Gerais</a>
		</h2>
		<?php
			if ( false !== $_REQUEST['settings-updated'] ) :
				settings_errors();
			endif;
		?>
		
		<form method="post" action="options.php">
			<?php
				settings_fields( 'issimple_general_options' );
				do_settings_sections( 'issimple_general_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}


/**
 * Cria a página de opções de estilo do tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 *//*
function issimple_style_options_page_screen() {
	echo 'Style Page';
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 *//*
function issimple_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}*/


$issimple_options = get_option( 'issimple_general_options' );
$issimple_style_options = get_option( 'issimple_style_options' );
