<?php

	function db_add($table, $data){
		// preparação de dados que serão usados
		$fields   = array_keys($data);
		$numb_fields = count($data);

		// sintaxe inicial
		$syntax = "INSERT INTO " . $table . " (";

		// adiciona todos os campos que terao valor inserido
		for ($aux = 0; $aux < $numb_fields; $aux++){
			$syntax .= $fields[$aux] . ", ";
		}

		// retira os dois ultimos caracteres (", ")
		$syntax = substr($syntax, 0, -2);
		$syntax .= ") VALUES (";

		// adiciona os valores a serem inseridos nos campos
		for ($aux = 0; $aux < $numb_fields; $aux++){
			if ($data[$fields[$aux]] != ""){
				$syntax .= "'" . addslashes($data[$fields[$aux]]) . "', ";
				// addslashes escapa os caracteres especiais
			} else {
				$syntax .= "NULL, ";
				// valores vazios são inseridos como nulos
			}
		}

		// retira novamente os ultimos dois caracteres e finaliza a sintaxe
		$syntax = substr($syntax, 0, -2);
		$syntax .= ")";

		// chama a $db_connection para o escopo da função
		global $db_connection;

		// prepara e executa a sintaxe SQL
		$prepared = $db_connection->prepare($syntax);
		$result = $prepared->execute();

		return $result;

	}

	// Função de alteração SQL

	function db_update($table, $data, $condition){
		// preparação de dados que serão usados
		$fields   = array_keys($data);
		$numb_fields = count($data);

		// sintaxe inicial
		$syntax = "UPDATE " . $table . " SET ";

		// adiciona a atribuição de dados nos campos
		for ($aux = 0; $aux < $numb_fields; $aux++){
			if ($data[$fields[$aux]] != ""){
				$syntax .= $fields[$aux] . "='" . addslashes($data[$fields[$aux]]) . "', ";
				// (campo)='(valor)', addslashes escapa caracteres especiais
			} else {
				$syntax .= $fields[$aux] . "=NULL, ";
				// valores vazios são inseridos como nulos
			}
		}

		// remove os dois ultimos caracteres
		$syntax = substr($syntax, 0, -2);

		// adiciona condicao
		$syntax .= " WHERE " . $condition;
		// chama a $db_connection para o escopo da função
		global $db_connection;

		// prepara e executa a sintaxe SQL
		$prepared = $db_connection->prepare($syntax);
		$result = $prepared->execute();

		return $result;

	}

	// Função de exclusão SQL

	function db_delete($table, $condition){

		// cria a sintaxe SQL
		$syntax = "DELETE FROM " . $table . " WHERE " . $condition;

		// chama a $db_connection para o escopo da função
		global $db_connection;

		// prepara e executa a sintaxe SQL
		$prepared = $db_connection->prepare($syntax);
		$result = $prepared->execute();

		return $result;

	}

?>