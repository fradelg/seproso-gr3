<?php

class MainLayout extends TTemplateControl
{	
	public function getProject(){ return $this->User->Project; }
	
	public function onLoad($param)
	{
		if (!$this->User->getIsGuest())
		{	
			$this->Session['project'] = $this->getUserDao()->getProject($this->User->Name);
			$this->projects->DataSource = $this->getProjects();
			$this->projects->dataBind();
		}
	}
	
	protected function getProjects()
	{
		$dao = $this->getProjectDao();
		$list = $dao->getProjectNamesByWorker($this->User->Name);
		$projects = array();
		foreach($list as $project) $projects[$project] = $project; 
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
		$this->Session['project'] = $sender->SelectedItem->Text;
		$this->getUserDao()->updateProject($this->User->Name, $this->Session['project']);
		$this->Response->reload();
	}
}

?>