<?php
class front_controller
{
	public static function main() 
	{
		if(isset($_GET["ruta"])){$ruta=$_GET["ruta"];}else{$ruta='';}

		if($ruta)
		{
			$arreglo_url=explode("/",$ruta);
			$clase=$arreglo_url[0];
			$metodo=$arreglo_url[1];
			
			$sufijo=substr($clase,-2);
			
			if($sufijo=='VI')
			{
				$carpeta="vistas";
			}
			else if($sufijo=='CO')
			{
				$carpeta="controladores";
			}		
		}
		else
		{
			$carpeta="vistas";
			$clase="menu_VI";
			$metodo="verMenu";
		}
		
		require_once $carpeta."/".$clase.".php";
		
		$objeto=new $clase();

		$objeto->$metodo();
	}
}
?>