<?php

class AddActivity extends TPage
{
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}

	protected function getActivityDao()
	{
		return $this->Application->Modules['daos']->getDao('ActivityDao');
	}
	
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$phases = $this->getPhases();
			$this->phaseList->DataSource = $phases;
			$this->phaseList->dataBind();
			$this->actList->DataSource = $this->getActivities(key($phases));
			$this->actList->dataBind();
			$this->workerList->DataSource = $this->getWorkers();
			$this->workerList->dataBind();
		}
	}
	
	public function getPhases(){ 
		$phases = array();
		foreach ($this->getProjectDao()->
					getPhasesByProject($this->Session['project']) as $phase) 
			$phases[$phase->ID] = $phase->Name;
		return $phases;
	}
	
	public function getActivities($phase){ 
		$activities = array();
		foreach ($this->getActivityDao()->getAllActivities($phase) as $act) 
			$activities[$act->ID] = $act->Name;
		return $activities;
	}
	
	public function getWorkers(){ 
		$workers = array();
		$project = $this->Session['project'];
		foreach ($this->getWorkerDao()->getWorkersInProject($project) as $worker) 
			$workers[$worker->UserID] = $worker->Name.' '.$worker->Surname;
		return $workers;
	}
	
	public function getTypesOfActivities(){ 
		$types = array();
		foreach ($this->getActivityDao()->getTypesOfActivities() as $type) 
			$types[$type['ID']] = $type['Type'];
		return $types;
	}
	
	public function getArtifacts(){ 
		$artifacts = array();
		foreach ($this->getActivityDao()->getArtifactSet() as $art) 
			$artifacts[$art] = $art;
		return $artifacts;
	}
		
	public function phaseChanged($sender, $param)
	{
		$this->actList->DataSource = $this->getActivities($sender->SelectedValue);
		$this->actList->dataBind();
	}
	
	// Changes to next step page
	public function nextStep($sender, $param)
	{
		$this->views->ActiveViewIndex++;
		if ($this->views->ActiveViewIndex == 1){
			$this->selectArtifact->Visible = true;
			$this->newArtifact->Visible = false;
			$this->type->DataSource = $this->getTypesOfActivities();
			$this->type->dataBind();
			$this->artifacts->DataSource = $this->getArtifacts();
			$this->artifacts->dataBind();
		}
	}
	
	// Changes to previous step page
	public function prevStep($sender, $param)
	{
		$this->views->ActiveViewIndex--;
	}
	
	// Changes to introduce artifact data
	public function changesToSetArtifact($sender, $param)
	{
		$this->selectArtifact->Visible = false;
		$this->newArtifact->Visible = true;
	}
		
	public function addNewActivity($sender, $param)
	{	
		// save artifact data if it is new
		if ($this->newArtifact->Visible)
			$this->getActivityDao()->addNewArtifact(
				$this->artName->Text, $this->artDescription->Text);
		
		// save activity data
		$act = new ActivityRecord;
		$act->TypeID = $this->type->SelectedValue;
		$act->PhaseID = $this->phaseList->SelectedValue;
		$act->ArtifactID = $this->artifacts->SelectedValue;
		$act->Name = $this->name->Text;
		$act->Description = $this->description->Text;
		$act->EstimateDate = $this->date->TimeStamp;
		$act->EstimateDuration = floatval($this->hours->Text);
		$this->getActivityDao()->addNewActivity($act);
		
		// save predecent activities data in its own table
		foreach($this->actList->Items as $item){
			if($item->Selected)
				$this->getActivityDao()->addPrecedentActivity($item->Value, $act->ID);
		}
		
		// save workers data
		foreach($this->workerList->Items as $item){
			if($item->Selected)
				$this->getActivityDao()->addWorkerToActivity($item->Value, $act->ID);
		}
					
		$this->Response->redirect("?page=Project.Activities");
	}
}

?>