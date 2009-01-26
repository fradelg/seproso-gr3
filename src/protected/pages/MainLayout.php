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
		$this->getUserDao()->updateProject($this->User->Name, $sender->SelectedValue);
		$this->Response->reload();
	}
}

?>