<?php

class Holidays extends TPage
{
	private $UsedWeeks;
	private $UsedPeriods;
	
	// Get worker data access object
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	// Page load event handler
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$data = $this->getWorkerDao()->getWorkerHolidays($this->User->Name);
			$this->periodList->DataSource = $data;
			$this->periodList->dataBind();
			
			$user = $this->User->Name;
			$this->UsedWeeks = $this->getWorkerDao()->getHolidayWeeks($user);
			$this->UsedPeriods = $this->getWorkerDao()->getNoHolidayPeriods($user);
			// Check if user has used all holiday weeks
			if ($this->UsedWeeks == 4 || $this->UsedPeriods == 3)
				$this->newPeriodButton->Visible = false;
		}
	}
	
	private function getLeftWeeks()
	{
		$data = array();
		for ($week = 1; $week <= 4 - $this->UsedWeeks; $week++)
			$data[$week] = $week;
		return $data;
	}
	
	// Changes to 'new period' form
	public function setPeriod($sender, $param)
	{
		$this->duration->DataSource = $this->getLeftWeeks();
		$this->duration->dataBind();
		$this->views->ActiveViewIndex = 1;
	}
	
	// Verifies if new period is valid or not 
	public function checkConstraits()
	{
		if ($this->UsedPeriods < 3 && $this->UsedWeeks < 4)
			$this->IsValid = true;
		else
			$this->IsValid = false;
	}
	
	// Creates new period with form data and saves it
	public function addNewPeriod($sender, $param)
	{
		$this->checkConstraits();
		
		// Shows an error message to user
		if (!$this->IsValid){ 
			$this->views->ActiveViewIndex = 3;
			return; 
		}
		
		// Save period data into database
		$period = new HolidayRecord;
		$period->UserID = $this->User->Name;
		$period->StartDate = $this->startDate->TimeStamp;
		$period->Duration = $this->duration->SelectedValue;
		$period->Reason = $this->description->Text;
		$this->getWorkerDao()->addNewHolidayPeriod($period);
		$this->views->ActiveViewIndex = 2;
	}
}

?>