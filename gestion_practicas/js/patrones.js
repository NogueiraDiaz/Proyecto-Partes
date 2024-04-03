// Guardamos en variables los distintos botones a los que les vamos a pasar una función:
var botonFormularioEmpresas = document.getElementById("crearEmpresa");

var botonFormularioAsignarEmpresas = document.getElementById("asignar");

var botonFormularioAlumnos = document.getElementById("crearAlumno");

var botonAñadirTLF = document.getElementById("crearTLF");
var botonEliminarTLF = document.getElementById("borrarTLF");

var botonAñadirCorreo = document.getElementById("crearCorreo");
var botonEliminarCorreo = document.getElementById("borrarCorreo");

// Condicional para comprobar en que formulario estamos,
// para ello miramos que botones están a NULL.
// Una vez dentro asignaremos las distintas funciones:
if (botonFormularioEmpresas == null && botonFormularioAlumnos == null) {
  botonFormularioAsignarEmpresas.onclick = validarCamposAsignarEmpresa;
} else if (
  botonFormularioEmpresas == null &&
  botonFormularioAsignarEmpresas == null
) {
  botonFormularioAlumnos.addEventListener("click", validarCamposAlumno);
} else {
  botonFormularioEmpresas.addEventListener("click", validarCamposEmpresa);
  botonAñadirTLF.addEventListener("click", function () {
    añadir("telefono");
  });
  botonEliminarTLF.addEventListener("click", function () {
    eliminar("telefono");
  });
  botonAñadirCorreo.addEventListener("click", function () {
    añadir("correo");
  });
  botonEliminarCorreo.addEventListener("click", function () {
    eliminar("correo");
  });
}

