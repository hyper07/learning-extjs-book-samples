<html>
<head>
    <title>Paging Grid</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all.js"></script>
	<script>
	Ext.onReady(function(){
		Ext.BLANK_IMAGE_URL = 'images/s.gif';
		Ext.QuickTips.init();
		
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
			return genres.queryBy(function(rec, id){
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
			url: 'movies-paged.php',
			reader: new Ext.data.JsonReader({
				root:'rows',
				totalProperty: 'results',
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
			renderTo: Ext.getBody(),
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
					renderer: Ext.util.Format.dateRenderer('m/d/Y')},
		      {header: "Genre", dataIndex: 'genre', renderer: genre_name, sortable: true},
		      {header: "Tagline", dataIndex: 'tagline', hidden: true},
			  {header: "Price", dataIndex: 'price', renderer: 'usMoney', sortable: true}
		    ],
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true,
				listeners: {
					rowselect: {
						fn: function(sm,index,record) { Ext.Msg.alert('You Selected',record.data.title); }
					}
				}
			}),
			bbar: new Ext.PagingToolbar({
				pageSize: 3,
				store: store
			})
		 });
		
	});
	</script>
</head>
<body>
</body>
</html>