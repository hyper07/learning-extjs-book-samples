The following are samples provided to accompany the Learning ExtJS book written by Shea Frederick,
Colin Ramsay & Steve ‘Cutter’ Blades - published by Packt Publishing. ISBN 13: 978-1-847195-14-2

http://www.packtpub.com/learning-ext-js/

All examples assume the ExtJS library files are installed in the same folder as this readme file
in a '/lib/extjs/' folder. So after the ExtJS library files are placed into this folder you 
should end up with a folder structure like the following:

/lib/extjs/
/lib/extjs/adapter/
/lib/extjs/resources/
/lib/extjs/ext-all.js
/lib/extjs/ext-all-debug.js

and so on...

The ExtJS SDK by default extracts to a version named folder, ie: 'ext-2.2' which can be extracted 
to the '/lib/' folder and then either renamed to be non-version specific, ie: 'extjs' or a 
symbolic link can be created.

/lib/extjs/ -> /lib/ext-2.2/
/lib/ext-2.2/

If the database examples are to be used, then a seperate '/cfg/' folder should also be created in 
the same folder as this readme file. This folder needs a single file which connects to your 
database. The file might look something like this...

<?php
$link = mysql_pconnect("localhost", "test", "testuser") or die("Could not connect");
mysql_select_db("test") or die("Could not select database");
?>

Change the connection strings to connect to your own database and install the database.sql file 
also found in this folder to create the test database tables.

Enjoy
-Shea