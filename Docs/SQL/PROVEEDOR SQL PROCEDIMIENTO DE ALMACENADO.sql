-- LISTAR REGISTROS POR EMPRESA --
CREATE PROCEDURE SP_L_PROVEEDOR_01
@EMP_ID INT
AS
BEGIN

	SELECT * FROM TM_PROVEEDOR
	WHERE EMP_ID = @EMP_ID
END


-- OBETENER REGISTROS POR ID --
CREATE PROCEDURE SP_L_PROVEEDOR_02
 @PROV_ID INT
AS
BEGIN

	SELECT * FROM TM_PROVEEDOR
	WHERE 
	PROV_ID = @PROV_ID 
	AND ACTIVE = 1
END

-- CAMBIAR ESTADO DE LA  UNIDAD DE MEDIDA (DELETE)--
CREATE PROCEDURE SP_D_PROVEEDOR_01
@PROV_ID INT
AS
BEGIN

	UPDATE TM_PROVEEDOR
	SET
		ACTIVE = 0
	WHERE 
		PROV_ID = @PROV_ID
	
END
-- INSERTAR REGISTROS --
CREATE PROCEDURE SP_I_PROVEEDOR_01
@EMP_ID INT,
@PROV_NAME VARCHAR(150),
@PROV_RUT VARCHAR(250),
@PROV_NUMBER INT,
@PROV_DIRC INT,
@PROV_EMAIL NUMERIC(18,2)
AS
BEGIN

	INSERT INTO TM_PROVEEDOR
		(EMP_ID, PROV_NAME,PROV_RUT,PROV_NUMBER, PROV_DIRC, PROV_EMAIL, CREATED_AT, ACTIVE)
	VALUES
		(@EMP_ID, @PROV_NAME, @PROV_RUT, @PROV_NUMBER, @PROV_DIRC, @PROV_EMAIL, GETDATE(), 1)
	
END

-- ACTUALIZAR REGISTROS --
CREATE PROCEDURE SP_U_PROVEEDOR_01
@PROV_ID INT,
@EMP_ID INT,
@PROV_NAME VARCHAR(150),
@PROV_RUT VARCHAR(250),
@PROV_NUMBER INT,
@PROV_DIRC INT,
@PROV_EMAIL NUMERIC(18,2)
AS
BEGIN

	UPDATE TM_PROVEEDOR
	SET
		EMP_ID = @EMP_ID,
		PROV_NAME = @PROV_NAME,
		PROV_RUT = @PROV_RUT,
		PROV_NUMBER = @PROV_NUMBER,
		PROV_DIRC = @PROV_DIRC,
		PROV_EMAIL = @PROV_EMAIL
	WHERE 
		PROV_ID = @PROV_ID
	
END