<?php
	/*
		Name:		 Calibre PHP webserver
		License:	 GPL v3
		Copyright:	 2010, Charles Haley
	                 http://charles.haleys.org
	*/

	require_once 'module.php';

	/*
	 * The handler for the index (front) page. Gets the categories. Fixed
	 * 'categories', such as titles, are handled in the template.
	 */
	class DoLogin extends Module {

		function do_work($smarty, $db) {
			$smarty->assign('message', $_REQUEST['msg']);
		}

		function template() {
			return 'login.tpl';
		}
	}
	$mod = new DoLogin();
?>