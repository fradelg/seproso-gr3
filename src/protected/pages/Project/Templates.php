<?php

class Templates extends TPage
{
	private $Phases;
	
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
		 		$templates = $this->getTemplates();
				$this->templateList->DataSource = $templates;
				$this->templateList->dataBind();
				$this->showPhaseList(key($templates));
		 	}
		}
	}

	/**
	 * Get template array associating ID => Name
	 * @return array template name list
	 */
	protected function getTemplates()
	{
		$templates = array();
		foreach ($this->getProjectDao()->getAllModelTemplates() as $template)
			$templates[$template->ID] = $template->Template;
		return $templates;
	}
	
	// Template list selection event
	public function templateSelected($sender, $param)
	{
		$this->showPhaseList($sender->SelectedValue);
	}
	
	/**
	 * Show phase list table for a model template
	 * @param $model model ID
	 */
	public function showPhaseList($model)
	{
		$this->Phases = $this->getProjectDao()->getPhasesByModel($model);
		$this->phaseList->DataSource = $this->getPhaseTree();
		$this->phaseList->dataBind();
	}
	
	/**
	 * Get project phase list sorted by parentID
	 * @return array phase list sorted
	 */
	private function getPhaseTree()
	{
		$result = array();
		foreach ($this->Phases as $phase)
			if ($phase->ParentID == NULL)
				$result = array_merge($result, $this->expandPhaseTree($phase, '-> '));
		return $result;
	}
	
	/**
	 * Traverse tree in depth, adding indentation
	 * @param $phase father node
	 * @param $prefix string to indent phase name in this tree level
	 * @return array children list
	 */
	private function expandPhaseTree($phase, $prefix)
	{
		$result = array();
		array_push($result, $phase);	// Push father
		foreach ($this->searchCildren($phase->ID) as $child){
			$child->Name = $prefix.$child->Name;
			$result = array_merge($result, $this->expandPhaseTree($child, $prefix.'-> '));
		}
		return $result;
	}
	
	/**
	 * Search children of a phase
	 * @param $phaseID parent
	 * @return array list of children
	 */
	private function searchCildren($phaseID)
	{
		$result = array();
		foreach($this->Phases as $phase)
			if ($phase->ParentID == $phaseID)
				array_push($result, $phase);
		return $result;
	}
	
	public function useTemplate($sender, $param)
	{
		$model = $this->getProjectDao()->getModelByTemplate($this->templateList->SelectedValue); 
		$this->getProjectDao()->addNewModel($model);
		$this->getProjectDao()->updateProjectModel($this->Session['project'], $model->ID);
		$phases = $this->getProjectDao()->getPhasesByModel($this->templateList->SelectedValue);
		foreach($phases as $phase){
			$phase->ProcessID = $model->ID;
			$this->getProjectDao()->addNewPhase($phase);
		}
		$this->Response->redirect("?page=Project.Phases");
	}
	
	public function customization($sender, $param)
	{
		$model = new ProcessRecord;
		$model->Name = 'Personalizado';
		$model->Description = 'Modelo definido por el usuario';
		$this->getProjectDao()->addNewModel($model);
		$this->getProjectDao()->updateProjectModel($this->Session['project'], $model->ID);
		$this->Response->redirect("?page=Project.Phases");
	}
}

?>