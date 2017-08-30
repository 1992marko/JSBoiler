/*jshint esnext: true */
import _ from 'underscore';
import Backbone from 'backbone';
import $ from 'jquery';
import Marionette from 'backbone.marionette';
import ApplicationLayoutView from './views/ApplicationLayoutView/ApplicationLayoutView';
import MainRouter from './routers/MainRouter';
import Globals from './globals';
import Dialog from './helpers/dialog/Dialog';
import Loader from './helpers/loader/Loader';
import {Dropdown, href, Scrollr} from './helpers/jquery/plugins';
import Handlebars from 'hbsfy/runtime';
window.$ = $;
window.jQuery = $;

// import AutiCollection from './AutiCollection/AutiCollection';

 
window.App = new Marionette.Application();
window.App.vent = _.extend({}, Backbone.Events);
// App.autiCollection = new AutiCollection();

App.on('start', function(app,options) {

  App.vent = _.extend({}, Backbone.Events);
  Globals.init();
  Dropdown.init();
  href.init();
  Scrollr.init();

  Globals.settings = JSON.parse(options);

  //Load the main application
  App.rootLayout = new ApplicationLayoutView();
  App.rootLayout.render();

  //Init router
  App.router = new MainRouter({ container : App.rootLayout.getRegion("content") });

  //Start history
  Backbone.emulateHTTP = true;
  Backbone.history.start({pushState: true, root: '/'});

});

// START THE APP ON SUCCESS
//Get global settings
$.ajax({
    method: "GET",
    url: "/page/settings" + window.location.search,
    data: {  }
  })
  .done(function( data ) {
    //Marionette start
    //Loader.hide();
    App.start(data);

  }).fail(function( jqXHR, textStatus ){
    //Load failed
    Loader.hide();
    Dialog.show( null, { 
      title : "Server error", 
      message : "There is something wrong with your internet conenction, or the server is down. Please try again in 10 minutes.",
      okTitle : "Retry",
      ok : ()=>{ location.reload(); } 
    } );

  });