<?php
include 'cabecera.php';
include 'menu.php';
include 'classrecurso.php';
include 'foot.php';

if(isset($_SESSION['nick']) and isset($_SESSION['habil'])){
    $nombre="";
    $descripcion="";
    $documentacion="";
    $stock="";
    $id_recurso="";
    $id_user=$_SESSION['id_user'];

if (isset($_GET['mdId'])) // si la operacion es modificar, este valor viene seteado y ejecuta el siguiente codigo
{

        $NuevoRecurso=new recurso($_GET['mdId']);  // instancio la clase identificacion pasandole el nro de identificacion, de esta forma lo busca
        $nombre=$NuevoRecurso->getnombre();
        $descripcion=$NuevoRecurso->getdescripcion(); // setea los datos
        $documentacion=$NuevoRecurso->getdocumentacion();
        $stock=$NuevoRecurso->getstock();
        $id_user=$NuevoRecurso->getid_user();
        $id_recurso=$NuevoRecurso->getid_recurso();
  
    }
    ?>

    <div id="cuerpo" >
        <?php
          
   if(isset($_GET['mdId']))
    {$value='Modificar';
    $disas="hidden";
    $s="readonly";
$a="readonly";}else
    {$value='Aceptar';
    $disas="hidden";
    $s="";
$a="";
}



?>
<form method="POST" action="beneficiosrecursos.php" autocomplete="off">

    <input type="hidden" name="id_recurso" value="<?php print $id_recurso?>">
    <input type="hidden" name="id_user" value="<?php print $id_user?>">
    <br></br>
    <table style="width: 50%" >

        <th colspan="3" style="border-bottom-style: solid;"><h3>Gestión de recursos</h3></th>
    <tr>
         <th style="width:10%">Nombre</th>
         <th style="text-align: left;"> <input type="text" id="nombre" name="nombre" maxlength="120" value = "<?php print $nombre ?>" tabindex="1" style="width:80%" required <?php print $s ?> ></th>

    </tr>
    <tr>
         <th>Descripción</th>
         <th style="text-align: left;"><textarea rows="5"  id="descripcion" name="descripcion" maxlength="500"  tabindex="2" style="width:80%"><?php print $descripcion ?></textarea></th>
    </tr>
    <tr>
        <th>Documentación requerida</th>
         <th style="text-align: left;"><textarea rows="5"  id="documentacion" name="documentacion" maxlength="500" tabindex="3" style="width:80%" ><?php print $documentacion ?></textarea></th>
    </tr>

     <tr>
        <th style="width:10%">Stock</th>
         <th style="text-align: left;"> <input type="text" id="stock" name="stock" align="right" class="entero" value = "<?php print $stock ?>" tabindex="4" style="width:40%" required ></th>
     <tr>


    <tr>
        
        <td colspan="2" id="boton">
             <input type="button" onclick="redirect1()" style="width:13%;margin-left:0%;" value="Cancelar" <?php print $disas ?>>
             <input type="submit" style="text-align:center;width:20% " name="submit" id="submitguardar" value ="<?php echo $value ?>" tabindex="5"></td>
    </tr>

   </table>
   </form>
   </div>



<?php

          

if (isset($_POST['submit']) && !is_numeric($_POST['id_recurso'])) // si presiono el boton ingresar
{
    $NuevoRecurso=new recurso();
    $NuevoRecurso->setnombre($_POST['nombre']);
    $NuevoRecurso->setdescripcion($_POST['descripcion']); // setea los datos
    $NuevoRecurso->setdocumentacion($_POST['documentacion']);
    $NuevoRecurso->setid_user($_POST['id_user']);
    $NuevoRecurso->setstock($_POST['stock']);
   

    print $NuevoRecurso->insertrecursos(); // inserta y muestra el resultado
}
if (isset($_POST['submit']) && is_numeric($_POST['id_recurso'])) // si presiono el boton y es modificar
{
      
    $NuevoRecurso=new recurso();
    $NuevoRecurso->setnombre($_POST['nombre']);
    $NuevoRecurso->setdescripcion($_POST['descripcion']); // setea los datos
    $NuevoRecurso->setdocumentacion($_POST['documentacion']);
    $NuevoRecurso->setstock($_POST['stock']);
    $NuevoRecurso->setid_user($_POST['id_user']);
    $NuevoRecurso->setid_recurso($_POST['id_recurso']);

    print  $NuevoRecurso->updaterecursos(); // inserta y muestra el resultado
}

if (isset($_GET['brId'])&&is_numeric($_GET['brId'])) // si presiono el boton y es eliminar
{
    $NuevoRecurso=new recurso();
    print  $NuevoRecurso->deleterecurso($_GET['brId']); // elimina el identificacion y muestra el resultado
}

if (isset($_GET['frId'])&&is_numeric($_GET['frId'])) // si presiono el boton y es cerrar
{
    $NuevoRecurso=new Ficha();
    print  $NuevoRecurso->FinalizarFicha($_GET['frId']); // finaliza la salida y muestra el resultado
}

if (isset($_GET['crId'])&&is_numeric($_GET['crId'])) // si presiono el boton y es cerrar
{
    $NuevoRecurso=new Ficha();
    print  $NuevoRecurso->CerrarFicha($_GET['crId']); // cierra la salida y muestra el resultado
}


$NuevoRecurso=new recurso();
$NuevoRecurso= $NuevoRecurso->getrecursos($_SESSION['id_user'],$_SESSION['habil']); // obtiene todos las salidas para despues mostrarlas

    print '<div  id="grilla"> <br/><br/><table style="display:<?php print $van ?>; width:100%"  border=1 ">'
    .'<th style="width:15%">Nombre</th>
    <th height="30">Descripción</th>
    <th height="30">Documentación</th>
    <th height="30" style="width:8%">Stock</th>
    <th style="width:4%">Id usuario</th>
    <th  colspan=5></th>';

while ($row=pg_fetch_array($NuevoRecurso)) // recorre los identificaciones uno por uno hasta el fin de la tabla
{


    
        print '<tr>'
        
        .'<td>'.$row['nombre'].'</td>'
        .'<td>'.$row['descripcion'].'</td>'
        .'<td>'.$row['documentacion'].'</td>'
        .'<td>'.$row['stock'].'</td>'
        .'<td>'.$row['id_user'].'</td>'
        .'<td colspan="1" style="width:8%"><a href="beneficiosrecursos.php?mdId='.$row['id_recurso'].'">Modificar Recurso</a></td>'
        .'<td style="width:8%" colspan="1"><a href="javascript:;" onclick= avisoifracto("beneficiosrecursos.php?brId='.$row['id_recurso'].'","'.$row['id_recurso'].'");>Eliminar Recurso</a></td>'

//                  .'<td><a href="javascript:;" onclick= avisoj("Salida_Mes.php?crId='.$row['id_salida_mes'].'","'.$row['mes'].'");>Cerrar Salida</a></td>'
        .'</tr>';
    

   
   
}



print '</table>';
print '</div>';
print '<br>';
print '<br>';
print '<br>';
print '<br>';




}  
else
{
    print '<img src="./imagenes/accesoDenegado.png" style=" position: absolute; top: 40%; left: 44%;">';
}
?>

<script type="text/javascript">
 function ponleFocus1(){

 document.getElementById("nombre");


  nombre.focus();
  aux=nombre.value;
  nombre.value="";
  nombre.value=aux;
}

function ponleFocus2(){

 document.getElementById("descripcion").focus();


  descripcion.focus();
  aux=descripcion.value;
  descripcion.value="";
  descripcion.value=aux;
}


if (document.getElementById("descripcion").value.length > 0)
    {ponleFocus2();}
else
    {ponleFocus1();}

</script>
</body>

</html> 