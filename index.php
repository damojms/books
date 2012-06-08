<?php
	/*
		Name:		 Calibre PHP webserver
		license:	 GPL v3
		copyright:	 2010, Charles Haley
	                 http://charles.haleys.org
	*/

	require_once 'config.php';
	$config['current_version'] = '0.2.8';

	require_once 'db.php';
	require_once 'utilities.php';
	require_once 'smarty.php';

	/*
	 * This is the entry point for all processing.
	 *
	 * It is imperative that this code do *no* output, leaving that to the
	 * handlers (see below). The reason is that the handlers need the freedom
	 * to output special headers.
	 */

	session_start();
	if ($config['use_internal_login']) {
		$_REQUEST['msg'] = '';
		if (!isset($_SESSION['has_logged_in'])) {
			if (isset($_REQUEST['name']) && isset($_REQUEST['password'])) {
				$lines = file($config['password_file'], FILE_IGNORE_NEW_LINES);
				foreach ($lines as $line) {
					list($name, $fpw) = explode(':', $line, 2);
					$upw = $_REQUEST['password'];
					$upw = crypt($upw, $fpw);
					if ($name == $_REQUEST['name'] && $fpw == $upw) {
						$_SESSION['has_logged_in'] = $_REQUEST['name'];
						dprint("$name has logged in");
						break;
					}
				}
				if (!isset($_SESSION['has_logged_in'])) {
					$_REQUEST['m'] = 'login';
					$_REQUEST['msg'] = 'invalid user name or password';
				}
			}
		}
		if (!isset($_SESSION['has_logged_in'])) {
			$_REQUEST['m'] = 'login';
		} else {
			$_SERVER['REMOTE_USER'] = $_SESSION['has_logged_in'];
		}
	}

	$db = new CalDatabase($config['library_dir']);

	/*
	 * Handle searches immediately. Compute the result set, then redo the
	 * last page request.
	 */
	if (isset($_REQUEST['m']) && $_REQUEST['m'] == 'search') {
		$db->search($_REQUEST['query']);
		$_SESSION['last_search'] = $_REQUEST['query'];
		$_REQUEST = $_SESSION['last_request'];
	}
	if ($config['restrict_display_to'] && !isset($_SESSION['book_filter'])) {
		$db->search('');
	}
	if (isset($_REQUEST['m']) && $_REQUEST['m'] == 'sort') {
		$db->set_sort($_REQUEST['sort_by'], $_REQUEST['sort_direction']);
		$_REQUEST = $_SESSION['last_request'];
	}

	/*
	 * The system is built around requests being 'dispatched' to an appropriate
	 * handler, which is named by the 'm' argument. Be sure that we have one,
	 * and be sure that it is one we know about.
	 */
	$submod = 'home';
	if (isset($_REQUEST['m']))
		$submod = $_REQUEST['m'];
	else if (isset($_SERVER['PATH_INFO'])) {
		$comps = explode('/', $_SERVER['PATH_INFO']);
		if (count($comps) == 4 && $comps[1] == 'book_format') {
			$submod = 'book_format';
			$_REQUEST['name'] = $comps[3];
			$_REQUEST['id'] = $comps[2];
			$_REQUEST['fmt'] = pathinfo($comps[3], PATHINFO_EXTENSION);
		} else
			$_REQUEST['name'] = NULL;
	}

	/*
	 * The handlers we know about. Use this method so we parse only the
	 * handler we are interested in.
	 */
	if (!in_array($submod, array('home', 'category', 'catval', 'cover', 'login',
								'titles', 'book_format', 'rating', 'book'))) {
		$smarty->assign('message', "Unknown module $submod in request");
		$smarty->display('error.tpl');
		exit(0);
	}

	/*
	 * The 'standard vars' handler generates smarty values for system-wide
	 * things, such as timestamps and the current library.
	 */
	require_once('modules/standard_vars.php');
	$mod->do_work($smarty, $db);

	/*
	 * Load the handler.
	 */
	require_once("modules/${submod}.php");
	/*
	 * Ask the handler to verify its arguments.
	 */
	if ($err = $mod->check_arguments($db)) {
		dprint ("check args failed: $err");
		$smarty->assign('message', $err);
		$smarty->display('error.tpl');
		exit(0);
	}

	/*
	 * Invoke the handler. It does whatever it does.
	 */
	$mod->do_work($smarty, $db);
	/*
	 * If the handler is paired with a template (most are), then give the
	 * template to smarty.
	 */
	$template = $mod->template();

	/*
	 * If we had a template, we had a response page. Remember the arguments
	 * so we can redo it if a search intervenes.
	 */
	if (isset($template)) {
		if ($submod != 'book')
			$_SESSION['last_request'] = $_REQUEST;
		$smarty->display($mod->template());
	}
?>