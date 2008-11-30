<html>
<head>
    <title>Grid Cell Rendering - Advanced</title>
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
			data: [
				[1,"84m.jpg","Office Space","Mike Judge","1999-02-19",1,"Work Sucks",19.95,true],
				[3,"42m.jpg","Super Troopers","Jay Chandrasekhar","2002-02-15",1,"Altered State Police",14.95,1],
				[4,"12m.jpg","American Beauty","Sam Mendes","1999-10-01",2,"... Look Closer",19.95,true],
				[5,"49m.jpg","The Big Lebowski","Joel Coen","1998-03-06",1,"The \"Dude\"",21.9,'true'],
				[6,"94m.jpg","Fight Club","David Fincher","1999-10-15",3,"How much can you know about yourself...",19.95,true]
		    ],
			reader: new Ext.data.ArrayReader({id:'id'}, [
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
	
		var grid = new Ext.grid.GridPanel({
			renderTo: document.body,
			frame:true,
			title: 'Movie Database',
			height:400,
			width:520,
			store: store,
			autoExpandColumn: 'title',
			columns: [
		      {header: "Title", dataIndex: 'title', renderer: title_img, id: 'title', sortable: true},
		      {header: "Director", dataIndex: 'director', hidden: true},
		      {header: "Released", dataIndex: 'released', sortable: true,  
					renderer: Ext.util.Format.dateRenderer('m/d/Y'), width: 80},
		      {header: "Genre", dataIndex: 'genre', renderer: genre_name, sortable: true, width: 80},
		      {header: "Tagline", dataIndex: 'tagline', hidden: true},
			  {header: "Price", dataIndex: 'price', renderer: 'usMoney', sortable: true, width: 60}
		    ]
		 });
		
	});
	</script>
</head>
<body>
</body>
</html>