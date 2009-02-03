<?php

class ProjectCreate extends TPage
{
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->manager->DataSource = $this->getProjectManagers();
			$this->manager->dataBind();
		}
	}
	
	protected function getProjectManagers()
	{
		$managers = array();
		foreach ($this->getWorkerDao()->getProjectManagers() as $manager)
			$managers[$manager['UserID']] = $manager['Worker'];
		return $managers; 
	}
	
	public function saveProject($sender, $param)
	{	
		if ($this->IsValid){
			$newProject = new ProjectRecord;
			$newProject->Title = $this->projectName->Text;
			$newProject->Description = $this->description->Text;
			$newProject->Burchet = floatval($this->burchet->Text);
			$newProject->ManagerID = $this->manager->SelectedValue;
		
			// add project to database
			$this->getProjectDao()->addNewProject($newProject);
			
			// check if worker is already participating in project
			$worker = $newProject->ManagerID;
			$title = $newProject->Title;
			if ($this->getWorkerDao()->participationExists($worker, $title))
				$this->getWorkerDao()->updateParticipation(
					$worker, $title, 'Jefe de proyecto', 50);
			else
				$this->getWorkerDao()->addParticipation(
					$worker, $title, 'Jefe de proyecto', 50);
		
			$this->Response->redirect("?page=Project.ProjectList");
		}
	}
	
	/**
	 * Verify that the project name is not taken.
	 * @param TControl custom validator that created the event.
	 * @param TServerValidateEventParameter validation parameters.
	 */
	public function checkProjectname($sender, $param)
	{
		if($this->getProjectDao()->projectNameExists($this->projectName->Text))
		{
			$param->IsValid = false;
			$sender->ErrorMessage =	"El nombre del proyecto ya existe. Utilice otro distinto.";
		}
	}
}

?>