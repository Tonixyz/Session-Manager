// JavaScript Document

var tickerRequest = new Request({
	url: 'remotes/ticker.remote.php',
	link: 'chain',
	evalScripts: true
});

$('tickerNewText').addEvent('keydown', function(event) {
	if(event.alt && event.key == "e") {
		event.preventDefault();
		$('tickerNewText').set('value', $('tickerNewText').get('value') + "$");
	}
});

var tickerMorph = new Fx.Morph('tickerButton', { link: 'cancel' });

TickerClass = new Class({
	
	toggle: function() {
		tickerRequest.send("action=toggleactive");
	},
	
	change: function() {
		tickerRequest.send("action=change&text=" + escape($('tickerNewText').value));
	},
	
	fav: function() {
		tickerRequest.send("action=add&text=" + escape($('tickerNewText').value));
	},
	
	addFav: function(id, text) {
		
		var li = new Element('li', {
			'id': 'tickerFav_' + id,
			'html': text
		});
		
		var liMorph = new Fx.Morph(li);
		liMorph.set({
			'height': 0,
			'padding-top': 0,
			'padding-bottom': 0
		});
		
		li.inject('ticker');
		
		var scrollSize = li.getScrollSize();
		liMorph.start({
			'height': scrollSize.y,
			'padding-top': '5px',
			'padding-bottom': '5px'
		});
		
	},
	
	deleteFav: function(id) {
		tickerRequest.send("action=delete&id=" + id);
	},
	
	hideFav: function(id) {
		
		new Fx.Morph('tickerFav_' + id, {
			onComplete: function(el) {
				el.dispose();
			}
		}).start({
			'height': 0,
			'opacity': 0,
			'margin': 0,
			'padding': 0
		});
		
	},
	
	useFav: function(id) {
		
		$('tickerNewText').set('value', $('tickerUse_' + id).get('text'));
		this.change();
		
	}
	
});
var ticker = new TickerClass();