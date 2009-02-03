<?php

class ApproveAct extends TPage
{
	// Activity report
	private $Report;
	
	protected function getWorkRecordDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkRecordDao');
	}
	
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->workerList->DataSource = $this->getWorkers();
			$this->workerList->dataBind();		
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
		$activities = array();
		foreach($activityDao->getActivitiesByWorker($worker) as $activity)
				$activities[$activity->ID] = $activity->Name;
		return $activities;
	}
	
	// Load work report list when user selects an activity
	public function actSelected($sender, $param)
	{
		$worker = $sender->SelectedValue;
		$activity = $sender->SelectedValue;
		$this->reportList->DataSource = $this->getApproveWorkRecords($worker, $activity);
		$this->reportList->dataBind();
	}
	
	protected function getApproveWorkRecords($worker, $act)
	{
		$dao = $this->getWorkRecordDao();
		$records = array();
		foreach($dao->getReviewWorkRecordsByWA($worker, $act, 1) as $record)
				$records[$record->ID] = $record->Date;
		return $records;
	}

	// Change view to Activity Report View. Previously, load report data.
	protected function showReport()
	{
		$this->views->ActiveViewIndex = 1;
		$recordID = $this->reportList->SelectedValue;
		
		$this->Report = $this->getWorkRecordDao()->getWorkRecordByID($recordID);
	}
	
	// Marks selected report as approved 
	protected function approveReport($sender, $param)
	{
		$this->getWorkRecordDao()->updateToState($this->Report->ID, 2);
		$this->views->ActiveViewIndex = 2;
	}
}

?>