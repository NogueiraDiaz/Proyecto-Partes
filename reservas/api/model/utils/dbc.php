<?php
/**
 * DATABASE CONNECTION MySQL
 * @author Eloy Rodríguez Martín (ERMtn)
 */ 
class Dbc {

    const server = "PMYSQL162.dns-servicio.com";
    const username = "adminjuliovernepartes";
    const password = "m4l3fD8*";
    const dbname = "9383564_app";

    protected function connect(){
        try{
            $server = self::server;
            $username = self::username;
            $password = self::password;
            $dbname = self::dbname;

            $dbh = new PDO("mysql:host=$server;dbname=".$dbname."; charset=UTF8", $username, $password);
            $this -> initDB($dbh);
            return $dbh;
                
        } catch(PDOException $e){
            //TODO: Handle errors properly
            echo $e;
        }
    }

    private function initDB($dbh){
        // Inicializar la base de datos con las tablas necesarias
        // Aqui se puede comprobar el esquema de las tablas
       
        $dbh -> exec('CREATE TABLE IF NOT EXISTS Reservas(
            id INT PRIMARY KEY AUTO_INCREMENT,
            autor INTEGER NOT NULL,
            aula VARCHAR(150) NOT NULL,
            fecha DATE NOT NULL, inicio TIME NOT NULL, fin TIME NOT NULL,
            comentario VARCHAR(255),
            FOREIGN KEY (autor) REFERENCES usuarios(cod_usuario),
            UNIQUE uniqueCombination (aula, fecha, inicio, fin));'
        );
    }
    
}