<?php

class Activities extends TPage
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
		$userDao = $this->Application->Modules['daos']->getDao('UserDao');
		$start = $this->dateFrom->TimeStamp;
		$end = $this->dateTo->TimeStamp;

		// Asociamos el resultado de la consulta al TRepeater
		$this->workers->DataSource = $userDao->getAllUsers();
		$this->workers->dataBind();		
	}
}

?>