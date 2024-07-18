<?php

    class Compra extends conectar{
        // TODO: Listar registros por sucursal id
        public function insert_compra_x_id($suc_id, $user_id){
            $conectar = parent::conexion();
            $sql = "SP_I_COMPRA_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2, $user_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
    
        public function insert_compra_detalle($compra_id, $prod_id, $prod_pcompra, $det_cant){
            $conectar = parent::conexion();
            $sql = "SP_I_COMPRA_DETALLE_01 ?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $compra_id);
            $sql_query->bindValue(2, $prod_id);
            $sql_query->bindValue(3, $prod_pcompra);
            $sql_query->bindValue(4, $det_cant);
            $sql_query->execute();
            // return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
        public function get_compra_detalle($compra_id){
            $conectar = parent::conexion();
            $sql = "SP_L_COMPRA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $compra_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
        public function delete_detalle_compra($det_id){
            $conectar = parent::conexion();
            $sql = "SP_D_COMPRA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $det_id);
            $sql_query->execute();
        }
        public function get_compra_calculo($compra_id){
            $conectar = parent::conexion();
            $sql = "SP_U_COMPRA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $compra_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     

        }
        public function update_compra(
            $compra_id,
            $pago_id,
            $prov_id,
            $prov_rut, 
            $prov_dirc,
            $prov_email,
            $mon_id,
            $prov_number, 
            $prov_coment,
            $doc_id
        ){
            $conectar = parent::conexion();
            $sql = "SP_U_COMPRA_03 ?,?,?,?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $compra_id);
            $sql_query->bindValue(2, $pago_id);
            $sql_query->bindValue(3, $prov_id);
            $sql_query->bindValue(4, $prov_rut);
            $sql_query->bindValue(5, $prov_dirc);
            $sql_query->bindValue(6, $prov_email);
            $sql_query->bindValue(7, $mon_id);
            $sql_query->bindValue(8, $prov_number);
            $sql_query->bindValue(9, $prov_coment);
            $sql_query->bindValue(10, $doc_id);
            $sql_query->execute();
        }
        public function get_compra_pdf($compra_id){
            $conectar = parent::conexion();
            $sql = "SP_l_COMPRA_PDF_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $compra_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     

        }
        public function get_list_compra($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_COMPRA_04 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC); 
        
        }
        public function update_stock_compra($compra_id){
            $conectar = parent::conexion();
            $sql = "SP_U_STOCK_COMPRA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $compra_id);
            $sql_query->execute();
        }
        public function get_compra_top_productos($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_TOP_PRODUCTOS_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     

        }
}

?>