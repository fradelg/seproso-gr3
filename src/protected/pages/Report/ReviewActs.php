<?php

class ReviewActs extends TPage
{
	// Bind report data to Repeater 
	public function onload($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");

		if(!$this->IsPostBack)
		{
			// Retrieve data from database with SQL query
			$reportDao = $this->Application->Modules['daos']->getDao('ReportsDao');
				$this->workRecords->DataSource = 
			$reportDao->getReviewWorkRecords($this->Session['project']);
			// Bind query data to TRepeater
			$this->workRecords->dataBind();
		}		
	}
	
	protected function openRecord($sender, $param)
	{
		$id = $this->workRecords->DataKeys[$param->Item->ItemIndex];
		$request = array('WorkRecordID'=> $id);
		$url = $this->Service->constructUrl('Project.MonitorAct', $request);
		$this->Response->redirect($url);
	}
}

?>