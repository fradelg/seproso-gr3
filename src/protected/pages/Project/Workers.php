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
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	/**
	 * Load all the users and display them in a repeater.
	 */
	function onLoad($param)
	{
		if (!$this->IsPostBack){
			// Loads current workers data
			$this->participants->DataSource = 
				$this->getWorkerDao()->getProjectWorkers($this->Session['project']);
			$this->participants->dataBind();
		} 	
	}
	
	public function getWorkers(){
		$workers = array();
		$project = $this->Session['project'];
		foreach ($this->getWorkerDao()->getFreeWorkers($project) as $worker) 
			$workers[$worker->UserID] = $worker->Name.' '.$worker->Surname;
		return $workers;
	}
	
	public function getRoles($workerID)
	{ 
		$roles = array();
		foreach ($this->getWorkerDao()->getRoles($workerID) as $role) 
			$roles[$role] = $role;
		return $roles;
	}
	
	// Show add new worker to project view
	protected function newWorkerToProject($sender, $param) 
	{
		$workers = $this->getWorkers();
		$this->workerList->DataSource = $workers; 
		$this->workerList->dataBind();
		$this->showRoles(key($workers));
		
		$this->views->ActiveViewIndex = 1;
	}
	
	// A worker is selected by user
	public function workerSelected($sender, $param)
	{
		$this->showRoles($sender->SelectedValue);
	}
	
	// Loads user roles data into roles List
	protected function showRoles($workerID)
	{
		$this->roles->DataSource = $this->getRoles($workerID); 
		$this->roles->dataBind();
	}
	
	// Add selected user to current project
	public function linkWorkerToProject($sender, $param)
	{
		$user = $this->workerList->SelectedValue;
		$project = $this->Session['project'];
		$role = $this->roles->SelectedValue;
		$perc = floatval($this->participation->Text);
		$this->getWorkerDao()->addParticipation($user, $project, $role, $perc);
		$this->views->ActiveViewIndex = 2;
	}
}

?>