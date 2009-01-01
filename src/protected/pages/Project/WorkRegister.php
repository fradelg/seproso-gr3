<?php

class WorkRegister extends TPage
{
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
		
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->activityList->DataSource = $this->getProjects();
			$this->activityList->dataBind();
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
		
	public function addNewEntry($sender, $param)
	{
		$entry = new TimeEntryRecord;
		$entry->CreatorUserName = $this->User->Name;
		$category = new CategoryRecord;
		$category->ID = $this->activityList->SelectedValue;
		$entry->Category = $category;
		$entry->Description = $this->comment->Text;
		$entry->Duration = floatval($this->hours->Text);
		$entry->ReportDate = $this->day->TimeStamp;
		$entry->Username = $this->User->Name;
	}
}

?>