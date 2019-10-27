<?php
	function calcular_Precio_Total_Producto($cantidad,$precio) {
		$suma =$cantidad*$precio;
		return $suma;
	}

	function calcular_Precio_Total_Compra($array){
		for ($i=1; sizeof($array)>$i;$i++){
			$cadena = explode(":",$array[$i]);
			$suma = calcular_Precio_Total_Producto($cadena[1],$cadena[2]);
			$sumaTotal += $suma;
		}
		return $sumaTotal;
	}
	function mostrar($array){ // Se usa en insertar, mostrar, modificar y eliminar se ha creado para ahorrar código.
		if (sizeof($array)>1) {
			$texto = "<table class='lista'><tr><th colspan='4'>Ticket</th></tr><tr><th>Nombre</th><th>Cantidad</th><th>Precio</th><th>Precio Total</th></tr>";
			for ($i=1; sizeof($array)>$i;$i++){
				$cadena = explode(":",$array[$i]);
				$suma = calcular_Precio_Total_Producto($cadena[1],$cadena[2]);
				$texto .="<tr><td>".$cadena[0]."</td><td>".$cadena[1]."</td><td>".$cadena[2]."</td><td>".$suma." €</td></tr>";
			}
			$sumaTotal = calcular_Precio_Total_Compra($array);
			$texto .="<tr bgcolor='cyan'><th colspan='3'>Total</th><td>".$sumaTotal." €</td></tr></table>";
		} else {
			$texto = "<p><span class='lista'>No hay elementos en la lista para mostrar<span><p>";
		}
		return $texto;
	}

?>