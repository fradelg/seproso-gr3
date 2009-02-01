<?php

class WorkRegister extends TPage
{	
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->activityList->DataSource = $this->getActivities($this->User->Name);
			$this->activityList->dataBind();
		}
	}
	
	protected function getActivities($worker)
	{
		$activityDao = $this->Application->Modules['daos']->getDao('ActivityDao');
		$project = $this->Session['project'];
		$activities = array();
		foreach($activityDao->getActivitiesByWorker($project, $worker) as $activity)
				$activities[$activity->ID] = $activity->Name;
		return $activities;
	}
		
	public function addNewRecord($sender, $param)
	{
		// Fill Work Record with form data
		$record = new WorkRecord;
		$record->WorkerID = $this->User->Name;
		$record->ActivityID = $this->activityList->SelectedValue;
		$record->StartDate = $this->day->TimeStamp;
		$record->EndDate = $this->day->TimeStamp + strtotime('+7 day');
		$record->Effort = floatval($this->hours->Text);
		$record->Comentary = $this->comment->Text;
		
		// Save data into database
		$dao = $this->Application->Modules['daos']->getDao('WorkRecordDao');
		$dao->addWorkRecord($record);
		
		// Change to confirm view
		$this->views->ActiveViewIndex = 1;
	}
}

?>