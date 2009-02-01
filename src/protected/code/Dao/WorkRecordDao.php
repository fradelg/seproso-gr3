<?php

class WorkReport
{
	public $ID = 0;
	public $Worker = '';
	public $Activity = '';
	
	public $Date = 0;
	public $StartDate = 0;
	public $EndDate = 0;
	
	public $Effort = 0.0;
	public $State = 0;
	public $Comentary = '';
}

class WorkRecordDao extends BaseDao
{
	public function addWorkRecord($record)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddWorkRecord', $record);
	}

	public function getWorkRecordByID($recID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetWorkRecordByID', $recID);
	}

	public function deleteTimeEntry($entryID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteTimeEntry', $entryID);
	}

	public function getTimeEntriesInProject($username, $projectID)
	{
		$sqlmap = $this->getSqlMap();
		$param['username'] = $username;
		$param['project'] = $projectID;
		return $sqlmap->queryForList('GetAllTimeEntriesByProjectIdAndUser', $param);
	}
	
	public function getWorkRecordsByWA($username, $actID)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $username;
		$param['act'] = $actID;
		return $sqlmap->queryForList('GetWorkRecordsByWorkerAndActivity', $param);
	}

	public function updateToState($id, $state)
	{
		$sqlmap = $this->getSqlMap();
		$param['id'] = $id;
		$param['state'] = $state;
		$sqlmap->update('UpdateToState', $param);
	}
	
	public function updateTimeEntry($entry)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateTimeEntry', $entry);
	}
}

?>