import MoviesCollectionView from '../../views/BookLook/MoviesCollectionView';
import MoviesViewTemplate from '../../views/BookLook/MoviesViewTemplate.hbs';

export default class MoviesView extends Marionette.View {

	constructor(options = {}) {
		super(options);

		this.template = MoviesViewTemplate;
	}

	events() {
		return {
			"click .test_remove": "test_remove"
		};
	}

	className() {
		//return "row";
	}

	regions() {
		return {
			list: "#movies"
		};
	}

	onRender() {
		this.showChildView("list", new MoviesCollectionView());
	}

	// test_remove() {
	// 	var proslijedjeni_parametar = $(".test_parametar").val();
	// 	if (proslijedjeni_parametar > 0) {
	// 		var element = $("div[model-id='" + proslijedjeni_parametar + "']");
	// 		if (element.length == 1) {
	// 			element.parent().remove();
	// 		} else {
	// 			alert("ne postoji element sa tim parametrom");
	// 		}
	// 	} else {
	// 		alert("niste upisali parametar");
	// 	}

	// }

}