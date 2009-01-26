<?php

class Phases extends TPage
{
	private $Project;
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	// Web page load event handler
	// If there are not phases loads templates page
	public function onLoad($param)
	{
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
		$phases = $this->getProjectDao()->getPhasesByProject($this->Project);
		$this->phaseList->DataSource = $phases;
		$this->phaseList->dataBind();
		
		$this->newTemplateButton->Visible = 
		 		!$this->getProjectDao()->modelTemplateExists($this->Project);
	}
	
	// Show phase information form (next view)
	protected function newPhase($sender, $param)
	{
		$this->views->ActiveViewIndex = 1;
		$this->phase->DataSource = $this->getPhases();
		$this->phase->dataBind();
	}
		
	public function addNewPhase($sender, $param)
	{	
		$phase = new PhaseRecord;
		$processID = $this->getProjectDao()->getProjectModel($this->User->Project);
		$phase->ProcessID = $processID;
		$phase->ParentID = $this->phase->SelectedValue;
		$phase->Name = $this->name->Text;
		$phase->Description = $this->description->Text;
		
		$this->getProjectDao()->addNewPhase($phase);
		
		$this->views->ActiveViewIndex = 0;
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
		$this->getProjectDao()->deleteProject($id);
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
		if($param->Item->ItemType == 'EditItem' && $param->Item->DataItem)
		{
//			$param->Item->manager->DataSource =	
//				$this->getManagers($param->Item->DataItem->ManagerID);	
//			$param->Item->manager->dataBind();
//			$param->Item->manager->SelectedValue = $param->Item->DataItem->ManagerID;
		}
	}
	
	public function getPhases(){ 
		$phases = array();
		foreach ($this->getProjectDao()->getPhasesByProject($this->Project) as $phase) 
			$phases[$phase->ID] = $phase->Name;
		return $phases;
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