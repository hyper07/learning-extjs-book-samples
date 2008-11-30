<html>
<head>
    <title>Editor Grids</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
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
		
	    var genres = new Ext.data.SimpleStore({
	        fields: ['id', 'genre'],
	        data : [['0','New Genre'],['1','Comedy'],['2','Drama'],['3','Action']]
	    });
		
		function genre_name(val){
			return genres.queryBy(function(rec){
				return rec.data.id == val;
			}).itemAt(0).data.genre;
		}
		
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
			url: 'movies.php',
			reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
				id:'id'
			}, ds_model)
	    });
	
		store.load();
	
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
	
	    var grid = new Ext.grid.EditorGridPanel({
			renderTo: document.body,
			frame:true,
			title: 'Movie Database',
	        height:300,
	        width:520,
			enableColumnMove: false,
	        store: store,
			clicksToEdit: 2,
	        columns: [
				{header: "Title", dataIndex: 'title', editor: title_edit},
				{header: "Director", dataIndex: 'director', editor: director_edit},
				{header: "Released", dataIndex: 'released', renderer: Ext.util.Format.dateRenderer('m/d/Y'), editor: release_edit},
				{header: "Genre", dataIndex: 'genre', renderer: genre_name, editor: genre_edit},
				{header: "Tagline", dataIndex: 'tagline', editor: tagline_edit}
	        ],
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true
			}),
			listeners: {
				afteredit: function(e){
					var conn = new Ext.data.Connection();
					conn.request({
						url: 'movies-update.php',
						params: {
							action: 'update',
							id: e.record.id,
							field: e.field,
							value: e.value
						},
						success: function(resp,opt) {
							e.commit();
						},
						failure: function(resp,opt) {
							e.reject();
						}
					});
				}
			},
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
										var conn = new Ext.data.Connection();
										conn.request({
											url: 'movies-update.php',
											params: {
												action: 'delete',
												id: sel.data.id
											},
											success: function(resp,opt) { 
												grid.getStore().remove(sel); 
											},
											failure: function(resp,opt) { 
												Ext.Msg.alert('Error','Unable to delete movie'); 
											}
										});
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
				text: 'Add Movie',
				icon: 'images/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function() {
					var conn = new Ext.data.Connection();
					conn.request({
						url: 'movies-update.php',
						params: {
							action: 'insert',
							title:'New Movie'
						},
						success: function(resp,opt) {
							var insert_id = Ext.util.JSON.decode(resp.responseText).insert_id;
							grid.getStore().insert(0, new ds_model({id:insert_id,title:'New Movie',director:'',genre:0,tagline:''}));
							grid.startEditing(0,0);
						},
						failure: function(resp,opt) {
							Ext.Msg.alert('Error','Unable to add movie');
						}
					});
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
									var conn = new Ext.data.Connection();
									conn.request({
										url: 'movies-update.php',
										params: {
											action: 'delete',
											id: sel.data.id
										},
										success: function(resp,opt) { 
											grid.getStore().remove(sel); 
										},
										failure: function(resp,opt) { 
											Ext.Msg.alert('Error','Unable to delete movie'); 
										}
									});
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