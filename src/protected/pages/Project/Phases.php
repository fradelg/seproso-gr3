<?php

class Phases extends TPage
{
	private $Project;
	private $Phases;
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	public function isProjectStarted()
	{
		$project = $this->Session['project'];
		return ($this->getProjectDao()->getProjectState($project) != 0);
	}
	
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	// Web page load event handler
	// If there are not phases loads templates page
	public function onLoad($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");
		
		$this->Project = $this->Session['project'];
		if (!$this->IsPostBack){
			// Redirects templates page if there isn`t process model
			if (!$this->getProjectDao()->projectModelExists($this->Project))
				$this->Response->redirect("?page=Project.Templates");
			else
		 		$this->showList(); 
		}
	}

	// Loads phase data from database
	protected function showList()
	{
		$this->Phases = $this->getProjectDao()->getPhasesByProject($this->Project);
		$this->phaseList->DataSource = $this->getPhaseTree();
		$this->phaseList->dataBind();
		
		$this->newTemplateButton->Visible = 
		 		!$this->getProjectDao()->modelTemplateExists($this->Project);
	}
	
	/**
	 * Get project phase list sorted by parentID
	 * @return array phase list sorted
	 */
	private function getPhaseTree()
	{
		$result = array();
		foreach ($this->Phases as $phase)
			if ($phase->ParentID == NULL)
				$result = array_merge($result, $this->expandPhaseTree($phase, '-> '));
		return $result;
	}
	
	/**
	 * Traverse tree in depth, adding indentation
	 * @param $phase father node
	 * @param $prefix string to indent phase name in this tree level
	 * @return array children list
	 */
	private function expandPhaseTree($phase, $prefix)
	{
		$result = array();
		array_push($result, $phase);	// Push father
		foreach ($this->searchCildren($phase->ID) as $child){
			$child->Name = $prefix.$child->Name;
			$result = array_merge($result, $this->expandPhaseTree($child, $prefix.'-> '));
		}
		return $result;
	}
	
	/**
	 * Search children of a phase
	 * @param $phaseID parent
	 * @return array list of children
	 */
	private function searchCildren($phaseID)
	{
		$result = array();
		foreach($this->Phases as $phase)
			if ($phase->ParentID == $phaseID)
				array_push($result, $phase);
		return $result;
	}
	
	// Show phase information form (next view)
	protected function newPhase($sender, $param)
	{
		$this->views->ActiveViewIndex = 1;
		$this->phase->DataSource = $this->getPhases();
		$this->phase->dataBind();
	}
	
	public function getPhases(){ 
		$phases = array();
		$phases[NULL] = NULL;
		foreach ($this->getProjectDao()->getPhasesByProject($this->Project) as $phase) 
			$phases[$phase->ID] = $phase->Name;
		return $phases;
	}
		
	public function addNewPhase($sender, $param)
	{	
		$phase = new PhaseRecord;
		$processID = $this->getProjectDao()->getProjectModel($this->Project);
		$phase->ProcessID = $processID;
		if ($this->phase->SelectedValue != NULL)
			$phase->ParentID = $this->phase->SelectedValue;  
		$phase->Name = $this->name->Text;
		$phase->Description = $this->description->Text;
		
		$this->getProjectDao()->addNewPhase($phase);
		
		// Go to phase list and refresh it
		$this->views->ActiveViewIndex = 0;
		$this->refreshEntryList();
	}
	
	public function editEntryItem($sender, $param)
	{
		$this->phaseList->EditItemIndex = $param->Item->ItemIndex;
		$this->showList();
	}
	
	public function refreshEntryList()
	{
		$this->phaseList->EditItemIndex = -1;
		$this->showList();
	}

	public function deleteEntryItem($sender, $param)
	{
		$id = $this->phaseList->DataKeys[$param->Item->ItemIndex];
		$this->getProjectDao()->deletePhase($id);
		$this->refreshEntryList();
	}
			
	public function updateEntryItem($sender, $param)
	{		
		if(!$this->Page->IsValid)
			return;
			
		$item = $param->Item;
		$id = $this->phaseList->DataKeys[$item->ItemIndex];

		// configure phase changes
		$phase = new PhaseRecord;
		$phase->ID = $id;
		$phase->Name = $param->Item->name->Text;
		$phase->Description = $param->Item->description->Text;	
		$this->getProjectDao()->updatePhase($phase);
					
		// update table
		$this->refreshEntryList();
	}

	public function EntryItemCreated($sender, $param)
	{
//		$item = $param->Item;
//		if($item->ItemType == 'EditItem' && $item->DataItem) {
//			$param->Item->manager->DataSource =	
//				$this->getManagers($param->Item->DataItem->ManagerID);	
//			$param->Item->manager->dataBind();
//			$param->Item->manager->SelectedValue = $param->Item->DataItem->ManagerID;
//		}
	}
	
	public function defineTemplate($sender, $param)
	{
		$this->newTemplateButton->Visible = false;
		$this->setTemplatePanel->Visible = true;
		$this->refreshEntryList();
	}
	
	public function saveTemplate($sender, $param)
	{
		// Update model template
		$project = $this->Session['project'];
		$model = new ProcessRecord;
		$model->ID = $this->getProjectDao()->getProjectModel($project);
		$model->Template = $this->tempName->Text; 
		$model->Name = $this->tempName->Text;
		$model->Description = $this->tempDescription->Text;
		$this->getProjectDao()->updateModel($model);
		
		// Changes components visibility
		$this->newTemplateButton->Visible = true;
		$this->setTemplatePanel->Visible = false;
		$this->refreshEntryList();
	}
}

?>