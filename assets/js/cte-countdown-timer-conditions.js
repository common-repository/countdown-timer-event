wp.CTECountdownWP = 'undefined' === typeof( wp.CTECountdownWP ) ? {} : wp.CTECountdownWP;

var CTECountdownWPConditions = Backbone.Model.extend({

	initialize: function( args ){
		var rows = jQuery('.countdown-timer-settings-container tr[data-container]');
		var tabs = jQuery('.countdown-wp-tabs .countdown-wp-tab');
		this.set( 'rows', rows );
		this.set( 'tabs', tabs );

		this.initEvents();
		this.initValues();
	},

	initEvents: function(){

		this.listenTo( wp.CTECountdownWP.Settings, 'change:type', this.changedType );
	},

	initValues: function(){

		this.changedType( false, wp.CTECountdownWP.Settings.get( 'type' ) );

		console.log( wp.CTECountdownWP.Settings.get( 'type' ) );

	},


	changedType: function( settings, value ){
		var rows = this.get( 'rows' ),
			tabs = this.get( 'tabs' );

		
		if ( 'design-1' == value ) {

			// Show Responsive tab
			// tabs.filter( '[data-tab="countdown-wp-responsive"]' ).show();
			
			
			rows.filter( '[data-container="countdownFontSize"], [data-container="countdownUnitColor"], [data-container="innerBorderSize"], [data-container="innerBorderRadius"], [data-container="innerPadding"], [data-container="innerBorderColor"], [data-container=""], [data-container="innerBgColor"],[data-container="hide_days"], [data-container="hide_hours"], [data-container="hide_minutes"], [data-container="margin"], [data-container="time_separator"]' ).hide();
     		rows.filter( '[data-container="circleWidth"], [data-container="circleBgColor"], [data-container="circleFgColor"]' ).show();

		}else if('design-2'){

			// Hide Responsive tab
			tabs.filter( '[data-tab="countdown-wp-responsive"]' ).hide();

			
			rows.filter( '[data-container="circleWidth"], [data-container="circleBgColor"], [data-container="circleFgColor"]' ).hide();
			rows.filter( '[data-container="countdownFontSize"], [data-container="countdownUnitColor"], [data-container="innerBorderSize"], [data-container="innerBorderRadius"], [data-container="innerPadding"], [data-container="innerBorderColor"], [data-container=""], [data-container="innerBgColor"], [data-container="hide_days"], [data-container="hide_hours"], [data-container="hide_minutes"], [data-container="margin"], [data-container="time_separator"]' ).show();

		}

	},


});