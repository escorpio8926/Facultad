<?php
include 'cabecera.php';
include 'menu.php';
include './classderivaciones.php';
include 'classConexion.php';

 ?>
 <div id="cuerpo" >
<form method="POST" action="beneficiosrecursos.php" autocomplete="off">


    <br></br>
    <input type="button" style="width:13%;margin-left:43%;" value="Solicitar IA">
    <br></br>
    <table style="width: 40%" >

        <th colspan="3" style="border-bottom-style: solid;"><h3>Indicadores de vulnerabilidad </h3></th>
    <tr>
         <th style="width:60%">Características del Hogar y Vivienda</th>
         <th style="text-align: left;"> <input type="text" style="width:50%" disabled></th>

    </tr>
    <tr>
         <th style="width:40%">Características de los Miembros del Hogar</th>
         <th style="text-align: left;"> <input type="text" style="width:50%" disabled></th>

    </tr>
    <tr>
         <th style="width:40%">Ingresos del Hogar</th>
         <th style="text-align: left;"> <input type="text" style="width:50%" disabled></th>

    </tr>
    <tr>
         <th style="width:40%">Situación Laboral mayores de 14 años</th>
         <th style="text-align: left;"> <input type="text" style="width:50%" disabled></th>

    </tr>
    <tr>
         <th style="width:40%">Total</th>
         <th style="text-align: left;"> <input type="text" style="width:50%" disabled></th>

    </tr>

     <tr>
      <th colspan="3" ><h3>Recomendaciones</h3></th>
    </tr>

   

        <tr>
         
         <th colspan="3"> <input type="text" style="width:90%" disabled=""></th>

    </tr>

   </table>
   </form>
   </div>
<?php

