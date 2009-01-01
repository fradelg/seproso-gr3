<?php

class Phases extends TPage
{
	// Page load event handler
	// If there are not phases loads templates page
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			if ($this->views->ActiveViewIndex == 0){
				// Redirects templates page if there isn`t process model
				//$this->Response->redirect("?page=Project.Templates");
			} else if ($this->views->ActiveViewIndex == 1){
				// Loads phase data from database
				//$projects = $this->getProjects();
				//$this->projects->DataSource = $projects;
				//$this->projects->dataBind();
				//$this->showCategories(key($projects));
			}
		}
	}
	
	// Show phase information form (next view)
	protected function newPhase($sender, $param)
	{
		$this->views->ActiveViewIndex = 1;
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
		
	public function addNewPhase($sender, $param)
	{
		$this->views->ActiveViewIndex = 2;
		return;
		
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
		
	public function setProjectEntry($userID,$projectID)
	{
		$this->setViewState('ProjectEntry', array($userID,$projectID));
	}
	
	protected function getCategories()
	{	
		$project = $this->getViewState('ProjectEntry');
		foreach($this->getCategoryDao()->getCategoriesByProjectID($project[1]) as $cat)
		{
			$categories[$cat->ID] = $cat->Name;
		}
		return $categories;
	}
	
	protected function showEntryList()
	{
		$project = $this->getViewState('ProjectEntry');
		$list = $this->getTimeEntryDao()->getTimeEntriesInProject($project[0], $project[1]);
		$this->entries->DataSource = $list;
		$this->entries->dataBind();
	}
	
	public function refreshEntryList()
	{
		$this->entries->EditItemIndex=-1;
		$this->showEntryList();
	}
	
	public function editEntryItem($sender, $param)
	{
		$this->entries->EditItemIndex=$param->Item->ItemIndex;
		$this->showEntryList();
	}	

	public function deleteEntryItem($sender, $param)
	{
		$id = $this->entries->DataKeys[$param->Item->ItemIndex];
		$this->getTimeEntryDao()->deleteTimeEntry($id);
		$this->refreshEntryList();
	}
			
	public function updateEntryItem($sender, $param)
	{		
		if(!$this->Page->IsValid)
			return;
			
		$item = $param->Item;
		
		$id = $this->entries->DataKeys[$param->Item->ItemIndex];
		
		$entry = $this->getTimeEntryDao()->getTimeEntryByID($id);
		$category = new CategoryRecord;
		$category->ID = $param->Item->category->SelectedValue;
		$entry->Category = $category;
		$entry->Description = $param->Item->description->Text;
		$entry->Duration = floatval($param->Item->hours->Text);
		$entry->ReportDate = $param->Item->day->TimeStamp;
		
		$this->getTimeEntryDao()->updateTimeEntry($entry);		
		$this->refreshEntryList();
	}

	public function EntryItemCreated($sender, $param)
	{
		if($param->Item->ItemType == 'EditItem' && $param->Item->DataItem)
		{
			$param->Item->category->DataSource = $this->getCategories();	
			$param->Item->category->dataBind();
			$param->Item->category->SelectedValue = $param->Item->DataItem->Category->ID;
		}
	}
}

?>