import Movies from '../../Movies/Movies';
// import Person from '../../Models/Person';
import MovieView from '../../views/BookLook/MovieView';

export default class MoviesCollectionView extends Marionette.CollectionView {

	constructor(options = {}) {
		super(options);

		this.collection = new Movies();
		this.collection.fetch({ success: () => { console.log(this.collection); } });

		// this.collection = phonebook;
	}

	//tagName(){ return "table"; }
	className() {
		return "row grid-12";
	}

	events() {
		return {

		};
	}

	childView() {
		return MovieView;
	}

	onRender() {
		// console.log("Izrendiralo se");
	}

}