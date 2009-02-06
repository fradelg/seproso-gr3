<?php

class MonitorAct extends TPage
{
	// Activity report
	public $Report;
	
	protected function getWorkRecordDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkRecordDao');
	}
	
	public function onLoad($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");
			
		if(!$this->IsPostBack)
		{
			$this->workerList->DataSource = $this->getWorkers();
			$this->workerList->dataBind();
			
			// Check for request param in redirection to show record
			$recordID = $this->Request['WorkRecordID'];
			if ($recordID > 0){
				$this->Report = $this->getWorkRecordDao()->getWorkRecordByID($recordID);
				$this->views->ActiveViewIndex = 1;
			}
		}
	}
	
	public function getWorkers()
	{
		$workerDao = $this->Application->Modules['daos']->getDao('WorkerDao');
		$project = $this->Session['project'];
		$participants = array();
		foreach ($workerDao->getProjectWorkers($project) as $part) 
			$participants[$part['UserID']] = $part['Worker'];
		return $participants;
	}
	
	// Load activity list when user selects a worker
	public function workerSelected($sender, $param)
	{
		$worker = $sender->SelectedValue;
		$this->actList->DataSource = $this->getActivities($worker);
		$this->actList->dataBind();
	}
	
	protected function getActivities($worker)
	{
		$activityDao = $this->Application->Modules['daos']->getDao('ActivityDao');
		$data = $activityDao->getActivitiesByWorker($this->Session['project'], $worker);
		$activities = array();
		foreach($data as $activity)	$activities[$activity->ID] = $activity->Name;
		return $activities;
	}
	
	// Load work report list when user selects an activity
	public function actSelected($sender, $param)
	{
		$worker = $this->workerList->SelectedValue;
		$activity = $this->actList->SelectedValue;
		$this->reportList->DataSource = $this->getWorkRecords($worker, $activity);
		$this->reportList->dataBind();
	}
	
	protected function getWorkRecords($worker, $act)
	{
		$records = array();
		foreach($this->getWorkRecordDao()->getWorkRecordsByWA($worker, $act) as $rec)
				$records[$rec->ID] = date('d - m - Y', $rec->Date);
		return $records;
	}

	// Change view to Activity Report View. Previously load report data
	protected function showReport()
	{
		$recordID = $this->reportList->SelectedValue;
		$this->Report = $this->getWorkRecordDao()->getWorkRecordByID($recordID);
		$this->views->ActiveViewIndex = 1;
	}
	
	// Marks selected report as reviewed 
	protected function reviewReport($sender, $param)
	{	
		$recordID = $this->reportList->SelectedValue;
		$this->getWorkRecordDao()->updateToState($recordID, 1);
		$this->views->ActiveViewIndex = 2;
	}
	
	// Marks selected report as approved 
	protected function approveReport($sender, $param)
	{	
		$recordID = $this->reportList->SelectedValue;
		$this->getWorkRecordDao()->updateToState($recordID, 2);
		$this->views->ActiveViewIndex = 3;
	}
	
	// Marks selected report as rejected 
	protected function rejectReport($sender, $param)
	{	
		$recordID = $this->reportList->SelectedValue;
		$this->getWorkRecordDao()->updateToState($recordID, 3);
		$this->views->ActiveViewIndex = 4;
	}
}

?>