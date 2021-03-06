<?php
/***********************************************************
| eXtreme-Fusion 5.0 Beta 5
| Content Management System       
|
| Copyright (c) 2005-2012 eXtreme-Fusion Crew                	 
| http://extreme-fusion.org/                               		 
|
| This product is licensed under the BSD License.				 
| http://extreme-fusion.org/ef5/license/						 
***********************************************************/
try
{
	require_once '../../config.php';
	require DIR_SITE.'bootstrap.php';
	require_once DIR_SYSTEM.'admincore.php';
	
	$_locale->load('comments');

    if ( ! $_user->hasPermission('admin.comments'))
    {
        throw new userException(__('Access denied'));
    }

    $_tpl = new Iframe;

	// Wyświetlenie komunikatów
	if ($_request->get(array('status', 'act'))->show())
	{
		// Wyświetli komunikat
		$_tpl->getMessage($_request->get('status')->show(), $_request->get('act')->show(), 
			array(
				'edit' => array(
					__('Comment has been edited.'), __('Error! Comment has not been edited.')
				),
				'delete' => array(
					__('Comment has been deleted.'), __('Error! Comment has not been deleted.')
				)
			)
		);
    }

    if ($_request->post('save')->show() && $_request->get('id')->isNum())
	{
		$count = $_pdo->exec('UPDATE [comments] SET `post` = :post WHERE `id` = '.$_request->get('id')->show(),
			array(':post', $_request->post('post')->filters('trim', 'strip'), PDO::PARAM_STR)
		);

		if ($count)
		{
			$_log->insertSuccess('edit', __('Comment has been edited.'));
			$_request->redirect(FILE_PATH, array('act' => 'edit', 'status' => 'ok'));
		}

		$_log->insertFail('edit', __('Error! Comment has not been edited.'));
		$_request->redirect(FILE_PATH, array('act' => 'edit', 'status' => 'error'));
    }
    elseif ($_request->get('action')->show() === 'delete' && $_request->get('id')->isNum())
    {
		$count = $_pdo->exec('DELETE FROM [comments] WHERE `id` = '.$_request->get('id')->show());

		if ($count)
        {
			$_log->insertSuccess('delete', __('Comment has been deleted.'));
            $_request->redirect(FILE_PATH, array('act' => 'delete', 'status' => 'ok'));
        }

		$_log->insertFail('delete', __('Error! Comment has not been deleted.'));
        $_request->redirect(FILE_PATH, array('act' => 'delete', 'status' => 'error'));
    }
    elseif ($_request->get('action')->show() === 'edit' && $_request->get('id')->isNum())
    {
		$row = $_pdo->getRow('SELECT `id`, `post` FROM [comments] WHERE `id` = '.$_request->get('id')->show());

		if ( ! $row)
		{
			throw new userException(__('Error! Missing id.', array(':id' => $_request->get('id')->show())));
		}

        $_tpl->assign('edit', $row);
    }
    else
    {
		$query = $_pdo->getData('
			SELECT c.`id`, c.`author`, c.`post`, c.`datestamp`, c.`ip`, u.`id` AS `user_id`, u.`username` FROM [comments] c
            LEFT JOIN [users] u
            ON c.`author` = u.`id`
            ORDER BY c.`datestamp` DESC
		');

		if ($_pdo->getRowsCount($query))
		{
	        foreach($query as &$row)
	        {
				$row['author'] = $row['username'] ? HELP::profileLink($row['username'], $row['user_id']) : __('Guest');
				$row['post'] = substr($row['post'], 0, 27);
				$row['datestamp'] = HELP::showDate('longdate', $row['datestamp']);
            }
			$_tpl->assign('comment', $query);
        }
    }

    $_tpl->template('comments');
}
catch(optException $exception)
{
    optErrorHandler($exception);
}
catch(systemException $exception)
{
    systemErrorHandler($exception);
}
catch(userException $exception)
{
    userErrorHandler($exception);
}
catch(PDOException $exception)
{
    PDOErrorHandler($exception);
}