export default class Rent extends Backbone.Model {

	constructor(attributes, options = {}) {
		super(attributes, options = {});

	}

	urlRoot() {
		return "/page/rent";
	}

}