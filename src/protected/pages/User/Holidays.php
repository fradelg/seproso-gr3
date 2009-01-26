<?php

class Holidays extends TPage
{
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
			$weeks = $this->getWorkerDao()->getHolidayWeeks($user);
			$periods = $this->getWorkerDao()->getNoHolidayPeriods($user);
			// Check if user has comsumed all holiday weeks
			if ($weeks == 4 || $periods == 3) 
				$this->newPeriodButton->Visible = false;
		}
	}
	
	private function getLeftWeeks()
	{
		$data = array();
		$weeks = $this->getWorkerDao()->getHolidayWeeks($this->User->Name);
		for ($week = 1; $week <= 4 - $weeks; $week++)
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
	
	/** Check for date avaleability
	 * @param TControl custom validator that created the event.
	 * @param TServerValidateEventParameter validation parameters.
	 */ 
	public function validateDate($sender, $param)
	{
		$dayofweek = date("N", $this->startDate->TimeStamp);
		$offset = "-".(intval($dayofweek) - 1)." day";
		$dateStart = strtotime($offset, $this->startDate->TimeStamp);
		$dateEnd = strtotime("+".$this->duration->SelectedValue." week", $dateStart);
		$data = $this->getWorkerDao()->getWorkerHolidays($this->User->Name);

		foreach($data as $period){
			$periodStart = $period->StartDate;
			$periodEnd = strtotime("+".$period->Duration." week", $period->StartDate);
			var_dump($dateStart, $dateEnd);
			var_dump($periodStart, $periodEnd);
			if (($dateStart >= $periodStart && $dateStart < $periodEnd) ||
				($dateEnd > $periodStart && $dateEnd < $periodEnd)){
					$param->IsValid = false;
			}
		}
	}
	
	// Creates new period with form data and saves it
	public function addNewPeriod($sender, $param)
	{
		if ($this->IsValid){
			// Save period data into database
			$period = new HolidayRecord;
			$period->UserID = $this->User->Name;
		
			// Compute first day of selected week
			$dayofweek = date("N", $this->startDate->TimeStamp);
			$offset = "-".(intval($dayofweek) - 1)." day";
			$period->StartDate = strtotime($offset, $this->startDate->TimeStamp);
		
			// Set rest of data
			$period->Duration = $this->duration->SelectedValue;
			$period->Reason = $this->description->Text;
			$this->getWorkerDao()->addNewHolidayPeriod($period);
			$this->views->ActiveViewIndex = 2;
		}
	}
}

?>