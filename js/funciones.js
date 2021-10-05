//Formatea el rut
function formato_rut(rut) {

	//Evita que se cree el caracter - cuando el input este vacio
	if(rut.value == "-" || rut.value == "") {  rut.value = ""; return }

    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv

    //Funcion que permite solo numero y letra K
    valores_rut(rut.value);
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { 
        //rut.setCustomValidity("RUT Incompleto"); 
        return false;
    }
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { 
        //rut.setCustomValidity("RUT Inválido"); 
        return false; 
    }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}

//Solo Numero y Letra K
function valores_rut(rut){

    //Si existen valores que no estan en replace, seran remplazado por vacio
    var rut_permitido = rut.replace(/[^-kK0-9]/g, "");
    //Retorna el valor al Id del input del formulario
    document.getElementById('rut').value = rut_permitido;

}

//Funcion para descargar el archivo de respaldo
function descargar_respaldo(){

    //obtiene el nombre del archivo seleccionado
    var archivo = document.getElementById("archivo").value;

    //creamos la url de donde se descargara el archivo
    var url = "http://localhost:8080/taller/backup/";
    
    //crea el elemento del boton 
    var link = document.createElement("a");

    //agrega el atributo download al archivo
    link.setAttribute('download', archivo);

    //crea la direccion al href de la url concatenado al nombre del archivo
    link.href = url + archivo;

    //pasa el metodo del boton
    document.body.appendChild(link);

    //inicia el click
    link.click();

    //luego lo remueve
    link.remove();

}