import Person from '../Models/Person';

export default class PhoneBook extends Backbone.Collection {

	constructor(models, options = {}) {
		super(models, options);
	}

	url() {
		return "/page/persons";
	}

	get model() {
		return Person;
	}

}