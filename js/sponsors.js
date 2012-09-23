// JavaScript Document

var sponsorsRequest = new Request({
	url: 'remotes/sponsors.remote.php',
	link: 'chain',
	evalScripts: true
});

var sponsorsFormTween = new Fx.Tween('sponsorsAddForm', {
	link: 'ignore',
	onComplete: function(el) {
		size = el.getSize();
		if(size.y > 0) {
			sponsorsRequest.send("action=loadfiles");
			$('sponsorsAddName').focus();
			$('sponsorsAddToggle').set('html', '&otimes; schlie&szlig;en').set('href', 'javascript:sponsors.close()');
		} else {
			$('sponsorsAddToggle').set('html', 'Sponsor hinzuf&uuml;gen &raquo;').set('href', 'javascript:sponsors.open()');			
			$('sponsorsAddName').set('value', '');
			$('sponsorsAddTime').set('value', '');
		}
	} 
});

var SponsorsClass = new Class({
	
	initialize: function() {
		
		$('sponsorsIndicator').fade('hide').set('tween', { duration: 1000, transition: 'cubic:in' });
		
		if(sponsorsListStatus == "hide")
			this.hideList();
		
	},
	
	toggleActive: function(id) {
		sponsorsRequest.send("action=toggleactive&id=" + id);
	},
	
	open: function() {
		scrollSize = $('sponsorsAddForm').getScrollSize();
		sponsorsFormTween.start('height', scrollSize.y);
	},
	
	close: function() {
		sponsorsFormTween.start('height', 0);
	},
	
	toggle: function() {
		size = $('sponsorsAddForm').getSize();
		if(size.y == 0)
			sponsors.open();
		else
			sponsors.close();
	},
	
	save: function() {
		
		name = escape($('sponsorsAddName').value);
		file = escape($('sponsorsAddFile').value);
		time = escape($('sponsorsAddTime').value).toInt();
		
		if(time != "" && name != "" && $type(time) == "number")
			sponsorsRequest.send("action=save&name=" + name + "&file=" + file + "&time=" + time);
		else {
			
			if(time == "" || $type(time) != "number")
				new Fx.Tween('sponsorsAddTimeBox', {
					link: 'chain'
				}).start('border-color', '#f77').start('border-color', '#777');
			
			if(name == "")
				new Fx.Tween('sponsorsAddNameBox', {
					link: 'chain'
				}).start('border-color', '#f77').start('border-color', '#777');
			
		}
		
	},
	
	add: function(id, text) {
		
		var li = new Element('li', {
			'id': 'sponsor_' + id,
			'html': text
		});
		
		var liMorph = new Fx.Morph(li);
		
		liMorph.set({
			'height': 0,
			'padding-top': 0,
			'padding-bottom': 0
		});
		
		li.inject('sponsors', 'top');
		
		//myTips.attach('#' + li.id + ' .tooltip');
		sponsorSortables.addItems(li);
		
		var scrollSize = li.getScrollSize();
		liMorph.start({
			'height': scrollSize.y,
			'padding-top': '5px',
			'padding-bottom': '5px'
		});
		
	},
	
	delete: function(id) {
		
		if(confirm("Sponsor #" + id + " entfernen?!"))
			sponsorsRequest.send("action=delete&id=" + id);
		
	},
	
	remove: function(id) {
		
		new Fx.Morph('sponsor_' + id, {
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
	
	hideList: function() {
		
		$('sponsors').setStyle('height', 0);
		$('sponsorsCollapesButton').set('html', '[+] Liste einblenden');
		
	},
	
	toggleList: function() {
		
		size = $('sponsors').getSize();
		
		if(size.y == 0) {
			
			scrollSize = $('sponsors').getScrollSize();
			new Fx.Tween('sponsors').start('height', scrollSize.y);
			$('sponsorsCollapesButton').set('html', '[&ndash;] Liste ausblenden');
			
			status = "show";
			
		} else {
			
			new Fx.Tween('sponsors').start('height', 0);
			$('sponsorsCollapesButton').set('html', '[+] Liste einblenden');
			
			status = "hide";
			
		}
		
		sponsorsRequest.send('action=togglelist&status=' + status);
		
	},
	
	serialize: function() {
		
		serial = sponsorSortables.serialize(0, function(element, index){
			return element.getProperty('id').replace('sponsor_', '') + "=" + index;
		}).join('&');
		
		sponsorsRequest.send("action=serialize&" + serial);
		
	}
	
});
var sponsors = new SponsorsClass();

$$('#sponsors li').addEvent('mouseenter', function(event) {
	if(event.alt && event.control)
		sponsors.toggleActive(this.id.replace('sponsor_', ''));
});

var sponsorSortables = new Sortables('sponsors', {
	clone: true,
	constrain: true,
	opacity: .5,
	revert: true,
	handle: '.handle',
	onComplete: function() {
		sponsors.serialize();
	}
});