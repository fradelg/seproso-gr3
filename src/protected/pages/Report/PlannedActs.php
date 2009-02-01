<?php

class PlannedActs extends TPage
{
	// Bind report data to Repeater 
	public function generateReport($sender, $param)
	{
		// Change to list view
		$this->views->ActiveViewIndex = 1;
		// Retrieve data from data base query aql
		$reportDao = $this->Application->Modules['daos']->getDao('ReportsDao');
		$date = $this->date->TimeStamp;

		// Bind query data to TRepeater
		$this->activityList->DataSource = 
			$reportDao->getPlannedActs($this->Session['project'], $date);
		$this->activityList->dataBind();		
	}
}

?>