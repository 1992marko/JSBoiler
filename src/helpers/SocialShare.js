/*jshint esnext: true */
import $ from 'jquery';

export default class SocialShare {

	constructor() {}

	static FacebookDialog(url) {
		window.open(
	        'https://www.facebook.com/dialog/share?app_id=177368329365556&href=' + url,
	        'facebook-share-dialog', 
	        'width=626,height=436'
	    );
	}

	static TwitterDialog(url) {
		window.open(
	        'http://twitter.com/share?url=' + url,
	        'twitter-share-dialog', 
	        'width=626,height=436'
	    );
	}

	static GoogleDialog(url) {
		window.open(
	        'https://plus.google.com/share?url=' +url,
	        'google-share-dialog', 
	        'width=626,height=436'
	    );
	}

	static LinkedInDialog(url) {
		window.open(
	        'http://www.linkedin.com/shareArticle?mini=true&url=' + url,
	        'linkedin-share-dialog', 
	        'width=626,height=436'
	    );
	}
	
}