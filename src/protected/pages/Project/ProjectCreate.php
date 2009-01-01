<?php

class ProjectCreate extends TPage
{
	private $allUsers;
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	protected function getCategoryDao()
	{
		return $this->Application->Modules['daos']->getDao('CategoryDao');
	}
	
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->manager->DataSource = $this->getUsersWithRole('manager');
			$this->manager->dataBind();
		}
	}
	
	protected function getUsersWithRole($role)
	{
		if(is_null($this->allUsers))
		{
			$dao = $this->Application->Modules['daos']->getDao('UserDao');
			$this->allUsers = $dao->getAllUsers();		
		}
		$users = array();
		foreach($this->allUsers as $user)
		{
			if($user->isInRole($role))
				$users[$user->Name] = $user->Name;
		}
		return $users;
	}
	
	public function saveProject($sender, $param)
	{
		$this->views->ActiveViewIndex = 1;
		
		$newProject = new ProjectRecord;
		
		$projectDao = $this->getProjectDao();
		
		if($project = $this->getCurrentProject())
			$newProject = $projectDao->getProjectByID($project->ID);
		else
			$newProject->CreatorUserName = $this->User->Name;
			
		$newProject->Name = $this->projectName->Text;
		$newProject->CompletionDate = $this->completionDate->TimeStamp;
		$newProject->Description = $this->description->Text;
		$newProject->EstimateDuration = floatval($this->estimateHours->Text);
		$newProject->ManagerUserName = $this->manager->SelectedValue;
		
		if($this->currentProject)
			$projectDao->updateProject($newProject);
		else
			$projectDao->addNewProject($newProject);
		
		$this->updateProjectMembers($newProject->ID);
		
		$url = $this->Service->constructUrl('Seproso.ProjectDetails', 
					array('ProjectID'=> $newProject->ID));
		
		$this->Response->redirect($url);
	}
	
	protected function updateProjectMembers($projectID)
	{
		$active = $this->getViewState('ActiveConsultants');
		$projectDao = $this->getProjectDao();
		foreach($this->members->Items as $item)
		{
			if($item->Selected)
			{
				if(!in_array($item->Value, $active))
					$projectDao->addUserToProject($projectID, $item->Value);
			}
			else
			{
				if(in_array($item->Value, $active))
					$projectDao->removeUserFromProject($projectID, $item->Value);
			}
		}
	}
}

?>