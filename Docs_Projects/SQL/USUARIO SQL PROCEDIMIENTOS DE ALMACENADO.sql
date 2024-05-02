-- LISTAR REGISTROS POR SUCURSAL --
CREATE PROCEDURE SP_L_USUARIO_01
@SUC_ID INT
AS
BEGIN

	SELECT * FROM TM_USUARIO
	WHERE SUC_ID = @SUC_ID
END


-- OBETENER REGISTROS POR ID --
CREATE PROCEDURE SP_L_USUARIO_02
 @USER_ID INT
AS
BEGIN

	SELECT * FROM TM_USUARIO
	WHERE 
	USER_ID = @USER_ID 
	AND ACTIVE = 1
END

-- CAMBIAR ESTADO DEL USUARIO (DELETE)--
CREATE PROCEDURE SP_D_USUARIO_01
@USER_ID INT
AS
BEGIN

	UPDATE TM_USUARIO
	SET
		ACTIVE = 0
	WHERE 
		USER_ID = @USER_ID
	
END
-- INSERTAR REGISTROS --
CREATE PROCEDURE SP_I_USUARIO_01
@SUC_ID INT,
@USER_EMAIL VARCHAR(150),
@USER_NAME VARCHAR(50),
@USER_ROLE_ID INT,
@USER_APE VARCHAR (150),
@USER_TYPEDOC INT,
@USER_DOCUMENT VARCHAR(50),
@USER_NUMBER VARCHAR(50),
@USER_PASSWORD VARCHAR(500)

AS
BEGIN

	INSERT INTO TM_USUARIO
		(SUC_ID,USER_EMAIL, USER_NAME, USER_ROLE_ID, USER_APE, USER_TYPEDOC, USER_DOCUMENT, USER_NUMBER, USER_PASSWORD, CREATED_AT, ACTIVE)
	VALUES
		(@SUC_ID,@USER_EMAIL, @USER_NAME, @USER_ROLE_ID, @USER_APE, @USER_TYPEDOC, @USER_DOCUMENT, @USER_NUMBER, @USER_PASSWORD, GETDATE(), 1)
	
END

-- ACTUALIZAR REGISTROS --
CREATE PROCEDURE SP_U_USUARIO_01
@USER_ID INT,
@SUC_ID INT,
@USER_EMAIL VARCHAR(150),
@USER_NAME VARCHAR(50),
@USER_ROLE_ID INT,
@USER_APE VARCHAR (150),
@USER_TYPEDOC INT,
@USER_DOCUMENT VARCHAR(50),
@USER_NUMBER VARCHAR(50),
@USER_PASSWORD VARCHAR(500)

AS
BEGIN

	UPDATE TM_USUARIO
	SET
		SUC_ID = @SUC_ID,
		USER_EMAIL = @USER_EMAIL,
		USER_NAME = @USER_NAME,
		USER_ROLE_ID = @USER_ROLE_ID,
		USER_APE = @USER_APE,
		USER_TYPEDOC = @USER_TYPEDOC,
		USER_DOCUMENT = @USER_DOCUMENT,
		USER_NUMBER = @USER_NUMBER,
		USER_PASSWORD = @USER_PASSWORD
	WHERE 
		USER_ID = @USER_ID
	
END

--ACCESO--
CREATE PROCEDURE SP_A_USUARIO_01
@USER_EMAIL VARCHAR(150),
@USER_PASSWORD VARCHAR(150)
AS
BEGIN
	SELECT * FROM TM_USUARIO
	WHERE
	USER_EMAIL = @USER_EMAIL
	AND USER_PASSWORD = @USER_PASSWORD
	AND ACTIVE = 1
END

--CAMBIO DE CONTRASEÑA--
CREATE PROCEDURE SP_U_USUARIO_02
@USER_ID VARCHAR(150),
@USER_PASSWORD VARCHAR(150)
AS
BEGIN
	UPDATE TM_USUARIO
	SET
	USER_PASSWORD = @USER_PASSWORD
	WHERE 
	USER_ID = @USER_ID
END