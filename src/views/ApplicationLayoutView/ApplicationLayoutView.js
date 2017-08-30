import layoutTemplate from './ApplicationLayoutTemplate.hbs';
import HeaderView from '../HeaderView/HeaderView';
import FooterView from '../Footer/FooterView';

export default class ApplicationLayoutView extends Marionette.View {

	constructor(options = {}) {
		options.template = layoutTemplate;
		super(options);
	}

	className(){ return "outer-wrapper"; }

	regions(){
		return {
			header: "#header",
			content: "#content",
			footer: "#footer"
		};
	}

	onRender(){
	
		this.setElement( this.el );
		$('body').append( this.$el );

		this.showChildView("header", new HeaderView());
		this.showChildView("footer", new FooterView());	
		
	} 

}