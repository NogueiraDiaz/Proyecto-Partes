<?php
    try {
        require '../../../archivosComunes/conexion.php';

        $empresas = $db->query("SELECT * FROM Empresas")->fetchAll(PDO::FETCH_ASSOC);

        $consulta = $db->query("SELECT * FROM Pertenece");
        $idsEmpresas = array();
        if ($consulta->rowCount() > 0) {
            foreach ($consulta as $empresa) {
                array_push($idsEmpresas, $empresa["cod_empresa"]);
            }
        }

        $data = array(
            "empresas" => $empresas,
            "idsEmpresas" => $idsEmpresas
        );

        header('Content-Type: application/json');
        echo json_encode($data);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Error con la base de datos: " . $e->getMessage()]);
    }
?>