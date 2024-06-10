<?php

    class Producto extends conectar{
        // TODO: Listar registros por sucursal id
        public function get_producto_sucursal_id($suc_id){
            $conectar = parent::conexion();
            $sql = "SP_L_PRODUCTO_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);     
        }
        // TODO: Listar registros por id 
        public function get_producto_id($prod_id){
            $conectar = parent::conexion();
            $sql = "SP_L_PRODUCTO_02 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $prod_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
            
        }
        public function get_producto_cat_id($cat_id){
            $conectar = parent::conexion();
            $sql = "SP_L_PRODUCTO_03 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $cat_id);
            $sql_query->execute();
            return $sql_query->fetchAll(PDO::FETCH_ASSOC);
            
        }
        // TODO: Eliminar registros
        public function delete_producto($prod_id){
            $conectar = parent::conexion();
            $sql = "SP_D_PRODUCTO_01 ?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $prod_id);
            $sql_query->execute();
            
            
        }
        // TODO: Insertar registros  
        public function insert_producto($suc_id, $cat_id, $prod_name, 
                                            $prod_description,$unid_id,$mon_id,
                                            $prod_pcompra,$prod_pventa, $prod_stock,
                                            $prod_fecha_en,$prod_img){
            $conectar = parent::conexion();
            $sql = "SP_I_PRODUCTO_01 ?,?,?,?,?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $suc_id);
            $sql_query->bindValue(2, $cat_id);
            $sql_query->bindValue(3, $prod_name);
            $sql_query->bindValue(4, $prod_description);
            $sql_query->bindValue(5, $unid_id);
            $sql_query->bindValue(6, $mon_id);
            $sql_query->bindValue(7, $prod_pcompra);
            $sql_query->bindValue(8, $prod_pventa);
            $sql_query->bindValue(9, $prod_stock);
            $sql_query->bindValue(10, $prod_fecha_en);
            $sql_query->bindValue(11, $prod_img);
            $sql_query->execute();
            
            
        }
        // TODO: Actualizar registros  
        public function update_producto($prod_id, $suc_id, $cat_id, $prod_name, 
                                            $prod_description,$unid_id,$mon_id,
                                            $prod_pcompra,$prod_pventa, 
                                            $prod_stock, $prod_fecha_en,$prod_img){
            $conectar = parent::conexion();
            $sql = "SP_U_PRODUCTO_01 ?,?,?,?,?,?,?,?,?,?,?,?";
            $sql_query=$conectar->prepare($sql);
            $sql_query->bindValue(1, $prod_id);
            $sql_query->bindValue(2, $suc_id);
            $sql_query->bindValue(3, $cat_id);
            $sql_query->bindValue(4, $prod_name);
            $sql_query->bindValue(5, $prod_description);
            $sql_query->bindValue(6, $unid_id);
            $sql_query->bindValue(7, $mon_id);
            $sql_query->bindValue(8, $prod_pcompra);
            $sql_query->bindValue(9, $prod_pventa);
            $sql_query->bindValue(10, $prod_stock);
            $sql_query->bindValue(11, $prod_fecha_en);
            $sql_query->bindValue(12, $prod_img);
            $sql_query->execute();

            
            
        }

    }

?>