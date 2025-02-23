jQuery( '.bci-upload-button' ).click( function( event ){ // button click
	// prevent default link click event
	event.preventDefault();
	
	const button = jQuery(this)
	// we are going to use <input type="hidden"> to store image IDs, comma separated
	const hiddenField = jQuery('#gallery_data')
	const hiddenFieldValue = hiddenField.val().split( ',' )

	const customUploader = wp.media({
		title: 'Insert images',
		library: {
			type: 'image'
		},
		button: {
			text: 'Use these images'
		},
		multiple: true
	}).on( 'select', function() {

		// get selected images and rearrange the array
		let selectedImages = customUploader.state().get( 'selection' ).map( item => {
			item.toJSON();
			return item;
		} )
		
		selectedImages.map( image => {
			// add every selected image to the <ul> list
			jQuery( '.bci-gallery' ).append( '<li data-id="' + image.id + '" style="float:left"><img src="' + image.attributes.url + '" style="max-width:100px"><a href="#" class="bci-gallery-remove">×</a></li>' );
			// and to hidden field
			hiddenFieldValue.push( image.id )
		} );

		// refresh sortable
		//jQuery( '.bci-gallery' ).sortable( 'refresh' );
		// add the IDs to the hidden field value
		hiddenField.val( hiddenFieldValue.join() );
			
	}).open();
});

// remove image event
jQuery( '.bci-gallery-remove' ).click( function( event ){

	event.preventDefault();
	
	const button = jQuery(this)
	const imageId = button.parent().data( 'id' )
	const container = button.parent().parent()
	const hiddenField = jQuery('#gallery_data')
	const hiddenFieldValue = hiddenField.val().split(",")
	
	for (a in hiddenFieldValue ) {
		hiddenFieldValue[a] = parseInt(hiddenFieldValue[a], 10);
	}

	const i = hiddenFieldValue.indexOf(imageId)

	button.parent().remove();

	// remove certain array element
	if( i != -1 ) {
		hiddenFieldValue.splice(i, 1);
	}

	// add the IDs to the hidden field value
	hiddenField.val( hiddenFieldValue.join() );

	// refresh sortable
	container.sortable( 'refresh' );

});

// reordering the images with drag and drop
jQuery( '.bci-gallery' ).sortable({
	items: 'li',
	cursor: '-webkit-grabbing', // mouse cursor
	scrollSensitivity: 40,
	/*
	You can set your custom CSS styles while this element is dragging
	start:function(event,ui){
		ui.item.css({'background-color':'grey'});
	},
	*/
	stop: function( event, ui ){
		ui.item.removeAttr( 'style' );

		let sort = new Array() // array of image IDs
		const container = jQuery(this) // .bci-gallery

		// each time after dragging we resort our array
		container.find( 'li' ).each( function( index ){
			sort.push( jQuery(this).attr( 'data-id' ) );
		});
		// add the array value to the hidden input field
		container.parent().next().val( sort.join() );
		// console.log(sort);
	}
});