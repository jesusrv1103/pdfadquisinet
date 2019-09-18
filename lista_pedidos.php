<?php
ob_start();
	// Ejemplo de conexión a base de datos MySQL con PHP.
	//
	// Ejemplo realizado por Oscar Abad Folgueira: http://www.oscarabadfolgueira.com y https://www.dinapyme.com
	
	// Datos de la base de datos
	$usuario = "root";
	$password = "9956";
	$servidor = "localhost";
    $basededatos = "adquisinetdb";
    $conexion = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos");
    // Selección del a base de datos a utilizar
    $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
    // establecer y realizar consulta. guardamos en variable.
    $consulta = "SELECT 
    Pedidos.id as pedido,
    Dependencias.nombre AS dependencia,
    Proveedores.razonSocial,
    Proveedores.rfc,
    Pedidos.fecha,
    MAX(DetallesCotizaciones.diasEntrega) AS tiempoDeEntrega
    FROM Pedidos
    INNER JOIN DetallesPedidos AS detalles ON detalles.idPedido = Pedidos.id
    INNER JOIN Asignaciones AS asignacion ON asignacion.id = detalles.idAsignacion
    INNER JOIN DetallesCotizaciones ON DetallesCotizaciones.id = asignacion.idDetalleCotizacion
    INNER JOIN Proveedores ON Proveedores.id = Pedidos.idProveedor
    INNER JOIN Dependencias ON Dependencias.id = Pedidos.idDependencia
    WHERE Pedidos.id = 54";
    $datos_Fiscales = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de pedidos</title>
    <style>
        table{
            width: 100%;
            border-collapse: collapse;
        }
        tr {
            width:100%
        }
        thead .encabezados {
            width: 33.3%;
           
            padding-top: 1px;
            padding-bottom: 1px;
         
        }
        tr:nth-child(even){background-color: #f2f2f2}
      
      
    </style>

   
</head>
<body>
    

     <center><img src="pedido2016.jpg" alt=""></center>
           
    <center><h3>DIRECCIÓN DE ADQUISICIONES <br>PEDIDO A CASA COMERCIAL</h3></center>
 
<table>
        <tr >
            <td class="encabezados"></td>
            <td class="encabezados" ></td>
            <td class="encabezados" style="text-align: right;">Pedido</td>
        </tr>
        <?php
       
      
                
       ?>
        <tr>
            <td class="encabezados">
               <h5>DEPENDENCIA</h5>
            </td>
            <td class="encabezados">
                Fiscalia General de Justicia del Estado de Zacatecas
            </td>
            <td class="encabezados" style="text-align: right;">98</td>
        </tr>
        <tr>
                <td class="encabezados">
                   <h5>RAZÓN SOCIAL</h5>
                </td>
                <td class="encabezados">
                        <?php
                      
                        foreach($datos_Fiscales as $dato )
                        { 
                          echo $dato['razonSocial']; 

                       }
                    ?>
                </td>
                <td class="encabezados" style="text-align: center;">
                    ADQUISINET
                </td>
        </tr>
        <tr>
                <td class="encabezados">
                   <h5>RFC</h5>
                </td>
                <td class="encabezados">
                        <?php
                        foreach($datos_Fiscales as $dato )
                        { 
                          echo $dato['rfc']; 

                       }
                    ?>
                </td>
                <td class="encabezados" style="text-align: center;">
                  
                </td>
        </tr>
        <tr>
            <td class="encabezados">
                <h5>EMISIÓN DE PEDIDO</h5>
            </td>
            <td class="encabezados">
                    <?php
                  
                    foreach($datos_Fiscales as $dato )
                    { 
                      
                      $fecha = new DateTime($dato['fecha']);
                      echo  $fecha_d_m_y = $fecha->format('d/m/Y');
                   }   
                ?>
            </td>
            <td class="encabezados" style="text-align: center;">
                COMPRAS VIA ELECTRONICA
            </td>
        </tr>
        <tr>
            <td class="encabezados">
                <h5>TIEMPO DE ENTREGA</h5>
            </td>
            <td class="encabezados">
                    <?php
                    foreach($datos_Fiscales as $dato )
                    { 
                      
                     echo $dato['tiempoDeEntrega'];
                   }   ?>  
            </td>
            <td class="encabezados" style="text-align: center;">
                
            </td>
            </tr>
       
    </table>

    <table>
        <thead>
            <tr>
                <td class="descripcion">
                    Fuente Finan.
                </td>
                <td class="descripcion">
                    Proc
                </td>
                <td class="descripcion">
                    Unid 
                    Adm
                </td>
                <td class="descripcion">
                    PART
                </td>
                <td class="descripcion">
                    Tipo Gast
                </td>
                <td class="descripcion">
                    REQ
                </td>
                <td class="descripcion">
                    D.P
                </td>
                <td class="descripcion">
                    CANT
                </td>
                <td style="width=15%;">
                    DESCRIPCION
                </td>
                <td style="width=10%;">
                    PRESENTACION 
                </td>
                <td style="width=10%"> 
                    P.U
                </td>
                <td style="width=10%">
                    IMPORTE
                </td>
        </tr>
        </thead>
        <tbody>
          
            
    
           
            <tr>
                <td class="descripcion">
                    
                </td>
                <td class="descripcion">
                           
                </td>
                <td class="descripcion">
                          
                </td>
                <td class="descripcion">
                 
                </td>
                <td class="descripcion">
                           
                </td>
                 <td class="descripcion">
                           
                 </td>
                 <td class="descripcion">
                          
                 </td>
                <td class="descripcion">
                            
                </td>
                <td style="width=15%;">
                            
                </td>
                <td style="width=10%;">
                           
                </td>
                 <td style="width=10%"> 
                           
                </td>
                <td style="width=10%">
                            
                 </td>
                </tr>
          
        <tbody>

    </table>

</body>
</html>

<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new DOMPDF();
$dompdf->load_html(ob_get_clean( 'dise_reporte_pedidos.php' ));
$dompdf->render();
$dompdf->output();
$filename="ListaPedidos.php"
$dompdf->stream($filename);

//return $pdf->download('invoice.pdf');

?>