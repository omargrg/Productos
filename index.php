<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://kit.fontawesome.com/5637dd924f.js" crossorigin="anonymous"></script>
    <script src="./scripts.js"></script> 
</head>
<body>
<div class="header">
<h1>Productos</h1>
<button type="button" onClick="abrirModal()">Nuevo Producto</button>
</div>

<?php 
include "../conexion.php";
?>


<section class="listaResultados">
    <div class = "contenedor" id="contenedor">
        <?php
        //checamos si hay un mensaje enviado a través de un querystring
        if (isset($_REQUEST["error"])){
            $error = $_REQUEST["error"];

            if ($error == 1){
                echo "<div class='errores'>El archivo seleccionado no es una imagen JPG, JPEG o PNG</div>";
            } else if ($error == 2){
                echo "<div class='errores'>El archivo pesa más de 500MB y no puede subirse al servidor</div>";
            }else if ($error == 3){
                echo "<div class='errores'>El archivo no se pudo subir al servidor. Contacte al administrador</div>";
            }else if ($error == 4){
                echo "<div class='errores'>El producto no se pudo subir.</div>";
            }
        } else if (isset($_REQUEST["foto"])){
            if ($_REQUEST["foto"] == "yes"){
                echo "<div class='subirFoto'>El producto y la foto se subieron correctamente al sevidor</div>";
            }
        }

    
        ?>
        <div class="titulo">Producto</div>
        <div class="titulo">Descripción</div>
        <div class="titulo">Precio</div>
        <div class="titulo">Fotos</div>
           
        <?php

        $sql = "select * from omar_productos";

        $rs = ejecutar($sql);
        $k = 1;
        while ($datos = mysqli_fetch_array($rs)){
            if ($k % 2 == 0){
                echo '<div class="claro">'.$datos["producto"].'</div>';
                echo '<div class="claro">'.$datos["descripcion"].'</div>';
                echo '<div class="precioClaro">$'.number_format($datos["precio"],2,'.',',').'</div>';
                echo '<div class="claro"><button type="button" class="boton" onClick=subirFoto('.$datos["idProducto"].')>';
                echo '<i class="fas fa-plus-circle"></i></button>';
                //hacemos un query para sacar todas las fotos de cada producto en este momento
                $sql2 = "select foto from omar_fotoProductos where idProducto = ".$datos["idProducto"];
                $rs2 = ejecutar($sql2);
                while($d2 = mysqli_fetch_array($rs2)){
                    echo '<img src="'.$ruta.$d2["foto"].'" class="fotoChica">';
                }
                echo '</div>';
            }else{
                echo '<div class="oscuro">'.$datos["producto"].'</div>';
                echo '<div class="oscuro">'.$datos["descripcion"].'</div>';
                echo '<div class="precioOscuro">$'.number_format($datos["precio"],2,'.',',').'</div>';
                echo '<div class="oscuro"><button type="button" class="boton" onClick=subirFoto('.$datos["idProducto"].')>';
                echo '<i class="fas fa-plus-circle"></i></button>';
                //hacemos un query para sacar todas las fotos de cada producto en este momento
                $sql2 = "select foto from omar_fotoProductos where idProducto = ".$datos["idProducto"];
                $rs2 = ejecutar($sql2);
                while($d2 = mysqli_fetch_array($rs2)){
                    echo '<img src="'.$ruta.$d2["foto"].'" class="fotoChica">';
                }
                echo '</div>';
            }
            $k++;
           
        }
        
        ?>  
        
    </div>

</section>
<div class="modal" id="vModal">
    <div class="modal-bg">
        <form method = "post" action = "index_xt.php" id="f2">
        <div class="modal-container"> 
            <div class="cerrar">
                <button type="button" onClick="cerrarModal()"><i class="fas fa-window-close"></i></button>
            </div>
            <div class="titulo">Ingreso Nuevo Producto</div>

            
            <div class="iconos"><i class="fas fa-user"></i></div>
            <div class="divformulario"><input type="text" placeholder="nombre" name="nombre" class="camposModal" id="c1"/></div>

            <div class="iconos"><i class="fas fa-align-justify"></i></div>
            <div class="divformulario"><textarea name="descripcion" rows="5" cols="40" class="camposModal" id="c2"></textarea></div>

            <div class="iconos"><i class="fas fa-tag"></i></div>
            <div class="divformulario"><input type="text" placeholder="precio" name="precio" class="camposModal" id="c3"/></div>

            <div class="iconos"><i class="fas fa-image"></i></div>
            <div class="divformulario"><input type="file" name="foto" class="camposModal" id="botonSubirFoto"/></div>

            <div class="iconos"></div>
            <div class="divformulario"><button type="button" class="botonFormularioModal" onClick="validarFormulario()">Ingresar</button>

            
            <div class="iconos"></div>
            <div class="divformulario"><span id="msj" class="mensaje"></span></div>


        </div>
        </form>
    </div>
</div>

</body>
</html>