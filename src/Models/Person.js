export default class Person extends Backbone.Model {

	constructor(attributes, options = {}) {
		super(attributes, options = {});

	}

	urlRoot() {
		return "/page/person";
	}

}