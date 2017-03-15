<?php 

	class Database{
		private static $instance = NULL;

		private function __construct() {}

		private function __clone() {}

		public static function getInstance(){
			//@TODO get instance of the database from config.php

			if(!isset(self::$instance)){
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				//create db instance here
			}
			return self::$instance;
		}
	}