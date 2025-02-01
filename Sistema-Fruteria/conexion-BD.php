<?php 
	function conectarBD(){
		$servername = "localhost" ;
		$database = "fruteria" ;
		$username = "root" ;
		$password = "" ;

		try{
			$conn = mysqli_connect($servername, $username, $password, $database) ;
		} catch (msqli_sql_exception $e) {
			die("Error en la conexion:: ". $e-> getMessage());
		}

		return $conn; 
}
?>