/*jshint esnext: true */
import $ from 'jquery';
import Backbone from 'backbone';
import Marionette from 'backbone.marionette';

import Globals from '../globals';
import Loader from '../helpers/loader/Loader';
import RenderOnServerView from '../views/DefaultServerPageView/DefaultServerPageView';
import Index from '../views/Index/Index';
import Page404 from '../views/404/404';
import PhoneBookView from '../views/BookLook/PhoneBookview';
import EditPersonView from '../views/EditPersonView/EditPersonView';
import AddPersonView from '../views/AddPersonView/AddPersonView';
import MoviesView from '../views/BookLook/MoviesView';
import AddMovieView from '../views/404/AddMovieView/AddMovieView';
import EditMovieView from '../views/EditMovieView/EditMovieView';
import RentsView from '../views/BookLook/RentsView';
import AddRentView from '../views/AddRentView/AddRentView';

export default class MainRouter extends Marionette.AppRouter {

	constructor(options = {}) {
		super(options);
		this.container = options.container;
		this.header = options.header;

		this.container.on("show", this.show);
	}

	show() {
		var scrollTop = history.state && history.state.scrollTop || 0;
		window.scrollTo(0, scrollTop);
	}

	routes() {
		return {
			'': 'index',
			'phoneBook': 'phoneBook',
			'editPerson/:id': 'editPerson',
			'addPerson': 'addPerson',
			'movies': 'movies',
			'addMovie': 'addMovie',
			'editMovie/:id': 'editMovie',
			'rents': 'rents',
			'addRent': 'addRent',

		};
	}

	index() {
		this.container.show(new Index());
	}

	phoneBook() {
		this.container.show(new PhoneBookView());
	}

	movies() {
		this.container.show(new MoviesView());
	}

	editPerson(id) {
		this.container.show(new EditPersonView({ id: id }));
	}

	addPerson() {
		this.container.show(new AddPersonView());
	}

	addMovie() {
		this.container.show(new AddMovieView());
	}

	editMovie(id) {
		this.container.show(new EditMovieView({ id: id }));
	}

	rents() {
		this.container.show(new RentsView());
	}

	addRent() {
		this.container.show(new AddRentView());
	}

	other() {

		const classes = {
			index
		};

		Loader.show();

		//CHECK IF THERE IS A ROUTE DEFINED ON SERVER
		$.ajax({

			url: "/page/" + Backbone.history.getFragment(),

		}).done((res) => {

			var data = JSON.parse(res);

			//Add class to body if provided
			$("body").removeClass();
			if (data.bodyClass) {
				$("body").addClass(data.bodyClass);
			}

			//Change Title
			//$('title').html( data.name ); 

			//IF THERE IS DATA FILENAME, THEN RENDER THE TEMPLATE NAME SENT FROM THE SERVER
			if (data.filename) {
				data.filename = data.filename.substr(data.filename.indexOf("#") + 1);
				this.container.show(new classes[data.filename](data));
			}

			//IF THERE IS NO FILENAME, RENDER THE CONTENT FROM THE SERVER ON DEFAULT EMPTY TEMPLATE, THAT MEENS THAT THE CONTENT HAS BEED RENDERED ON THE SERVER
			else {
				this.container.show(new RenderOnServerView(data));
			}

			//UPDATE LANGUAGES AND SEND EVENT
			if (data.allLang) {
				App.vent.trigger("updateLanguages", data.allLang);
			}

			//HIDE THE LOADER
			Loader.hide();

		}).fail((jqXHR, textStatus) => {

			//Load failed
			Loader.hide();
			this.container.show(new Page404());

		});

	}

	execute(callback, args, name) {

		//Google Analytics pageview
		/* ga('send', 'pageview', location.pathname); */

		//Notify that the route has changed
		App.vent.trigger("routeChanged", name);
		$("body").removeClass();

		var proceed = true;
		if (name === "mybookings" || name === "myprofile") {
			proceed = this.checkLogin();
		}

		if (callback && proceed) callback.apply(this, args);

	}

	checkLogin() {
		if (!Globals.settings.user.loggedIn) {
			Backbone.history.navigate("login", true);
			return false;
		}

		return true;
	}

}