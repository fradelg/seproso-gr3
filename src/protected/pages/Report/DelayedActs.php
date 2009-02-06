<?php

class DelayedActs extends TPage
{
	// Bind report data to Repeater 
	public function onload($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");
			
		if(!$this->IsPostBack){
			// Retrieve data from data base query aql
			$dao = $this->Application->Modules['daos']->getDao('ReportsDao');

			// Bind query data to TRepeater
			$acts = $dao->getDelayedActs($this->Session['project']);
			$this->activityList->DataSource = $this->getDelayedActs($acts); 
			$this->activityList->dataBind();
		}		
	}
	
	/**
	 * Get all delayed activities from finished or active activity list
	 * @param $activities finished or active activities
	 * @return array list of delayed activities
	 */
	private function getDelayedActs($activities)
	{
		$result = array();
		foreach($activities as $act)
			if ($act->Delay > 0.0) array_push($result, $act);
		return $result;
	}
}

?>