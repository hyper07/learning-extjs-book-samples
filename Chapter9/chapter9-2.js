var windows = {

	basic : function() {
		var w = new Ext.Window({
			height:50,
			width: 100,
			closable: false,
			draggable: false,
			resizable: false
		});
		w.show();
	},

	basicplain : function() {
		var w = new Ext.Window({
			height:50,
			width: 100,
			closable: false,
			draggable: false,
			resizable: false,
			plain: true
		});
		w.show();
	},
	
	simple : function() {
		var w = new Ext.Window({height:50, width: 100});
		w.show();
	},
	
	html : function() {
		var w = new Ext.Window({
			height: 150, width: 200,
			title: 'A Window',
			html: '<h1>Oh</h1><p>HI THERE EVERYONE</p>'
		});
		w.show();
	},
	
	components : function() {
		var w = new Ext.Window({
			items:[
				{ xtype: 'textfield', fieldLabel: 'First Name'},
				new Ext.form.TextField({fieldLabel: 'Surname'})
			]
		});
		w.show();
	},
	
	formlayout : function() {

		var w = new Ext.Window({
			layout: 'form',
			items:[
				{ xtype: 'textfield', fieldLabel: 'First Name'},
				new Ext.form.TextField({fieldLabel: 'Surname'})
			]
		});
		w.show();
	},
	
	auto : function() {
		var w = new Ext.Window({width: 100, autoHeight: true,
			html: '<p>Curabitur bibendum dictum arcu. Nunc dolor nisi, mollis eu, scelerisque quis, gravida nec, mi. Pellentesque vitae erat. Curabitur bibendum dictum arcu. Nunc dolor nisi, mollis eu, scelerisque quis, gravida nec, mi. Pellentesque vitae erat.</p>'
		});
		w.show();
	},

	minmax : function() {
		var w = new Ext.Window({height:50, width: 100, minimizable: true, maximizable: true});
		w.show();
	},

	collapse : function() {
		var w = new Ext.Window({title: 'Collapse Me Baby', height:100, width: 150, collapsible: true});
		w.show();
	},
	
	showargs : function() {
		var w = new Ext.Window({
			height: 500,
			width: 500
		});
		w.show('animTarget', function() { alert('Now Showing'); }, this);
	},
	
	bars : function() {
		var w = new Ext.Window({
			tbar: [{ text: 'A tbar item'}],
			bbar: [{ text: 'A bbar item'}],
			buttons: [{text: 'A button'}],
			width: 300,
			height: 200,
			html: '<p>Curabitur bibendum dictum arcu. Nunc dolor nisi, mollis eu, scelerisque quis, gravida nec, mi. Pellentesque vitae erat. Curabitur bibendum dictum arcu. Nunc dolor nisi, mollis eu, scelerisque quis, gravida nec, mi. Pellentesque vitae erat.</p>'
		});
		w.show();
	},
	
	minimize : function() {
		var w = new Ext.Window({
			height: 50,
			width: 100,
			minimizable: true
		});
		w.on('minimize', doMin, w);
		w.show();
	}	
};

function doMin() {
	this.collapse(false);
	this.alignTo(document.body, 'bl-bl');
}