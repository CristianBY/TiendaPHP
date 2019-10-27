<!DOCTYPE html>
<html>
<head>
	<title>Tienda</title>
	<meta charset="utf-8">
	<style type="text/css">
		h1 {
			color: red;
			text-align: center;
		}
		.lista {
			position: absolute;
			top:140px;
			left:920px;
		}
		span {
			position: absolute;
			top:140px;
			left:320px;
			color:red;
			font-weight: bold;
		}
		th,td{
			text-align: center;
		}
		form {
			width: 800px;
		}
		fieldset {
			background-color: cyan;
		}
	</style>
</head>
<body>
	<h1>Tienda</h1>
	<br/>
	<?php
		include 'funciones.php';

			if (isset($_POST["inserta"])){ // Inserción de producto
				if (isset($_POST['oculto'])) {
	            	$array = explode(",",$_POST['oculto']);
	          	} 
	          	if (!empty($_POST['producto'])) { //Para evitar artículos sin nombre
	          		$control = true;
	          		$array = explode(",",$_POST['oculto']);
	          		if (empty($_POST['cantidad'])){ // Evita elemento vacío y lo cambia por 0; 
	          			$_POST['cantidad'] = 0;
	          		}
	          		if (empty($_POST['precio'])){
	          			$_POST['precio'] = 0; // Evita elemento vacío y lo cambia por 0; 
	          		}
	          		for ($i=1; sizeof($array)>$i;$i++){ // Para no escribir un producto dos veces
	          			$cadena = explode(":",$array[$i]);
	          			if ($_POST['producto'] == $cadena[0]){ 
	          				$control = false;
	          				$i=sizeof($array);
	          			}
	          		}
	          		if ($control){ //Se habilita la inserción en el array si no se encuentra repetido 
	          			$array[]=$_POST['producto'].":".$_POST['cantidad'].':'.$_POST['precio'];
	          			print("<p><span>Insertado<span><p>");
	          			print(mostrar($array));
	          		} else {
	          			print("<p><span>El producto está en la lista, para realizar cambios use modificar<span><p>");
	          		}
	        		
	        	}else{
	        		print("<p><span>No has indicado un producto<span><p>");
	        	}
	    	
	    	}elseif (isset($_POST["muestra"])){ // Muestra los artículos con totales
	    		$array = explode(",",$_POST['oculto']);
	    		print(mostrar($array)); // Creada funcion porque el código se repite en modificar y en eliminar.
	    		
	    	}elseif (isset($_POST["modifica"])){ // Modifica un producto y luego vuelve a mostrar
	    		$control = false; // controla la modificacion false si no la hace y true si la hace 
	    		$vacio = false; // controla que hayamos indicado por lo menos cantidad o precio para modificar
	    		$array = explode(",",$_POST['oculto']);
		    		for ($i=1; sizeof($array)>$i;$i++){
		    			$cadena = explode(":",$array[$i]);
		    			if ($_POST['pro'] == $cadena[0]){
		    				$control = true; 
		    				if (!empty($_POST['producto']) && empty($_POST['cantidad']) && !empty($_POST['precio'])){ // Si no queremos modificar la cantidad
		    					$array[$i] = $_POST['producto'].":".$cadena[1].':'.$_POST['precio'];
		    				} elseif (!empty($_POST['producto']) && !empty($_POST['cantidad']) && empty($_POST['precio'])) { // Si no queremos modificar el precio
		    					$array[$i] = $_POST['producto'].":".$_POST['cantidad'].':'.$cadena[2];
		    				} elseif (!empty($_POST['producto']) && empty($_POST['cantidad']) && empty($_POST['precio'])){ // Solo queremos cambiar el nombre
		    					$array[$i] = $_POST['producto'].":".$cadena[1].':'.$cadena[2];
		    				} elseif (empty($_POST['producto']) && !empty($_POST['cantidad']) && !empty($_POST['precio'])){ // Si no queremos cambiar el nombre 
		    					$array[$i] = $cadena[0].":".$_POST['cantidad'].':'.$_POST['precio'];
		    				} elseif (empty($_POST['producto']) && !empty($_POST['cantidad']) && empty($_POST['precio'])){ // Solo queremos cambiar cantidad 
		    					$array[$i] = $cadena[0].":".$_POST['cantidad'].':'.$cadena[2];
		    				} elseif (empty($_POST['producto']) && empty($_POST['cantidad']) && !empty($_POST['precio'])){ // Solo queremos cambiar el precio 
		    					$array[$i] = $cadena[0].":".$cadena[1].':'.$_POST['precio'];
		    				} elseif (empty($_POST['producto']) && empty($_POST['cantidad']) && empty($_POST['precio'])){ // No indicamos ninguno de los valores y se lo hacemos saber al usuario 
		    					$vacio = true;
		    				} else { // En el caso que modifiquemos los tres valores
		    					$array[$i]=$_POST['producto'].":".$_POST['cantidad'].':'.$_POST['precio'];
		    				}
		    				$i=sizeof($array);
		    			}
		    		}
		    		if ($control && !$vacio) {
		    			print("<p><span>Modificado<span><p>");
		    		}elseif ($vacio) {
		    			print("<p><span>No modificado, indique un precio, cantidad o nombre<span><p>");
		    		}elseif ($_POST['pro'] == "") {
		    			print("<p><span>No has indicado un nombre del listado a modificar</span></p>");
		    		}else {
		    			print("<p><span>No modificado, producto no encontrado<span><p>");
		    		}
		    		print(mostrar($array));
	    		
	    	}elseif (isset($_POST["elimina"])){ // Elimina productos y vuelve a mostrar la lista
	    		$control = false;
	    		$array = explode(",",$_POST['oculto']);
	    		for ($i=1; sizeof($array)>$i;$i++){
	    			$cadena = explode(":",$array[$i]);
	    			if ($_POST['producto'] == $cadena[0]){
	    				array_splice($array,$i,1);// Quita el elemento y reorganiza las keys.
	    				$i=sizeof($array);
	    				$control = true;
	    			}
	    		}
	    		if ($control){
	    			print("<p><span>Eliminado<span><p>");
	    		}elseif (empty($_POST['producto'])){
	    			print("<p><span>No has indicado un nombre a eliminar</span></p>");
	    		} else {
	    			print("<p><span>No eliminado, producto no encontrado<span><p>");
	    		}
	    		print(mostrar($array));
	    	}
	    			
	?>
	<form method="POST" action="tienda.php">
		<fieldset>
			<legend>Tienda</legend>
			<table>
				<tr>
					<td>Nombre</td>
					<td><input type="text" name="producto"></td>
				</tr>
				<tr>
					<td>Cantidad</td>
					<td><input type="number" name="cantidad" step="any"></td>
				</tr>
				<tr>
					<td>Precio</td>
					<td><input type="number" name="precio" step="any"></td>
				</tr>
				<tr>
				<td>Listado</td>
					<td>
						<select value="pro" name="pro">
							<option value="" selected>-- Elija uno a modificar --</option>
							<?php
								for ($i=1; sizeof($array)>$i;$i++){
	    							$cadena = explode(":",$array[$i]);
	    							print("<option value='".$cadena[0]."'>".$cadena[0]."</option>");
	    						}
	    					?>		
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" name="muestra" value="Muestra">
			<input type="submit" name="inserta" value="Inserta">
			<input type="submit" name="modifica" value="Modifica">
			<input type="submit" name="elimina" value="Elimina">
			<input type="hidden" name="oculto" value="<?php echo implode (',',$array);?>">
		</fieldset>
		
</body>
</html>