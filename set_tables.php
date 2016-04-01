<?php

include 'db_config.php';

try {
	$db = new PDO("mysql:host=localhost;dbname=".$CONFIG['dbname'], $CONFIG['username'], $CONFIG['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// event1 table
	$followersTable = "CREATE TABLE IF NOT EXISTS ecard (
			id INT(11) NOT NULL AUTO_INCREMENT,
			senderName VARCHAR(255) NOT NULL,
			sender VARCHAR(255) NOT NULL,
			receiver VARCHAR(255) NOT NULL,
			message TEXT NOT NULL,
			created_at DATETIME NOT NULL,
			PRIMARY KEY(id)
		) COLLATE=utf8_general_ci AUTO_INCREMENT=0";

	$followersTableResult = $db->exec($followersTable);

	if ($followersTableResult === 0):
		echo "ecard table created\r\n";
	endif;

}
catch (Exception $e) {
	echo $e->getMessage();
}