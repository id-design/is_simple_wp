(function( $ ) {
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
    
    // Checa se o valor de 'data' é vazio (nulo)
	function empty( data ) {
		if ( typeof ( data ) == 'number' || typeof ( data ) == 'boolean') {
			return false;
		}
		
		if ( typeof ( data ) == 'undefined' || data === null) {
			return true;
		}
		
		if ( typeof ( data.length ) != 'undefined') {
			return data.length == 0;
		}
		
		var count = 0;
		
		for ( var i in data ) {
			if ( data.hasOwnProperty( i ) ) {
				count++;
			}
		}
		
		return count == 0;
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
		var content_img_link = $( '.entry-content a:has( img )' );
		
		content_img_link.each( function() {
			var this_img = $( this ).children( 'img' );
			var gallery_id = $( this ).parents( '.gallery' ).attr( 'id' );
			var is_gallery = empty( $( this ).parents( '.gallery' ) ) ? false : true;
			var is_wp_caption = empty( $( this ).parent( '.wp-caption' ) ) ? false : true;
			
			if ( is_gallery ) {
				$( this ).attr( 'data-lightbox', content_id + '-' + gallery_id );
			} else {
				$( this ).attr( 'data-lightbox', content_id );
			}
			
			if ( is_gallery ) {
				var caption_txt = $( this ).parents( '.gallery-item' ).children( '.gallery-caption' ).text();
				$( this ).attr( 'data-title', caption_txt );
			} else if ( is_wp_caption ) {
				var caption_txt = $( this ).parent( '.wp-caption' ).children( '.wp-caption-text' ).text();
				$( this ).attr( 'data-title', caption_txt );
				$( this ).parent().addClass( 'thumbnail' );
				$( this ).parent( '.wp-caption' ).children( '.wp-caption-text' ).addClass( 'caption' );
			} else {
				$( this ).addClass( 'thumbnail' );
				
				var this_img_class = this_img.attr( 'class' ).split( ' ' );
				
				for ( i = 0; i < this_img_class.length - 1; i++ ) {
					switch ( this_img_class[ i ] ) {
						case 'alignleft':
							this_img.removeClass( 'alignleft' ).parent( 'a' ).addClass( 'alignleft' );
						break;
						case 'alignright':
							this_img.removeClass( 'alignright' ).parent( 'a' ).addClass( 'alignright' );
						break;
						case 'aligncenter':
							this_img.removeClass( 'aligncenter' ).parent( 'a' ).addClass( 'aligncenter' );
						break;
						case 'alignnone':
							this_img.removeClass( 'alignnone' ).parent( 'a' ).addClass( 'alignnone' );
						break;
					}
				}
				/*
				if ( this_img.hasClass( 'alignleft' ) ) {
					this_img.removeClass( 'alignleft' ).parent( 'a' ).addClass( 'alignleft' );
				}
				*/
			}
		} );
	} );

})( jQuery );