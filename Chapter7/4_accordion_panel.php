<html>
<head>
    <title>Basic Layout</title>
    <link rel="stylesheet" type="text/css" href="../lib/extjs/resources/css/ext-all.css" />
 	<script type="text/javascript" src="../lib/extjs/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../lib/extjs/ext-all.js"></script>
	<script>
	Ext.onReady(function(){
		Ext.BLANK_IMAGE_URL = 'images/s.gif';
		Ext.QuickTips.init();
		
		function genre_name(val){
			return genres.queryBy(function(rec){
				return rec.data.id == val;
			}).itemAt(0).data.genre;
		}

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
			layout: "border",
			id: 'movieview',
			renderTo: document.body,
			items: [{
				region: "north",
				xtype: 'panel',
				html: 'North'
			},{
				region: 'west',
				xtype: 'panel',
				split: true,
				width: 200,
				html: 'West'
			},{
				region: 'center',
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
					view: new Ext.grid.GroupingView(),
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true
					}) 
				},{
					title: 'Movie Descriptions',
					layout: 'accordion',
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
				}]
			},{
				region: 'east',
				xtype: 'panel',
				split: true,
				width: 200,
				html: 'East'
			},{
				region: 'south',
				xtype: 'panel',
				html: 'South'
			}]
		}); 

	});
	</script>
</head>
<body>
</body>
</html>