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
	 * @return array list with all workers.
	 */
	public function getAllWorkers()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllWorkers');
	}
	
	/**
	 * @return array list with all partipants in one project.
	 */
	public function getProjectWorkers($projectID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetProjectWorkers', $projectID);
	}
	
	/**
	 * @return array list with all free workers.
	 */
	public function getFreeWorkers($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetFreeWorkers', $project);
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
	 * @param name of worker
	 * @return username of worker
	 */
	public function getUsername($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetUsername', $name);
	}
	
	/**
	 * @param user name
	 * @return array list with all holiday periods
	 */
	public function getWorkerHolidays($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetWorkerHolidays', $name);
	}

	/** 
	 * @param user name
	 * @return int number of holiday period used by worker
	 */
	public function getNoHolidayPeriods($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetNoHolidayPeriods', $name);
	}
	
	/** 
	 * @param user name
	 * @return int number of weeks consumed by worker
	 */
	public function getHolidayWeeks($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetHolidayWeeks', $name);
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
	 * Updates the worker data modified by admin.
	 * @param WorkerRecord updated worker details.
	 */
	public function updateWorker($worker)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateWorker', $worker);
	}
	
	/**
	 * Deletes the worker from database.
	 * @param workers identifier
	 */
	public function deleteWorker($workerID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteWorkerByName', $workerID);
	}
}

?>