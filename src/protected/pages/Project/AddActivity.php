<?php

class AddActivity extends TPage
{
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			if ($this->views->ActiveViewIndex == 0){
				$this->actList->DataSource = $this->getUsers();
				$this->actList->dataBind();
				$this->workerList->DataSource = $this->getUsers();
				$this->workerList->dataBind();
			} else {
			}
		}
	}
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	protected function getCategoryDao()
	{
		return $this->Application->Modules['daos']->getDao('CategoryDao');
	}
	
	protected function getTimeEntryDao()
	{
		return $this->Application->Modules['daos']->getDao('TimeEntryDao');
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
	
	// Changes to next step page
	public function nextStep($sender, $param)
	{
		$this->views->ActiveViewIndex++;
	}
	
	// Changes to previous step page
	public function prevStep($sender, $param)
	{
		$this->views->ActiveViewIndex--;
	}
	
	protected function showCategories($projectID)
	{
		$categories = array();
		foreach($this->getCategoryDao()->getCategoriesByProjectID($projectID) as $cat)
		{
			$categories[$cat->ID] = $cat->Name;
		}				
		$this->category->DataSource = $categories;
		$this->category->dataBind();
		$this->showProjectUsers($projectID);
	}
	
	protected function showProjectUsers($projectID)
	{
		if($this->User->isInRole('manager'))
			$users = $this->getProjectDao()->getProjectMembers($projectID);
		else
			$users = array($this->User->Name);
		$this->projectMembers->DataSource = $users;
		$this->projectMembers->dataBind();
		if(is_int($index = array_search($this->User->Name, $users)))
		{
			$this->projectMembers->SelectedIndex = $index;
			$this->showTimeSheet();
		}
	}
	
	public function showTimeSheet()
	{
		$user = $this->projectMembers->SelectedItem->Text;
		$project = $this->projects->SelectedValue;
		$this->entryList->setProjectEntry($user,$project);
		$this->entryList->refreshEntryList();
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
	
	public function projects_Changed($sender, $param)
	{
		$this->showCategories($sender->SelectedValue);
	}
		
	public function addNewActivity($sender, $param)
	{
		$this->views->ActiveViewIndex = 2;
		
		if($this->projectMembers->SelectedItem)
		{
			$entry = new TimeEntryRecord;
			$entry->CreatorUserName = $this->User->Name;
			$category = new CategoryRecord;
			$category->ID = $this->category->SelectedValue;
			$entry->Category = $category;
			$entry->Description = $this->description->Text;
			$entry->Duration = floatval($this->hours->Text);
			$entry->ReportDate = $this->day->TimeStamp;
			$entry->Username = $this->projectMembers->SelectedItem->Text;
			
			$this->hours->Text = '';
			$this->description->Text = '';
			
			$this->getTimeEntryDao()->addNewTimeEntry($entry);
			$this->showTimeSheet();
		}
	}
}

?>