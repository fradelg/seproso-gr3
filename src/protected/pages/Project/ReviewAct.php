<?php

class ReviewAct extends TPage
{
	// Activity report
	private $Report;
	
	protected function getProjects()
	{
		$projectDao = $this->Application->Modules['daos']->getDao('ProjectDao');
		$projects = array();
		foreach($projectDao->getAllProjects() as $project)
				$projects[$project->ID] = $project->Name;
		return $projects;
	}
	
	protected function getUsers()
	{
		$dao = $this->Application->Modules['daos']->getDao('UserDao');
		$users = array();
		foreach($dao->getAllUsers() as $user)
			$users[$user->Name] = $user->Name;
		return $users;
	}
	
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->workerList->DataSource = $this->getUsers();
			$this->workerList->dataBind();		
		}
	}
	
	// Load activity list when user selects a worker
	public function workerSelected($sender, $param)
	{
		$worker = $sender->SelectedValue;
		$this->actList->DataSource = $this->getUsers();
		$this->actList->dataBind();
	}
	
	// Load report list when user selects an activity
	public function actSelected($sender, $param)
	{
		$activity = $sender->SelectedValue;
		$this->reportList->DataSource = $this->getProjects();
		$this->reportList->dataBind();
	}

	// Change view to Activity Report View. Previously load report data
	protected function showReport()
	{
		$this->views->ActiveViewIndex = 1;
		$reportDao = $this->Application->Modules['daos']->getDao('ReportDao');
		$reportID = $this->reportList->SelectedValue;
		
		//$this->Report = $reportDao->getReportByID($reportID);
	}
	
	// Marks selected report as reviewed 
	protected function reviewReport($sender, $param)
	{	
		$this->views->ActiveViewIndex = 2;
	}
}

?>