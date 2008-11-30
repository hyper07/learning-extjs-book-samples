<html>
<head>
    <title>Editor Grids</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all-debug.js"></script>
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
		
	    var genres = new Ext.data.SimpleStore({
	        fields: ['id', 'genre'],
	        data : [['0','New Genre'],['1','Comedy'],['2','Drama'],['3','Action']]
	    });
		
		function genre_name(val){
			return genres.queryBy(function(rec){
				return rec.data.id == val;
			}).itemAt(0).data.genre;
		}
		
		var title_edit = new Ext.form.TextField({
			allowBlank: false,
			maxLength: 45
		});
	
		var director_edit = new Ext.form.TextField({
			allowBlank: false,
			maxLength: 45,
			vtype: 'name'
		});
	
		var genre_edit = new Ext.form.ComboBox({
			typeAhead: true,
			triggerAction: 'all',
			mode: 'local',
			store: genres,
			displayField:'genre',
			valueField: 'id',
			listeners: {
				select: function(f,r,i){
					if (i === 0){
						Ext.Msg.prompt('New Genre','Name',Ext.emptyFn);
					}
				}
			}
		});
	
		release_edit = new Ext.form.DateField({
            format: 'm/d/Y'
        });
	
		var tagline_edit = new Ext.form.TextField({
			allowBlank: false,
			maxLength: 45
		});
		
		var ds_model = Ext.data.Record.create([
			'id',
			'coverthumb',
			'title',
			'director',
			{name: 'released', type: 'date', dateFormat: 'Y-m-d'},
			'genre',
			'tagline',
			{name: 'price', type: 'float'},
			{name: 'available', type: 'bool'}
		]);
		
	    var store = new Ext.data.Store({
			data: [
				[1,"84m.jpg","Office Space","Mike Judge","1999-02-19",1,"Work Sucks",19.95,true],
				[3,"42m.jpg","Super Troopers","Jay Chandrasekhar","2002-02-15",1,"Altered State Police",14.95,1],
				[4,"12m.jpg","American Beauty","Sam Mendes","1999-10-01",2,"... Look Closer",19.95,true],
				[5,"49m.jpg","The Big Lebowski","Joel Coen","1998-03-06",1,"The \"Dude\"",21.9,'true'],
				[6,"94m.jpg","Fight Club","David Fincher","1999-10-15",3,"How much can you know about yourself...",19.95,true]
		    ],
			reader: new Ext.data.ArrayReader({id:'id'}, ds_model)
	    });
	
	    var grid = new Ext.grid.EditorGridPanel({
			id: 'sample-grid',
			renderTo: document.body,
			frame:true,
			title: 'Movie Database',
	        height:250,
	        width:520,
			enableColumnMove: false,
	        store: store,
	        columns: [
				{header: "Title", dataIndex: 'title', editor: title_edit},
				{header: "Director", dataIndex: 'director', editor: director_edit},
				{header: "Released", dataIndex: 'released', renderer: Ext.util.Format.dateRenderer('m/d/Y'), editor: release_edit},
				{header: "Genre", dataIndex: 'genre', renderer: genre_name, editor: genre_edit},
				{header: "Tagline", dataIndex: 'tagline', editor: tagline_edit}
	        ],
			listeners: {
				afteredit: function(e){
					if (e.field == 'director' && e.value == 'Mel Gibson'){
						Ext.Msg.alert('Error','Mel Gibson movies not allowed');
						e.record.reject();
					}else{
						e.record.commit();
					}
				}
			},
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true
			}),
			keys: [
				{
					key: 46,
					fn: function(key,e){
						var sm = grid.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							Ext.Msg.show({
								title: 'Remove Movie', 
								buttons: Ext.MessageBox.YESNOCANCEL,
								msg: 'Remove '+sel.data.title+'?',
								fn: function(btn){
									if (btn == 'yes'){
										 grid.getStore().remove(sel);
									}
								}
							});
						}
					},
					ctrl:false,
					stopEvent:true
				}
			],
			tbar: [{
				text: 'Add Movie (First)',
				icon: 'images/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function() {
					grid.getStore().insert(0, new ds_model({title:'New Movie',director:'',genre:0,tagline:''}));
					grid.startEditing(0,0);
				}
			},{
				text: 'Add Movie (Last)',
				icon: 'images/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function() {
					grid.getStore().insert(grid.getStore().getCount(), new ds_model({title:'New Movie',director:'',genre:0,tagline:''}));
					grid.startEditing(grid.getStore().getCount()-1,0);
				}
			},{
				text: 'Remove Movie',
				icon: 'images/table_delete.png',
				cls: 'x-btn-text-icon',
				handler: function() {
					var sm = grid.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						Ext.Msg.show({
							title: 'Remove Movie', 
							buttons: Ext.MessageBox.YESNOCANCEL,
							msg: 'Remove '+sel.data.title+'?',
							fn: function(btn){
								if (btn == 'yes'){
									 grid.getStore().remove(sel);
								}
							}
						});
					}
				}
			}]
	    });
		
	});
	</script>
</head>
<body>
</body>
</html>