<?php

	class Worker {

		//------------------------------------------------------------constructor method
		public function __construct(){
			// Require DB congifuration and connect to DB
			require_once('config/config.php');
			mysql_connect (DB_HOST, USER, PASS) ;
			mysql_select_db (DB);
		}
		

		//----------------------------------------------------------deconstructor method
		public function __destruct() {
			// Close the connection to the database
			mysql_close();
		}
		
	}

?>