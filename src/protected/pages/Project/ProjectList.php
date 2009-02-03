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
			
	public function updateEntryItem($sender, $param)
	{		
		$item = $param->Item;
		$id = $this->list->DataKeys[$item->ItemIndex];
		$project = $this->getProjectDao()->getProjectByID($id);
		$newManager = $item->manager->SelectedValue;
		
		// check project manager changes
		if ($project->ManagerID != $newManager){
			$this->getWorkerDao()->updateParticipation(
				$project->ManagerID, $project->Title, 'Analista', 50);
			if ($this->getWorkerDao()->participationExists($newManager, $project->Title))
				$this->getWorkerDao()->updateParticipation(
					$newManager, $project->Title, 'Jefe de proyecto', 50);
			else
				$this->getWorkerDao()->addParticipation(
					$newManager, $project->Title, 'Jefe de proyecto', 50);
		}
		
		// configure new project with changes
		$project = new ProjectRecord;
		$project->Title = $id;
		$project->ManagerID = $item->manager->SelectedValue;
		$project->Description = $item->description->Text;
		$project->Burchet = floatval($item->burchet->Text);	
		$this->getProjectDao()->updateProject($project);
					
		// update table
		$this->refreshEntryList();
	}
	
	public function deleteEntryItem($sender, $param)
	{
		$id = $this->list->DataKeys[$param->Item->ItemIndex];
		
		// check if deletion is possible
		if (!$this->getProjectDao()->projectWorkersExists($id)){
			$manager = $this->getProjectDao()->getProjectManager($id);
			$this->getWorkerDao()->deleteParticipation($manager, $id);
			$this->getProjectDao()->deleteProject($id);
		} else
			$this->views->ActiveViewIndex = 1;

		$this->refreshEntryList($sender, $param);
	}

	public function EntryItemCreated($sender, $param)
	{
		$item = $param->Item;
		if($param->Item->ItemType == 'EditItem' && $param->Item->DataItem)
		{
			$item->manager->DataSource = $this->getManagers($item->DataItem->ManagerID);	
			$item->manager->dataBind();
			$item->manager->SelectedValue = $param->Item->DataItem->ManagerID;
		}
	}
	
	public function getManagers($manager)
	{
		$managers = array();
		foreach ($this->getWorkerDao()->getProjectManagers() as $man)
			$managers[$man['UserID']] = $man['Worker'];
		// add actual manager
		$managers[$manager] = $this->getWorkerDao()->getWorkerName($manager);
		return $managers;
	}
}

?>