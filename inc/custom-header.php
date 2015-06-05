<?php
/**
 * Cabeçalho Personalizado para o tema
 *
 * @package Estúdio Viking
 * @since 1.0
 */


/**
 * Configuração principal para cabeçalho personalizado no tema
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_custom_header_setup() {
	add_theme_support( 'custom-header', array(
		// Imagem e cor de texto padrão
		//'default-image'          => $headers_uri . 'logo_header.png',
		//'default-text-color'     => '000',
		
		// Tamanho padrão para as imagens
		'width'                  => 340,
		'height'                 => 50,
		
		// Opções extras
		'random-default'         => false,	// Cabeçalho aleatório
		'flex-height'            => false,	// Altura flexível
		'flex-width'             => true,	// Largura flexível
		'header-text'            => true,	// Habilita suporte a personalização do texto
		'uploads'                => true,	// Permite upload de imagens
		
		// Estilo que vai apareceer no head do site
		'wp-head-callback'       => 'issimple_header_style',
	) );
	
	/**
	 * Pacote de imagens personalizadas para o cabeçalho
	 * Remova os comentários para habilitar
	 * ----------------------------------------------------------------------------
	 */
	
	/**
	 * Diretório dos cabeçalhos personalizados
	 * %s é um placeholder para o diretório URI do tema.
	 */
	$headers_uri = '%s/img/headers/';
	register_default_headers( array(
		'logo_header' => array(
			'url'           => $headers_uri . 'logo_header.png',
			'thumbnail_url' => $headers_uri . 'logo_header-thumbnail.png',
			'description'   => _x( 'Estúdio Viking Brand', 'header image description', 'issimple' )
		),
	) );
}
add_action( 'after_setup_theme', 'issimple_custom_header_setup', 11 );


/**
 * Elementos que vão aparecer no head do site após personalização
 * na área de administração do cabeçalho personalizado do site.
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_header_style() {
	$header_image = get_header_image();
	$image_width_px  = get_custom_header()->width;
	$image_width_rem  = ( $image_width_px / 10 );
	$image_height_px  = get_custom_header()->height;
	$image_height_rem = ( $image_height_px / 10 );
	$text_color   = get_header_textcolor();

	// Se chegarmos a este ponto, temos estilos personalizados.
	?>
	<style type="text/css" id="issimple-header-css">
	<?php
		// Se a imagem estiver sendo exibida...
		if ( ! empty( $header_image ) ) :
	?>
		#logo-header {
			background: url(<?php header_image(); ?>) no-repeat center top;
			-webkit-background-size: contain;
			-moz-background-size:    contain;
			-o-background-size:      contain;
			background-size:         contain;
			padding-top: <?php echo $image_height_px; ?>px;
			padding-top: <?php echo $image_height_rem; ?>rem;
			width: <?php echo $image_width_px; ?>px;
			width: <?php echo $image_width_rem; ?>rem;
			line-height: 0;
			height: 0;
			text-indent: -99999px;
			display: block;
		}
	<?php endif;
		
		// Se o texto está sendo exibido...
		if ( display_header_text() ) :
	?>
		#name a { color: #<?php echo esc_attr( $text_color ); ?>; }
	<?php endif;
		
		// Se o texto e a imagem estiverem sendo exibidos...
		if ( display_header_text() && ! empty( $header_image ) ) :
	?>
		
	<?php endif;
		
		// Se apenas o texto estiver sendo exibido...
		if ( display_header_text() && empty( $header_image ) ) :
	?>
		
	<?php endif;
		
		// Se não estiver sendo exibida a imagem...
		if ( empty( $header_image ) ) :
	?>
		#logo-header {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute !important;
		}
	<?php endif;
		
		// Se não estiver sendo exibida o texto...
		if ( ! display_header_text() ) :
	?>
		#header-txt {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute !important;
		}
	<?php endif; ?>
	</style>
	<?php
}