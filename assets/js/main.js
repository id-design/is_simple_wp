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
		
		scrollUp			= windowPos < lastWindowPos ? true : false;
		scrollDown			= windowPos > lastWindowPos ? true : false;
		
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
		
		if ( windowPos > 0 ) {
		    $header.attr( 'style', 'position: fixed; top: 0; width: 100%; z-index: 9999;' );
		    $main.attr( 'style', 'margin-top: ' + mainOffsetTop + 'px;' );
		} else {
			$header.removeAttr( 'style' );
			$main.removeAttr( 'style' );
		}
		
		// Se a sidebar for maior que o tamanho da janela...
		if ( mainHeight > windowHeight ) {
			if ( scrollDown ) {
				if ( top ) {
					top = false;
					topOffset = ( sidebarOffsetTop > mainOffsetTop ) ? sidebarOffsetTop - mainOffsetTop : 0;
					$sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
				} else if ( ! bottom && windowPos > sidebarHeight + sidebarOffsetTop - windowHeight && sidebarHeight + mainOffsetTop < bodyHeight ) {
					bottom = true;
					$sidebar.attr( 'style', 'position: fixed; bottom: 0;' );
				} else if ( bottom && windowPos > mainHeight + mainOffsetTop - windowHeight && sidebarHeight + mainOffsetTop < bodyHeight ) {
					$sidebar.attr( 'style', 'bottom: 0;' );
				}
			} else if ( scrollUp ) {
				if ( bottom ) {
					bottom = false;
					topOffset = ( sidebarOffsetTop > mainOffsetTop ) ? sidebarOffsetTop - mainOffsetTop : 0;
					$sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
				} else if ( ! top && windowPos + mainOffsetTop < sidebarOffsetTop && sidebarOffsetTop > mainOffsetTop ) {
					top = true;
					$sidebar.attr( 'style', 'position: fixed; top: ' + mainOffsetTop + 'px;' );
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
	
	function navbar_resize() {
		if ( $wpadminbar.height() ) {
			$fixed_navbar_header.attr( 'style', 'top: ' + $wpadminbar.height() + 'px;' );
			
			if ( 600 >= $window.width() ) {
				$fixed_navbar_header.attr( 'style', 'position: absolute; top: ' + $wpadminbar.height() + 'px;' );
			}
		}
		
		$body.attr( 'style', 'padding-top: ' + ( $fixed_navbar_header.height() + 20 ) + 'px;' );
	}
	
	$( document ).ready( function() {
		$wpadminbar = $( '#wpadminbar' ).first();
		$fixed_navbar_header = $( '#fixed-nav-header' ).first();
		$window	 = $( window );
		$body	 = $( document.body );
		$header  = $( '#header' ).first();
		$main = $( '#main' ).first();
		$sidebar = $( '#sidebar' ).first();
		$footer  = $( '#footer' ).first();
		
		navbar_resize();
		$window.resize( navbar_resize );
		
		// Ajustes dos ícones para os post-details
		//$( '.post-categ > a' ).prepend( '<i class="fa fa-folder-open"></i> ' );
		//$( '.post-author > a' ).prepend( '<i class="fa fa-user"></i> ' );
		//$( '.post-date > time' ).prepend( '<i class="fa fa-clock-o"></i> ' );
		//$( '.post-comments > a' ).prepend( '<i class="fa fa-comments"></i> ' );
		//$( '.edit-link > a' ).prepend( '<i class="fa fa-pencil"></i> ' );
		
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