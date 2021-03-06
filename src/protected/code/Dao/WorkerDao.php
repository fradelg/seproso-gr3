<?php
/**
 * Worker Dao object.
 *
 * @author Grupo 3 - ISO 2 - UVA
 * @version 1.0
 * 
 */

/**
 * WorkerDao class list, create, find and delete workers.
 */
class WorkerDao extends BaseDao
{
	/**
	 * @param $worker username
	 * @return boolean true if worker participates some project
	 */
	public function workerHasProject($worker)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('WorkerHasProject', $worker);
	}

	/**
	 * 
	 * @param $worker worker username
	 * @param $project project title
	 * @return boolean true if worker is participating in project
	 */
	public function participationExists($worker, $project)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $worker;
		$param['project'] = $project;
		return $sqlmap->queryForObject('ParticipationExists', $param);
	}

	/**
	 * @return array list with all registered users.
	 */
	public function getAllSeprosoUsers()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllSeprosoUsers');
	}
	
	/**
	 * @return array list with all workers.
	 */
	public function getAllWorkers()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllWorkers');
	}
	
	/**
	 * @return array list with all worker data in a project.
	 */
	public function getWorkersInProject($projectID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetWorkersInProject', $projectID);
	}
	
	/**
	 * @return array list with partipant data for a project.
	 */
	public function getProjectWorkers($projectID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetProjectWorkers', $projectID);
	}
	
	/**
	 * @return array list with all avalaible workers for a project.
	 */
	public function getWorkersForProject($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetWorkersForProject', $project);
	}
	
	/** 
	 * @return array list of project manager.
	 */
	public function getProjectManagers()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetProjectManagers');
	}
	
	/** 
	 * Look for finished project for manager
	 * @return string project name
	 */
	public function getFinishedProject($user)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetFinishedProject', $user);
	}
	
	/** 
	 * @param name of worker
	 * @return username of worker
	 */
	public function getUsername($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetUsername', $name);
	}
	
	/** 
	 * @param $name username of worker
	 * @return string name of worker
	 */
	public function getWorkerName($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetWorkerName', $name);
	}
	
	/** 
	 * @param $name username
	 * @return float participation porcentage
	 */
	public function getParticipation($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetParticipation', $name);
	}
	
	/**
	 * @return array list of all roles.
	 */
	public function getAllRoles()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllRoles');
	}
	
	/**
	 * @return array list with greater roles.
	 */
	public function getGreaterRoles($minRole)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetGreaterRoles', $minRole);
	}
	
	/**
	 * @param worker identifier
	 * @return array list with allowed roles for worker.
	 */
	public function getRoles($workerID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetRoles', $workerID);
	}
	
	/**
	 * @param $name username
	 * @return array list with all holiday periods
	 */
	public function getWorkerHolidays($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetWorkerHolidays', $name);
	}

	/** 
	 * @param $name username
	 * @return int number of holiday period used by worker
	 */
	public function getNoHolidayPeriods($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetNoHolidayPeriods', $name);
	}
	
	/** 
	 * @param $name username
	 * @return int number of weeks consumed by worker
	 */
	public function getHolidayWeeks($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetHolidayWeeks', $name);
	}
	
	/** 
	 * @param $name username
	 * @param $date date to check
	 * @return boolean true if 
	 */
	public function workerIsInHolidays($name, $date)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $name;
		$param['date'] = $date;
		return $sqlmap->queryForObject('WorkerIsInHolidays', $param);
	}
	
	/**
	 * @param WorkerRecord new worker details.
	 */
	public function addNewWorker($worker)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddNewWorker', $worker);
	}
	
	/**
	 * @param user Username who participate
	 * @param user Project Name
	 * @param role User role
	 * @param perc Percentage
	 */
	public function addParticipation($user, $project, $role, $perc)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['project'] = $project;
		$param['role'] = $role;
		$param['perc'] = $perc;
		$sqlmap->insert('AddParticipation', $param);
	}

	/**
	 * @param HolydayRecord new worker holyday period.
	 */
	public function addNewHolidayPeriod($period)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddHolidayPeriod', $period);
	}
	
	/**
	 * @param string username to delete
	 */
	public function deleteWorkerByName($username)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteWorkerByName', $username);
	}
	
	/**
	 * Updates the worker data modified by admin.
	 * @param WorkerRecord updated worker details.
	 */
	public function updateWorker($worker)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateWorker', $worker);
	}
	
	/**
	 * Updates the worker data modified by admin.
	 * @param $user project worker 
	 * @param $project project title
	 * @param $role $worker role
	 * @param $perc	$percentage
	 */
	public function updateParticipation($user, $project, $role, $perc)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['project'] = $project;
		$param['role'] = $role;
		$param['perc'] = $perc;
		$sqlmap->update('UpdateParticipation', $param);
	}
	
	/**
	 * Deletes the worker from database.
	 * @param $workerID worker identifier
	 */
	public function deleteWorker($workerID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteWorkerByName', $workerID);
	}
	
	/**
	 * Deletes the participation entry.
	 * @param $workerID worker identifier
	 * @param $projectID project identifier
	 */
	public function deleteParticipation($workerID, $projectID)
	{
		$sqlmap = $this->getSqlMap();
		$param['worker'] = $workerID;
		$param['project'] = $projectID;
		$sqlmap->delete('DeleteParticipation', $param);
	}
}

?>