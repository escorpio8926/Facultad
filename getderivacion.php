<?php
include 'classConexion.php';
$obj_gurpo=new Conexion();
$result=$obj_gurpo->consulta("select * from recursos_beneficios order by id_recurso ASC");
while ( $row =  pg_fetch_array($result))    
                        { 			
			echo '<option value="'.$row['id_recurso'].'">'.$row['nombre'].' - '.$row['stock'].'</option>';
                        }