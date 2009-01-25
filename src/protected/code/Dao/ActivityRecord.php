<?php
/**
 * Seproso Activity record.
 *
 * @author Grupo 3 - ISO 2 - UVA
 * @version 1.0
 * 
 */
class ActivityRecord
{
	public $ID = 0;
	public $TypeID = 0;
	public $PhaseID = 0;
	public $ArtifactID = 0;
	
	public $Name = '';
	public $Description = '';
	public $EstimateDate = 0;
	public $RealDate = 0;
	public $EstimateDuration = 0.0;
	public $RealDuration = 0.0;
	public $State = 0;
	
	public $Preds = NULL;
}

?>