<?php
/**
 * Workers page class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: UserList.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

/**
 * List all participant workers on the current project.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: UserList.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class Worker extends TPage
{
	/**
	 * Load all the users and display them in a repeater.
	 */
	function onLoad($param)
	{
		if (!$this->IsPostBack){
			$this->workerList->DataSource = $this->getUsers();
			$this->workerList->dataBind();
		} 	
	}
	
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	protected function getUsers()
	{
		$dao = $this->getUserDao();
		$users = array();
		foreach($dao->getAllUsers() as $user)
			$users[$user->Name] = $user->Name;
		return $users;
	}
	
	protected function viewReport($sender, $param)
	{
	}
}

?>