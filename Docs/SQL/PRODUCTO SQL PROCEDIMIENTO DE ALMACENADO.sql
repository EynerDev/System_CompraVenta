-- LISTAR REGISTROS POR SUCURSAL --
CREATE PROCEDURE SP_L_PRODUCTO_01
@SUC_ID INT
AS
BEGIN

	SELECT * FROM TM_PRODUCTO
	WHERE SUC_ID = @SUC_ID
END


-- OBETENER REGISTROS POR ID --
CREATE PROCEDURE SP_L_PRODUCTO_02
@PROD_ID INT    
AS    
BEGIN    
  SELECT   
   TM_PRODUCTO.*,  
   TM_CATEGORIA.CAT_NAME,    
   TM_UNIDAD_DE_MEDIDA.UNID_NAME,  
   TM_MONEDA.MON_NAME
   FROM   
		TM_PRODUCTO   
		INNER JOIN      
		TM_CATEGORIA ON TM_PRODUCTO.CAT_ID = TM_CATEGORIA.CAT_ID  
		INNER JOIN      
		TM_UNIDAD_DE_MEDIDA ON TM_PRODUCTO.UNID_ID = TM_UNIDAD_DE_MEDIDA.UNI_ID   
		INNER JOIN      
		TM_MONEDA ON TM_PRODUCTO.MON_ID = TM_MONEDA.MON_ID  
  WHERE TM_PRODUCTO.PROD_ID = @PROD_ID  
  AND TM_PRODUCTO.ACTIVE = 1  
END    

-- CAMBIAR ESTADO DE LA  UNIDAD DE MEDIDA (DELETE)--
CREATE PROCEDURE SP_D_PRODUCTO_01
@PROD_ID INT
AS
BEGIN

	UPDATE TM_PRODUCTO
	SET
		ACTIVE = 0
	WHERE 
		PROD_ID = @PROD_ID
	
END
-- INSERTAR REGISTROS --
CREATE PROCEDURE SP_I_PRODUCTO_01
@SUC_ID INT,
@CAT_ID INT,
@PROD_NAME VARCHAR(150),
@PROD_DESCRIPTION VARCHAR(250),
@UNID_ID INT,
@MON_ID INT,
@PROD_PCOMPRA NUMERIC(18,2),
@PROD_PVENTA NUMERIC (18, 2),
@PROD_STOCK INT,
@PROD_FECHA_EN DATE,
@PROD_IMG VARCHAR(MAX)

AS
BEGIN

	INSERT INTO TM_PRODUCTO
		(SUC_ID, CAT_ID, PROD_NAME,PROD_DESCRIP, UNID_ID, MON_ID, PROD_PCOMPRA, PROD_PVENTA, PROD_STOCK, PROD_FECHA_EN, CREATED_AT, ACTIVE)
	VALUES
		(@SUC_ID, @CAT_ID, @PROD_NAME,@PROD_DESCRIPTION, @UNID_ID, @MON_ID, @PROD_PCOMPRA, @PROD_PVENTA, @PROD_STOCK, @PROD_FECHA_EN, GETDATE(), 1)
	
END

-- ACTUALIZAR REGISTROS --
CREATE PROCEDURE SP_U_PRODUCTO_01
@PROD_ID INT,
@SUC_ID INT,
@CAT_ID INT,
@PROD_NAME VARCHAR(150),
@PROD_DESCRIPTION VARCHAR(250),
@UNID_ID INT,
@MON_ID INT,
@PROD_PCOMPRA NUMERIC(18,2),
@PROD_PVENTA NUMERIC (18, 2),
@PROD_STOCK INT,
@PROD_FECHA_EN DATE,
@PROD_IMG VARCHAR(MAX)
AS
BEGIN

	UPDATE TM_PRODUCTO
	SET
		SUC_ID = @SUC_ID,
		CAT_ID = @CAT_ID,
		PROD_NAME = @PROD_NAME,
		PROD_DESCRIP = @PROD_DESCRIPTION,
		UNID_ID = @UNID_ID,
		MON_ID = @MON_ID,
		PROD_PCOMPRA = @PROD_PCOMPRA,
		PROD_PVENTA = @PROD_PVENTA,
		PROD_STOCK = @PROD_STOCK,
		PROD_FECHA_EN = @PROD_FECHA_EN,
		PROD_IMG = @PROD_IMG
	WHERE 
		PROD_ID = @PROD_ID
	
END

CREATE PROCEDURE SP_L_PRODUCTO_03
@CAT_ID INT    
AS    
BEGIN    
  SELECT   
   TM_PRODUCTO.*,  
   TM_CATEGORIA.CAT_NAME,    
   TM_UNIDAD_DE_MEDIDA.UNID_NAME,  
   TM_MONEDA.MON_NAME
   FROM   
		TM_PRODUCTO   
		INNER JOIN      
		TM_CATEGORIA ON TM_PRODUCTO.CAT_ID = TM_CATEGORIA.CAT_ID  
		INNER JOIN      
		TM_UNIDAD_DE_MEDIDA ON TM_PRODUCTO.UNID_ID = TM_UNIDAD_DE_MEDIDA.UNI_ID   
		INNER JOIN      
		TM_MONEDA ON TM_PRODUCTO.MON_ID = TM_MONEDA.MON_ID  
  WHERE TM_PRODUCTO.CAT_ID = @CAT_ID  
  AND TM_PRODUCTO.ACTIVE = 1  
END   