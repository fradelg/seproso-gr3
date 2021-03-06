<?php

class Summary extends TPage
{
	private $ProjectStats;
	
	// Bind report data to Repeater
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$projects = $this->getFinishedProjects();
			$this->projectList->DataSource = $projects; 
			$this->projectList->dataBind();
			$this->show(key($projects));
		}
	}
	
	private function getFinishedProjects()
	{
		$dao = $this->Application->Modules['daos']->getDao('ProjectDao');
		$projects = array();
		foreach ($dao->getProjectsByState(2) as $project)
			$projects[$project->Title] = $project->Title;
		return $projects; 
	}
	
	public function projectChanged($sender, $param)
	{
		$this->show($sender->SelectedValue);
	}
	
	private function show($projectID) 
	{
		// Get report DAO
		$reportDao = $this->Application->Modules['daos']->getDao('ReportsDao');
		
		// Bind query data to TRepeater
		$this->activityList->DataSource = $reportDao->getSummary($projectID);
		$this->activityList->dataBind();
		
		// Get project general stats
		$this->ProjectStats = $reportDao->getProjectStats($projectID);
		$this->ProjectStats->StartDelay = floor(($this->ProjectStats->RealStart - 
			$this->ProjectStats->EstimateStart)/(60*60*24));
		$this->ProjectStats->EndDelay = floor(($this->ProjectStats->RealEnd - 
			$this->ProjectStats->EstimateEnd)/(60*60*24));
		$this->ProjectStats->DurationDelay = 100.0*($this->ProjectStats->RealDuration - 
			$this->ProjectStats->EstimateDuration)/$this->ProjectStats->EstimateDuration;
		$this->projectStats->DataSource = array("0" => $this->ProjectStats);
		$this->projectStats->dataBind();
		
	}
}

?>