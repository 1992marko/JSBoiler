/*jshint esnext: true */
import $ from 'jquery';
import LoaderTemplate from './Loader.hbs';

export default class Loader  {
	
	constructor() {
		this.shown = false;
	}

	static show(el, options){
		if(this.shown){
			return;
		}
		
		Loader.html = $( LoaderTemplate( options ) );

		if(el){
			el.append(Loader.html);
		} else {
			$('body').append(Loader.html);
		}

		this.shown = true;
	}

	static hide(){
		Loader.html.removeClass("loading");
		
		setTimeout( ()=> {
		    Loader.html.remove();
		    $(".loader").remove();
		}, 1500);
		this.shown = false;
	}

}