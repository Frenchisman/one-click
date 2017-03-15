<?php
	function call($controller, $action){
		//require the controller file
		require_once('controllers/'.$controller.'_controller.php');

		//Instanciate controllr
		switch($controller){
			case('base'):
				$controller = new BaseController();
			break;
			case('install'):
				$controller = new InstallController();
			break;


		}

		$controller->{ $action }();
	}

	//List of allowed controllers and their actions
	$controllers = array(
		'base' => ['home', 'error'],
		'install' => ['validate', 'create'],
		);

	//Check that the controller exists and the action i allowed for that controller
	//If not, redirect to base error.
	if(array_key_exists($controller, $controllers)){
		if(in_array($action, $controllers[$controller])){
			call($controller, $action);
		}
		else{
			call('base', 'error');
		}
	}
	else{
		call('base', 'error');
	}
?>