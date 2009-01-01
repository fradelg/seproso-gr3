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
class Workers extends TPage
{
	/**
	 * Load all the users and display them in a repeater.
	 */
	function onLoad($param)
	{
		if (!$this->IsPostBack){
			// Loads current workers data
			if ($this->views->ActiveViewIndex == 0){
				$userDao = $this->Application->Modules['daos']->getDao('UserDao');
				$this->participants->DataSource = $userDao->getAllUsers();
				$this->participants->dataBind();
			// Loads free workers for this project
			} else if ($this->views->ActiveViewIndex == 1) {
				$users = $this->getUsers();
				$this->workerList->DataSource = $users;
				$this->workerList->dataBind();
				$this->showRoles(key($users));
			}
		} 	
	}
	
	// Show new worker to project view
	protected function newWorkerInProject($sender, $param) {
		$users = $this->getUsers();
		$this->workerList->DataSource = $users;
		$this->workerList->dataBind();
		$this->showRoles(key($users));
		$this->views->ActiveViewIndex = 1;
	}
	
	// Returns DAO for User queries
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	// Returns array with all users
	protected function getUsers()
	{
		$dao = $this->getUserDao();
		$users = array();
		foreach($dao->getAllUsers() as $user)
			$users[$user->Name] = $user->Name;
		return $users;
	}
	
	// An user is selected by user
	public function userSelected($sender, $param)
	{
		$this->showRoles($sender->SelectedValue);
	}
	
	// Loads user role data into roles List
	protected function showRoles($userID)
	{
		$user = $this->getUserDao()->getUserByName($userID);
		$this->roles->DataSource = $user->Roles;
		$this->roles->dataBind();
	}
	
	// Add selected user to current project
	public function linkWorkerToProject($sender, $param)
	{
		$this->views->ActiveViewIndex = 2;
	}
}

?>