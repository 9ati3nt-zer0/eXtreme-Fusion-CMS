<?php defined('EF5_SYSTEM') || exit;
/*---------------------------------------------------------------+
| eXtreme-Fusion - Content Management System - version 5         |
+----------------------------------------------------------------+
| Copyright (c) 2005-2012 eXtreme-Fusion Crew                	 |
| http://extreme-fusion.org/                               		 |
+----------------------------------------------------------------+
| This product is licensed under the BSD License.				 |
| http://extreme-fusion.org/ef5/license/						 |
+---------------------------------------------------------------*/
$_locale->moduleLoad('lang', 'point_system');

if($_user->isLoggedIn())
{
	$theme = array(
		'Title' => __('Points History'),
		'Keys' => 'points, history, ranks, point_system',
		'Desc' => 'Strona punktacji użytkownika '.$_user->get('username')
	);
			
	if($_request->post('clear_history')->show())
	{
		$_points->clearHistory($_user->get('id'));
		$_system->clearCache('point_system');
		$_request->redirect(ADDR_SITE.'point_system.html');
	}
	
	$rows = $_pdo->getMatchRowsCount('SELECT `id` FROM [points_history] WHERE `user_id` = '.$_user->get('id'));
	
	if($rows)
	{
		$per_page = 10;
	
		if ( ! $_route->getByID(2))
		{
			$_GET['current'] = 1;
		}
		else
		{
			$_GET['current'] = $_route->getByID(2);
		}

		$_GET['rowstart'] = PAGING::getRowStart($_GET['current'], $per_page);

		$data = $_system->cache('ps,'.$_user->getCacheName().',page-'.$_GET['current'], NULL, 'point_system', 86700);
		if($data === NULL)
		{
			$query = $_pdo->getData('
				SELECT p.*, u.`id` 
				FROM [points_history] p
				LEFT JOIN [users] u 
				ON p.`user_id` = u.`id`
				WHERE p.`user_id` = '.$_user->get('id').'
				ORDER BY p.`date` DESC LIMIT :rowstart,:per_page',
				array(
					array(':rowstart', $_GET['rowstart'], PDO::PARAM_INT),
					array(':per_page', $per_page, PDO::PARAM_INT)
				)
			);
			
			if ($_pdo->getRowsCount($query)) 
			{
				$i = 0; $data = array();
				foreach ($query as $row)
				{
					$data[] = array(
						'date' => HELP::showDate("shortdate", $row['date']),
						'text' => $row['text']
					);
					$i++;
				}
			}
			
			$_system->cache('ps,'.$_user->getCacheName().',page-'.$_GET['current'], $data, 'point_system');
		}
	}
	
	$_tpl->assign('points', $_points->show($_user->get('id')));
	$_tpl->assign('ranks', $_points->showRank($_user->get('id')));
	$_tpl->assign('history', $data);
	
	$_pagenav = new PageNav(new Paging($rows, $_GET['current'], $per_page), $_tpl, 5, array($_route->getFileName(), 'page'));
	$_pagenav->get($_pagenav->create(), 'page_nav');
}
else
{
	$_request->redirect(ADDR_SITE.'login.html');
}

$_tpl->assign('Theme', $theme);

// Definiowanie katalogu templatek modułu
$_tpl->setPageCompileDir(DIR_MODULES.'point_system'.DS.'templates'.DS);
