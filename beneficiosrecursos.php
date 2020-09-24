<?php
include 'cabecera.php';
include 'menu.php';
include 'classFicha.php';
include 'foot.php';

if(isset($_SESSION['nick']) and isset($_SESSION['habil'])){
    $id_exp="";
    $fecha_ei="";
    $entre="";
    $dni="";
    $apellido="";
    $nombre="";
    $calle="";
    $nro="";
    $piso="";
    $dpto="";
    $barrio="";
    $localidad="";
    $provincia="";
    $t_ali="";
    $p_ali="";
    $meren="";    
    $meren_co="";
    $padron="";
    $telcon="";
    $muni="";
    $muni1="";
    $muni2="";
    $muni3="";
    $encuestador="";
    $id_user=$_SESSION['id_user'];

if (isset($_GET['mdId'])) // si la operacion es modificar, este valor viene seteado y ejecuta el siguiente codigo
{

        $NuevaFicha=new Ficha($_GET['mdId']);  // instancio la clase identificacion pasandole el nro de identificacion, de esta forma lo busca
        $id_exp=$NuevaFicha->getid_exp();
        $fecha_ei=$NuevaFicha->getfecha_ei(); // setea los datos
        $entre=$NuevaFicha->getentre();
        $dni=$NuevaFicha->getDni();
        $apellido=$NuevaFicha->getApellido();
        $nombre=$NuevaFicha->getNombre();
        $calle=$NuevaFicha->getcalle();
        $nro=$NuevaFicha->getnro();
        $piso=$NuevaFicha->getpiso();
        $dpto=$NuevaFicha->getdpto();
        $barrio=$NuevaFicha->getbarrio();
        $localidad=$NuevaFicha->getlocalidad();
        $provincia=$NuevaFicha->getprovincia();
        $t_ali=$NuevaFicha->gett_ali();
        $p_ali=$NuevaFicha->getp_ali();
        $meren=$NuevaFicha->getmeren();
        $meren_co=$NuevaFicha->getmeren_co();
        $muni=$NuevaFicha->getmuni();
        $muni1=$NuevaFicha->getmuni1();
        $muni2=$NuevaFicha->getmuni2();
        $muni3=$NuevaFicha->getmuni3();
        $padron=$NuevaFicha->getpadron();
        $telcon=$NuevaFicha->gettelcon();
        $encuestador=$NuevaFicha->getencuestador();
        $id_user=$NuevaFicha->getId_Usuario();
    }
    ?>

    <div id="cuerpo" >
        <?php
        if(is_numeric($id_exp))
            {$value='Modificar';
        $s="readonly";
        $disas="";
    }
    else
        {$value='Guardar';
    $disas="hidden";
    $s="";

}
?>
<form method="POST" action="nueva_ficha.php" autocomplete="off">

    <input type="hidden" name="id_exp" value="<?php print $id_exp ?>">
    <input type="hidden" name="id_user" value="<?php print $id_user ?>">
    <br></br>
    <table style="width: 65%" >

        <th colspan="3" style="border-bottom-style: solid;"><h3>Asignación de Recursos o beneficios</h3></th>

   </table>
   </form>
   </div>






<?php    
}  
else
{
    print '<img src="./imagenes/accesoDenegado.png" style=" position: absolute; top: 40%; left: 44%;">';
}
?>


</body>

</html>