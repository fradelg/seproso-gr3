<?php
/**
 * DaoManager class file.
 *
 * @author Grupo3 - ISO 2 - UVA
 */

Prado::using('System.Data.SqlMap.TSqlMapConfig');

/**
 * DaoManager class.
 *
 * A Registry for Dao and an implementation of that type.
 */
class DaoManager extends TSqlMapConfig
{
	/**
	 * @var array registered list of dao
	 */
	private $_dao=array();

	/**
	 * Initializes the module.
	 * This method is required by IModule and is invoked by application.
	 * It loads dao information from the module configuration.
	 * @param TXmlElement module configuration
	 */
	public function init($xml)
	{
		parent::init($xml);
		foreach($xml->getElementsByTagName("dao") as $node)
		{
			$this->_dao[$node->getAttribute('id')] =
				array('class' => $node->getAttribute('class'));
		}
	}

	/**
	 * @return array list of registered Daos
	 */
	public function getDaos()
	{
		return $this->_dao;
	}

	/**
	 * Returns an implementation of a Dao type, implements the Registery
	 * pattern. Multiple calls returns the same Dao instance.
	 * @param string Dao type to find.
	 * @return object instance of the Dao implementation.
	 */
	public function getDao($class)
	{
		if(isset($this->_dao[$class]))
		{
			if(!isset($this->_dao[$class]['instance']))
			{
				$dao = Prado::createComponent($this->_dao[$class]['class']);
				$dao->setSqlMap($this->getClient());
				$this->_dao[$class]['instance'] = $dao;
			}
			return $this->_dao[$class]['instance'];
		}
		else
			throw new SeprosoException('daomanager_undefined_dao', $class);
	}
}

?>