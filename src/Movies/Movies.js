import Movie from '../Models/Movie';

export default class Movies extends Backbone.Collection {

	constructor(models, options = {}) {
		super(models, options);
	}

	url() {
		return "/page/movies";
	}

	get model() {
		return Movie;
	}

}