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
		return $this->getWorkerDao()->getProjectManagers();
	}
	
	public function saveProject($sender, $param)
	{	
		if ($this->IsValid){
			$newProject = new ProjectRecord;
			$userNick = $this->getWorkerDao()->getUsername(
								$this->manager->SelectedItem->Text);
			
			$newProject->Title = $this->projectName->Text;
			$newProject->Description = $this->description->Text;
			$newProject->Burchet = floatval($this->burchet->Text);
			$newProject->ManagerID = $userNick;
		
			$this->getProjectDao()->addNewProject($newProject);
			$this->getWorkerDao()->addParticipation($newProject->ManagerID,
								$newProject->Title, 'Jefe de proyecto', 100);
		
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