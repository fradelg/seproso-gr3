<?php

class WorkRegisters extends TPage
{
	public function onLoad($param)
	{
		if(!$this->IsPostBack){}
	}	
	
	// Generate report and show to user: include all data
	public function generateReport($sender, $param)
	{
		// Change to report view
		$this->views->ActiveViewIndex = 1;
		// Load data from DataBase
		$userDao = $this->Application->Modules['daos']->getDao('UserDao');
		$start = $this->dateFrom->TimeStamp;
		$end = $this->dateTo->TimeStamp;

		// Bind database query result to TRepeater component
		$this->activities->DataSource = $userDao->getAllUsers();
		$this->activities->dataBind();		
	}
}

?>