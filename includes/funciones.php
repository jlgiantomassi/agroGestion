<?php 
function fecha_a_normal($fecha)
{ 	
	if ($fecha=="")
	{ return "";
	}
	else {
		$fNomal=DateTime::createFromFormat("Y-m-d",$fecha);
		return $fNomal->format("d/m/Y");	
	}


} 
function fecha_a_mysql($fecha){ 
	if ($fecha=="")
	{
		return null;
	}
	else
	{
		$fMysql=DateTime::createFromFormat("d/m/Y",$fecha);
		return $fMysql->format("Y-m-d");
	}
} 
?>