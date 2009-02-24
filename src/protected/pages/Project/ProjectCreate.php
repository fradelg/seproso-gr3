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
			
			// add manager data to project participants
			$worker = $newProject->ManagerID;
			$title = $newProject->Title;
			$perc = floatval($this->participation->Text);
			$this->getWorkerDao()->addParticipation(
				$worker, $title, 'Jefe de proyecto', $perc);
		
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
	
	/**
	 * Verify that participation porcentage is less than or equal 100%
	 * @param TControl custom validator that created the event.
	 * @param TServerValidateEventParameter validation parameters.
	 */
	public function validatePorcentage($sender, $param)
	{
		$p = $this->getWorkerDao()->getParticipation($this->manager->SelectedValue);
		$p = 100.0 - $p;
		if ($p < floatval($this->participation->Text)){
			$param->IsValid = false;
			$sender->ErrorMessage =	"Este trabajador s&oacute;lo puede participar como 
				Jefe de proyecto hasta el ".$p."%.";
		}
	}
}

?>