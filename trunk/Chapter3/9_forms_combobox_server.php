<html>
<head>
    <title>Forms Example</title>
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
        
        var genres = new Ext.data.Store({
            reader: new Ext.data.JsonReader({
                fields: ['id', 'genre_name'],
                root: 'rows'
            }),
            proxy: new Ext.data.HttpProxy({
                url: 'data/genres.php'
            }),
            autoLoad: true
        });
        //genres.load();
        
		new Ext.FormPanel({ 
			url: 'movie-form-submit.php',
			renderTo: document.body,
			frame: true,
			title: 'Movie Information Form',
			width: 250,
			items: [{
				xtype: 'textfield',
				fieldLabel: 'Title',
				name: 'title',
				allowBlank: false
		    },{
				xtype: 'textfield',
				fieldLabel: 'Director',
				name: 'director',
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
				fieldLabel: 'Bad Movie',
				name: 'bad_movie'
			},{
				xtype: 'combo',
				name: 'genre',
				fieldLabel: 'Genre',
				mode: 'local',
				store: genres,
				displayField:'genre_name',
                valueField: 'id',
				width: 130
			},{
				xtype: 'htmleditor',
				name: 'description',
				hideLabel: true,
				labelSeparator: '',
				height: 100,
				anchor: '100%'
			}]
		});
	});
	
	</script>
</head>
<body>
</body>
</html>