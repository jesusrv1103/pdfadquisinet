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


    $id=54;
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
    WHERE Pedidos.id = $id";

    $consulta2="SELECT 
	Validaciones.fuenteFinan,
	Validaciones.proceso,
	Validaciones.unidadAdmin,
	Validaciones.tipoGasto,
	Partidas.numero AS partida,
	DetallesRequisiciones.idRequisicion AS requisicion,
	DetallesPedidos.id AS detallePedido,
	DetallesRequisiciones.cantidad,
	concat(Productos.nombre,'-',Marcas.nombre) AS producto,
	Productos.presentacion,
	(DetallesCotizaciones.precio/(1 + Impuestos.decima)) AS precio,
	(DetallesPedidos.monto/(1 + Impuestos.decima)) AS importe,
	((DetallesPedidos.monto/(1 + Impuestos.decima)) * Impuestos.decima) AS iva
    FROM Pedidos
    INNER JOIN DetallesPedidos ON DetallesPedidos.idPedido = Pedidos.id
    INNER JOIN Asignaciones ON Asignaciones.id = DetallesPedidos.idAsignacion
    INNER JOIN DetallesCotizaciones ON DetallesCotizaciones.id = Asignaciones.idDetalleCotizacion
    INNER JOIN DetallesRequisiciones ON DetallesRequisiciones.id = Asignaciones.idDetalleRequisicion
    INNER JOIN Partidas ON Partidas.id = DetallesRequisiciones.idPartida
    INNER JOIN Productos ON Productos.id = DetallesRequisiciones.idProducto
    INNER JOIN Impuestos on Productos.idImpuesto = Impuestos.id 
    INNER JOIN Marcas on Productos.idMarca = Marcas.id
    INNER JOIN (
	SELECT
	DetallesRequisiciones.id,
	FuentesFinanciamientos.numero AS fuenteFinan,
	Procesos.numero AS proceso,
	TiposGastos.numero AS tipoGasto,
	UnidadesAdministrativas.numero AS unidadAdmin,
    UnidadesAdministrativas.clave AS cve_accion
	FROM DetallesRequisiciones
	INNER join UnidadesAdministrativas on DetallesRequisiciones.idUnidadAdmin = UnidadesAdministrativas.id
    INNER join FuentesFinanciamientos on UnidadesAdministrativas.idFuenteFinan = FuentesFinanciamientos.id
    INNER join Procesos on UnidadesAdministrativas.idProceso = Procesos.id
    INNER join TiposGastos on UnidadesAdministrativas.idTipoGasto = TiposGastos.id
    ) AS Validaciones ON Validaciones.id = DetallesRequisiciones.id
    WHERE Pedidos.id = $id and DetallesPedidos.estatus not in('Cancelado','Rechazado')";

 



    




    $datos_Fiscales = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
	
    $productos = mysqli_query( $conexion, $consulta2 ) or die ( "Algo ha ido mal en la consulta a la base de datos");

    



  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de pedidos</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
    

     <center><img src="pedido2016.jpg" alt=""></center>
           
    <center><h3>DIRECCIÓN DE ADQUISICIONES <br>PEDIDO A CASA COMERCIAL</h3></center>
 
