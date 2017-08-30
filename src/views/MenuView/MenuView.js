import ItemView from './ItemView.hbs';
import Globals from './../../globals';

export class MenuView extends Marionette.CompositeView {
	
	constructor(options = {}) {
		super(options);
		//this.template = `<a href="{{link}}">{{name}}</a> {{#if nodes}} <ul></ul> {{/if}}`; 
		this.template = ItemView;
		this.collection = this.model.get("nodes");
		this.listenTo(App.vent, "routeChanged", this.selectItem);
	}

	className(){
		return this.model.get("ClassName");
	}

	tagName(){ return "li"; }

	events() {
		return {
			"click" : "onclick",
			"mouseover" : "over",
			"mouseout" : "out"
		};
	}

	onclick(e){
		App.vent.trigger('menu:li:clicked', this); 
		this.$el.addClass("selected");
		this.$el.removeClass("open");
	}

	over(){
		this.$el.addClass("open");
	}

	out(){
		this.$el.removeClass("open");
	}

	childEvents(){ 
		return {
	    	'li:clicked': 'onChildClick'
		};
  	}

  	onChildClick(){
  		this.$("li").removeClass("selected");
  	}

	attachHtml(cv, iv, index){
        cv.$("ul:first").append(iv.el);
    } 

	onRender(){
		var link = this.model.get("link");
		
		//select link
		if( window.location.pathname.indexOf( link ) > -1 && link ){
			this.$el.addClass("selected");
		}

		//za početnu 
		if(link === "" && window.location.pathname === "/"){
			this.$el.addClass("selected");
		}

	}

	selectItem(){

		this.$el.removeClass("selected");
		var link = this.model.get("link");

		if( window.location.pathname.indexOf( link ) > -1 && link != "/" ){
			this.$el.addClass("selected");
		}

		/*if(window.location.pathname === this.model.get("link")){
			this.$el.addClass("selected");
			this.$el.parents("li").addClass("selected");
		}*/
		
		//Selektiraj početnu
		if(this.options.childIndex === 0 && window.location.pathname === "/"){
			this.$el.addClass("selected");
		}
	}

}


export class MenuRoot extends Marionette.CollectionView {

	constructor(options = {}) {
		super(options);
		this.collection = new MenuNodeCollection( options.data );
	}

	childEvents(ev){
		return {
	    	'li:clicked': 'onChildClick'
		};
  	}

  	onChildClick(e){
  		this.trigger("menu:clicked", this);
  		this.$("li").removeClass("selected");
  	}

  	onRender(){
  		
  	}

	className(){ return this.options.className?this.options.className:"menu"; }
	
	tagName(){ return "ul"; }

	get childView(){ return MenuView; } 
	
	childViewOptions(model, index) {
		return {
			parent:this,
			childIndex: index
		};
	};

}



export class MenuNode extends Backbone.Model {

	constructor(options = {}) {
		super(options);

		var nodes = this.get("nodes");

        if (nodes){
            this.set("nodes", new MenuNodeCollection(nodes));
        }
	}
	
}


export class MenuNodeCollection extends Backbone.Collection {

	constructor(options = {}) {
		super(options);
	}

	get model(){
		return MenuNode;
	}

}