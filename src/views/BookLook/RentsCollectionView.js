import Rents from '../../Rents/Rents';
// import Person from '../../Models/Person';
import RentView from '../../views/BookLook/RentView';

export default class RentsCollectionView extends Marionette.CollectionView {

	constructor(options = {}) {
		super(options);

		this.collection = new Rents();
		this.collection.fetch({
			success: () => {
				// console.log(this.collection);
			}
		});
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
		return RentView;
	}

}