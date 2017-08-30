import Template404 from './Template404.hbs';

export default class HomeView extends Marionette.View {

	constructor(options = {}) {
		options.template = Template404;
		super(options);
	}

	className(){
		return "popup";
	}

	onRender(){
		
	}

}