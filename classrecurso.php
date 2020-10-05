 <?php
 include 'classConexion.php';

 class recurso
 {
   var $nombre;
   var $descripcion;
   var $documentacion;
   var $stock;
   var $id_recurso;
   var $id_user;

 

	function recurso($val1='') // declara el constructor, si trae el id de nombres la busca , si no, trae todas las nombress
	{
		if ($val1!='')
		{
			$obj_nombres=new Conexion();
			$result=$obj_nombres->consulta("select * from recursos_beneficios where id_recurso = $val1"); // ejecuta la consulta para traer la nombres
      $row=  pg_fetch_array($result);
      $this->nombre=$row['nombre'];   
      $this->descripcion=$row['descripcion'];
      $this->documentacion=$row['documentacion'];
      $this->stock=$row['stock'];
      $this->id_user=$row['id_user'];
      $this->id_recurso=$row['id_recurso'];
    }
  }
	function getrecursos($val1,$val2) // este metodo podria no estar en esta clase, se incluye para simplificar el codigo, lo que hace es traer todas las nombress
  {
    if($val2>1){
      $obj_nombres=new Conexion();
      $query = "select * from recursos_beneficios order by id_recurso ASC";
                            $result=$obj_nombres->consulta($query); // ejecuta la consulta para traer las nombress                             
                            return $result; // retorna todas las nombress
                          }
                          else{
                            $obj_nombres=new Conexion();
                            $query = "select * from recursos_beneficios where id_recurso = '$val1' order by nombre ASC";
                            $result=$obj_nombres->consulta($query); // ejecuta la consulta para traer los informantes   
                            return $result; // retorna todos los informantes
                          }
                        }

	// metodos que devuelven valores
                        function getnombre()
                        { return $this->nombre;}    
                        function getdescripcion()
                        { return $this->descripcion;}
                        function getdocumentacion()
                        { return $this->documentacion;}
                        function getstock()
                        { return $this->stock;}
                        function getid_recurso()
                        { return $this->id_recurso;}     
                        function getid_user()
                        { return $this->id_user;}

                      
                     
                       


	// metodos que setean los valores

                        function setnombre($val)
                        {  $this->nombre=$val;} 

                        function setdescripcion($val)
                        {  $this->descripcion=$val;} 

                         function setdocumentacion($val)
                        {  $this->documentacion=$val;}

                        function setstock($val)
                        {  $this->stock=$val;}

                        function setid_recurso($val)
                        {  $this->id_recurso=$val;}

                        function setid_user($val)
                        {  $this->id_user=$val;}  


  

      

	function updaterecursos()	// actualiza la identificacion cargada en los atributos
	{
   $obj_nombres=new Conexion();
   $qverifica="select * from recursos_beneficios where id_recurso='$this->id_recurso'";                    
   $obj_nombres->consulta($qverifica);
   if($obj_nombres->num_rows()<>0){       


     $query="update recursos_beneficios set descripcion='$this->descripcion', "
     . "stock='$this->stock', "

     . "documentacion='$this->documentacion'"
   
     . "where id_recurso='$this->id_recurso'";  
                 
			$obj_nombres->consulta($query); // ejecuta la consulta para traer la identificacion 
			return '<div id="mensaje"><p/><h4>El Recurso :  '.$this->nombre.'  fue modificado con exito</h4></div>'; // retorna todos los registros afectados
    }
    else{
      return '<div id="mensaje"><p/><h4>ERROR: YA FUE CARGADO El Recurso '.$this->nombre.', COMPRUEBE QUE LOS DATOS SEAN CORRECTOS </h4></div>'; 
    }
  }
        function updateEstadoSalidaMes($val)	// actualiza el estado de la salida
        {
         $obj_nombres=new Conexion();                       
         $qverifica="select * from salidas_mes where id_salida_mes='$val'";                      
         $obj_nombres->consulta($qverifica);
         if($obj_nombres->num_rows()<>0){                          
           $query="update salidas_mes set estado='FINALIZADA' where id_salida_mes = '$val'";                      
			$obj_nombres->consulta($query); // ejecuta la consulta para actualizar estado 
      $query1="update precios set consistir=0 where id_salida_mes = '$val'";                    
                        $obj_nombres->consulta($query1);// ejecuta la consulta para desconsistir
                        date_default_timezone_set('America/Argentina/Tucuman');
                        $fecha = date('Y-m-d');
                        $hora=  date("H:i:s");  
                        $query2="insert into reapertura( fecha, hora, id_salida_mes, id_user) values ('$fecha', '$hora', '$val', '$this->id_user')";
                        $obj_nombres->consulta($query2);
                        $resultado="select salidas_mes.estado, salidas_mes.id_salida_mes, salidas_mes.anio, salidas_mes.mes, salidas_mes.id_salida, salidas.panel, salidas.tarea, informantes.cod_informante, informantes.empresa 
                        from informantes, salidas, salidas_mes
                        where salidas_mes.id_salida = salidas.id_salida 
                        AND salidas.id_informante=informantes.cod_informante
                        AND salidas_mes.id_salida_mes='$val'                                               
                        order by anio , mes , panel, tarea, cod_informante ASC";                        
                        $result=$obj_nombres->consulta($resultado);
			return $result; // retorna todos los registros afectados
    }
    else{
     return '<div id="mensaje"><p/><h4>ERROR: YA ESTA DADO DE ALTA EL FORMULARIO, COMPRUEBE QUE LOS DATOS SEAN CORRECTOS </h4></div>'; 
   }
 }
        function BuscarSalidaMes()	// inserta la identificacion cargada en los atributos
        {
         $obj_nombres=new Conexion();                    
         $qverifica="select * from salidas_mes "
         ."where anio='$this->año' and mes='$this->mes' and id_salida='$this->id_salida'";                        
         $result=$obj_nombres->consulta($qverifica);                       
         if($obj_nombres->num_rows()<>0){                      
			return $result;// retorna todos los registros afectados
    }
    else{
     return '<div id="mensaje"><p/><h4>ERROR: AUN NO FUE CARGADA LA SALIDA, COMPRUEBE QUE LOS DATOS SEAN CORRECTOS</h4></div>'; 
   }
 }	
	function insertrecursos()	// inserta la identificacion cargada en los atributos
	{
   $obj_nombres=new Conexion();
   $qverifica1="select * from recursos_beneficios where nombre='$this->nombre'";
   $obj_nombres->consulta($qverifica1); 
  if($obj_nombres->num_rows()==0){                
                      
                        
     $query="insert into recursos_beneficios (nombre, descripcion, documentacion, id_user, stock) values ('$this->nombre','$this->descripcion','$this->documentacion', '$this->id_user', '$this->stock')";			                       
                        $obj_nombres->consulta($query); // ejecuta la consulta para traer la identificacion
			return '<div id="mensaje"><p/><h4>El Recurso/Beneficio:  '.$this->nombre.'  se guardo con exito</h4></div>'; // retorna todos los registros afectados
    
  
  }  
   else
   {
      return '<div id="mensaje"><p/><h4>ERROR: Ya fue cargado el Recurso '.$this->nombre.', COMPRUEBE QUE LOS DATOS SEAN CORRECTOS </h4></div>'; 
   }
 }	
	function deleterecurso($val)	// elimina la identificacion
	{

   $obj_nombres=new Conexion();                        
   $query="delete from recursos_beneficios where id_recurso=$val;";             
			$obj_nombres->consulta($query); // ejecuta la consulta para  borrar la identificacion
			return '<div id="mensaje"><p/><h4>Se elimino el Recurso con exito</h4></div>'; // retorna todos los registros afectados

   }
        function CerrarSalidaMes($val)	// elimina la identificacion
        {
         $obj_nombres=new Conexion();
         $qverifica="select * from precios where id_salida_mes = '$val' and consistir = '0'"; 
         $obj_nombres->consulta($qverifica);                        
         if($obj_nombres->num_rows()== 0){
           $query="update salidas_mes set estado = 'CERRADA' where id_salida_mes=$val";                        
			$obj_nombres->consulta($query); // ejecuta la consulta para  borrar la identificacion
			return '<div id="mensaje"><p/><h4>Se cerro:  '.$obj_nombres->getAffect().'  Salida con exito</h4></div>'; // retorna todos los registros afectados
    }
    else{
      return '<div id="mensaje"><p/><h4>NO ES POSIBLE CERRAR LA SALIDA PORQUE AUN HAY FORMULARIOS SIN CONSISTIR</h4></div>';     
    } 
  }
        function FinalizarSalidaMes($val)	// elimina la identificacion
        {
         $obj_nombres=new Conexion();
         $qverifica="select * from precios where id_salida_mes = '$val' and consistir = '0'"; 
         $obj_nombres->consulta($qverifica);                        
         if($obj_nombres->num_rows()== 0){
           $query="update salidas_mes set estado = 'FINALIZADA' where id_salida_mes=$val";                        
			$obj_nombres->consulta($query); // ejecuta la consulta para  borrar la identificacion
			return '<div id="mensaje"><p/><h4>Se Finalizo:  '.$obj_nombres->getAffect().'  Salida con exito</h4></div>'; // retorna todos los registros afectados
    }
    else{
      return '<div id="mensaje"><p/><h4>NO ES POSIBLE FINALIZAR LA SALIDA PORQUE AUN HAY FORMULARIOS SIN CONSISTIR</h4></div>';     
    } 
  }
        function buscaFormularios($val)	// elimina la identificacion
        {
         $obj_nombres=new Conexion();
         if ($val!=''){
          $query="select formularios.id_formulario, formularios.nombre from formularios, informantes_formularios
          where informantes_formularios.id_informante= $val and informantes_formularios.id_formulario=formularios.id_formulario;";
			$result=$obj_nombres->consulta($query); // ejecuta la consulta para  borrar la identificacion
			return $result;    
    }
    else{
      $query="select formularios.id_formulario, formularios.nombre from formularios;";
			$result=$obj_nombres->consulta($query); // ejecuta la consulta para  borrar la identificacion
			return $result;      
    }

  }	

}
?>