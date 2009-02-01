<?php

class Configuration extends TPage
{
	protected function getProjectDao()
	{
		return $this->Application->Modules['daos']->getDao('ProjectDao');
	}
	
	/**
	 * Load all parameter data and display them.
	 */
	function onLoad($param)
	{
		if(!$this->IsPostBack) $this->showList();
	}
	
	protected function showList()
	{
		$this->paramList->DataSource = $this->getProjectDao()->getAllParameters();
		$this->paramList->dataBind();
	}
	
	public function editEntryItem($sender, $param)
	{
		$this->paramList->EditItemIndex = $param->Item->ItemIndex;
		$this->showList();
	}
	
	public function refreshEntryList()
	{
		$this->paramList->EditItemIndex = -1;
		$this->showList();
	}
			
	public function updateEntryItem($sender, $param)
	{					
		$item = $param->Item;
		$paramID = $this->paramList->DataKeys[$item->ItemIndex];
		$value = intval($item->valueBox->Text);
		$this->getProjectDao()->updateParameter($paramID, $value);
			
		// update table
		$this->refreshEntryList();
	}
}

?>