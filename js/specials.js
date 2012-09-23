// JavaScript Document

var specialsRequest = new Request({
	url: 'remotes/specials.remote.php',
	evalScripts: true
});

var specialsChangeTween = new Fx.Tween('specials', { link: 'chain' });
var specialsRefreshTween = new Fx.Tween('specialsRefreshButton', { link: 'chain' });

SpecialsClass = new Class({
	
	reload: function() {
		specialsRequest.send("action=reload");
	},
	
	change: function() {
		specialsRequest.send("action=change&value=" + $('specials').value);
	},
	
	highlightRefresh: function() {
		specialsRefreshTween.start('color', '#7f7').start('color', '#77f');
	},
	
	highlightSelect: function(color) {
		specialsChangeTween.start('border-color', color).start('border-color', '#777');
	}
	
});
var specials = new SpecialsClass();