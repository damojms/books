<?php
	/*
		Name:		 Calibre PHP webserver
		license:	 GPL v3
		copyright:	 2010, Charles Haley
	                 http://charles.haleys.org
	*/

	require_once 'book_base.php';

	/*
	 * Handler for lists of books matching a particular category value
	 */

	class DoCatval extends BookBase {

		function check_arguments($db) {
			if (!isset($_REQUEST['id']))
				return "Missing 'id' argument in query string";
			if (!isset($_REQUEST['cat']))
				return "Missing 'cat' argument in query string";
			if (!isset($_REQUEST['v']))
				return "Missing 'v' argument in query string";
			if (!isset($_REQUEST['p']))
				return "Missing 'p' (page) argument in query string";
			if (!is_numeric($_REQUEST['p']))
				return "Page 'p' argument in query string not numeric";
			if ($_REQUEST['p'] <= 0)
				return "Page 'p' argument invalid value";
			return false;
		}

		function do_work($smarty, $db) {
			global $config;
			$cat = $_REQUEST['cat'];
			$id = $_REQUEST['id'];
			$short_form = $config['use_short_form'];
			$books = $db->books_in_category($cat, $id, $short_form);
			$this->do_books($smarty, $db, $books, $short_form, array(
											array('m', 'catval'),
											array('id', $id),
											array('cat', $cat),
											array('v', $_REQUEST['v'])
										));
			$smarty->assign('category_name', $fm = $db->fm->name_for($cat));
			$smarty->assign('category_value', $_REQUEST['v']);
			$smarty->assign('up_url', "index.php?m=category&amp;id=$id&amp;cat=".urlencode($cat));
		}

		function template() {
			return 'books.tpl';
		}

	}
	$mod = new DoCatval();
?>
