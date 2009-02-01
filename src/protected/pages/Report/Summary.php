<?php

class Summary extends TPage
{
	// Bind report data to Repeater
	public function onLoad($param)
	{
		// Check for current project state
		$dao = $this->Application->Modules['daos']->getDao('ProjectDao');
		$state = $dao->getProjectState($this->Session['project']);
		$this->views->ActiveViewIndex = $state;
		
		if ($state == 2){
			$reportDao = $this->Application->Modules['daos']->getDao('ReportsDao');
			// Bind query data to TRepeater
			$this->activityList->DataSource = 
				$reportDao->getSummary($this->Session['project']);
			$this->activityList->dataBind();
		}
	}	
}

?>