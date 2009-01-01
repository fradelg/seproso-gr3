<?php

class Holidays extends TPage
{
	// Page load event handler
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
		}
	}
	
	// Changes to new period form
	public function newPeriod($sender, $param)
	{
		$this->views->ActiveViewIndex = 1;
	}
	
	// Verifies if new period is valid or not 
	public function checkConstraits()
	{
		$this->IsValid = false;
	}
	
	// Creates new period with form data and saves it
	public function addPeriod($sender, $param)
	{
		$this->checkConstraits();
		
		// Shows success or error message to user
		if (!$this->IsValid){ 
			$this->views->ActiveViewIndex = 3;
			return;
		} else 
			$this->views->ActiveViewIndex = 2;
		
		// Save data into database
		if($this->projectMembers->SelectedItem){
			$entry = new TimeEntryRecord;
			$entry->CreatorUserName = $this->User->Name;
			$category = new CategoryRecord;
			$category->ID = $this->category->SelectedValue;
			$entry->Category = $category;
			$entry->Description = $this->description->Text;
			$entry->Duration = floatval($this->hours->Text);
			$entry->ReportDate = $this->day->TimeStamp;
			$entry->Username = $this->projectMembers->SelectedItem->Text;
		}
	}
	
	protected function getTimeEntryDao()
	{
		return $this->Application->Modules['daos']->getDao('TimeEntryDao');
	}

	protected function getCategoryDao()
	{
		return $this->Application->Modules['daos']->getDao('CategoryDao');
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