<?php
/**
 * Funções para algumas utilidades básicas no tema
 *
 * @package Estúdio Viking
 * @since 1.0
 */

 
/**
 * Converte cores do padrão hexadecimal para rgb
 * ----------------------------------------------------------------------------
 */
function hex2rgb( $hex, $implode = true ) {
	$hex = str_replace( '#', '', $hex );
	
	if ( strlen( $hex ) == 3 ) :
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	else :
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	endif;
	
	$rgb = array( $r, $g, $b );
	
	if ( $implode === true ) $rgb = implode( ',', $rgb );	// Retorna o valor de rgb separado por vírgulas
	
	return $rgb;
}

/**
 * Converte cores do padrão rgb para hexadecimal
 * ----------------------------------------------------------------------------
 */
function rgb2hex( $rgb ) {
	$hex  = '#';
	$hex .= str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );
	
	return $hex;	// Retorna o valor de hex incluindo o símbolo (#)
}

/**
 * Converte variáveis de cores no padrão hexadecimal/alpha para rgba
 * ----------------------------------------------------------------------------
 */
function hexalpha2rgba( $hexalpha ) {
	$hexalpha_color = $hexalpha['color'];
	$hexalpha_color_rgb = hex2rgb( $hexalpha_color );
	$hexalpha_alpha = $hexalpha['alpha'];
	$rgba = $hexalpha_color_rgb . ',' . $hexalpha_alpha;
	
	return $rgba;	// Retorna o valor de rgba separado por vírgulas
}

/**
 * Função para leitura de diretórios
 * ----------------------------------------------------------------------------
 */
function issimple_readdir( $dir, $type = FALSE ) {
	$files = array();
	$ds = DIRECTORY_SEPARATOR;
	
	// Se não existir o diretório...
	if ( ! is_dir( $dir ) ) return false;
	
	// Abrindo diretório...
	$odir = @opendir( $dir );
	
	// Se falhar ao abrir o diretório...
	if ( ! $odir ) return false;
	
	// Construindo o array de arquivos...
	while ( ( $file = readdir( $odir ) ) !== false ) :
		// Ignora os resultados "." e ".." ...
		if ( $file == '.' || $file == '..' ) continue;
		
		$slug = explode( '.', $file );
		$ext = ( count( $slug ) == 1 ) ? 'dir' : end( $slug );					// Extensão do arquivo
		$path = ( count( $slug ) == 1 ) ? $dir . $file . $ds : $dir . $file;	// Caminho do arquivo
		$slug = str_replace( '.' . $ext, '', $file );							// Nome do arquivo
		
		if ( is_dir( $path ) ) :
			$files[$slug] = array(
				'type' 	=> $ext,
				'name' 	=> $slug,
				'path' 	=> $path,
				'files' => read_dir( $path, $type )
			);
			continue;
		endif;
		
		// Pegar todos os arquivos
		if ( empty( $type ) ) :
			$files[$slug] = array(
				'type' => $ext,
				'name' => $slug,
				'path' => $path
			);
			continue;
		endif;
		
		// Pegar apenas os diretórios
		if ( $type === 1 ) :
			if ( is_dir( $path ) ) :
				$files[$slug] = array(
					'type' 	=> $ext,
					'name' 	=> $slug,
					'path' 	=> $path,
					'files' => read_dir( $dir, $type )
				);
			endif;
			continue;
		endif;
		
		// Se $type for um array
		if ( is_array( $type ) ) :
			if ( in_array( $ext, $type ) ) :
				$files[$slug] = array(
					'type' => $ext,
					'name' => $slug,
					'path' => $path
				);
			endif;
			continue;
		endif;
		
		// Se $type for uma string
		if ( $ext == $type ) :
			$files[$slug] = array(
				'type' => $ext,
				'name' => $slug,
				'path' => $path
			);
			continue;
		endif;
	endwhile;
	
	// Fechando diretório...
	closedir( $odir );
	
	return $files;
}
















?>