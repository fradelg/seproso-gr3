<?php
/**
 * Workers page class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: UserList.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

/**
 * List all participant workers on the current project.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: UserList.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class Worker extends TPage
{
	/**
	 * Load all users and display them in a selection list.
	 */
	function onLoad($param)
	{
		if (!$this->IsPostBack){
			$this->workerList->DataSource = $this->getWorkers();
			$this->workerList->dataBind();
		} 	
	}
	
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	protected function getReportDao()
	{
		return $this->Application->Modules['daos']->getDao('ReportsDao');
	}
	
	protected function getWorkers()
	{
		$workers = array();
		foreach($this->getWorkerDao()->getAllWorkers() as $worker)
			$workers[$worker->UserID] = $worker->Name.' '.$worker->Surname;
		return $workers;
	}
	
	protected function viewReport($sender, $param)
	{
		// Parameters
		$worker = $this->workerList->SelectedValue;
		$start = $this->dateFrom->TimeStamp;
		$end = $this->dateTo->TimeStamp;
		
		// Queries
		$projects = $this->getReportDao()->getWorkerProjects($worker);
		$this->projectList->dataSource = $projects;
		
		$holidays = $this->getReportDao()->getWorkerHolidays($worker, $start, $end);
		$this->holidayList->dataSource = $holidays;
		
		$activities = $this->getReportDao()->getWorkerActivities($worker, $start, $end);
		$this->activityList->dataSource = $activities;
		$this->dataBind();
	}
}

?>