<?php

class ActivityDao extends BaseDao
{
	function addNewActivity($activity)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddNewActivity', $activity);
	}
	
	function addNewArtifact($name, $description)
	{
		$sqlmap = $this->getSqlMap();
		$param['name'] = $name;
		$param['description'] = $description; 
		$sqlmap->insert('AddNewArtifact', $param);
	}
	
	function addPrecedentActivity($pred, $actID)
	{
		$sqlmap = $this->getSqlMap();
		$param['act'] = $actID;
		$param['pred'] = $pred; 
		$sqlmap->insert('AddPrecedentActivity', $param);
	}
	
	function addWorkerToActivity($worker, $actID)
	{
		$sqlmap = $this->getSqlMap();
		$param['worker'] = $worker;
		$param['act'] = $actID; 
		$sqlmap->insert('AddWorkerToActivity', $param);
	}

	function existsActivePrecedents($actID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('ExistsActivePrecedents', $actID);
	}
	
	function getActivityByID($actID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetActivityByID', $actID);
	}

	function getAllActivities($phaseID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllActivities', $phaseID);
	}
	
	function getAllActivitiesByProject($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllActivitiesByProject', $project);
	}
	
	function getTypesOfActivities()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetTypesOfActivities');
	}
	
	function getArtifactSet()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetArtifactSet');
	}

	function getInitActivities($projectID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetInitActivities', $projectID);
	}
	
	function getPredActivities($actID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPrecedentActivities', $actID);
	}
	
	function getPosteriorActivities($actID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPosteriorActivities', $actID);
	}
	
	function getActivitiesByWorker($projectID, $workerID)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $projectID;
		$param['worker'] = $workerID; 
		return $sqlmap->queryForList('GetActivitiesByWorker', $param);
	}

	function getActivityDuration($actID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetActivityDuration', $actID);
	}
	
	function beginActivity($actID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('BeginActivity', $actID);
	}
	
	function endActivity($actID, $duration)
	{
		$sqlmap = $this->getSqlMap();
		$param['act'] = $actID;
		$param['time'] = $duration; 
		$sqlmap->update('EndActivity', $param);
	}
	
	function updateActivity($actID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateActivity', $actID);
	}
	
	function deleteActivity($actID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteActivity', $actID);
	}
}

?>