<?php

class Activities extends TPage
{
	// Page load event
	public function onLoad($param)
	{
		if (is_null($this->Session['project']))
			$this->Response->redirect("?page=User.NoProject");
	}
	
	// Genera el informe de datos asociado a esta página
	public function generateReport($sender, $param)
	{
		// Cambiamos a la vista de información
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