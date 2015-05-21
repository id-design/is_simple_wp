( function( $ ) {
	var $window, $body, $sidebar,
		windowHeight, bodyHeight, sidebarHeight,
		top = false, bottom = false,
		topOffset = 0, lastWindowPos = 0;
	
	// Controla o visual do tema dependendo da largura da janela
	function resize() {
		windowWidth   = $window.width();

		if ( 900 > windowWidth ) {
			top = bottom = false;
			$sidebar.removeAttr( 'style' );
		} else {
			$sidebar.find( '#nav-header' ).removeAttr( 'style' );
		}
	}
	
	// Controla a posição da sidebar conforme o scroll da janela
	function scroll() {
		windowWidth			= $window.width();
		windowHeight		= $window.height();
		windowPos			= $window.scrollTop();
		
		bodyHeight			= $body.height();
		headerHeight		= $header.height();
		footerHeight		= $footer.height();
		
		mainOffsetTop		= $main.offset().top;
		mainHeight			= $main.height();
		
		sidebarOffsetTop	= $sidebar.offset().top;
		sidebarHeight		= $sidebar.height();
		
		margin				= mainOffsetTop - headerHeight;
		offsetTop			= mainOffsetTop - margin - headerHeight;
		
		scrollUp			= windowPos > lastWindowPos ? true : false;
		scrollDown			= windowPos < lastWindowPos ? true : false;
		
		if ( 900 > windowWidth ) {
			return;
		}
		
		$( 'body' ).append('<div id="vars"></div>');
		$( '#vars' ).attr( 'style', 'position: fixed; top: 0; left: 0; z-index: 99999;' )
			.append('<div id="windowPos"></div>')
			.append('<div id="sidebarOps"></div>')
			.append('<div id="mainOps"></div>');
		$( '#windowPos' )
			.text(
				'windowHeight = ' + windowHeight
				+ ' | ' +
				'windowPos = ' + windowPos
				+ ' | ' +
				'lastWindowPos = ' + lastWindowPos
			);
		$( '#sidebarOps' )
			.text(
				'sidebarOffsetTop = ' + sidebarOffsetTop
				+ ' | ' +
				'sidebarHeight = ' + sidebarHeight
			);
		$( '#mainOps' )
			.text(
				'mainOffsetTop = ' + mainOffsetTop
				+ ' | ' +
				'mainHeight = ' + mainHeight
			);
		
		if ( windowPos ) {
		    $header.attr( 'style', 'position: fixed; top: 0; width: 100%; z-index: 9999;' );
		    $( '#main' ).attr( 'style', 'margin-top: ' + mainOffsetTop + 'px;' );
		}
		
		// Se a sidebar for maior que o tamanho da janela...
		if ( mainHeight > windowHeight ) {
			if ( scrollUp ) {
				if ( top ) {
					top = false;
					topOffset = ( windowPos > margin ) ? mainOffsetTop : 0;
					$sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
				} else if ( ! bottom && windowPos > sidebarHeight + mainOffsetTop - windowHeight && sidebarHeight + mainOffsetTop < bodyHeight ) {
					bottom = true;
					$sidebar.attr( 'style', 'position: fixed; bottom: 0;' );
				} else if ( bottom && windowPos > mainHeight + mainOffsetTop - windowHeight && sidebarHeight + mainOffsetTop < bodyHeight ) {
					bottomOffset = mainHeight - windowPos;
					$sidebar.attr( 'style', 'bottom: ' + topOffset + 'px;' );
				}
			} else if ( scrollDown ) {
				if ( bottom ) {
					bottom = false;
					$sidebar.attr( 'style', 'bottom: 0;' );
				} else if ( ! top && windowPos < mainHeight - sidebarHeight && sidebarHeight + mainOffsetTop < bodyHeight ) {
					top = true;
					topOffset = mainOffsetTop;
					$sidebar.attr( 'style', 'position: fixed; top: ' + topOffset + 'px;' );
				} else if ( top && windowPos < mainHeight - sidebarHeight && sidebarHeight + mainOffsetTop < bodyHeight ) {
                    topOffset = windowPos;
                    $sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
                }
			} else {
				top = bottom = false;
				topOffset = ( sidebarOffsetTop > mainOffsetTop ) ? sidebarOffsetTop - mainOffsetTop : 0;
				$sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
			}
		} else if ( ! top ) {
			top = true;
			$sidebar.attr( 'style', 'position: fixed;' );
		}

		lastWindowPos = windowPos;
	}
	
	// Executa as funções resize e scroll
	function resize_and_scroll() {
		resize();
		scroll();
	}
	
	$( document ).ready( function() {
		$window	 = $( window );
		$body	 = $( document.body );
		$header  = $( '#header' ).first();
		$main = $( '#main' ).first();
		$sidebar = $( '#sidebar' ).first();
		$footer  = $( '#footer' ).first();
		
		// Executando a função resize_and_scroll
		resize_and_scroll();
		$window.scroll( resize_and_scroll );
		$window.resize( resize_and_scroll );
		
		// Função ao clicar no botão #toggle
		$( '#toggle' ).click( function() {
			$( '#nav-header' ).slideToggle();
		} );
		
		// Ajustes da paginação dos artigos
		$( '.pagination .prev, .pagination .next' ).addClass( 'button' ).removeClass( 'page-numbers' );
		
		// Adicionando a classe .radius2
		$( 'form, fildset, input, button, .button, .input-group, textarea, pre, select' ).addClass( 'radius2' );
		
		// Adicionando a classe .transition
		$( 'a, .widget li' ).addClass( 'transition' );
		$( '.button, button, html input[type="button"], input[type="reset"], input[type="submit"]' ).addClass( 'transition' );
		
		// Ajuste de imagens nas postagens
		$( 'a:has( img )' ).addClass( 'img-link' );
		$( '.img-link' ).each( function () {
			var link = $( this );
			var img = link.find( 'img' );
			
			img.addClass( 'transition' );
			
			if ( img.hasClass( 'aligncenter' ) ) {
				img.removeClass( 'aligncenter' );
				link.addClass( 'aligncenter' );
			}
			
			if ( img.hasClass( 'alignleft' ) ) {
				img.removeClass( 'alignleft' );
				link.addClass( 'alignleft' );
			}
			
			if ( img.hasClass( 'alignright' ) ) {
				img.removeClass( 'alignright' );
				link.addClass( 'alignriht' );
			}
		} );
		
		// Ajustes dos comentários
		$( '#comments .avatar' ).addClass( 'alignleft' );
		$( '.comment-body, .comment-content' ).addClass( 'inner' );
		$( '.comment-content' ).addClass( 'radius2' );
		$( '.reply' ).addClass( 'clear' );
		$( 'a.comment-reply-link' ).addClass( 'button radius2' );
		
		// Ajustes do header-menu
		$( '#header-menu .sub-menu' ).hide();
		$( '#header-menu .menu-item-has-children > a' ).after( '<button class="toggle-sub-menu transition" type="button"><i class="fa fa-angle-down"></i></button>' );
		$( '.toggle-sub-menu' ).click( function() {
			var _this = $( this );
			
			_this.children( 'i' ).toggleClass( 'fa-angle-down' );
			_this.children( 'i' ).toggleClass( 'fa-angle-up' );
			_this.next( '.sub-menu' ).slideToggle();
		} );
		
		// Ajustes dos ícones para os post-details
		$( '.post-categ > a' ).prepend( '<i class="fa fa-folder-open"></i> ' );
		$( '.post-author > a' ).prepend( '<i class="fa fa-user"></i> ' );
		$( '.post-date > time' ).prepend( '<i class="fa fa-clock-o"></i> ' );
		$( '.post-comments > a' ).prepend( '<i class="fa fa-comments"></i> ' );
		$( '.edit-link > a' ).prepend( '<i class="fa fa-pencil"></i> ' );
		
		// Ajustes para o lightbox
		var content_id = $( 'article.page, article.post' ).attr( 'id' );
		var link_img = $( '.page #principal .post-content a:has( img ), .single #principal .post-content a:has( img )' );
		
		link_img.attr( 'data-lightbox', content_id );
		
		link_img.each( function() {
			if ( $( this ).parent( 'figure' ) ) {
				var figure = $( this ).parent( 'figure' );
				var figcaption = figure.children( 'figcaption' );
				var caption_txt = figcaption.text();
				
				figcaption.parent().children( 'a' ).attr( 'data-title', caption_txt );
			}
		} );
	} );

} )( jQuery );