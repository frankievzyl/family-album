<?php
	function call($controller, $action) {

		if($action == "settings") { $controller = 'user'; }
		
		require_once('controllers/'.$controller.'_controller.php');

		switch($controller) {
			case 'user':
				require_once('models/user.php');
				$controller = new User_Controller();
			break;
			case 'album':
				require_once('models/user.php');
				require_once('models/album.php');
				$controller = new Album_Controller();
			break;
			case 'pages':
				$controller = new Pages_Controller();
			break;
			case 'media':
				require_once('models/media.php');
				$controller = new Media_Controller();
			break;
			case 'note':
				require_once('models/note.php');
				$controller = new Note_Controller();
			break;
			case 'tag':
				require_once('models/tag.php');
				$controller = new Tag_Controller();
			break;
		}

		$controller->{ $action }();
	}

	$controllers = array(	'user' => ['settings', 'sign_up', 'log_in'],
						 	'album' => ['show_all', 'create', 'edit', 'delete'],
							'mediaalbum' => ['show_all', 'upload', 'add', 'remove']);

	
	isset($_GET['controller']) ? $controller = $_GET['controller'] : null;
	isset($_GET['action']) ? $action = $_GET['action'] : null;

  	if (array_key_exists($controller, $controllers)) {
  		if (in_array($action, $controllers[$controller])) {
  			call($controller, $action);
  		} else {
  			call('pages', 'error');
  		}
  	} else {
  		call('pages', 'error');
	}
?>