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
	
	$_locale->load('settings_login');

	if ( ! $_user->hasPermission('admin.settings_login'))
	{
		throw new userException(__('Access denied'));
	}

	$_tpl = new Iframe;

	if ($_request->post('save')->show())
	{
		$_sett->update(array(
			'loging' => serialize(array(
				'site_normal_loging_time' => HELP::hoursToSeconds($_request->post('site_normal_loging_time')->isNum(TRUE)),
				'site_remember_loging_time' => HELP::daysToSeconds($_request->post('site_remember_loging_time')->isNum(TRUE)),
				'admin_loging_time' => HELP::minutesToSeconds($_request->post('admin_loging_time')->isNum(TRUE)),
				'user_active_time' => HELP::minutesToSeconds($_request->post('user_active_time')->isNum(TRUE))
			))
		));
		
		$_tpl->printMessage('valid', $_log->insertSuccess('edit', __('Data has been saved.')));
	}

	$_tpl->assignGroup(array(
		'site_normal_loging_time' => HELP::hoursToSeconds($_sett->getUns('loging', 'site_normal_loging_time'), TRUE),
		'site_remember_loging_time' => HELP::daysToSeconds($_sett->getUns('loging', 'site_remember_loging_time'), TRUE),
		'admin_loging_time' => HELP::minutesToSeconds($_sett->getUns('loging', 'admin_loging_time'), TRUE),
		'user_active_time' => HELP::minutesToSeconds($_sett->getUns('loging', 'user_active_time'), TRUE)
	));

	$_tpl->template('settings_login');
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