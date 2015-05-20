<?php
/**
 * Funções para incrementar o formulário de contato em qualquer lugar do tema ou post
 * 
 * @package Estúdio Viking
 * @since 1.0
 */

/**
 * Código HTML para o formulário de contato
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function html_contact_form() {
	$html = '<form id="contact-form" action="' . esc_url( get_the_permalink() ) . '#contact-form" method="post">' .
				'<div class="form-group">' .
					'<label for="cf-name">' . __( 'Name', 'issimple' ) . ' <span class="required">*</span></label>' .
					'<input type="text" name="cf-name" placeholder="' . __( 'Your name', 'issimple' ) . '" value="' . ( isset( $_POST['cf-name'] ) ? esc_attr( $_POST['cf-name'] ) : '' ) . '" size="40" required>' .
				'</div>' .
				'<div class="form-group">' .
					'<label for="cf-email">' . __( 'Email', 'issimple' ) . ' <span class="required">*</span></label>' .
					'<input type="email" name="cf-email" placeholder="email@email.com" value="' . ( isset( $_POST['cf-email'] ) ? esc_attr( $_POST['cf-email'] ) : '' ) . '" size="40" required>' .
				'</div>' .
				'<div class="form-group">' .
					'<label for="cf-subject">' . __( 'Subject', 'issimple' ) . ' <span class="required">*</span></label>' .
					'<input type="text" name="cf-subject" placeholder="' . __( 'What is the subject of the message?', 'issimple' ) . '" value="' . ( isset( $_POST['cf-subject'] ) ? esc_attr( $_POST['cf-subject'] ) : '' ) . '" size="40" required>' .
				'</div>' .
				'<div class="form-group">' .
					'<label for="cf-message">' . __( 'Message', 'issimple' ) . ' <span class="required">*</span></label>' .
					'<textarea cols="45" rows="8" name="cf-message" placeholder="' . __( 'Enter your message here.', 'issimple' ) . '" required>' . ( isset( $_POST['cf-message'] ) ? esc_attr( $_POST['cf-message'] ) : '' ) . '</textarea>' .
				'</div>' .
				'<p class="form-submit"><input type="submit" name="cf-submitted" value="' . __( 'Send', 'issimple' ) . '"></p>' .
			'</form><!-- #contact-form -->';
	
	echo $html;
}


/**
 * Altera o formato do email para HTML
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function set_html_content_type() {
	return 'text/html';
}
add_filter( 'wp_mail_content_type', 'set_html_content_type' );


/**
 * Código de envio do formulário de contato
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function deliver_contact_form_mail() {
	// Se o botão de envio for clicado, envia o email
	if ( isset( $_POST['cf-submitted'] ) ) :
		$name    = sanitize_text_field( $_POST['cf-name'] );
		$email   = sanitize_email( $_POST['cf-email'] );
		$subject = sanitize_text_field( $_POST['cf-subject'] );
		$message = esc_textarea( $_POST['cf-message'] );
		
		// Endereço de e-mail do administrador
		$to = get_option( 'admin_email' );
		
		$headers[] = "From: $name <$email>";
		$headers[] = "Reply-To: $name <$email>";
		
		// Mensagens do formulário
		$success = __( 'Thanks for contacting us, expect a response soon.', 'issimple' );
		$error = __( 'An unexpected error occurred. Try again later.', 'issimple' );
		
		// Se o e-mail for enviado, exibe uma mensagem de sucesso
        if ( wp_mail( $to, $subject, $message, $headers ) ) :
			echo '<div class="form-message success inner radius2"><p>' . $success . '</p></div>';
		else :
			echo '<div class="form-message error inner radius2"><p>' . $error . '</p></div>';
		endif;
	endif;
}


/**
 * Shortcode para inserir o formulário de contato
 * 
 * @since Estúdio Viking 1.0
 * @uses [issimple_contact_form]
 * ----------------------------------------------------------------------------
 */
function render_issimple_contact_form() {
	ob_start();
	
	deliver_contact_form_mail();
	html_contact_form();
	
	return ob_get_clean();
}
add_shortcode( 'issimple_contact_form', 'render_issimple_contact_form' );
