<?php

class ProjectList extends TPage
{
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	/**
	 * Load all projects and display them in a repeater.
	 */
	function onLoad($param)
	{
		if(!$this->IsPostBack) $this->showList();
	}
	
	protected function showList()
	{
		$this->list->DataSource = $this->getProjectDao()->getAllProjects();
		$this->list->dataBind(); 	
	}
	
	public function editEntryItem($sender, $param)
	{
		$this->list->EditItemIndex = $param->Item->ItemIndex;
		$this->showList();
	}
	
	public function refreshEntryList()
	{
		$this->list->EditItemIndex = -1;
		$this->showList();
	}

	public function deleteEntryItem($sender, $param)
	{
		$id = $this->list->DataKeys[$param->Item->ItemIndex];
		$this->getProjectDao()->deleteProject($id);
		$this->refreshEntryList();
	}
			
	public function updateEntryItem($sender, $param)
	{		
		if(!$this->Page->IsValid)
			return;
			
		$item = $param->Item;
		$id = $this->list->DataKeys[$item->ItemIndex];

		// configure project changes
		$project = new ProjectRecord;
		$project->Title = $id;
		$project->ManagerID = $param->Item->manager->SelectedValue;
		$project->Description = $param->Item->description->Text;
		$project->Burchet = floatval($param->Item->burchet->Text);	
		$this->getProjectDao()->updateProject($project);
					
		// update table
		$this->refreshEntryList();
	}

	public function EntryItemCreated($sender, $param)
	{
		if($param->Item->ItemType == 'EditItem' && $param->Item->DataItem)
		{
			$param->Item->manager->DataSource =	
				$this->getManagers($param->Item->DataItem->ManagerID);	
			$param->Item->manager->dataBind();
			$param->Item->manager->SelectedValue = $param->Item->DataItem->ManagerID;
		}
	}
	
	public function getManagers($manager){
		$managers = array();
		foreach ($this->getWorkerDao()->getProjectManagers() as $man) 
			$managers[$man] = $man;
		// add actual manager
		$managers[$manager] = $manager;
		return $managers;
	}
}

?>