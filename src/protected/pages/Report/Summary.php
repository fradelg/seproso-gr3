<?php

class Summary extends TPage
{
	// Carga los datos en los componentes al cargar la p�gina
	public function onLoad($param)
	{
		if(!$this->IsPostBack){}
	}	
	
	// Genera el informe de datos asociado a esta p�gina
	public function generateReport($sender, $param)
	{
		// Cambiamos a la vista de informaci�n
		$this->views->ActiveViewIndex = 1;
		// Consultamos los datos en la base de datos
		$actDao = $this->Application->Modules['daos']->getDao('TimeEntryDao');
		$user = $this->User;
		//$report = $actDao->getTimeEntriesInProject($project, $start, $end);

		// Asociamos el resultado de la consulta al TRepeater
		//$this->workers->DataSource = $report;
		//$this->workers->dataBind();		
	}
}

?>