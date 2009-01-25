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

	function getCategoryByID($categoryID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetCategoryByID', $categoryID);
	}

	function getAllActivities($phaseID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllActivities', $phaseID);
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
	
	function getPosteriorActivities($actID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPosteriorActivities', $actID);
	}
	
	function existsActivePrecedents($actID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('ExistsActivePrecedents', $actID);
	}
	
	function deleteActivity($actID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteActivity', $actID);
	}

	function getActivitiesByWorker($workerID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetActivitiesByWorker', $workerID);
	}

	function getCategoryByNameInProject($name, $projectID)
	{
		$sqlmap = $this->getSqlMap();
		$param['project'] = $projectID;
		$param['category'] = $name;
		return $sqlmap->queryForObject('GetCategoryByNameInProject', $param);
	}

	function beginActivity($actID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('BeginActivity', $actID);
	}
	
	function endActivity($actID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('EndActivity', $actID);
	}
	
	function updateActivity($actID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateActivity', $actID);
	}
}

?>