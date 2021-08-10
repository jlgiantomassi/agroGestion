<?php

class BaseDatos {

	private $host="127.0.0.1";
	private $port=3306;
	private $socket="";
	private $user="root";
	private $password="";
	private $dbname="agrogestion";
	private $cantReg;
	
	private function conectar()
	{
		
		$con = new mysqli($this->host, $this->user, $this->password, $this->dbname, $this->port, $this->socket);
		$con->set_charset("utf-8");
		//$this->con->connect_errno ? die("Error en la conexion a la base de datos".mysqli_connect_errno()): $m="Conectado";
		
		if ($con->connect_error) {
			$con->connect_error;
			header('Location: error-conexion.php');
			exit;
		} 
		else
		{
			return $con;
		}
	}

	private function cerrar($con)
	{
		$con->close();
	}

	public function sql($sql)
	{
		try{
			$con=$this->conectar();
			$query = $con->query($sql);
			$datos=array();
			if($query)
			{
				$this->cantReg=$query->num_rows;
				$datos=$query->fetch_all(MYSQLI_ASSOC);
			}
			else 
			{
				$this->cantReg=0;
			}
			$this->cerrar($con);
			return $datos;
		}catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function cantidadRegistros()
	{
		return $this->cantReg;
	}
	
	public function insertar($sql)
	{
		
		try
		{
			$con=$this->conectar();
			$query=$con->query($sql);
			if($query)
			{
				$id = $con->insert_id;
				return $id;
			}
			else
			{
				return 0;
			}
		}
		catch(Exception $e)
		{
			die($e->getMessage());
			return 0;
		}

	}

	public function insertarVarios($sql)
	{
		
		try
		{
			$con=$this->conectar();
			$con->multi_query($sql);
			$id = $con->insert_id;
			return $id;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
			return 0;
		}

	}

	public function eliminar($sql)
	{
		
		try
		{
			$con=$this->conectar();
			$query=$con->query($sql);
			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(Exception $e)
		{
			die($e->getMessage());
			return 0;
		}

	}
}

?>