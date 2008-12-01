<html>
<head>
    <title>Layout With Many Additions</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
	<style>
		.bomb {
			background-image:url(images/bomb.png) !important;
		}
	</style>
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all.js"></script>
   	<script>
	Ext.onReady(function(){
		Ext.BLANK_IMAGE_URL = 'images/s.gif';
		Ext.QuickTips.init();
		
        Ext.form.VTypes.nameVal  = /^([A-Z]{1})[A-Za-z\-]+ ([A-Z]{1})[A-Za-z\-]+/;
		Ext.form.VTypes.nameMask = /[A-Za-z\- ]/;
		Ext.form.VTypes.nameText = 'In-valid Director Name.';
		Ext.form.VTypes.name 	= function(v){
			return Ext.form.VTypes.nameVal.test(v);
		};
		
		var Movies = function() {
			return {
				showHelp : function(btn){
                    var moreinfo = Ext.getCmp('movieview').findById('moreinfo');
					if (!moreinfo.isVisible()){ moreinfo.expand(); }
					moreinfo.load({url:'html/'+btn.helpfile+'.txt'});
				},
				showFullDesc : function(grid,index){
                    var moreinfo = Ext.getCmp('movieview').findById('moreinfo');
					var record = grid.getSelectionModel().getSelected().data;
					if (!moreinfo.isVisible()){ moreinfo.expand(); }
					moreinfo.load({url:'html/'+record.id+'.txt'});
				},
				doSearch : function(frm,evt){
                    var moreinfo = Ext.getCmp('movieview').findById('moreinfo');
					if (!moreinfo.isVisible()){ moreinfo.expand(); }
					if (evt.getKey() == evt.ENTER) {
						moreinfo.body.dom.innerHTML = Ext.getCmp('genre').getValue()+' : '+frm.getValue();
					}
				},
				showFullDetails : function(grid,index){
                    var moreinfo = Ext.getCmp('movieview').findById('moreinfo');
					if (moreinfo.isVisible()){ moreinfo.collapse(); }
					var record = grid.getSelectionModel().getSelected().data;
					Ext.getCmp('movieview').findById('movietabs').add({
						title: record.title,
						close: true
					}).show().load({url: 'html/'+record.id+'.txt'});
				}
			};
		}();
		
		function genre_name(val){
			return genres.queryBy(function(rec){
				return rec.data.id == val;
			}).itemAt(0).data.genre;
		}

		// A longer format that does the same thing as above, but is easier to read
		/*function genre_name(val){
			return genres.queryBy(function(rec){
				if (rec.data.id == val){
					return true;
				}else{
					return false;
				}
			}).itemAt(0).data.genre;
		}*/

		function title_img(val, x, store){
			return  '<img src="images/'+store.data.coverthumb+'" width="50" height="68" align="left">'+
					'<b style="font-size: 13px;">'+val+'</b><br>'+
					'Director:<i> '+store.data.director+'</i><br>'+
					store.data.tagline;
		}
		
	    var store = new Ext.data.GroupingStore({
			url: 'movies.json',
			sortInfo: {
				field: 'genre', 
				direction: "ASC"
			},
			groupField: 'genre',
			reader: new Ext.data.JsonReader({
				root:'rows',
				id:'id'
			}, [
				'id',
				'coverthumb',
				'title',
				'director',
				{name: 'released', type: 'date', dateFormat: 'Y-m-d'},
				'genre',
				'tagline',
				{name: 'price', type: 'float'},
				{name: 'available', type: 'bool'}
			])
	    });
	
		store.load();
		
	    var genres = new Ext.data.SimpleStore({
	        fields: ['id', 'genre'],
	        data : [['0','New Genre'],['1','Comedy'],['2','Drama'],['3','Action']]
	    });
		
		var viewport = new Ext.Viewport({
			layout: 'border',
			id: 'movieview',
			renderTo: document.body,
			items: [{
				region: "north",
				xtype: 'toolbar',
				border: true,
				items: [{
					xtype: 'tbspacer'
				},{
					xtype: 'tbbutton',
					text: 'Button',
					handler: function(btn){
						btn.disable();
					}
				},{
					xtype: 'tbfill'
				},{
					xtype: 'tbbutton',
					text: 'Menu Button',
					menu: [{
						text: 'Better'
					},{
						text: 'Good'
					},{
						text: 'Best'
					}]
				},{
					xtype: 'tbseparator'
				},{
					xtype: 'tbsplit',
					text: 'Help',
					menu: [{
						text: 'Genre',
						helpfile: 'genre',
						handler: Movies.showHelp
					},{
						text: 'Director',
						helpfile: 'director',
						handler: Movies.showHelp
					},{
						text: 'Title',
						helpfile: 'title',
						handler: Movies.showHelp
					}]
				},{
					xtype: 'tbseparator'
				},{
					xtype: 'tbtext',
					text: 'Genre:'
				},{
					xtype: 'tbspacer'
				},{
					xtype: 'combo',
					id: 'genre',
					name: 'genre',
					mode: 'local',
					store: genres,
					displayField:'genre',
					width: 70
				},{
					xtype: 'tbspacer'
				},{
					xtype: 'textfield',
					listeners: {
						specialkey: Movies.doSearch
					}
				},{
					xtype: 'tbspacer'
				}]
			},{
				region: 'west',
				xtype: 'form',
				split: true,
				collapsible: true,
				collapseMode: 'mini',
				title: 'Movie Information Form',
				bodyStyle:'padding:5px;',
				width: 250,
				minSize: 250,
				items: [{
					xtype: 'textfield',
					fieldLabel: 'Title',
					name: 'title',
					anchor: '100%',
					allowBlank: false,
					listeners: {
						specialkey: function(f,e){
							if (e.getKey() == e.ENTER) {
								movie_form.getForm().submit();
							}
						}
					}
			    },{
					xtype: 'textfield',
					fieldLabel: 'Director',
					name: 'director',
					anchor: '100%',
					vtype: 'name'
			    },{
					xtype: 'datefield',
					fieldLabel: 'Released',
					name: 'released',
					disabledDays: [1,2,3,4,5]
			    },{
					xtype: 'radio',
					fieldLabel: 'Filmed In',
					name: 'filmed_in',
					boxLabel: 'Color'
				},{
					xtype: 'radio',
					hideLabel: false,
					labelSeparator: '',
					name: 'filmed_in',
					boxLabel: 'Black & White'
				},{
					xtype: 'checkbox',
					fieldLabel: 'Available?',
					name: 'available'
				},{
					xtype: 'combo',
					name: 'genre',
					fieldLabel: 'Genre',
					mode: 'local',
					store: genres,
					displayField:'genre',
					width: 130,
					listeners: {
						select: function(f,r,i){
							if (i === 0){
								Ext.Msg.prompt('New Genre','Name',Ext.emptyFn);
							}
						}
					}
				},{
					xtype: 'textarea',
					name: 'description',
					hideLabel: true,
					labelSeparator: '',
					height: 100,
					anchor: '100%'
				}],
				buttons: [{
					text: 'Save',
					handler: function(){
						movie_form.getForm().submit({
							success: function(f,a){
								Ext.Msg.alert('Success', 'It worked');
							},
							failure: function(f,a){
								console.log(a);
								Ext.Msg.alert('Warning', a.result.errormsg);
							}
						});
					}
				}, {
					text: 'Reset',
					handler: function(){
						movie_form.getForm().reset();
					}
				}]
			},{
				region: 'center',
				id: 'movietabs',
				xtype: 'tabpanel',
				activeTab: 0,
				items: [{
					title: 'Movie Grid',
					xtype: 'grid',
					store: store,
					autoExpandColumn: 'title',
					columns: [
						{header: "Title", dataIndex: 'title', renderer: title_img, id: 'title', sortable: true},
						{header: "Director", dataIndex: 'director', hidden: true},
						{header: "Released", dataIndex: 'released', sortable: true, renderer: Ext.util.Format.dateRenderer('m/d/Y'), width: 80},
						{header: "Genre", dataIndex: 'genre', renderer: genre_name, sortable: true, width: 80},
						{header: "Tagline", dataIndex: 'tagline', hidden: true},
						{header: "Price", dataIndex: 'price', renderer: 'usMoney', sortable: true, width: 60}
				    ],
					listeners: {
						rowdblclick: {
							fn: Movies.showFullDetails
						},
						rowclick: {
							fn: Movies.showFullDesc
						}
					},
					view: new Ext.grid.GroupingView(),
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true
					})
				},{
					title: 'Movie Descriptions',
					layout: 'accordion',
					defaults: {bodyStyle:'padding:5px;font-family:Arial;font-size:10pt;'},
					layoutConfig: {animate: true},
					items: [{
						title: 'Office Space',
						autoLoad: 'html/1.txt'
					},{
						title: 'Super Troopers',
						autoLoad: 'html/3.txt'
					},{
						title: 'American Beauty',
						autoLoad: 'html/4.txt'
					}]
				},{
					title: 'Nested Layout',
					layout: 'border',
					border: false,
					items: [{
						region: 'north',
						height: 100,
						split: true,
						html: 'Nested North'
					},{
						region: 'center',
						html: 'Nested Center'
					}]
				},{
					title: 'The Bomb',
					iconCls: 'bomb',
					html: 'Boom!'
				}]
			},{
				region: 'east',
				xtype: 'panel',
				id: 'moreinfo',
				bodyStyle:'padding:5px;font-family:Arial;font-size:10pt;',
				split: true,
				collapsed: true,
				collapsible: true,
				collapseMode: 'mini',
				width: 200
			}]
		}); 

	});
	</script>
</head>
<body>
</body>
</html>