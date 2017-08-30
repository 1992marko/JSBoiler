/*jshint esnext: true */
import $ from 'jquery';
import Backbone from 'backbone';
import Marionette from 'backbone.marionette';
import Handlebars from 'Handlebars';
import Globals from '../../globals';

export default class DefaultServerPage extends Marionette.View {
	constructor(options = {}) {
		super(options);
		this.template = Handlebars.compile(options.content);
	}

	regions(){}

	events() {}

	onRender(){}

	onDestroy(){}

}