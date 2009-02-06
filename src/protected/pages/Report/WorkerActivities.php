<?php

class WorkerActivities extends TPage
{		
	public function generateReport($sender, $param)
	{
		// Change to report view
		$this->views->ActiveViewIndex = 1;
		// Query data base
		$reportDao = $this->Application->Modules['daos']->getDao('ReportsDao');
		$start = $this->dateFrom->TimeStamp;
		$end = $this->dateTo->TimeStamp;

		// Data bind to Worker TRepeater
		$this->workerList->DataSource = 
				$reportDao->getWorkerActivitiesReport($start, $end);
		$this->workerList->dataBind();		
	}
	
	// New worker created slot
	public function workerCreated($sender, $param)
	{
		$item = $param->Item;
		if($item->ItemType==='Item' || $item->ItemType==='AlternatingItem')
			$item->activityList->DataSource = $item->DataItem->Activities;
	}
}

?>