if(isset($_SESSION['nick']) and isset($_SESSION['habil'])){
    $id_drv=""; 
    $deriva="";
    $otro="";
    $id_exp=$_GET['Id'];
    $id_user=$_SESSION['id_user'];
    $date="";
    $estate="";        

if (isset($_GET['mtri'])) // si la operacion es modificar, este valor viene seteado y ejecuta el siguiente codigo
{

        $Nuevodrvs=new drvs($_GET['Id'],$_GET['mtri']);// instancio la clase identificacion pasandole el nro de identificacion, de esta forma lo busca
    
        $id_exp=$Nuevodrvs->getid_exp();
        $id_drv=$Nuevodrvs->getid_drv();

        $estate=$Nuevodrvs->getestate();
}
    ?>

    <div id="cuerpo">
        <?php 
        if(is_numeric($id_exp)&&is_numeric($id_drv)) 
            {$value='Modificar';
          $aparecer='block';
          $aparecer1='none';
          $valer='disabled';
          $valer2='readonly';
         $disa="hidden";
$disas="";
$foco='autofocus';} 
        else
            {$value='Agregar';
             $aparecer='none';
             $aparecer1='block';
           $valer='';
           $valer2='';
          $disa="";
$disas="hidden";
$foco='';}
        ?> 
        <form method="POST" action="evaluacion_trabajo.php?Id=<?php print $id_exp ?>" autocomplete="off"> 
            <input type="hidden" name="id_exp" id="id_exp" value="<?php print $id_exp ?>">
            <input type="hidden" name="id_drv" value="<?php print $id_drv ?>">
            <input type="hidden" name="id_user" value="<?php print $id_user ?>">
            <br></br>

            <table>
            <tr>
            <th class="selector-deriva" style="text-align: center;">
                <label for="Derivaciones">Asignación de recursos y beneficios</label>
            <select name="deriva" id="deriva"  style="text-align-last: center;
   text-align: center;
   -ms-text-align-last: center;
   -moz-text-align-last: center;" <?php print $valer ?> ></select>
   <input type="text" style=" width: 50%;" class="entero" name="otro" id="otro" placeholder="¿Cantidad?" required oninput="drvscheck()" value="<?php print $otro ?>"  <?php print $valer2 ?>  >
   <?php $fcha = date("Y-m-d");?>
   <input type="date" style="display:none; width: 50%;" class="ph-center texto" name="date" id="date" value="<?php echo $fcha;?>" readonly>
   <input type="text" style="display:<?php print $aparecer ?>;width: 50%;margin-left: 25%" class="entero" name="estate" id="estate" value="<?php echo $estate;?>" placeholder="Expediente N°" <?php echo $foco ?> >
        </th>
         <td colspan="3" id="boton"><input  type="submit" name="submitare" style="width:25% " id="submitguardara" value ="<?php echo $value ?>" tabindex="8">
            <input type="button" onclick="redirect()" style="width:22%;margin-left:10%;" value="Principal" <?php print $disa ?>>
    <input type="button" onclick="redirect1()" style="width:22%;margin-left:10%;" value="Cancelar" <?php print $disas ?>></td>

            </tr>
            </table>

         

        </form>
    </div>

    <?php

if (isset($_POST['submitare'])&&!is_numeric($_POST['id_drv'])) // si presiono el boton drvsresar
{   
    $Nuevodrvs=new drvs();
    $Nuevodrvs->setid_drv($_POST['id_drv']);
    $Nuevodrvs->setotro(strtoupper($_POST['otro']));
    $Nuevodrvs->setderiva($_POST['deriva']);
    $Nuevodrvs->setid_exp($_POST['id_exp']);
    $Nuevodrvs->setdate($_POST['date']);
    $Nuevodrvs->setestate($_POST['estate']); 
    print  $Nuevodrvs->insertdrvs($_POST['deriva'],$_POST['otro']); // inserta y muestra el resultado


}
?>

<?php
if (isset($_POST['submitare'])&&is_numeric($_POST['id_exp'])&&is_numeric($_POST['id_drv'])) // si presiono el boton y es modificar
{
    $Nuevodrvs=new drvs ();
    $Nuevodrvs->setid_drv($_POST['id_drv']); 


    $Nuevodrvs->setid_exp($_POST['id_exp']);

    $Nuevodrvs->setid_exp($_POST['estate']); 
    print  $Nuevodrvs->updatedrvs ($_POST['id_drv'],$_POST['id_exp'],$_POST['estate']);// inserta y muestra el resultado
}

if (isset($_GET['braIds'])&&is_numeric($_GET['braIds'])) // si presiono el boton y es eliminar
{
    $Nuevodrvs=new drvs ();
    print  $Nuevodrvs->deletedrvs($_GET['Id'],$_GET['braIds']);
}

if (isset($_GET['frId'])&&is_numeric($_GET['frId'])) // si presiono el boton y es cerrar
{
    $Nuevodrvs=new drvs ();
    print  $Nuevodrvs->FinalizarFicha($_GET['frId']); // finaliza la salida y muestra el resultado
}

if (isset($_GET['crId'])&&is_numeric($_GET['crId'])) // si presiono el boton y es cerrar
{
    $Nuevodrvs=new drvs ();
    print  $Nuevodrvs->CerrarFicha($_GET['crId']); // cierra la salida y muestra el resultado
}
?>
<?php 


new Conexion();
$id_exp_1 =$_GET['Id'];
$query="select * from derivacion where id_exp = '$id_exp_1'"; 
$result = pg_query($query); 
if(pg_num_rows($result)>'0'){
    $conti="1";
  }//fin de la fila del if
  else
  {
    $conti="2";
}
echo $conti;
?>
<?php
 print '<br>';
if($conti=='1'){
    $Nuevodrvs=new drvs();
$Nuevodrvs= $Nuevodrvs->getdrvs($_GET['Id']); // obtiene todos las salidas para despues mostrarlas
print '<div id="grilla"><h3 style="text-align: center;">Recursos/beneficios Asignados</h3> <br/><br/><table style="width:80%" border=1 >'
.'<th>Id</th>
<th>Nombre</th>                      
<th>Fecha</th>
<th>Cantidad</th>
<th>Estado</th>
<th>Expediente</th>



<th colspan=1></th>';

    while ($row= pg_fetch_array($Nuevodrvs)) // recorre los identificaciones uno por uno hasta el fin de la tabla
    {

     $s=$row['deriva'];
$querys="select nombre from recursos_beneficios where id_recurso = $s "; 
$results =pg_query($querys);
while ($resultados = pg_fetch_array($results)) {
         $guardar=$resultados['nombre'];        
      }//fin del while de resultados

if($row['estate']=="")
{$way='Pendiente';}
if($row['estate'] > 0)
{$way='Aprobado';}

if($row['estate']==''){
   print '<tr>'

        .'<td>'.$row['deriva'].'</td>'
        .'<td>'.$guardar.'</td>'
        .'<td>'.$row['date'].'</td>'
        .'<td>'.$row['otro'].'</td>'
        .'<td>'.$way.'</td>'
 
        .'<td><a href="evaluacion_trabajo.php?Id='.$row['id_exp'].'&mtri='.$row['id_drv'].'">Asignar Expediente</a></td>'
         .'<td><a href="javascript:;" onclick= avisoo("evaluacion_trabajo.php?Id='.$row['id_exp'].'&braIds='.$row['id_drv'].'");>Eliminar</a></td>' 
            //                  .'<td><a href="javascript:;" onclick= avisoi("Salida_Mes.php?brId='.$row['id_salida_mes'].'","'.$row['mes'].'");>Borrar</a></td>'                
            //                  .'<td><a href="javascript:;" onclick= avisoj("Salida_Mes.php?crId='.$row['id_salida_mes'].'","'.$row['mes'].'");>Cerrar Salida</a></td>'                  
        .'</tr>'; 
}
else
{
     print '<tr>'

        .'<td>'.$row['deriva'].'</td>'
        .'<td>'.$guardar.'</td>'
        .'<td>'.$row['date'].'</td>'
        .'<td>'.$row['otro'].'</td>'
        .'<td>'.$way.'</td>'
 .'<td>'. $row['estate'].'</td>'
       
         .'<td><a href="javascript:;" onclick= avisoo("evaluacion_trabajo.php?Id='.$row['id_exp'].'&braIds='.$row['id_drv'].'");>Eliminar</a></td>' 
            //                  .'<td><a href="javascript:;" onclick= avisoi("Salida_Mes.php?brId='.$row['id_salida_mes'].'","'.$row['mes'].'");>Borrar</a></td>'                
            //                  .'<td><a href="javascript:;" onclick= avisoj("Salida_Mes.php?crId='.$row['id_salida_mes'].'","'.$row['mes'].'");>Cerrar Salida</a></td>'                  
        .'</tr>'; 
}
    
    }
    print '</table>';
    print '</div>';


}
}
else

{
    print '<img src="./imagenes/accesoDenegado.png" style=" position: absolute; top: 40%; left: 44%;">';       
}
?> 




</script>
<script type="text/javascript">
<!--
function redirect() {
   window.location = "nueva_ficha.php";
}
//-->
</script>
<script type="text/javascript">
<!--
function redirect1(q1) {
const queryString = window.location.search;
console.log(queryString);
const urlParams = new URLSearchParams(queryString);
const product = urlParams.get('Id');
console.log(product);

var str2 = "evaluacion_trabajo.php?Id=";
window.location = str2.concat(product);

}
  function drvscheck()
  {
   
    var otro = document.getElementById('otro');
    var date = document.getElementById('date');
   
    

     if(otro.value.length > 0){
  
      date.style.display="block";
      date.style.margin="auto";
      date.readOnly=true;

     
  }
  else
  {     
     
        date.style.display="none";
        date.style.margin="auto";

  }

  }
//-->
</script>
</body>
</html>
