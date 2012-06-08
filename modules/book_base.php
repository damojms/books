<?php
	/*
		Name:		 Calibre PHP webserver
		License:	 GPL v3
		Copyright:	 2010, Charles Haley
	                 http://charles.haleys.org
	*/
	require_once 'module.php';
	require_once 'db.php';

	/*
	 * This handler should never be used directly. It is instead the base class
	 * for handlers that need to produce lists of books.
	 */

	class BookBase extends Module {

		/*
		 * Produce the appropriate values for the smarty templates that renders
		 * a list of books. Mainly concerns paging
		 */
		function do_books($smarty, $db, $books, $short_form, $p_n_array) {
			global $config, $sortable_fields;

			$page = $_REQUEST['p'];
			$start = ($page-1) * $config['books_page_count'];
			if ($start > count($books)) {
				$page = (int)(count($books)/$config['books_page_count']);
				$start = $page*$config['books_page_count'];
				$page++;
			}
			$end = $start + $config['books_page_count'];
			$res = array();
			// Get the books for page N
			for ($i = min($start, count($books)); $i < min($end, count($books)); $i++) {
				$res[] = $books[$i];
				$res[count($res)-1]['cover'] = 'index.php?m=cover&amp;id=' . $books[$i]['id'];
				if ($short_form)
					$res[count($res)-1]['details_url'] =
								'index.php?m=book&amp;id=' . $books[$i]['id'];
			}
			$smarty->assign('books', $res);
			$p_n_url = '';
			foreach ($p_n_array as $v) {
				$p_n_url .= "$v[0]=" . urlencode($v[1]) . "&";
			}
			if ($page > 1)
				$smarty->assign('page_back', "index.php?{$p_n_url}p=" . ($page-1));
			if ($end < count($books))
				$smarty->assign('page_forw', "index.php?$p_n_url&amp;p=" . ($page+1));
			$smarty->assign('page', $page);
			$smarty->assign('maxpage', (int)((count($books)-1)/$config['books_page_count'])+1);
			$smarty->assign('sortable_fields', $sortable_fields);
			$smarty->assign('current_sortable', $_SESSION['sort_books_on']);
			$smarty->assign('current_sort_direction', $_SESSION['sort_books_ascending'] ? 0 : 1);
			$smarty->assign('prev_next', $p_n_array);
		}
	}
?>
