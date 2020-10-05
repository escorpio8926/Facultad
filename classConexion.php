<?php 
class Conexion{

  private $conexion; 
  private $total_consultas;
  private $consulta;

  public function __construct(){ 
    if(!isset($this->conexion)){
      $this->conexion = pg_connect("host='localhost' port='5432' user='postgres' password='892647As'  dbname='Facu' options='--client_encoding=UTF8'")
      or die('No pudo conectarse: ' . pg_last_error());
      
//      mysql_select_db("indicadoreseph",$this->conexion) or die('No pudo selccionar db: '. mysql_error());
    }

  }

  public function consulta($consulta){ 

    $this->total_consultas++; 
    $this->consulta = pg_exec($this->conexion,$consulta);
    if(!$this->consulta){ 
      echo 'PostgreSql Error: ' . pg_last_error();
      echo $consulta;
      exit;
    }
    return $this->consulta;
  }

  public function fetch_array(){
   return pg_fetch_array($this->consulta);
 }

 public function num_rows(){
   return pg_num_rows($this->consulta);
 }

 public function getTotalConsultas(){
   return $this->total_consultas; 
 }

  public function getAffect() { // devuelve las cantidad de filas afectadas

   return pg_affected_rows($this->consulta);
   
 }

  public function Close() {		// cierra la conexion

    pg_close($this->conexion);

  }	

  public function Clean(){ // libera la consulta

    pg_free_result($this->consulta);    

  }
  
  public function fetchAll() {

    $rows=array();
    if ($this->consulta)
    {
     while($row=  pg_fetch_array($this->consulta))
     {
      $rows[]=$row;
    }
  }
  return $rows;
}  
}

?>

