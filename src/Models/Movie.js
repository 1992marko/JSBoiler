export default class Movie extends Backbone.Model {

	constructor(attributes, options = {}) {
		super(attributes, options = {});

	}

	urlRoot() {
		return "/page/movie";
	}

}