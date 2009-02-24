<?php

class WorkRegister extends TPage
{	
	public function onLoad($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");
			
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
		// Check for validity of record data
		if (!$this->IsValid) return;
		
		// Losk for first day of week
		$dayofweek = date("N", $this->day->TimeStamp);
		$offset = "-".(intval($dayofweek) - 1)." day";
		$dateStart = strtotime($offset, $this->day->TimeStamp);
		
		// Fill Work Record with form data
		$record = new WorkRecord;
		$record->WorkerID = $this->User->Name;
		$record->ActivityID = $this->activityList->SelectedValue;
		$record->StartDate = $dateStart;
		$record->EndDate = strtotime('+5 day', $dateStart);
		$record->Effort = floatval($this->hours->Text);
		$record->Comentary = $this->comment->Text;
		
		// Save data into database
		$dao = $this->Application->Modules['daos']->getDao('WorkRecordDao');
		$dao->addWorkRecord($record);
		
		// Save artifact in server
//		if ($this->artifact->HasFile)
//       	$this->artifact->saveAs('artifacts/'.$this->artifact->FileName, true);
		
		// Change to confirm view
		$this->views->ActiveViewIndex = 1;
	}
	
	/**
	 * Verify that date´s week doesn`t have other report
	 * @param TControl custom validator that created the event.
	 * @param TServerValidateEventParameter validation parameters.
	 */
	public function validateDate($sender, $param)
	{
		$dao = $this->Application->Modules['daos']->getDao('WorkRecordDao');
		$act = $this->activityList->SelectedValue;
		$date = $this->day->TimeStamp;
		if ($dao->workRecordExists($this->User->Name, $act, $date)){
			$param->IsValid = false;
			$sender->ErrorMessage =	"En esta semana ya tiene registrado un 
									informe para esta actividad.";
		}
	}	
}

?>