var msg = {
	alert : function() {
		Ext.Msg.alert('Hey!', 'Something happened.');
	},
	
	prompt : function() {

		var data = prompt('Tell me something');
	
		Ext.Msg.prompt('Hey!', 'Tell me something', function(btn, text){
			if (btn == 'ok'){
				var data = text;
			}
		});

	},
	
	mprompt : function() {
		Ext.Msg.prompt('Hey!', 'Tell me something', function(btn, text){
			if (btn == 'ok'){
				var data = text;
			}
		}, this, true, 'hi');
	},
	
	confirm : function() {
		Ext.Msg.confirm('Hey!', 'Is this ok?', function(btn, text){
			if (btn == 'ok'){
				// go ahead and do more stuff
			} else {
				// abort, abort!
			}
		});
	},
	
	progress : function() {
		Ext.Msg.progress('Hey!', 'We\'re waiting...', 'progressing');
		
		var count = 0;

		var interval = window.setInterval(function() {
			count = count + 0.04;
			
			Ext.Msg.updateProgress(count);
			
			if(count >= 1) {
				window.clearInterval(interval);
				Ext.Msg.hide();
			}
		}, 100);
	},
	
	simpleshow : function() {
		Ext.Msg.show({
			msg: 'AWESOME.'
		});
	},
	
	alertshow : function() {
		Ext.Msg.show({
			title:'Hey!',
			msg: 'Icons and Buttons! AWESOME.',
			icon: Ext.MessageBox.INFO,
			buttons: Ext.MessageBox.OK
		});
	}
};