CREATE ALTER PROCEDURE SP_L_VENTA_01      
@VENTA_ID INT      
AS      
BEGIN      
  SELECT       
    TD_VENTA_DETALLE.DET_VENTA_ID,       
    TD_VENTA_DETALLE.VENTA_ID,       
    TD_VENTA_DETALLE.PROD_ID,            
    TD_VENTA_DETALLE.DET_VENTA_CANT,       
    FORMAT(TD_VENTA_DETALLE.DET_TOTAL, 'N2') AS TOTAL,       
    FORMAT(TD_VENTA_DETALLE.DET_VENTA_CANT, 'N2') AS PRECIO_PRODUCTO,       
    TM_PRODUCTO.PROD_NAME,   
    TM_PRODUCTO.PROD_IMG,  
    TM_CATEGORIA.CAT_NAME,       
    TM_UNIDAD_DE_MEDIDA.UNID_NAME      
  FROM     TD_VENTA_DETALLE INNER JOIN      
       TM_PRODUCTO ON TD_VENTA_DETALLE.PROD_ID = TM_PRODUCTO.PROD_ID INNER JOIN      
       TM_CATEGORIA ON TM_PRODUCTO.CAT_ID = TM_CATEGORIA.CAT_ID INNER JOIN      
       TM_UNIDAD_DE_MEDIDA ON TM_PRODUCTO.UNID_ID = TM_UNIDAD_DE_MEDIDA.UNI_ID      
      
  WHERE       
    TD_VENTA_DETALLE.VENTA_ID = @VENTA_ID      
    AND TD_VENTA_DETALLE.ACTIVE = 1      
END

CREATE PROCEDURE SP_U_VENTA_01         
@VENTA_ID INT        
AS        
BEGIN        
SET NOCOUNT ON      
    UPDATE TM_VENTA        
    SET         
    VENTA_SUB_TOTAL = (SELECT SUM(DET_TOTAL)     
                        FROM TD_VENTA_DETALLE     
                        WHERE VENTA_ID = @VENTA_ID AND ACTIVE = 1),    
    VENTA_IVA = (SELECT SUM(DET_TOTAL)     
                  FROM TD_VENTA_DETALLE     
                  WHERE VENTA_ID = @VENTA_ID AND ACTIVE = 1) * 0.19,    
    VENTA_TOTAL = (SELECT SUM(DET_TOTAL)     
                    FROM TD_VENTA_DETALLE     
                    WHERE VENTA_ID = @VENTA_ID AND ACTIVE = 1) * 1.19          
    WHERE         
    VENTA_ID = @VENTA_ID       
        
  SELECT       
      FORMAT(VENTA_SUB_TOTAL, 'N2') AS SUB_TOTAL,     
      FORMAT(VENTA_IVA,'N2') AS IVA,    
      FORMAT(VENTA_TOTAL, 'N2') AS TOTAL       
  FROM      
      TM_VENTA      
  WHERE       
    VENTA_ID = @VENTA_ID      
        
SET NOCOUNT OFF      
        
END 

CREATE PROCEDURE SP_L_VENTA_04   
  @SUC_ID INT
AS    
BEGIN    
  SELECT     
    TM_VENTA.*,     
    TM_TIPO_DOCUMENTO.DESCRIPTION,  
    TM_SUCURSAL.SUC_NAME,     
    TM_EMPRESA.EMP_EMAIL,     
    TM_EMPRESA.EMP_WEBSITE,     
    TM_EMPRESA.EMP_TEL,     
    TM_EMPRESA.EMP_DIRC,    
    TM_EMPRESA.EMP_NAME,     
    TM_EMPRESA.EMP_RUT,     
    TM_COMPANIA.COM_NAME,     
    TM_USUARIO.USER_NUMBER,     
    TM_USUARIO.USER_DOCUMENT,     
    TM_USUARIO.USER_TYPEDOC,     
    TM_USUARIO.USER_APE,     
    TM_USUARIO.USER_ROLE_ID,     
    TM_USUARIO.USER_NAME,     
    TM_USUARIO.USER_EMAIL,     
    TM_ROL.ROLE_NAME,     
    TM_MONEDA.MON_NAME,     
    TM_PAGO.PAGO_NAME,    
    TM_CLIENTE.CLI_NAME,
    FORMAT(TM_VENTA.VENTA_TOTAL,'N2') AS TOTAL,
    FORMAT(TM_VENTA.VENTA_SUB_TOTAL, 'N2') AS SUB_TOTAL,
    FORMAT(TM_VENTA.VENTA_IVA, 'N2') AS IVA,
    FORMAT(TM_VENTA.CREATED_AT, 'yyyy-MM-dd') + ' / ' + FORMAT(TM_VENTA.CREATED_AT, 'HH:mm') AS FECHA_VENTA,
    TM_DOCUMENTO.DOC_NAME
  FROM  TM_VENTA INNER JOIN    
                      TM_TIPO_DOCUMENTO ON TM_VENTA.CLI_TIPO_DOC_ID = TM_TIPO_DOCUMENTO.TIPO_DOC_ID INNER JOIN  
                      TM_SUCURSAL ON TM_VENTA.SUC_ID = TM_SUCURSAL.SUC_ID INNER JOIN    
                      TM_EMPRESA ON TM_SUCURSAL.EMP_ID = TM_EMPRESA.EMP_ID INNER JOIN    
                      TM_COMPANIA ON TM_EMPRESA.COM_ID = TM_COMPANIA.COM_ID INNER JOIN    
                      TM_USUARIO ON TM_VENTA.USER_ID = TM_USUARIO.USER_ID INNER JOIN    
                      TM_ROL ON TM_USUARIO.USER_ROLE_ID = TM_ROL.ROLE_ID INNER JOIN    
                      TM_MONEDA ON TM_VENTA.MON_ID = TM_MONEDA.MON_ID INNER JOIN    
                      TM_PAGO ON TM_VENTA.PAGO_ID = TM_PAGO.PAGO_ID INNER JOIN    
                      TM_CLIENTE ON TM_VENTA.CLI_ID = TM_CLIENTE.CLI_ID    INNER JOIN
                      TM_DOCUMENTO ON TM_VENTA.DOC_ID = TM_DOCUMENTO.DOC_ID
  WHERE       
        TM_VENTA.ACTIVE= 1 AND
        TM_VENTA.SUC_ID = @SUC_ID 
