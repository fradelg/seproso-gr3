<?php

class FutureActs extends TPage
{
	// Page load event
	public function onLoad($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");
	}
	
	// Bind report data to Repeater 
	public function generateReport($sender, $param)
	{
		// Change to list view
		$this->views->ActiveViewIndex = 1;
		// Retrieve data from database 
		$reportDao = $this->Application->Modules['daos']->getDao('ReportsDao');
		$start = $this->dateFrom->TimeStamp;
		$end = $this->dateTo->TimeStamp;

		// Bind query data to TRepeater
		$this->activityList->DataSource = 
			$reportDao->getFutureActs($this->Session['project'], $start, $end);
		$this->activityList->dataBind();
	}
}

?>