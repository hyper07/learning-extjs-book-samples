<html>
<head>
    <title>Grid Interaction</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all.js"></script>
	<script>
	Ext.onReady(function(){
		Ext.BLANK_IMAGE_URL = 'images/s.gif';
		Ext.QuickTips.init();
		
        // small override to allow setHidden to accept either an array or single value 
		Ext.override(Ext.grid.ColumnModel, {
			setHidden : function(colIndex, hidden){
				if(Ext.isArray(colIndex)){
					Ext.each(colIndex, function(n){
					        var c = this.config[n];
				        	if(c.hidden !== hidden){
				    	        	c.hidden = hidden;
					        }
							this.totalWidth = null;
							this.fireEvent("hiddenchange", this, n, hidden);
					},this);
				}else{
				    var c = this.config[colIndex];
				    if(c.hidden !== hidden){
				        c.hidden = hidden;
						this.totalWidth = null;
						this.fireEvent("hiddenchange", this, colIndex, hidden);
					}
				}
			}
		});
		
	    var genres = new Ext.data.SimpleStore({
	        fields: ['id', 'genre'],
	        data : [['1','Comedy'],['2','Drama'],['3','Action']]
	    });
		
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
		
	    var store = new Ext.data.Store({
			url: 'movies.xml',
			reader: new Ext.data.XmlReader({
				record:'row',
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
	
		var grid = new Ext.grid.GridPanel({
			renderTo: document.body,
			frame:true,
			title: 'Movie Database',
			height:300,
			width:520,
			store: store,
			autoExpandColumn: 'title',
			columns: [
		      {header: "Title", dataIndex: 'title', renderer: title_img, id: 'title', sortable: true},
		      {header: "Director", dataIndex: 'director', hidden: true},
		      {header: "Released", dataIndex: 'released', sortable: true,  
					renderer: Ext.util.Format.dateRenderer('m/d/Y'), id: 'released'},
		      {header: "Genre", dataIndex: 'genre', renderer: genre_name, sortable: true},
		      {header: "Tagline", dataIndex: 'tagline', hidden: true},
			  {header: "Price", dataIndex: 'price', renderer: 'usMoney', sortable: true, id: 'price'}
		    ],
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true
			}),
			tbar: [{
                // changes the title of the currently selected row usign a messagebox
				text: 'Change Title',
				handler: function(){
					var sm = grid.getSelectionModel();
                    // get the selected row (if exists)
					var sel = sm.getSelected();
                    // has something been selected?
					if (sm.hasSelection()){
						Ext.Msg.show({
							title: 'Change Title', 
							prompt: true,
							buttons: Ext.MessageBox.OKCANCEL,
							value: sel.data.title, 
							fn: function(btn,text){
								if (btn == 'ok'){
                                    // set a new value for one of the
                                    // columns in our selected row
									sel.set('title', text); 
								}
							}
						});
					}
				}
			},'-',{
                // hides or shows a single pre-defined column
				text: 'Hide Price',
				handler: function(btn){
					var cm = grid.getColumnModel();
					var pi = cm.getIndexById('price');
                    // is this column visible?
					if (cm.isHidden(pi)){
						cm.setHidden(pi,false);
						btn.setText('Hide Price');
					}else{
						cm.setHidden(pi,true);
						btn.setText('Show Price');
					}
					btn.render();
				}
			},'-',{
                // hides or shows two pre-defined columns
				text: 'Hide Price & Released',
				handler: function(btn){
					var cm = grid.getColumnModel();
					var pi = cm.getIndexById('price');
					var rl = cm.getIndexById('released');
                    // is this column visible
					if (cm.isHidden(pi)){
						cm.setHidden([pi,rl],false);
						btn.setText('Hide Price & Released');
					}else{
						cm.setHidden([pi,rl],true);
						btn.setText('Show Price & Released');
					}
					btn.render();
				}
			},'-',{
                // removes the currently selected row
				text: 'Remove Movie',
				id: 'tst',
				handler: function(){
					var sm = grid.getSelectionModel();
					var sel = sm.getSelected();
                    // has something been selected?
					if (sm.hasSelection()){
						Ext.Msg.show({
							title: 'Remove Movie', 
							buttons: Ext.MessageBox.YESNOCANCEL,
							msg: 'Remove '+sel.data.title+'?',
							fn: function(btn){
								if (btn == 'yes'){
                                    // remove the row from our data store
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