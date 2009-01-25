<?php
/**
 * Project DAO class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: ProjectDao.php 1578 2006-12-17 22:20:50Z wei $
 * @package Demos
 */

/**
 * Project DAO class.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: ProjectDao.php 1578 2006-12-17 22:20:50Z wei $
 * @package Demos
 * @since 3.1
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

	public function addNewProject($project)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('CreateNewProject', $project);
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
	
	public function getProjectNamesByWorker($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetProjectNamesByWorker', $name);
	}
	
	public function getProjectModel($name)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProjectModel', $name);
	}
	
	public function getPhasesByTemplate($template)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPhasesByTemplate', $template);
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
	
	public function getPhaseChildren($phase)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetPhaseChildren', $phase);
	}

	public function addNewPhase($phase)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->insert('AddNewPhase', $phase);
	}

	public function addNewModel($model)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->insert('AddNewModel', $model);
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
	
	public function deleteProject($projectID)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteProject', $projectID);
	}
	
}

?>