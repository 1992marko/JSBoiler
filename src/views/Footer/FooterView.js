import FooterViewTemplate from './FooterViewTemplate.hbs';

export default class FooterView extends Marionette.View {

	constructor(options = {}) {
		options.template = FooterViewTemplate;
		super(options);
	}

	onRender(){

	}

}