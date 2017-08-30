/*jshint esnext: true */
import $ from 'jquery';
import DialogTemplate from './Dialog.hbs';

export default class Dialog  {
	
	constructor() {

	}

	static show(el, options){

		console.log( options.data );
		var template = !options.template?DialogTemplate:options.template;
		Dialog.html = $( template( options ) );

		if(!options.ok){
			Dialog.html.find("#ok").remove();
		}

		if(!options.cancel){
			Dialog.html.find("#cancel").remove();
		}
		
		Dialog.html.find("#ok").click( function(e){
			e.preventDefault();
			e.stopPropagation();
			options.requestMessageText = Dialog.html.find("#requestMessage").val();
			options.ok( options );
			$(this).addClass("loading");
		});

		Dialog.html.find("#cancel").click( function(e){
			e.preventDefault();
			e.stopPropagation();
			options.cancel( options );
		});

		//set Titles
		if(options.okTitle){
			Dialog.html.find("#ok").html( options.okTitle );
		}

		if(options.cancelTitle){
			Dialog.html.find("#cancel").html( options.cancelTitle );
		}

		if(options.errorMessage){
			Dialog.html.find("#errorMessage").html( options.errorMessage );
		}

		if(el){
			el.append(Dialog.html);
		} else {
			$('body').append(Dialog.html);
		}
	}

	static notify(message){
		
	}

	static fail(message){
		Dialog.html.find("#ok").removeClass("loading");
		Dialog.html.find("#message").html(message);
	}

	static close(){
		Dialog.html.remove();
	}

}