<?php 

	class funciones {

		//Funcion para limpiar variables que contengan inyeccion SQL
	    public static function limpiarCadena($valor) {
	        $valor=addslashes($valor);
	        $valor = str_ireplace("<script>", "", $valor);
	        $valor = str_ireplace("</script>", "", $valor);
	        $valor = str_ireplace("SELECT * FROM", "", $valor);
	        $valor = str_ireplace("DELETE FROM", "", $valor);
	        $valor = str_ireplace("UPDATE", "", $valor);
	        $valor = str_ireplace("INSERT INTO", "", $valor);
	        $valor = str_ireplace("DROP TABLE", "", $valor);
	        $valor = str_ireplace("TRUNCATE TABLE", "", $valor);
	        $valor = str_ireplace("--", "", $valor);
	        $valor = str_ireplace("^", "", $valor);
	        $valor = str_ireplace("[", "", $valor);
	        $valor = str_ireplace("]", "", $valor);
	        $valor = str_ireplace("\\", "", $valor);
	        $valor = str_ireplace("=", "", $valor);
	        return $valor;
	    }


	}


?>