END

CREATE SP_L_VENTA_PDF_01  
  @VENTA_ID INT    
AS    
BEGIN    
    SELECT   
      TM_VENTA.VENTA_ID,   
      TM_VENTA.SUC_ID,   
      TM_VENTA.PAGO_ID,   
      TM_VENTA.CLI_ID,   
      TM_VENTA.CLI_DOC,   
      TM_VENTA.CLI_DIRECC,   
      TM_VENTA.CLI_EMAIL,   
      TM_VENTA.MON_ID,   
      TM_VENTA.CLI_NUMBER,   
      FORMAT(TM_VENTA.VENTA_SUB_TOTAL, 'N2') AS SUB_TOTAL,
      FORMAT(TM_VENTA.VENTA_IVA, 'N2') AS IVA,
      FORMAT(TM_VENTA.VENTA_TOTAL, 'N2') AS TOTAL,
      TM_VENTA.VENTA_COMENT,   
      TM_VENTA.USER_ID,   
      FORMAT(TM_VENTA.CREATED_AT, 'yyyy-MM-dd') + ' / ' + FORMAT(TM_VENTA.CREATED_AT, 'HH:mm') AS FECHA_VENTA,   
      TM_VENTA.ACTIVE,   
      TM_SUCURSAL.SUC_NAME,   
      TM_EMPRESA.EMP_EMAIL,   
      TM_EMPRESA.EMP_WEBSITE,   
      TM_EMPRESA.EMP_TEL,   
      TM_EMPRESA.EMP_DIRC,  
      TM_EMPRESA.EMP_NAME,   
      TM_EMPRESA.EMP_RUT,   
      TM_COMPANIA.COM_NAME,   
      TM_USUARIO.USER_NUMBER,   
      TM_USUARIO.USER_DOCUMENT,   
      TM_USUARIO.USER_TYPEDOC,   
      TM_USUARIO.USER_APE,   
      TM_USUARIO.USER_ROLE_ID,   
      TM_USUARIO.USER_NAME,   
      TM_USUARIO.USER_EMAIL,   
      TM_ROL.ROLE_NAME,   
      TM_MONEDA.MON_NAME,   
      TM_PAGO.PAGO_NAME,  
      TM_CLIENTE.CLI_NAME  
    FROM     TM_VENTA INNER JOIN  
                      TM_SUCURSAL ON TM_VENTA.SUC_ID = TM_SUCURSAL.SUC_ID INNER JOIN  
                      TM_EMPRESA ON TM_SUCURSAL.EMP_ID = TM_EMPRESA.EMP_ID INNER JOIN  
                      TM_COMPANIA ON TM_EMPRESA.COM_ID = TM_COMPANIA.COM_ID INNER JOIN  
                      TM_USUARIO ON TM_VENTA.USER_ID = TM_USUARIO.USER_ID INNER JOIN  
                      TM_ROL ON TM_USUARIO.USER_ROLE_ID = TM_ROL.ROLE_ID INNER JOIN  
                      TM_MONEDA ON TM_VENTA.MON_ID = TM_MONEDA.MON_ID INNER JOIN  
                      TM_PAGO ON TM_VENTA.PAGO_ID = TM_PAGO.PAGO_ID INNER JOIN  
                      TM_CLIENTE ON TM_VENTA.CLI_ID = TM_CLIENTE.CLI_ID  
      WHERE     
                      VENTA_ID = @VENTA_ID  
END