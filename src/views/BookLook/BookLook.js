import PhoneBook from '../../PhoneBook/PhoneBook';
// import Person from '../../Models/Person';
import PersonView from '../../views/BookLook/PersonView';

export default class BookLook extends Marionette.CollectionView {

	constructor(options = {}) {
		super(options);

		this.collection = new PhoneBook();
		this.collection.fetch({
			success: () => {
				console.log(this.collection);
			}
		});

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
		return PersonView;
	}

	onRender() {
		// console.log("Izrendiralo se");
	}

}