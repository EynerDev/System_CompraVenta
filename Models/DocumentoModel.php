<?php

    class Documento extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_documento($doc_tipo){
            $conectar = parent::conexion();
            $sql = "SP_L_DOCUMENTO_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindParam(1,$doc_tipo);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
    }

?>