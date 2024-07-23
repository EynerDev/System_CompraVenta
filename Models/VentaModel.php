<?php

    class Venta extends conectar{
        public function insert_venta_x_id($suc_id, $user_id){
            $conectar = parent::conexion();
            $sql = "SP_I_VENTA_01 ?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2, $user_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
    
        public function insert_venta_detalle($venta_id, $prod_id, $prod_pventa,
                                                             $det_vent_cant){
            $conectar = parent::conexion();
            $sql = "SP_I_VENTA_DETALLE_02 ?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $venta_id);
            $sql_query->bindValue(2, $prod_id);
            $sql_query->bindValue(3, $prod_pventa);
            $sql_query->bindValue(4, $det_vent_cant); 
            $sql_query->execute(); 
        }
        public function get_venta_detalle($venta_id){
            $conectar = parent::conexion();
            $sql = "SP_L_VENTA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $venta_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
        public function delete_detalle_venta($det_venta_id){
            $conectar = parent::conexion();
            $sql = "SP_D_VENTA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $det_venta_id);
            $sql_query->execute();
        }
        public function get_venta_calculo($venta_id){
            $conectar = parent::conexion();
            $sql = "SP_U_VENTA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $venta_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     

        }
        public function update_venta(
            $venta_id,
            $pago_id,
            $cli_id,
            $cli_tipo_doc_id,
            $cli_doc, 
            $cli_direcc,
            $cli_email,
            $cli_number,
            $mon_id, 
            $venta_coment,
            $doc_id
        ){
            $conectar = parent::conexion();
            $sql = "SP_U_VENTA_03 ?,?,?,?,?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $venta_id);
            $sql_query->bindValue(2, $pago_id);
            $sql_query->bindValue(3, $cli_id);
            $sql_query->bindValue(4, $cli_tipo_doc_id);
            $sql_query->bindValue(5, $cli_doc);
            $sql_query->bindValue(6, $cli_direcc);
            $sql_query->bindValue(7, $cli_email);
            $sql_query->bindValue(8, $cli_number);
            $sql_query->bindValue(9, $mon_id);
            $sql_query->bindValue(10,$venta_coment);
            $sql_query->bindValue(11,$doc_id);
            $sql_query->execute();
        }
        public function get_venta_pdf($venta_id){
            $conectar = parent::conexion();
            $sql = "SP_L_VENTA_PDF_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $venta_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     

        }
        public function get_list_venta($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_VENTA_04 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC); 
        
        }
        public function get_stock_actual($prod_id) {
            $conectar = parent::conexion();
            $sql = "SP_GET_STOCK_ACTUAL ?";
            $sql_query = $conectar->prepare($sql);
            $sql_query->bindValue(1, $prod_id, PDO::PARAM_INT);
            $sql_query->execute();
            $result = $sql_query->fetch(PDO::FETCH_ASSOC);
        
            // Asegúrate de que el valor devuelto sea un entero
            if ($result && isset($result['PROD_STOCK'])) {
                return (int)$result['PROD_STOCK']; // Convierte el valor a entero
            } else {
                return 0; // Devuelve 0 si no hay resultados o el stock no está definido
            }
        }
        
        
        public function update_stock_venta($venta_id){
            $conectar = parent::conexion();
            $sql = "SP_U_STOCK_VENTA_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $venta_id);
            $sql_query->execute();
        }
        public function get_venta_top_productos($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_TOP_PRODUCTOS_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     

        }
        public function get_venta_grafico_barra($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_CONSUMO_VENTAS_DIARIAS ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     

        }
        public function delete_venta($venta_id){
            $conectar = parent::conexion();
            $sql = "SP_D_VENTA_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $venta_id);
            $sql_query->execute();
        
        }
}

?>