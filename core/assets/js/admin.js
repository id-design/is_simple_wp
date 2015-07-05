/* global issimpleAdminParams */
(function ( $ ) {
	'use strict';

	/**
	 * Theme Options and Metaboxes.
	 */
	$( function () {

		/**
		 * Image field.
		 */
		$( '.issimple-upload-image .button' ).on( 'click', function ( e ) {
			e.preventDefault();

			var uploadFrame,
				uploadInput = $(this).siblings( '.image' ),
				uploadPreview = $(this).siblings( '.preview' );

			// If the media frame already exists, reopen it.
			if ( uploadFrame ) {
				uploadFrame.open();

				return;
			}

			// Create the media frame.
			uploadFrame = wp.media.frames.downloadable_file = wp.media({
				title: issimpleAdminParams.uploadTitle,
				button: {
					text: issimpleAdminParams.uploadButton
				},
				multiple: false,
				library: {
					type: 'image'
				}
			});

			uploadFrame.on( 'select', function () {
				var attachment = uploadFrame.state().get( 'selection' ).first().toJSON();
				uploadPreview.attr( 'src', attachment.url );
				uploadInput.val( attachment.id );
			});

			// Finally, open the modal.
			uploadFrame.open();
		});

		$( '.issimple-upload-image .delete' ).click( function ( e ) {
			e.preventDefault();

			var wrapper      = $( this ).parents( '.issimple-upload-image' ),
				defaultImage = $( '.default-image', wrapper ).text();

			$( '.image', wrapper ).val( '' );
			$( '.preview', wrapper ).attr( 'src', defaultImage );
		});

		/**
		 * Upload.
		 */
		$( '.issimple-upload-button' ).on( 'click', function ( e ) {
			e.preventDefault();

			var uploadFrame,
				uploadInput = $( this ).prev( 'input' );

			// If the media frame already exists, reopen it.
			if ( uploadFrame ) {
				uploadFrame.open();

				return;
			}

			// Create the media frame.
			uploadFrame = wp.media.frames.downloadable_file = wp.media({
				title: issimpleAdminParams.uploadTitle,
				button: {
					text: issimpleAdminParams.uploadButton
				},
				multiple: false
			});

			uploadFrame.on( 'select', function () {
				var attachment = uploadFrame.state().get( 'selection').first().toJSON();
				uploadInput.val( attachment.url );
			});

			// Finally, open the modal.
			uploadFrame.open();
		});

		/**
		 * Color Picker.
		 */
		$( '.issimple-color-field' ).wpColorPicker();

		/**
		 * Image plupload adds.
		 */
		$( '.issimple-gallery-container' ).on( 'click', '.issimple-gallery-add', function ( e ) {
			e.preventDefault();

			var galleryFrame,
				galleryWrap = $( this ).parent( '.issimple-gallery-container' ),
				imageGalleryIds = $( '.issimple-gallery-field', galleryWrap ),
				images = $( 'ul.issimple-gallery-images', galleryWrap ),
				attachmentIds = imageGalleryIds.val();

			// If the media frame already exists, reopen it.
			if ( galleryFrame ) {
				galleryFrame.open();

				return;
			}

			// Create the media frame.
			galleryFrame = wp.media.frames.downloadable_file = wp.media({
				title: issimpleAdminParams.galleryTitle,
				button: {
					text: issimpleAdminParams.galleryButton
				},
				multiple: true,
				library: {
					type: 'image'
				}
			});

			// When an image is selected, run a callback.
			galleryFrame.on( 'select', function () {

				var selection = galleryFrame.state().get( 'selection' );

				selection.map( function ( attachment ) {

					attachment = attachment.toJSON();

					if ( attachment.id ) {
						attachmentIds = attachmentIds ? attachmentIds + ',' + attachment.id : attachment.id;

						images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment.url + '" /><ul class="actions"><li><a href="#" class="delete" title="' + issimpleAdminParams.galleryRemove + '">X</a></li></ul></li>' );
					}

				});

				imageGalleryIds.val( attachmentIds );
			});

			// Finally, open the modal.
			galleryFrame.open();
		});

		/**
		 * Image plupload ordering.
		 */
		$( '.issimple-gallery-container' ).on( 'mouseover', 'ul.issimple-gallery-images', function () {
			var galleryWrap = $( this ).parent( '.issimple-gallery-container' ),
				imageGalleryIds = $( '.issimple-gallery-field', galleryWrap );

			// Call the sortable action.
			$( this ).sortable({
				items: 'li.image',
				cursor: 'move',
				scrollSensitivity: 40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start: function ( event, ui ) {
					ui.item.css('background-color', '#f6f6f6');
				}, stop: function ( event, ui ) {
					ui.item.removeAttr( 'style' );
				}, update: function () {
					var attachmentIds = '';

					// Gets the current ids.
					$( 'li.image', $( this ) ).css( 'cursor', 'default' ).each( function () {
						var attachmentId = $( this ).attr( 'data-attachment_id' );
						attachmentIds = attachmentIds + attachmentId + ',';
					});

					// Return the new value.
					imageGalleryIds.val( attachmentIds );
				}
			});
		});

		/**
		 * Image plupload remove link.
		 */
		$( '.issimple-gallery-container' ).on( 'click', 'a.delete', function ( e ) {
			e.preventDefault();

			var galleryWrap = $( this ).parents( '.issimple-gallery-container' ),
				imageGalleryIds = $( '.issimple-gallery-field', galleryWrap ),
				attachmentIds = '';

			// Remove the item.
			$( this ).closest( 'li.image' ).remove();

			// Gets the current ids.
			$( 'ul li.image', galleryWrap ).css( 'cursor', 'default' ).each( function () {
				var attachmentId = $( this ).attr( 'data-attachment_id' );
				attachmentIds = attachmentIds + attachmentId + ',';
			});

			// Return the new value.
			imageGalleryIds.val( attachmentIds );
		});
	});
}( jQuery ));
