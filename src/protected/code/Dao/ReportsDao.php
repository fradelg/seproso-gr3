<?php

class ProjectReport extends TComponent
{
	public $ProjectName = '';
	public $EstimateHours = 0;
	public $EstimateCompletion = 0;
	public $Categories;

	public function __construct()
	{
		$this->Categories = new TList;
	}

	public function getActualHours()
	{
		$total = 0;
		foreach($this->Categories as $cat)
			$total += $cat->getActualHours();
		return $total;
	}
}

class CategoryReport extends TComponent
{
	public $CategoryName = '';
	public $EstimateHours = 0;
	public $members = array();

	public function getActualHours()
	{
		$total = 0;
		foreach($this->members as $member)
			$total += $member['hours'];
		return $total;
	}
}

class UserReport extends TComponent
{
	public $Username;
	public $Projects = array();

	public function getTotalHours()
	{
		$hours = 0;
		foreach($this->Projects as $project)
			$hours += $project->Duration;
		return $hours;
	}
}

class WorkerProjectReport
{
	public $Project = '';
	public $Role = '';
	public $Part = 0;
}

class WorkerActivityReport
{
	public $ID = 0;
	public $Worker = '';
	public $Activity = '';
	public $Date = 0;
	public $Effort = 0.0;
}

class PlanActivityReport
{
	public $Activity = '';
	public $Description = '';
	public $EstimateDate = 0;
	public $RealDate = 0;
	public $EstimateTime = 0;
	public $RealTime = 0;
	public $Delay = 0.0;
	public $Workers = array();
}

class WorkerActivitiesReport extends TComponent
{
	public $Worker = '';
	public $Activities;
	
	public function __construct()
	{
		$this->Activities = new TList;
	}
}

class ProjectActivityReport
{
	public $Project = '';
	public $Activity = '';
	public $Description = '';
	public $Date = 0;
	public $Effort = 0.0;
}


class ReportsDao extends BaseDao
{
	public function getTimeReportsByProjectIDs($projects)
	{
		$ids = implode(',', array_map('intval', $projects));
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetTimeReportByProjectIDs', $ids);
	}

	public function getUserProjectTimeReports($users, $projects, $startDate, $endDate)
	{
		$sqlmap = $this->getSqlMap();
		$ids = implode(',', array_map('intval', $projects));
		$sqlmap->getDbConnection()->setActive(true); //db connection needs to be open for quoteString
		$usernames = implode(',', array_map(array($sqlmap->getDbConnection(), 'quoteString'), $users));

		$param['projects'] = $ids;
		$param['members'] = $usernames;
		$param['startDate'] = intval($startDate);
		$param['endDate'] = intval($endDate);

		return $sqlmap->queryForList('GetTimeReportByUsername', $param);
	}
	
	/**
	 * Get first activity date of a project
	 * @param $project project title
	 * @return date first date 
	 */
	public function getProjectInit($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProjectInit', $project);
	}
	
	/**
	 * Get last activity date of a project
	 * @param $project project title
	 * @return date last date 
	 */
	public function getProjectEnd($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProjectEnd', $project);
	}
	
	/******************** PROJECT MANAGER ****************************/
	
	/**
	 * Get report of worker who have activities in curse
	 * @param $project project name
	 * @param $start start date
	 * @param $end end date
	 * @return array active worker list
	 */
	public function getActiveWorkers($project, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $project;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetActiveWorkers', $param);
	}
	
	/**
	 * Get report of worker who have activities asigned
	 * @param $project project name
	 * @param $start start date
	 * @param $end end date
	 * @return array activity list
	 */
	public function getAsignedActs($project, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $project;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetAsignedActs', $param);
	}
	
	/**
	 * Get work record to review for manager
	 * @param $project project name
	 * @return array work record list
	 */
	public function getReviewWorkRecords($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetReviewWorkRecords', $project);
	}
	
	/**
	 * Get work record to approve for manager
	 * @param $project project name
	 * @return array work record list
	 */
	public function getApproveWorkRecords($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetApproveWorkRecords', $project);
	}
	
	/**
	 * Get report of current working activities and its state
	 * @param $project project name 
	 * @param $start start date
	 * @param $end end date
	 * @return array activity list
	 */
	public function getCurrentActs($project, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $project;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetCurrentActs', $param);
	}
	
	/**
	 * Get planned activities for a date and its actual duration 
	 * @param $project project name 
	 * @param $date activity date
	 * @return array activity list
	 */
	public function getPlannedActs($project, $date)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $project;
		$param['date'] = $date;
		return $sqlmap->queryForList('GetPlannedActs', $param);
	}
	
	/**
	 * Get delayed activities respect its initial planification 
	 * @param $project project name 
	 * @return array activity list
	 */
	public function getDelayedActs($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetDelayedActs', $project);
	}
	
	/**
	 * Get activities and assigned workers for future period 
	 * @param $project project name
	 * @param $start start date 
	 * @param $end end date
	 * @return array activity list
	 */
	public function getFutureActs($project, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $project;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetFutureActs', $param);
	}
	
	/**
	 * Get workers with activities assigned for a future period
	 * @param $project project name
	 * @param $start start date 
	 * @param $end end date
	 * @return array activity list
	 */
	public function getFutureWorkers($project, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $project;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetFutureWorkers', $param);
	}
	
	/**
	 * Get summary of all finished activities for a project 
	 * @param $project project name 
	 * @return array activity list
	 */
	public function getSummary($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetSummary', $project);
	}
	
	/************************* DEVELOPER *****************************/
	
	/**
	 * Get work record report for a time period
	 * @param $user user name 
	 * @param $project project name 
	 * @param $start start date
	 * @param $end end date
	 * @return array work record list
	 */
	public function getWorkRecordReport($user, $project, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['project'] = $project;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetWorkRecordReport', $param);
	}
	
	/**
	 * Get activity effort report for a finished project
	 * @param $user user name 
	 * @param $project project name 
	 * @return array activity-effort list
	 */
	public function getActEffortReport($user, $projec)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['project'] = $project;
		return $sqlmap->queryForList('GetActEffortReport', $param);
	}
	
	/******************** PERSONAL MANAGER ****************************/
	
	/** 
	 * Get report of projects for a worker
	 * @param worker name
	 * @return array project list
	 */
	public function getWorkerProjects($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetWorkerProjects', $name);
	}
	
	/**
	 * Get report of holidays for a worker
	 * @param $start start date
	 * @param $end end date
	 * @return array holiday periods
	 */
	public function getWorkerHolidays($user, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetWorkerHolidaysByPeriod', $param);
	}
	
	/**
	 * Get report of activities for a worker
	 * @param $start start date
	 * @param $end end date
	 * @return array activity records
	 */
	public function getWorkerActivities($user, $start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetWorkerActivitiesByPeriod', $param);
	}
	
	/**
	 * Get report of activities for all workers
	 * @param $start start date
	 * @param $end end date
	 * @return array worker-activities records
	 */
	public function getWorkerActivitiesReport($start, $end)
	{
		$sqlmap = $this->getSqlMap();
		$param['start'] = $start;
		$param['end'] = $end;
		return $sqlmap->queryForList('GetWorkerActivitiesReport', $param);
	}
}

?>