<?php

	class Worker {

		//------------------------------------------------------------ private variables
		private $connection;

		//------------------------------------------------------------constructor method
		public function __construct(){
			// Require DB congifuration and connect to DB
			require_once('config/config.php');

			try {
				// Open connection to the database
				$this->connection = new PDO("mysql:host=". DB_HOST .";db=" . DB, DB_USER, DB_PASS});
				// Set error mode
				$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	        } catch (PDOException $e) {
	        	// Print error
	            die($e->getMessage());
	        }
		}
		

		//----------------------------------------------------------deconstructor method
		public function __destruct() {
			
			try {
				// Close the connection to the database
				$this->connection = null;
			} catch (PDOException $e) {
				// Print error
				die($e->getMessage());
			}
		}
		
	}

?>