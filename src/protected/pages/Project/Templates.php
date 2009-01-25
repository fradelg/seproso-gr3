<?php

class Templates extends TPage
{
	private $phases;
	
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			if ($this->getProjectDao()->projectModelExists($this->Session['project']))
				$this->Response->redirect("?page=Project.Phases");
		 	else {
				$this->templateList->DataSource = $this->getTemplates();
				$this->dataBind();
		 	}
		}
	}

	protected function getTemplates()
	{
		$dao = $this->getProjectDao();
		$templates = array();
		foreach ($dao->getAllModelTemplates() as $template)
			$templates[$template] = $template;
		return $templates;
	}
	
	public function templateSelected($sender, $param)
	{
		$this->phases = 
			$this->getProjectDao()->getPhasesByTemplate($sender->SelectedValue);
		$this->phaseList->DataSource = $this->phases;
		$this->dataBind();
	}
	
	public function useTemplate($sender, $param)
	{
		$model = $this->getProjectDao()->getModelByTemplate(
						$this->phaseList->SelectedItem->Text); 
		$id = $this->getProjectDao()->addNewModel($model);
		foreach($this->phases as $phase){
			$phase->ModelID = $id;
			$this->getProjectDao()->addNewPhase($phase);
		}
		$this->Response->redirect("?page=Project.Phases");
	}
	
	public function customization($sender, $param)
	{
		$model = new ProcessRecord;
		$model->Name = 'Personalizado';
		$model->Description = 'Definido por el usuario';
		$id = $this->getProjectDao()->addNewModel($model);
		$this->getProjectDao()->updateProjectModel($this->User->Project, $id);
		$this->Response->redirect("?page=Project.Phases");
	}
}

?>