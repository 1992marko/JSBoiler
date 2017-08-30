export default class AutoModel extends Backbone.Model {

	constructor(attributes, options = {}) {
		super(attributes, options);
	}

	get idAttribute() {
		return "id";
	}

	url() {
		return "/page/settings/";
	}

	defaults() {
		return {

		};
	}
}