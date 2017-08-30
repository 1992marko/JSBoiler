import homeTemplate from './HomeTemplate.hbs';

export default class Index extends Marionette.View {

	constructor(options = {}) {
		super(options);
		this.template = homeTemplate;
	}

	events(){
		return {
			"click #myButton" : "onButtonClick",
			"mouseover #myButton" : "onButtonClick"
		};
	}

	onRender(){
		this.listenTo( this.model, "change:ime", this.onChange);


		
	}

	onButtonClick(e){
		console.log("hjvfieuievhreiuvh");
	}

	onChange(){
		console.log("promjenilo se ime");
	
	}

}


