/*jshint esnext: true */
import $ from 'jquery';
import Backbone from 'backbone';
import _ from 'underscore';

export class Scrollr {
	
	static init(){

		Scrollr.items = [];

		$(window).on("scroll", function(event){

			$.each(Scrollr.items, function(){

				if( this.item.posY == null){
					this.item.posY = $( this.item ).offset().top;
					this.item.width = $( this.item ).outerWidth();
					this.item.height = $( this.item ).outerHeight();
					$(this.item).after('<div class="dummy" style="display:none; height:'+ $(this.item).outerHeight() +'px;"></div>');
					//$(this.item).css({width : this.item.width});
				}

				//Optimize this
				if( (window.scrollY + $(this.item).outerHeight()) > ( $(this.item).closest(".container").offset().top + $(this.item).closest(".container").outerHeight() ) ){
					this.item.outside = true;
				} else {
					this.item.outside = false;
				}

				//Rules
				if(!this.item.outside){
					$( this.item ).removeClass("bottom");
				}

				if( window.scrollY >= this.item.posY && !this.item.outside && !$(this.item).hasClass("fos-active") ){
					$( this.item ).addClass("fos-active");
					$( this.item ).css({width : this.item.width});
				} else if(window.scrollY < this.item.posY && !this.item.outside && $(this.item).hasClass("fos-active")) {
					$( this.item ).removeClass("fos-active");
					$( this.item ).css({width : ""});
				} else if(this.item.outside){
					$( this.item ).addClass("bottom");
					$( this.item ).css({width : this.item.width});
				} 

			});
		});

		$.fn.Scrollr = function() {
		   this.find(".fos").each(function(key, value){
				Scrollr.items.push({item : this, posY : null});
			});
		};

	}

}

export class Dropdown {
	
	static init(){

		$("body").on("click", function(e){
			e.stopPropagation();
			$(".dropdown").removeClass("open");
		});

		$("body").on("click", ".dropdown-win", function(e){
			e.stopPropagation();
		});

		$("body").on("click", ".dropdown-win a", function(e){
			$(".dropdown").removeClass("open");
		});

		$.fn.Dropdown = function(event) {
		    
		    var ref = event;
		    
		    this.click( function(e){
		    	
		    	e.stopPropagation();
		    	e.preventDefault();
		    	$(".dropdown").not(this).removeClass("open");

		    	console.log($(e.currentTarget).hasClass("open"));

		    	$(e.currentTarget).toggleClass("open");

		    	if(ref && ref.hasOwnProperty("onOpen") && $(e.currentTarget).hasClass("open")){
		    		ref.onOpen();
		    	}
		    	
		    });

		};
	}

}

export class href {
	
	static init(){

		$("body").on("click", "a", function(e){

			e.stopPropagation(); //Test da vidimo hoče li raditi da se eventi ne bublaju

			var link = $(e.currentTarget).attr("href");
			var forceReload = $(e.currentTarget).attr("reload");
			var force = $(e.currentTarget).attr("force");

			history.replaceState(
		        _.extend(history.state || {}, { 
		            scrollTop: document.body.scrollTop || $(document).scrollTop() 
		        }),
		        document.title,
		        window.location
		    );
			
			if( link && link.indexOf("http") !== 0 && link.indexOf("mailto") !== 0 && !force ) {
			    e.preventDefault();
				Backbone.history.navigate(link, true);
			} 
			
			/*if(forceReload){
				location.reload();
			}*/

		});
	}

}

export class URL{

	static get(name, url){
		if (!url) url = window.location.href;
	    //url = url.toLowerCase(); // This is just to avoid case sensitiveness  
	    name = name.replace(/[\[\]]/g, "\\$&");//.toLowerCase();// This is just to avoid case sensitiveness for query parameter name
	    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	        results = regex.exec(url);
	    if (!results) return null;
	    if (!results[2]) return '';
	    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	static set(paramName, paramValue, url){
	    var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)');
	    if (!url) url = window.location.pathname + window.location.search;
	    if(url.search(pattern)>=0){
	        return url.replace(pattern,'$1' + paramValue + '$2');
	    }
	    return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
	}

	static getParamsAsArray(){
	
		var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	 
	    for(var i = 0; i < hashes.length; i++)
	    {
	        hash = hashes[i].split('=');
	        //vars.push(hash[0]);
	        vars[hash[0]] = hash[1];
	    }
	 
	    return vars;
	}

	static updateHistoryScrollPosition(){
		history.replaceState(
	        _.extend(history.state || {}, { 
	            scrollTop: document.body.scrollTop || $(document).scrollTop() 
	        }),
	        document.title,
	        window.location
	    );
	}

}