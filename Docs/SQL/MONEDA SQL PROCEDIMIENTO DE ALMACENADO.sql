
--Listar todos los registros por Sucursal
CREATE PROCEDURE SP_L_CATEGORIA_01  
@SUC_ID INT  
AS  
BEGIN  
 SELECT  
  CAT_ID,  
  SUC_ID,  
  CAT_NAME,  
  CONVERT(VARCHAR, CREATED_AT, 103) AS CREATED_AT,  
  ACTIVE  
 FROM   
  TM_CATEGORIA  
 WHERE SUC_ID = @SUC_ID  
 AND ACTIVE = 1  
  
  
  
END

--Obtener registro por ID
CREATE PROCEDURE SP_L_MONEDA_02
@MON_ID INT
AS
BEGIN
	SELECT * FROM TM_MONEDA
	WHERE
	MON_ID = @MON_ID
END

--Eliminar Registro
CREATE PROCEDURE SP_D_MONEDA_01
@MON_ID INT
AS
BEGIN
	UPDATE TM_MONEDA
	SET
		ACTIVE = 0
	WHERE
		MON_ID = @MON_ID
END

--REGISTRAR NUEVO REGISTRO
CREATE PROCEDURE SP_I_MONEDA_01
@SUC_ID INT,
@MON_NAME VARCHAR(150)
AS
BEGIN
	INSERT INTO TM_MONEDA
	(SUC_ID,MON_NAME,CREATED_AT,ACTIVE)
	VALUES
	(@SUC_ID,@MON_NAME,GETDATE(),1)
END

--ACTUALIZAR REGISTRO
CREATE PROCEDURE SP_U_MONEDA_01
@MON_ID INT,
@SUC_ID INT,
@MON_NAME VARCHAR(150)
AS
BEGIN
	UPDATE TM_MONEDA
	SET
		SUC_ID = @SUC_ID,
		MON_NAME = @MON_NAME
	WHERE
		MON_ID = @MON_ID
END