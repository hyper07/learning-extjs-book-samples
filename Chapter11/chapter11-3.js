
var people = [{
	id: 1,
	name: 'Sarah Jones',
	image: 'sarah.png',
	city: 'Leeds',
	country: 'UK'
}, {
	id: 2,
	name: 'Billy Heart',
	image: 'billy.png',
	city: 'Paris',
	country: 'France'
}, {
	id: 3,
	name: 'Sam Thomas',
	image: 'sam.png',
	city: 'New York',
	country: 'USA'
}, {
	id: 4,
	name: 'Laurie Kuler',
	image: 'laurie.png',
	city: 'Tokyo',
	country: 'Japan'
}, {
	id: 5,
	name: 'Franke Stein',
	image: 'franke.png',
	city: 'Sydney',
	country: 'Australia'
}];
	
var peopleRecord = Ext.data.Record.create([
	{ name: 'id' },
	{ name: 'name' },
	{ name: 'image' },
	{ name: 'city' },
	{ name: 'country' }
]);

var personStore = new Ext.data.Store({
	data: people,
	reader: new Ext.data.JsonReader({
		id: 'id'
	}, peopleRecord)
});

var personView = new Ext.DataView({
	tpl: '<tpl for=".">' +
			'<div class="person">' +
				'<h1>{name}</h1>' +
				'<div><img src="img/{image}" alt="{name}" /></div>' +
			'</div>' +
		 '</tpl>',
	itemSelector: 'div.person',
	store: personStore
});

var detailForm = new Ext.form.FormPanel({
	width: 250,
	height: 80,
	defaultType: 'textfield',
	items: [
		{ fieldLabel: 'Name', name:'name' },
		{ fieldLabel: 'City', name:'city' },
		{ fieldLabel: 'Country', name:'country' }
	]
});

Ext.onReady(function() {
	personView.render('people');
	detailForm.render('detail');

	new Ext.dd.DragZone(personView.getEl(), {
		getDragData : function(e) {
			var container = e.getTarget('div.person', 5, true);
			return {
				ddel : container.down('h1').dom,
				record : personView.getRecord(container.dom)
			}
		}
	});
	
	new Ext.dd.DropTarget(detailForm.body.dom, {
		notifyDrop  : function(source, e, data){
			
			detailForm.getForm().loadRecord(source.dragData.record);	

			return true;
		}
	}); 	


});