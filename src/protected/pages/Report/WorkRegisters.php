<?php

class WorkRegisters extends TPage
{
	// Get report data access object
	protected function getReportDao()
	{
		return $this->Application->Modules['daos']->getDao('ReportsDao');
	}
	
	public function onLoad($param)
	{
		// Check for current project state
		$dao = $this->Application->Modules['daos']->getDao('ProjectDao');
		$state = $dao->getProjectState($this->Session['project']);
		
		if ($state != 1)	// Show error message
			$this->views->ActiveViewIndex = 2;
	}
	
	// Bind report data to Repeater 
	public function generateReport($sender, $param)
	{
		// Check for page validity
		if ($this->Page->IsValid){
			// Change to list view
			$this->views->ActiveViewIndex = 1;
			// Configure parameters for SQL query
			$start = $this->dateFrom->TimeStamp;
			$end = $this->dateTo->TimeStamp;
			$user = $this->User->Name;
			$project = $this->Session['project'];
	
			// Bind query data to TRepeater
			$this->activityList->DataSource = $this->getReportDao()->
					getWorkRecordReport($user, $project, $start, $end);
			$this->activityList->dataBind();
		}
	}
	
	/**
	 * Returns image url for icon that represents record state
	 * @param $state 0->Stand-by, 2->Accepted, 3->Rejected
	 * @return ico image url
	 */
	public function getImage($state)
	{
		if ($state == 0)
			$img = $this->Page->Theme->BaseUrl.'/comment.png';
		else if ($state == 2)
			$img = $this->Page->Theme->BaseUrl.'/accept.png';
		else if ($state == 3)
			$img = $this->Page->Theme->BaseUrl.'/cancel.png';
		
		return $img;
	}
	
	/**
	 * Returns current project start date (first activity)
	 * @return timestamp project start date
	 */
	public function getProjectInit()
	{
		$startDate = $this->getReportDao()->getProjectInit($this->Session['project']);
		return $startDate['date'];
	}
}

?>