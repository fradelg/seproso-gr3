<?php

class Activities extends TPage
{	
	private $Project;
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}

	protected function getActivityDao()
	{
		return $this->Application->Modules['daos']->getDao('ActivityDao');
	}
	
	public function onLoad($param)
	{
		$this->Project = $this->Session['project'];
		
		if(!$this->IsPostBack)
		{
			$this->phaseList->DataSource = $this->getPhases();
			$this->phaseList->dataBind();	
		}
	}
	
	public function getPhases(){ 
		$phases = array();
		foreach ($this->getProjectDao()->getPhasesByProject($this->Project) as $phase) 
			$phases[$phase->ID] = $phase->Name;
		return $phases;
	}
		
	public function phaseChanged($sender, $param)
	{
		$this->showList();
	}
	
	protected function showList()
	{	
		$phase = $this->phaseList->SelectedValue;
		$this->actList->DataSource = $this->getActivityDao()->getAllActivities($phase);
		$this->actList->dataBind();
	}
	
	public function refreshEntryList()
	{
		$this->actList->EditItemIndex = -1;
		$this->showList();
	}
	
	public function editEntryItem($sender, $param)
	{
		$this->actList->EditItemIndex = $param->Item->ItemIndex;
		$this->showList();
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
		if($param->Item->ItemType == 'EditItem' && $param->Item->DataItem)
		{
//			$param->Item->category->DataSource = $this->getCategories();	
//			$param->Item->category->dataBind();
//			$param->Item->category->SelectedValue = $param->Item->DataItem->Category->ID;
		}
	}
	
	public function closeActivity($sender, $param)
	{
		$id = $this->actList->DataKeys[$param->Item->ItemIndex];
		$this->getActivityDao()->endActivity($id);
		
		// Check other activities that could begin
		$actPost = $this->getActivityDao()->getPosteriorActivities($id);
		foreach($actPost as $act){
			if (!$this->getActivityDao()->existsActivePrecedents($act))
				$this->getActivityDao()->beginActivity($act);
		}
		
		$this->refreshEntryList();
	}
	
	public function addActivity()
	{
		$this->Response->redirect("?page=Project.AddActivity");
	}
}

?>