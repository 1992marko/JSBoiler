import AddRentViewTemplate from './AddRentViewTemplate.hbs';
//import Binder from '../../Helpers/Binder';
import Rent from '../../Models/Rent';
import Backbone from 'backbone';

export default class AddRentView extends Marionette.View {

	constructor(options = {}) {
		super(options);
		this.model = new Rent();
		this.template = AddRentViewTemplate;
		this.model.attributes.state = 1;
	}

	events() {
		return {
			// "click .delete": "removePerson",
			"click .save": "save",
			"click .cancel": "cancel",
			"click .show": "show",
			"keyup #user": "searchUser",
			"keyup #movie": "searchMovie",
			"keyup #genre" : "searchGenre",
			"click .user_choose": "userChoose",
			"click .movie_choose": "movieChoose",
			"click .genre_choose" : "genreChoose",
			"click .state": "changeState"
		};
	}

	onRender() {}

	// removePerson() {
	// 	this.model.destroy();
	// }

	 changeState(el){
		this.model.attributes.state = el.currentTarget.value;
	 	console.log(this.model.attributes);
	 }

	searchUser(el) {
		var name = el.currentTarget.value;
		$.get("page/persons", { name: name })
			.done(function(data) {
				var result = JSON.parse(data);
				var html = "";

				$.each(result, function(index, value) {
					html += '<div data-id="' + value.id + '" class="user_choose">' + value.Name + ' ' + value.Surname + '</div>';
				});

				$(".users").html(html);
				$(".users").show();

			});
	}

	searchMovie(el) {
		var name = el.currentTarget.value;
		$.get("page/movies", { name: name })
			.done(function(data) {

				var result = JSON.parse(data);
				var html = "";

				$.each(result, function(index, value) {
					html += '<div data-id="' + value.id + '" class="movie_choose">' + value.name + '</div>';
				});

				$(".movies").html(html);
				$(".movies").show();
			});
	}

	searchGenre(el) {
		var genre = el.currentTarget.value;
		$.get("page/movies", { genre: genre })
			.done(function(data) {
				var result = JSON.parse(data);
				var html = "";

				$.each(result, function(index, value) {
					html += '<div data-id="' + value.id + '" class="genre_choose">' + value.genre + '</div>';
					
				});


				$(".genres").html(html);
				$(".genres").show();
			});
	}

	userChoose(el) {
		var user = $(el.currentTarget).attr("data-id");
		$("#user").val($(el.currentTarget).html());
		$(".users").hide();
		this.model.attributes.user = user;
		console.log(this.model.attributes);
	}

	movieChoose(el) {
		var movie = $(el.currentTarget).attr("data-id");
		$("#movie").val($(el.currentTarget).html());
		$(".movies").hide();
		this.model.attributes.movie = movie;
		console.log(this.model.attributes);
	}

	genreChoose(el) {
		var genre = $(el.currentTarget).attr("data-id");
		$("#genre").val($(el.currentTarget).html());
		$(".genres").hide();
		this.model.attributes.genre = genre;
		console.log(this.model.attributes);
	}





	show() {
		$('#notification-bar').html('The page has been successfully loaded');

	}




	save() {
		// Binder.formToModel(this.$el, this.model, true);

		this.model.save(null, {
			success: () => {
				Backbone.history.navigate("/rents", true);
			}
		});
	}

	cancel(id) {

		
  $.getJSON('/page/movies', function (data) {
	var genre = $(id.currentTarget).attr("data-id");
	
	//$(this).attr("id")
    console.log(id);
  });
	};
		//Backbone.history.navigate("/rents", true);
	}


