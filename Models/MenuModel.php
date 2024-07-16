<?php

    class Menu extends conectar{
        // TODO: Listar registros por compañia id
        public function get_menu_role_id($role_id) {
            $conectar = parent::conexion();
            $sql = "SP_LISTAR_MENU_01 ?";
            $sql_query = $conectar->prepare($sql);
            $sql_query->bindValue(1, $role_id, PDO::PARAM_INT);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function update_menu_habilitar($mend_id) {
            $conectar = parent::conexion();
            $sql = "SP_U_MENU_01 ?";
            $sql_query = $conectar->prepare($sql);
            $sql_query->bindValue(1, $mend_id, PDO::PARAM_INT);
            $sql_query->execute();
        }
        public function update_menu_inhabilitar($mend_id) {
            $conectar = parent::conexion();
            $sql = "SP_U_MENU_02 ?";
            $sql_query = $conectar->prepare($sql);
            $sql_query->bindValue(1, $mend_id, PDO::PARAM_INT);
            $sql_query->execute();
        }

        
    }

?>