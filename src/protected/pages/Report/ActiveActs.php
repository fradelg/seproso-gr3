<?php

class ActiveActs extends TPage
{
	// Bind report data to Repeater 
	public function generateReport($sender, $param)
	{
		// Change to list view
		$this->views->ActiveViewIndex = 1;
		// Retrieve data from data base query aql
		$reportDao = $this->Application->Modules['daos']->getDao('ReportsDao');
		$start = $this->dateFrom->TimeStamp;
		$end = $this->dateTo->TimeStamp;

		// Bind query data to TRepeater
		$this->activityList->DataSource = 
			$reportDao->getCurrentActs($this->Session['project'], $start, $end);
		$this->activityList->dataBind();		
	}
}

?>