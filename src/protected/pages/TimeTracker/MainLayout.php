<?php

class MainLayout extends TPage
{	
	public function getProject(){ return $this->User->Project; }
	
	public function onLoad($param)
	{
		if (!$this->isPostBack){
			$this->User->Project = $this->getUserDao()->getProject($this->User->Name);
			$projects = $this->getProjects();
			$this->projects->DataSource = $projects;
			$this->projects->dataBind();
		}
	}
	
	protected function getProjects()
	{
		$projects = array();
		if($this->User->isInRole('admin'))
			$list = $this->getProjectDao()->getAllProjects();
		else if($this->User->isInRole('manager'))
			$list = $this->getProjectDao()->getProjectsByManagerName($this->User->Name);
		else
			$list = $this->getProjectDao()->getProjectsByUserName($this->User->Name);
		foreach($list as $project)
			$projects[$project->ID] = $project->Name;
		return $projects;
	}
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	public function projectChanged($sender, $param)
	{
		$this->User->Project = $sender->SelectedItem->Text;
		$this->getUserDao()->updateProject($this->User);
	}
}

?>