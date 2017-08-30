import Rent from '../Models/Rent';

export default class Rents extends Backbone.Collection {

	constructor(models, options = {}) {
		super(models, options);
	}

	url() {
		return "/page/rents";
	}

	get model() {
		return Rent;
	}

}