<table class="table table-striped" style="font-size:12px">
        <tr >
            <td class="encabezados"></td>
            <td class="encabezados" ></td>
            <td class="encabezados" style="text-align: right;">Pedido</td>
        </tr>
        <?php
       
      
                
       ?>
        <tr >
            <td class="encabezados">
               <h5><strong>DEPENDENCIA</strong</h5>
            </td>
            <td class="encabezados">
                Fiscalia General de Justicia del Estado de Zacatecas
            </td>
            <td class="encabezados" style="text-align: right;">98</td>
        </tr>
        <tr>
                <td class="encabezados">
                   <h5><strong>RAZÓN SOCIAL</strong></h5>
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
                   <h5><strong>RFC</strong></h5>
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
                <h5><strong>EMISIÓN DE PEDIDO</strong</h5>
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
                <h5><strong>TIEMPO DE ENTREGA</strong></h5>
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
    <br>

    <table class="table table-striped"  style="font-size:10px" >
     
            <tr>
                <td class="descripcion">
                    <strong>Fuente Finan.</strong>
                </td>
                <td class="descripcion">
                   <strong> Proc</strong>
                </td>
                <td class="descripcion">
                  <strong>  
                    Unid 
                    Adm
                  </strong>
                </td>
                <td class="descripcion">
                    <strong>
                    PART
                </strong>
                </td>
                <td class="descripcion">
                <strong>
                    Tipo Gast
                </strong>
                </td>
                <td class="descripcion">
                    <strong>
                    REQ
                    </strong>
                </td>
                <td class="descripcion">
                    <strong>
                    D.P
                    </strong>
                </td>
                <td class="descripcion">
                    <strong>
                    CANT
                    </strong>
                </td>
                <td style="width=15%;">
                    <strong>
                    DESCRIPCION
                    </strong>
                </td>
                <td style="width=10%;">
                    <strong>
                    PRESENTACION 
                    </strong>
                </td>
                <td style="width=10%"> 
                    <strong>
                    P.U
                    </strong>
                </td>
                <td style="width=10%">
                    <strong>
                    IMPORTE
                    </strong>
                </td>
            
                <td style="display: none; " >
                </td>
        </tr>
       
        <tbody>
            <?php
            $sumaIva=0;
            $sumaImporte=0;
            foreach($productos as $consulta) {
            ?>
            <?php   echo "<tr >"; ?>
               <?php echo "<td>". $consulta['fuenteFinan']."</td>"; ?>
               <?php echo "<td>". $consulta['proceso']."</td>"; ?>
               <?php echo "<td>" .$consulta['unidadAdmin']."</td>"; ?>
               <?php echo "<td>". $consulta['partida']."</td>"; ?>
               <?php echo "<td>". $consulta['tipoGasto']."</td>"; ?>
               <?php echo "<td>" .$consulta['requisicion']."</td>"; ?>
               <?php echo "<td>" .$consulta['detallePedido']."</td>"; ?>
               <?php echo "<td>" .$consulta['cantidad']."</td>"; ?>
               <?php echo "<td>". $consulta['producto']."</td>"; ?>
               <?php echo "<td>". $consulta['presentacion']."</td>"; ?>
               <?php echo "<td>" .number_format($consulta['precio'],2)."</td>";
            
               ?>
               <?php echo "<td>" .number_format($consulta['importe'],2)."</td>";
               $sumaImporte=$sumaImporte+$consulta['importe'];
               ?>
               <?php echo "<td  style=\"display: none; \" >" .number_format($consulta['iva'],2)."</td>"; 
                    $sumaIva=$sumaIva+$consulta['iva'];
               ?>
            <?php   echo "</tr>"; ?>
           <?php
             }
            ?>       
        <tbody>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
         
             <td>IMPORTE</td>
             <td>
                    <?php
                      echo  number_format($sumaImporte,2);
                        ?>
             </td>
             <td style="display: none; "></td>
         </tr>
         <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        
                <td>IVA</td>
                <td>
                        <?php
                      echo  number_format($sumaIva,2);
                        ?>
                    
                </td>
                <td style="display: none; "></td>
            </tr>
            <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  
                    <td>TOTAL:</td>
                    <td>
                            <?php
                            echo  number_format($sumaIva+$sumaImporte,2);
                              ?>
                    </td>
                    <td style="display: none; "></td>
                </tr>

    </table>
    <?php
    require 'vendor/autoload.php';
    use NumeroALetras\NumeroALetras;
    echo "<center>".NumeroALetras::convertir(99.99, ' PESOS M.N')."</center>"
    ?>

    <br>
    <table  width="100%">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><center>_______________</center></td>
            <td style="margin-left:20px;"><center>_______________</center></td>
            <td style="margin-left:20px;"><center>_______________</center></td>
            <td style="margin-left:20px;"><center>_______________</center></td>
            </tr>
            <tr>
                <td><center>ELABORA</center></td>
                <td><center>REVISA</center></td>
                <td><center>AUTORIZA</center></td>
                <td><center>Vo.Bo.</center></td>
            </tr>
    </table>

</body>

</html>

<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new DOMPDF();
$dompdf->load_html(ob_get_clean());
$dompdf->render();
$pdf=$dompdf->output();
$filename='ListaPedidos.pdf';
$dompdf->stream($filename,array('Attachment'=>0));


?>