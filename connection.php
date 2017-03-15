<?php 

	class Database{
		private static $instance = NULL;

		private function __construct() {}

		private function __clone() {}

		public static function getInstance(){
			//@TODO get instance of the database from config.ini
			if(!isset(self::$instance)){
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				//create db instance here from config.ini
			}
			return self::$instance;
		}

		//if connection is ok set instance and return true else return false
		public static function checkConnection($db_host, $db_name, $db_user, $db_password){
			try{
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$dbh = new pdo( 'mysql:host'.$db_host.';db_name='.$db_name,
					$db_user,
					$db_password,
					$pdo_options);
				self::$instance = $dbh;

				return true;
			}
			catch(PDOException $e){
				return false;
			}
		}
	}