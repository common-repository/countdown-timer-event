wp.CTECountdownWP = 'undefined' === typeof( wp.CTECountdownWP ) ? {} : wp.CTECountdownWP;
wp.CTECountdownWP.modalChildViews = 'undefined' === typeof( wp.CTECountdownWP.modalChildViews ) ? [] : wp.CTECountdownWP.modalChildViews;
wp.CTECountdownWP.previewer = 'undefined' === typeof( wp.CTECountdownWP.previewer ) ? {} : wp.CTECountdownWP.previewer;
wp.CTECountdownWP.modal = 'undefined' === typeof( wp.CTECountdownWP.modal ) ? {} : wp.CTECountdownWP.modal;
wp.CTECountdownWP.items = 'undefined' === typeof( wp.CTECountdownWP.items ) ? {} : wp.CTECountdownWP.items;
wp.CTECountdownWP.upload = 'undefined' === typeof( wp.CTECountdownWP.upload ) ? {} : wp.CTECountdownWP.upload;

	console.log( wp );
jQuery( document ).ready( function( $ ){


	// Settings related objects.
	wp.CTECountdownWP.Settings = new wp.CTECountdownWP.settings['model']( CTECountdownWPHelper.settings );

	// CTECountdownWP conditions
	wp.CTECountdownWP.Conditions = new CTECountdownWPConditions();	

});