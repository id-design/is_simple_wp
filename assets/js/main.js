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
		
		mainOffsetTop		= $( '#page-header' ).height() > 0 ? $( '#page-header' ).offset().top  : $main.offset().top;
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
		/*
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
		*/
		// Se a sidebar for maior que o tamanho da janela...
		if ( sidebarHeight > windowHeight ) {
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
		if ( $navbar_header.hasClass( 'navbar-fixed-top' ) ) {
			if ( $wpadminbar.height() ) {
				$navbar_header.attr( 'style', 'top: ' + $wpadminbar.height() + 'px;' );

				if ( 600 >= $window.width() ) {
					$navbar_header.attr( 'style', 'top: ' + $wpadminbar.height() + 'px;' );
				}
			}

			$body.attr( 'style', 'padding-top: ' + ( $navbar_header.height() ) + 'px;' );
		}
	}
    
    function sidebar_affix() {
        $sidebar.hasClass( 'affix' ).css( 'margin-left', $( '#primaty' ).width() );
    }
	
	$( document ).ready( function() {
		$wpadminbar = $( '#wpadminbar' ).first();
		$navbar_header = $( '#nav-header' ).first();
		$window	 = $( window );
		$body	 = $( document.body );
		$header  = $( '#header' ).first();
		$main = $( '#main' ).first();
		$sidebar = $( '#secondary' ).first();
		$footer  = $( '#footer' ).first();
		
		navbar_resize();
		$window.resize( navbar_resize );
		/*
		$sidebar.affix( {
			offset: {
				top: 180,
				bottom: 50
			}
		} );
		*/
		//var footerOffsetBottom = $footer.height();
		//alert( mainOffsetBottom );
		//$sidebar.attr( 'data-spy', 'affix' ).attr( 'data-offset-top', 60 ).attr( 'data-offset-bottom', footerOffsetBottom );
		
		//$window.scroll( sidebar_affix );
		//$( 'body' ).append('<div id="vars"></div>');
		//resize_and_scroll();
		//$window.scroll( resize_and_scroll );
		//$window.resize( resize_and_scroll );
		
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