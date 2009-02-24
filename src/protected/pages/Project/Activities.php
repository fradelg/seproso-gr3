<?php

class Activities extends TPage
{	
	private $Project;
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	public function isProjectStarted()
	{
		$project = $this->Session['project'];
		return ($this->getProjectDao()->getProjectState($project) != 0);
	}

	protected function getActivityDao()
	{
		return $this->Application->Modules['daos']->getDao('ActivityDao');
	}
	
	public function onLoad($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");
			
		$this->Project = $this->Session['project'];
		
		if(!$this->IsPostBack)
		{
			$phases = $this->getPhases();
			$this->phaseList->DataSource = $phases; 
			$this->phaseList->dataBind();
			$this->showList(key($phases));
		}
	}
	
	/**
	 * Returns image url for icon representing state
	 * @param $state 0->Stopped, 1->Started, 2->Ended
	 * @return ico image url
	 */
	public function getStateImage($state)
	{
		if ($state == 0)
			$img = $this->Page->Theme->BaseUrl.'/stop.png';
		else if ($state == 1)
			$img = $this->Page->Theme->BaseUrl.'/start.png';
		else if ($state == 2)
			$img = $this->Page->Theme->BaseUrl.'/end.png';
		
		return $img;
	}
	
	/**
	 * Find and construct a list with all project phases
	 * @return array phase list with ID => Name
	 */
	public function getPhases()
	{ 
		$phases = array();
		foreach ($this->getProjectDao()->getPhasesByProject($this->Project) as $phase) 
			$phases[$phase->ID] = $phase->Name;
		return $phases;
	}
	/**
	 * Find and construct a string with all activity precedents
	 * @param $actID activity
	 * @return string comma list with precedents
	 */
	public function getPredActivities($actID)
	{
		$preds = $this->getActivityDao()->getPredActivities($actID);
		if (!count($preds)) return '-';
		return implode(',', $preds);
	}
		
	public function phaseChanged($sender, $param)
	{
		$this->showList($this->phaseList->SelectedValue);
	}
	
	protected function showList($phase)
	{	
		$this->actList->DataSource = $this->getActivityDao()->getAllActivities($phase);
		$this->actList->dataBind();
	}
	
	public function refreshEntryList()
	{
		$this->actList->EditItemIndex = -1;
		$this->showList($this->phaseList->SelectedValue);
	}
	
	public function editEntryItem($sender, $param)
	{
		$this->actList->EditItemIndex = $param->Item->ItemIndex;
		$this->showList($this->phaseList->SelectedValue);
	}	
			
	public function updateEntryItem($sender, $param)
	{		
		if(!$this->Page->IsValid) return;
			
		$item = $param->Item;
		
		$id = $this->actList->DataKeys[$param->Item->ItemIndex];
		
		$act = $this->getActivityDao()->getActivityByID($id);
		$act->Name = $param->Item->name->Text;
		$act->Description = $param->Item->description->Text;
		$act->EstimateDate = $param->Item->day->TimeStamp;
		$act->EstimateDuration = floatval($param->Item->hours->Text);
		
		$this->getActivityDao()->updateActivity($act);		
		$this->refreshEntryList();
	}

	public function EntryItemCreated($sender, $param)
	{
		$item = $param->Item;
		if($item->ItemType==='Item' || $item->ItemType==='AlternatingItem'){
			$item->DataItem->Preds = $this->getPredActivities($item->DataItem->ID);
		} else if($param->Item->ItemType == 'EditItem' && $param->Item->DataItem) {
			$item->DataItem->Preds = $this->getPredActivities($item->DataItem->ID);
		}
	}
	
	public function closeActivity($sender, $param)
	{
		$id = $this->actList->DataKeys[$param->Item->ItemIndex];
		$duration = $this->getActivityDao()->getActivityDuration($id);
		$this->getActivityDao()->endActivity($id, $duration);
		
		// Check other activities that could begin (depends on other)
		$actPost = $this->getActivityDao()->getPosteriorActivities($id);
		foreach($actPost as $act){
			if (!$this->getActivityDao()->existsActivePrecedents($act))
				$this->getActivityDao()->beginActivity($act);
		}
	    
		// Check for all activities finished -> project is finished
		$this->Project = $this->Session['project'];
		if (!$this->getActivityDao()->existsCurrentActivities($this->Project)) 
			$this->closeProject();
		
		$this->refreshEntryList();
	}
	
	private function closeProject()
	{
		// change project state
		$this->getProjectDao()->updateProjectState($this->Project, 2);
		
		// clear worker participation on it
		$dao = $this->Application->Modules['daos']->getDao('WorkerDao');
		foreach ($dao->getProjectWorkers($this->Project) as $worker){
			if ($worker['Role'] != 'Jefe de proyecto')
				$dao->deleteParticipation($worker['UserID'], $this->Project);
				var_dump($worker);
		}
	}
	
	// Redirect to AddActivity page
	public function addActivity($sender, $param)
	{
		$this->Response->redirect("?page=Project.AddActivity");
	}
	
	// Change project state to mark as active
	public function beginProject($sender, $param)
	{
		$this->getProjectDao()->updateProjectState($this->Project, 1);
		
		// Start activities without precedents
		$initActs = $this->getActivityDao()->getInitActivities($this->Project);
		foreach($initActs as $act) $this->getActivityDao()->beginActivity($act);
		
		$this->refreshEntryList();
	}
}

?>