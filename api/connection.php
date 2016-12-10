<?php
	class Conexion{
		
		private $host = 'localhost';
		private $dbname = 'lab';
		private $user = 'hernan';
		private $pass = '123456';
		public $dbConn;
		private $connected = false;
		
		function connect(){
			try {
				$this->dbConn = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
				return true;
			} catch(mysqliException $e){
				die ("ERROR: No se estableció la conexión. " . mysqli_connect_error());
				return false;
			}
		}

		function init(){
			if(!$this->connected){
				$this->connected = $this->connect();
			}
		}
		
		function query($query){
			return $this->dbConn->query($query);
		}
		
		function close(){
			$this->dbConn->close();
		}

		function prepare($args){
			return $this->dbConn->prepare($args);
		}

		function initQuery($query){
			$this->init();
			if($this->dbConn->connect()){
				$rows = array();
				if($result = $this->dbConn->query($query)){
					while($r = mysqli_fetch_assoc($result)) {
						$rows[] = $r;
					}
					return $rows;
				}
			}
			$this->dbConn->close();
			
			return null;
		}
	}
?>