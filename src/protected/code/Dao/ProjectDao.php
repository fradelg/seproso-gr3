<?php
/**
 * Project DAO class file.
 *
 * @author Grupo 3 - ISO 2 - UVA
 */

/**
 * Configuration record.
 */
class ConfigurationRecord
{
	public $Parameter = '';
	public $Description = '';
	public $Value = 0;
}

/**
 * Project DAO class.
 */
class ProjectDao extends BaseDao
{
	public function projectNameExists($projectName)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('ProjectNameExists', $projectName);
	}
	
	public function projectModelExists($projectName)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('ProjectModelExists', $projectName);
	}

	public function modelTemplateExists($projectName)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('ModelTemplateExists', $projectName);
	}

	public function projectWorkersExists($projectName)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('ProjectWorkersExists', $projectName);
	}
	
	public function getProjectByID($projectID)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProjectByID', $projectID);
	}
	
	public function getProjectByWorker($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetProjectByWorker', $name);
	}
	
	public function getProjectsByState($state)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetProjectsByState', $state);
	}
	
	public function getProjectModel($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProjectModel', $name);
	}
	
	public function getProjectManager($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProjectManager', $name);
	}
	
	public function getProjectState($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProjectState', $name);
	}
	
	public function getPhasesByModel($model)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPhasesByModel', $model);
	}
	
	public function getPhasesByProject($project)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPhasesByProject', $project);
	}
	
	public function getModelByTemplate($template)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetModelByTemplate', $template);
	}
	
	public function getAllProjects()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllProjects');
	}
	
	public function getAllModelTemplates()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllModelTemplates');
	}
	
	public function getPhasesByParent($phase)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPhasesByParent', $phase);
	}
	
	public function getAllParameters()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllParameters');
	}

	public function addNewProject($project)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddNewProject', $project);
	}
	
	public function addNewPhase($phase)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddNewPhase', $phase);
	}

	public function addNewModel($model)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddNewModel', $model);
	}

	public function updateProject($project)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateProject', $project);
	}
	
	public function updateModel($model)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateModel', $model);
	}
	
	public function updatePhase($phase)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdatePhase', $phase);
	}
	
	public function updateProjectModel($project, $model)
	{
		$sqlmap = $this->getSqlMap();
		$param['title'] = $project;
		$param['model'] = $model;
		$sqlmap->update('UpdateProjectModel', $param);
	}
	
	public function updateProjectState($project, $state)
	{
		$sqlmap = $this->getSqlMap();
		$param['title'] = $project;
		$param['state'] = $state;
		$sqlmap->update('UpdateProjectState', $param);
	}
	
	public function updateParameter($paramID, $value)
	{
		$sqlmap = $this->getSqlMap();
		$param['param'] = $paramID;
		$param['value'] = $value;
		$sqlmap->update('UpdateParameter', $param);
	}
	
	public function deleteProject($projectID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteProject', $projectID);
	}
}

?>