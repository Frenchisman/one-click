<?php
	class InstallController{

		public function validate(){
			$ini = parse_ini_file('config/config.ini');
			//check variables exist
			$required = array(
					'db_name',
					'db_user',
					'db_password',
					'db_host',
					'table_prefix'
				);

			$form_errors = [];

			foreach($required as $field){
				if(empty($_POST[$field])){
					$form_errors['empty'] = true;
				}
			}

			if(!empty($form_errors)){
				require_once('views/pages/install.php');

			}	
			else{
				//Form is filled out, check db connection.
				$db_name = $_POST['db_name'];
				$db_user = $_POST['db_user'];
				$db_password = $_POST['db_password'];
				$db_host = $_POST['db_host'];
				$table_prefix = $_POST['table_prefix'];

				if(Database::checkConnection($db_host, $db_name, $db_user, $db_password) == true){
					//Store values in session in connection infos are ok.
					session_start();					
					$_SESSION['db_name'] = $db_name;
					$_SESSION['db_user'] = $db_user;
					$_SESSION['db_password'] = $db_password;
					$_SESSION['db_host'] = $db_host;
					$_SESSION['table_prefix'] = $table_prefix;

					require_once('views/pages/install_p2.php');
				}
				else{
					//redirect to form if connection failed
					$form_errors['connection'] = true;
					require_once('views/pages/install.php');
				}

			}
		}

		public function create(){

			$required = array(
				'user_id', 
				'password'
			);
			//Check fields are filled
			foreach($required as $field){
				if(empty($_POST[$field])){
					$form_errors['empty'] = true;
				}
			}

			if(!empty($form_errors)){
				require_once('views/pages/install_p2.php');

			}	
			else{
				//Get our pdo object from db
				//Get dbh from DAtabase object 
//				$dbh = Database::getInstance();
				session_start();
				$db_name = $_SESSION['db_name'];
				$db_user = $_SESSION['db_user'];
				$db_password = $_SESSION['db_password'];
				$db_host = $_SESSION['db_host'];
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$dbh = new pdo( 'mysql:host'.$db_host.';db_name='.$db_name,
					$db_user,
					$db_password,
					$pdo_options);


				$sql_table_users = "CREATE TABLE IF NOT EXISTS ".$_SESSION['table_prefix']."_users(
				id INT(11) AUTO_INCREMENT PRIMARY KEY,
				login VARCHAR(250) NOT NULL,
				pass VARCHAR(250) NOT NULL,
				nom VARCHAR(250),
				prenom VARCHAR(250)
				);";

				$sql_table_resources = "CREATE TABLE IF NOT EXISTS ".$_SESSION['table_prefix']."_resources(
				id INT(11) AUTO_INCREMENT PRIMARY KEY,
				contenu VARCHAR(250) NOT NULL,
				proprietaire INT(11),
				FOREIGN KEY(proprietaire) REFERENCES ".$_SESSION['table_prefix']."_users(id)
				);";


				$sql_add_user = "INSERT INTO ".$_SESSION['table_prefix']."_users (login, pass) values ('".$_POST['user_id']."', '".$_POST['password']."');";

				try{
					$dbh->beginTransaction();
					$dbh->exec("USE ".$db_name);
					$dbh->exec($sql_table_users);
					$dbh->exec($sql_table_resources);
					$dbh->exec($sql_add_user);
					$dbh->commit();

					//If all went ok write to config file.
					$ini_array = array(
						'db_name' => $_SESSION['db_name'],
						'db_user' => $_SESSION['db_user'],
						'db_password' => $_SESSION['db_password'],
						'db_host' => $_SESSION['db_host'],
						'table_prefix' => $_SESSION['table_prefix'],
						'installed' => true
						);
					self::write_php_ini($ini_array, 'config/config.ini');
					echo("Creation Successful");
				}
				catch(PDOException $e){
					$dbh->rollBack();
					print($e);
					$form_errors['creation'] = true;
					require_once('views/pages/install_p2.php');
				}


			}
		}

		private function write_php_ini($array, $file)
		{
		    $res = array();
		    foreach($array as $key => $val)
		    {
		        if(is_array($val))
		        {
		            $res[] = "[$key]";
		            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
		        }
		        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
		    }
		    self::safefilerewrite($file, implode("\r\n", $res));
		}

		private function safefilerewrite($fileName, $dataToSave)
		{    if ($fp = fopen($fileName, 'w'))
		    {
		        $startTime = microtime(TRUE);
		        do
		        {            $canWrite = flock($fp, LOCK_EX);
		           // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
		           if(!$canWrite) usleep(round(rand(0, 100)*1000));
		        } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

		        //file was locked so now we can store information
		        if ($canWrite)
		        {            fwrite($fp, $dataToSave);
		            flock($fp, LOCK_UN);
		        }
		        fclose($fp);
		    }

		}
	}

?>