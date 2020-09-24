<?php 
class conect{

  private $conect; 
  private $total_consultas;
  private $consulta;

  public function __construct(){ 
    if(!isset($this->conect)){
      $this->conect = pg_connect("host='ec2-54-247-118-139.eu-west-1.compute.amazonaws.com' port='5432' user='htglilcpjgobix' password='ecbf78e696a7c3fb914ce8d7b491d36501ab90ef09900d1627e933021ac66565'  dbname='d60cl4e31pl1pl' options='--client_encoding=UTF8'") or die('No pudo conectarse: ' . pg_last_error());
      
//      mysql_select_db("indicadoreseph",$this->conect) or die('No pudo selccionar db: '. mysql_error());
    }

  }

  public function consulta($consulta){ 

    $this->total_consultas++; 
    $this->consulta = pg_exec($this->conect,$consulta);
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

  public function Close() {		// cierra la conect

    pg_close($this->conect);

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
