<?php

class MainLayout extends TPage
{		
	public function onLoad($param)
	{
		if (!$this->IsPostBack && $this->isProjectVisible())
		{	
			$this->projects->DataSource = $this->getProjects();
			$this->projects->dataBind();
		}
	}
	
	protected function getProjects()
	{
		$list = $this->getUserDao()->getProjectsByUser($this->User->Name);
		$projects = array();
		foreach($list as $project) $projects[$project] = $project; 
		return $projects; 
	}
	
	protected function isProjectVisible()
	{
		return $this->User->IsInRole('manager') || $this->User->IsInRole('developer');
	}
	
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	public function projectChanged($sender, $param)
	{
		$this->Session['project'] = $sender->SelectedValue;
		$view = $this->Session['view'];
		
		// Change view for project manager based to selected project 
		if ($this->User->IsInRole('manager') && $this->Session['view'] == 'developer'){
			$role = $this->getUserDao()->getRoleInProject(
						$this->User->Name, $this->Session['project']);
			// Change to manager view and set managing flag
			if ($role === 'Jefe de proyecto'){
				$this->Session['view'] = 'manager';
				$this->Session['managing'] = true;
			} 
		} else {
			$this->Session['view'] = 'developer';
			$this->Session['managing'] = false;
		}
		
		// Reload page to show project differences
		if ($view == $this->Session['view'])
			$this->Response->reload();
		else
			$this->Response->redirect("?page=User.Home");
	}
}

?>