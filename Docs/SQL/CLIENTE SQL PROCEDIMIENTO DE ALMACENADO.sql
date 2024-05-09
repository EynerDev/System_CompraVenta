-- LISTAR REGISTROS POR EMPRESA --
CREATE PROCEDURE SP_L_CLIENTE_01
@EMP_ID INT
AS
BEGIN

	SELECT * FROM TM_CLIENTE
	WHERE EMP_ID = @EMP_ID
END


-- OBETENER REGISTROS POR ID --
CREATE PROCEDURE SP_L_CLIENTE_02
 @CLI_ID INT
AS
BEGIN

	SELECT * FROM TM_CLIENTE
	WHERE 
	CLI_ID = @CLI_ID 
	AND ACTIVE = 1
END

-- CAMBIAR ESTADO DE LA  UNIDAD DE MEDIDA (DELETE)--
CREATE PROCEDURE SP_D_CLIENTE_01
@CLI_ID INT
AS
BEGIN

	UPDATE TM_CLIENTE
	SET
		ACTIVE = 0
	WHERE 
		CLI_ID = @CLI_ID
	
END
-- INSERTAR REGISTROS --
CREATE PROCEDURE SP_I_CLIENTE_01
@EMP_ID INT,
@TIPO_DOC_ID INT,
@CLI_DOC VARCHAR(250),
@CLI_NAME VARCHAR(150),
@CLI_NUMBER INT,
@CLI_DIRECC INT,
@CLI_EMAIL NUMERIC(18,2)
AS
BEGIN

	INSERT INTO TM_CLIENTE
		(EMP_ID, TIPO_DOC_ID,CLI_DOC,CLI_NAME,CLI_NUMBER, CLI_DIRECC, CLI_EMAIL, CREATED_AT, ACTIVE)
	VALUES
		(@EMP_ID, @TIPO_DOC_ID, @CLI_DOC,@CLI_NAME, @CLI_NUMBER, @CLI_DIRECC, @CLI_EMAIL, GETDATE(), 1)
	
END

-- ACTUALIZAR REGISTROS --
CREATE PROCEDURE SP_U_CLIENTE_01
@CLI_ID INT,
@EMP_ID INT,
@TIPO_DOC_ID INT,
@CLI_DOC VARCHAR(250),
@CLI_NAME VARCHAR(150),
@CLI_NUMBER INT,
@CLI_DIRECC INT,
@CLI_EMAIL NUMERIC(18,2)
AS
BEGIN

	UPDATE TM_CLIENTE
	SET
		EMP_ID = @EMP_ID,
		CLI_NAME = @CLI_NAME,
		TIPO_DOC_ID = @TIPO_DOC_ID,
		CLI_DOC = @CLI_DOC,
		CLI_NUMBER = @CLI_NUMBER,
		CLI_DIRECC = @CLI_DIRECC,
		CLI_EMAIL = @CLI_EMAIL
	WHERE 
		CLI_ID = @CLI_ID
	
END