// Función para validar los campos de los formularios de editar y crear empresas:
function validarCamposEmpresa() {
  // Almacenamos en variables los elementos del formulario que vamos a validar,
  // a través del Id:
  var formulario = document.getElementById("formulario");
  var dni = document.getElementById("dni");
  var CP = document.getElementById("CP");
  var CIF = document.getElementById("CIF");
  var provincia = document.getElementById("provincia");
  var telefono = document.getElementById("telefono");
  var correo = document.getElementById("correo");

  // Accedemos a todos los input salvo los ciclos y los anexos:
  var inputs = formulario.querySelectorAll(
    'input:not([name="ciclo[]"]):not(.inputAnexos)'
  );

  // Accedemos a los input los cuales tengan como Id "telefono":
  var inputsTlf = document.querySelectorAll("#telefono");

  // Accedemos a los input los cuales tengan como Id "correo":
  var inputsCorreo = document.querySelectorAll("#correo");

  // Inicializamos un array vacío donde almacenaremos los ciclos,
  // para ello seleccionamos todos los input que tengan como name "ciclo[]":
  var ciclosSeleccionados = [];
  var checkboxes = document.querySelectorAll('input[name="ciclo[]"]:checked');
  // Bucle para añadir el valor de los ciclos de los input:
  for (var i = 0; i < checkboxes.length; i++) {
    ciclosSeleccionados.push(checkboxes[i].value);
  }

  // Inicializamos una variable a true para controlar
  // que se van comprobando los input uno a uno en vez de que salgan
  // todos los errores a la vez:
  let estado = true;

  /* --------------- Comprobamos todos los campos tanto para que no estén vacíos, como para que cumplan unas pautas determinadas.
    ------------------ En caso de error mostrará una alerta, se detendrá el evento y añadirá una clase, la cual marcará el input en el que está el error. --------------- */

  // Bucle para comprobar que no haya ningún campo vacío:
  for (var j = 0; j < inputs.length; j++) {
    if (inputs[j].value === "") {
      Swal.fire("Error", "Rellena todos los campos", "error");
      estado = false;
      inputs[j].classList.add("errorInput", "form-control");
      event.preventDefault();
    } else {
      inputs[j].classList.remove("errorInput");
    }
  }

  // Condicional para comprobar el DNI, a través de una función específica:
  if (!validarDNI(dni.value)) {
    if (estado) {
      Swal.fire("Error", "Debes introducir un DNI correcto", "error");
      dni.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar que haya algún ciclo seleccionado,
  // a través de la cantidad de elementos que haya en el array:
  else if (ciclosSeleccionados.length === 0) {
    if (estado) {
      Swal.fire("Error", "Debes seleccionar mínimo un ciclo", "error");
      checkboxes.forEach(function (checkbox) {
        checkbox.classList.add("errorCheckBox");
      });
      event.preventDefault();
    }
  }
  // Condicional para comprobar el Código Postal a través de un patrón:
  else if (!validarForm(CP.value, /^(0[1-9]|[1-4]\d|5[0-2])\d{3}$/)) {
    if (estado) {
      Swal.fire("Error", "Debes introducir un Código Postal correcto", "error");
      CP.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar el CIF a través de un patrón:
  else if (!validarForm(CIF.value, /^[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J]$/)) {
    if (estado) {
      Swal.fire("Error", "Debes introducir un CIF correcto", "error");
      CIF.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar que la provincia introducida corresponda con el CIF introducido,
  // a través de una función específica:
  else if (!validarProvinciaCIF(CIF.value, provincia.value)) {
    if (estado) {
      Swal.fire(
        "Error",
        "El CIF no corresponde con la provincia introducida",
        "error"
      );
      CIF.classList.add("errorInput", "form-control");
      provincia.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar el teléfono a través de un patrón:
  else if (!validarForm(telefono.value, /^(\+34|0034|34)?[6|7|9][0-9]{8}$/)) {
    if (estado) {
      Swal.fire(
        "Error",
        "Debes introducir un número de teléfono correcto",
        "error"
      );
      telefono.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar que no se han introducido teléfonos duplicados,
  // a través de una función específica:
  else if (!validarDuplicados(inputsTlf)) {
    if (estado) {
      Swal.fire(
        "Error",
        "Debes introducir distintos números de teléfono",
        "error"
      );
      inputsTlf.forEach(function (input) {
        input.classList.add("errorInput", "form-control");
      });
      event.preventDefault();
    }
  }
  // Condicional para comprobar el correo a través de un patrón:
  else if (
    !validarForm(
      correo.value,
      /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    )
  ) {
    if (estado) {
      Swal.fire(
        "Error",
        "Debes introducir un correo electrónico correcto",
        "error"
      );
      correo.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar que no se han introducido correos duplicados,
  // a través de una función específica:
  else if (!validarDuplicados(inputsCorreo)) {
    if (estado) {
      Swal.fire(
        "Error",
        "Debes introducir distintos correos electrónicos",
        "error"
      );
      inputsCorreo.forEach(function (input) {
        input.classList.add("errorInput", "form-control");
      });
      event.preventDefault();
    }
  }
}

// Función para validar los campos de los formularios de editar y asignar alumnos a empresas:
function validarCamposAsignarEmpresa() {
  // Almacenamos en variables los elementos del formulario que vamos a validar,
  // a través del Id:
  var formulario = document.getElementById("formulario");
  var inputs = formulario.querySelectorAll("input:not(.inputAnexos)");
  var inicioBeca = document.getElementById("inicioBeca");
  var finBeca = document.getElementById("finBeca");

  // Inicializamos una variable a true para controlar
  // que se van comprobando los input uno a uno en vez de que salgan
  // todos los errores a la vez:
  var estado = true;

  // Bucle para comprobar que no haya ningún campo vacío:
  for (var j = 0; j < inputs.length; j++) {
    if (inputs[j].value === "") {
      Swal.fire("Error", "Rellena todos los campos", "error");
      estado = false;
      inputs[j].classList.add("errorInput", "form-control");
      event.preventDefault();
    } else {
      inputs[j].classList.remove("errorInput");
    }
  }

  // Condicional para comprobar que la fecha de inicio de la beca
  // es anterior a la fecha de fin de beca,
  // a través de una función específica:
  if (!validarFechasBeca(inicioBeca, finBeca)) {
    if (estado) {
      Swal.fire(
        "Error",
        "La fecha de Inicio de Beca no puede ser mayor a la de Fin de Beca",
        "error"
      );
      inicioBeca.classList.add("errorInput", "form-control");
      finBeca.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
}

// Función para validar los campos de los formularios de editar y crear alumnos:
function validarCamposAlumno() {
  var formulario = document.getElementById("formulario");
  var inputs = formulario.querySelectorAll("input");
  var dni = document.getElementById("dni");
  var correo = document.getElementById("correo");
  var tlf = document.getElementById("tlf");
  var CP = document.getElementById("CP");
  var anio = document.getElementById("anio");
  var fechaNac = document.getElementById("fechaNac");

  // Inicializamos una variable a true para controlar
  // que se van comprobando los input uno a uno en vez de que salgan
  // todos los errores a la vez:
  var estado = true;

  // Bucle para comprobar que no haya ningún campo vacío:
  for (var j = 0; j < inputs.length; j++) {
    if (inputs[j].value === "") {
      Swal.fire("Error", "Rellena todos los campos", "error");
      inputs[j].classList.add("errorInput", "form-control");
      event.preventDefault();
      estado = false;
    } else {
      inputs[j].classList.remove("errorInput");
    }
  }

  // Condicional para comprobar el DNI, a través de una función específica:
  if (!validarDNI(dni.value)) {
    if (estado) {
      Swal.fire("Error", "Debes introducir un DNI correcto", "error");
      dni.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar el correo a través de un patrón:
  else if (
    !validarForm(
      correo.value,
      /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    )
  ) {
    if (estado) {
      Swal.fire("Error", "Debes introducir un correo correcto", "error");
      correo.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar el teléfono a través de un patrón:
  else if (!validarForm(tlf.value, /^(\+34|0034|34)?[6|7|9][0-9]{8}$/)) {
    if (estado) {
      Swal.fire(
        "Error",
        "Debes introducir un número de teléfono correcto",
        "error"
      );
      tlf.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar el código postal a través de un patrón:
  else if (!validarForm(CP.value, /^(0[1-9]|[1-4]\d|5[0-2])\d{3}$/)) {
    if (estado) {
      Swal.fire("Error", "Debes introducir un código postal correcto", "error");
      CP.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar el año a través de un patrón:
  else if (!validarForm(anio.value, /^\d{4}$/)) {
    if (estado) {
      Swal.fire("Error", "Debes introducir un año correcto", "error");
      anio.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
  // Condicional para comprobar la fecha de nacimiento, a través de una función específica:
  else if (!validarFechaNac(fechaNac.value)) {
    if (estado) {
      Swal.fire(
        "Error",
        "La fecha de nacimiento introducida no es correcta, el alumno tiene que tener minimo 16 años",
        "error"
      );
      fechaNac.classList.add("errorInput", "form-control");
      event.preventDefault();
    }
  }
}

// Función para añadir los input de añadir teléfono o añadir correo,
// pasándole como parámetro el elemento deseado:
function añadir(elemento) {
  // Almacenamos en variables los div que hay antes y despues de donde irán los nuevos,
  // esto se hace para que se creen entre el input que aparece por defecto y los botones de añadir y eliminar:
  var anterior = document.getElementById("anterior" + elemento);
  var posterior = document.getElementById("posterior" + elemento);

  // Creamos el div nuevo, con un id y una clase determinada:
  var divCol = document.createElement("div");
  var id = "div" + elemento;
  divCol.setAttribute("id", id);
  divCol.classList.add("col-lg-4", "col-md-6", "col-sm-12");

  // Creamos el label, con un for y una clase determinada:
  var label = document.createElement("label");
  label.setAttribute("for", elemento);
  label.classList.add("form-label", "datos");

  // Creamos un input con un name, un id y una clase determinada:
  var input = document.createElement("input");
  // Añadimos [] para que en caso de que haya varios se almacene el name en un array,
  // y así poder acceder a ellos:
  var name = elemento + "[]";
  input.setAttribute("name", name);
  input.setAttribute("id", elemento);
  input.classList.add("form-control");

  // Condicional para comprobar el tipo de dato que tendrá el input y
  // el texto que añadiremos al label dependiendo del parámetro introducido:
  if (elemento == "telefono") {
    label.textContent = "Número de teléfono: ";
    input.setAttribute("type", "number");
  } else {
    label.textContent = "Correo electrónico: ";
    input.setAttribute("type", "text");
  }

  // Añadimos el label y el input en el que meteremos los datos
  // dentro del div creado anteriormente para que salgan en columna:
  divCol.appendChild(label);
  divCol.appendChild(input);

  // Insertamos el div entre los dos div anteriores para que estén en el lugar deseado
  // (entre el input por defecto y los botones de añadir y eliminar):
  anterior.parentNode.insertBefore(divCol, posterior);
}

// Función para eliminar los elementos, según el parámetro
// (correo o teléfono):
function eliminar(elemento) {
  // Condicional para comprobar el elemento pasado por parámetro,
  // accederemos al último div introducido, a través del id,
  // y en caso de que exista lo eliminamos:
  if (elemento == "correo") {
    var divCorreos = document.querySelectorAll("#divcorreo");
    var divCorreo = divCorreos[divCorreos.length - 1];

    if (divCorreo) {
      divCorreo.remove();
    }
  } else if (elemento == "telefono") {
    var divTelefonos = document.querySelectorAll("#divtelefono");
    var divTLF = divTelefonos[divTelefonos.length - 1];
    if (divTLF) {
      divTLF.remove();
    }
  }
}

// Función para validar que no haya varios correos o teléfonos
// (dependiendo del valor introducido por parámetro) duplicados:
function validarDuplicados(elementos) {
  // Bucle para recorrer todos los elementos:
  for (var i = 0; i < elementos.length; i++) {
    // Añadimos los valores en una variable:
    var valorActual = elementos[i].value;

    // Bucle para recorrer los elementos e ir comprobando
    // que el elemento guardado en la variable anterior no se repite:
    for (var j = i + 1; j < elementos.length; j++) {
      // Valor a comparar
      var valorComparacion = elementos[j].value;

      // En caso de que sean iguales devuelve false:
      if (valorActual == valorComparacion) {
        return false;
      }
    }
  }

  // Devolve true si no hay ningún duplicado:
  return true;
}

// Función para validar el DNI pasado por parámetro:
function validarDNI(dni) {
  // Almacenamos en una variable la letra:
  var letra = dni.substr(-1);

  // Almacenamos en una variable todos los números:
  var numeros = dni.substr(0, dni.length - 1);

  // Calculamos el resto para ver que letra le pertenece:
  var resto = numeros % 23;

  // Almacenamos las posibles letras que puede tener un DNI español:
  var letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";

  // Verificamos que la letra valida esté entre las posibilidades:
  var letraValida = letrasValidas.charAt(resto);

  // Condicional para ver que la letra que le corresponde a los dígitos introducidos
  // sea igual a la que hemos introducido.
  // Retornamos true en caso de que vaya bien y si no false:
  if (letraValida === letra) {
    return true;
  } else {
    return false;
  }
}

// Función para validar que los datos introducidos,
// a través de un parámetro:
function validarForm(dato, patron) {
  return patron.test(dato);
}

// Función para validar que la provincia introducida
// corresponda con el CIF introducido:
function validarProvinciaCIF(CIF, provincia) {
  // Almacenamos en un array las provincias,
  // pasándoles como valor los dígitos que les corresponden:
  var provinciasCIF = {
    "00": "No Residente",
    "01": "Álava",
    "02": "Albacete",
    "03": "Alicante",
    53: "Alicante",
    54: "Alicante",
    "04": "Almería",
    "05": "Ávila",
    "06": "Badajoz",
    "07": "Islas Baleares",
    57: "Islas Baleares",
    "08": "Barcelona",
    58: "Barcelona",
    59: "Barcelona",
    60: "Barcelona",
    61: "Barcelona",
    62: "Barcelona",
    63: "Barcelona",
    64: "Barcelona",
    65: "Barcelona",
    66: "Barcelona",
    68: "Barcelona",
    "09": "Burgos",
    10: "Cáceres",
    11: "Cádiz",
    72: "Cádiz",
    12: "Castellón",
    13: "Ciudad Real",
    14: "Córdoba",
    56: "Córdoba",
    15: "La Coruña",
    70: "La Coruña",
    16: "Cuenca",
    17: "Gerona",
    55: "Gerona",
    67: "Gerona",
    18: "Granada",
    19: "Guadalajara",
    20: "Guipúzcoa",
    71: "Guipúzcoa",
    21: "Huelva",
    22: "Huesca",
    23: "Jaén",
    24: "León",
    25: "Lérida",
    26: "La Rioja",
    27: "Lugo",
    28: "Madrid",
    78: "Madrid",
    79: "Madrid",
    80: "Madrid",
    81: "Madrid",
    82: "Madrid",
    83: "Madrid",
    84: "Madrid",
    85: "Madrid",
    86: "Madrid",
    87: "Madrid",
    88: "Madrid",
    29: "Málaga",
    92: "Málaga",
    93: "Málaga",
    30: "Murcia",
    73: "Murcia",
    31: "Navarra",
    32: "Orense",
    33: "Asturias",
    74: "Asturias",
    34: "Palencia",
    35: "Las Palmas",
    75: "Las Palmas",
    36: "Pontevedra",
    94: "Pontevedra",
    37: "Salamanca",
    38: "Santa Cruz de Tenerife",
    76: "Santa Cruz de Tenerife",
    39: "Cantabria",
    40: "Segovia",
    41: "Sevilla",
    90: "Sevilla",
    91: "Sevilla",
    42: "Soria",
    43: "Tarragona",
    77: "Tarragona",
    44: "Teruel",
    45: "Toledo",
    46: "Valencia",
    96: "Valencia",
    97: "Valencia",
    98: "Valencia",
    47: "Valladolid",
    48: "Vizcaya",
    95: "Vizcaya",
    49: "Zamora",
    50: "Zaragoza",
    99: "Zaragoza",
    51: "Ceuta",
    52: "Melilla",
  };

  // Cogemos los 2 dígitos del CIF introducido:
  var codigoProvincia = CIF.substr(1, 2);

  // Condicional para comprobar que el array contiene los 2 dígitos del CIF y
  // que la provincia tenga como identificador en el array los 2 dígitos del CIF.
  // Retornamos true en caso de que se cumpla la condición:
  if (
    provinciasCIF.hasOwnProperty(codigoProvincia) &&
    provinciasCIF[codigoProvincia] == provincia
  ) {
    return true;
  } else {
    return false;
  }
}

// Función para validar que la fecha de inicio de beca sea menor que la de fin de beca:
function validarFechasBeca(inicioBeca, finBeca) {
  // Condicional para ver que el valor de inicio de beca es menor
  // que el valor de la fecha de fin de beca.
  // Retornamos false en caso de que sea mayor, si no false:
  if (inicioBeca.value > finBeca.value) {
    return false;
  } else {
    return true;
  }
}

// Función para validar la fecha de nacimiento.
// Esto lo hacemos para que mínimo el alumno tenga 15 años
// (edad mínima para acceder al FPB en España):
function validarFechaNac(fechaNac) {
  // Almacenamos en una variable la fecha actual:
  var fechaActual = new Date();

  // Almacenamos en una variable la fecha de nacimiento,
  // convirtiendo la cadena de texto que pasamos por parámetro en una fecha:
  var fechaNacimiento = new Date(Date.parse(fechaNac));

  // Calculamos la edad:
  var edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();

  // Condicional para ver si la edad es mayor que 15,
  // si se cumple retornamos true:
  if (edad > 15) {
    return true;
  }
  // En caso de que tenga justo 15 años, comprobamos si los cumple justo ese año:
  else if (edad === 15) {
    // Obtenemos la fecha actual completa:
    var fechaCompleta = new Date(
      fechaActual.getFullYear(),
      fechaActual.getMonth(),
      fechaActual.getDate()
    );

    // Almacenamos en una variable la fecha en la que cumpliriamos años:
    var cumpleanios15 = new Date(
      fechaNacimiento.getFullYear() + 15,
      fechaNacimiento.getMonth(),
      fechaNacimiento.getDate()
    );

    // Condicional para ver que la fecha en la que cumple años está dentro del año actual.
    // Retornamos true en caso de que se cumpla:
    if (fechaCompleta >= cumpleanios15) {
      return true;
    }
  }

  // Retornamos false en caso de que no tenga 15 años o no los cumpla este año:
  return false;
}
