<?php
	/*
		Name:		 Calibre PHP webserver
		license:	 GPL v3
		copyright:	 2010, Charles Haley
	                 http://charles.haleys.org
	*/

	require_once 'module.php';

	/*
	 * Handler for the all-titles page.
	 */

	class DoBook extends Module {

		function check_arguments($db) {
			if (!isset($_REQUEST['id']))
				return "Missing 'id' argument in query string";
			if (!is_numeric($_REQUEST['id']))
				return "id argument in query string not numeric";
			if ($_REQUEST['id'] <= 0)
				return "Page 'p' argument invalid value";
			return false;
		}

		function do_work($smarty, $db) {
			$book = $db->book($_REQUEST['id'], true, false);
			if (isset($book)) {
				$book['cover'] = 'index.php?m=cover&id=' . $book['id'];
				$smarty->assign('books', array($book));
				$args = array();
				foreach ($_SESSION['last_request'] as $k=>$v) {
					$args[] = "$k=" . urlencode($v);
				}
				$args = join('&', $args);
				$smarty->assign('up_url', "index.php?$args");
				$smarty->assign('use_back', 1);
			}
		}

		function template() {
			return 'titles.tpl';
		}
	}

	$mod = new DoBook();
?>