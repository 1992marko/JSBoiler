import HeaderViewTemplate from './HeaderViewTemplate.hbs';
import Globals from '../../globals';
import {MenuRoot} from '../MenuView/MenuView';

export default class HeaderView extends Marionette.View {

	constructor(options = {}) {
		options.template = HeaderViewTemplate;
		super(options);
	}

	events(){
		return {
			"click .openMenu" : "toggleMenu"
		};
	}

	regions(){
		return {
			menu : ".menu-container"
		};
	}

	onRender(){
		var tr = new MenuRoot({ data : Globals.settings.headerNav });
		//this.showChildView("menu", tr);
	}

	toggleMenu(){
		this.$(".openMenu").toggleClass("open");
	}

}