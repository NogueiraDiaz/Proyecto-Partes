// Almacenamos en variable la tabla y al elemento de paginación:
var contenedorTabla = document.getElementById("contenedor-tabla");
var buscador = document.getElementById("buscador");

// Función para paginar el contenido:
function paginarContenido(url, registrosPorPagina) {
  // Inicializamos una variable para identificar la página actual:
  let paginaActual = 1;

  // Función para cargar el contenido:
  function cargarContenido(pagina) {
    // Retornamos una promesa:
    return new Promise((resolve, reject) => {
      // Accedemos a los datos pasándole al fetch la URL:
      fetch(`${url}`)
        .then((response) => response.json())
        .then((data) => {
          // Almacenamos los datos relacionados con las empresas:
          var empresas = data.empresas;

          // Almacenamos los datos relacionados con las empresas que estén asignadas:
          var idsEmpresas = data.idsEmpresas;

          // Filtramos para buscar por nombre o por código de empresa
          // y lo concatenamos:
          const nombreBuscador = empresas.filter((emp) =>
            emp.NOMBRE_EMPRESA.match(buscador.value)
          );
          const codigoBuscador = empresas.filter((emp) =>
            emp.COD_EMPRESA.match(buscador.value)
          );
          const resultados = nombreBuscador.concat(codigoBuscador);

          // Cogemos los elementos que vamos a mostrar por pagina:
          const primerosElementos = resultados.slice(
            (pagina - 1) * registrosPorPagina,
            pagina * registrosPorPagina
          );
          const todo = empresas.slice(
            (pagina - 1) * registrosPorPagina,
            pagina * registrosPorPagina
          );

          // Vaciamos la tabla donde mostraremos los datos:
          contenedorTabla.innerHTML = "";

          // Condicional para ver si se ha hecho una búsqueda:
          if (buscador.value == "") {
            // Si no se ha introducido nada en el buscador,
            // recorremos el array donde están todos los datos de las empresas:
            todo.forEach((item) => {
              // Creamos una fila:
              const fila = document.createElement("tr");

              // Construir las celdas de la fila con los datos recibidos,
              // le pasamos lo que queremos mostrar y una clase determinada:
              celdas(item.COD_EMPRESA, fila);
              celdas(item.TIPO, fila);
              celdas(item.RESPO_EMPRESA, fila);
              celdas(item.DNI_RESPONSABLE, fila);
              celdas(item.NOMBRE_EMPRESA, fila);
              celdas(item.LOCALIDAD_EMPRESA, fila);
              celdas(item.PROVINCIA_EMPRESA, fila);
              celdas(item.DIRECC_EMPRESA, fila);
              celdas(item.CP_EMPRESA, fila);
              celdas(item.CIF_EMPRESA, fila);
              celdas(item.LOCALIDAD_FIRMA, fila);
              celdas(item.FECHA_FIRMA, fila);
              if (
                typeof item.ANEXO_0 === "object" ||
                typeof item.ANEXO_0A === "object" ||
                typeof item.ANEXO_0B === "object" ||
                typeof item.ANEXO_XVI === "object"
              ) {
                celdas("", fila);
                celdas("", fila);
                celdas("", fila);
                celdas("", fila);
              } else {
                celdas(
                  item.ANEXO_0.split("/")[item.ANEXO_0.split("/").length - 1],
                  fila
                );
                celdas(
                  item.ANEXO_0A.split("/")[item.ANEXO_0A.split("/").length - 1],
                  fila
                );
                celdas(
                  item.ANEXO_0B.split("/")[item.ANEXO_0B.split("/").length - 1],
                  fila
                );
                celdas(
                  item.ANEXO_XVI.split("/")[
                    item.ANEXO_XVI.split("/").length - 1
                  ],
                  fila
                );
              }

              // Creamos la celda para el botón de editar:
              const celdaEditar = document.createElement("td");

              // Creamos el enlace y le especificamos
              // la dirección, la clase y el texto que queremos mostrar:
              const enlaceEditar = document.createElement("a");
              enlaceEditar.href =
                "editarEmpresa.php?COD_EMPRESA=" + item.COD_EMPRESA;
              enlaceEditar.className = "btn botones";
              enlaceEditar.textContent = "Editar";

              // Agregamos el enlace a la celda:
              celdaEditar.appendChild(enlaceEditar);
              fila.appendChild(celdaEditar);

              // Verificamos si el COD_EMPRESA está en idsEmpresas:
              var linkEliminar = idsEmpresas.includes(item.COD_EMPRESA);

              // Creamos el botón de eliminar para cuando la empresa esté asignada:
              const eliminar = document.createElement("div");
              eliminar.className = "deselected btn btn-secondary";

              // Creamos un span para mostrar en caso de que la empresa esté asignada:
              const spanElement = document.createElement("span");
              spanElement.className = "texto-deselected";
              spanElement.textContent = "Hay alumnos asignados";

              // Le añadimos el texto a mostrar y el span:
              eliminar.appendChild(document.createTextNode("Eliminar"));
              eliminar.appendChild(spanElement);

              // Creamos el botón de eliminar, donde le pondremos el texto a mostrar,
              // una clase determinada y la dirección para eliminar la empresa seleccionada:
              const aElement = document.createElement("a");
              aElement.href = "eliminar.php?COD_EMPRESA=" + item.COD_EMPRESA;
              aElement.className = "btn btn-danger";
              aElement.textContent = "Eliminar";

              // Creamos una nueva celda, donde meteremos el botón:
              const celda17 = document.createElement("td");

              // En caso de que la empresa está asignada, añadimos a la celda el botón deshabilitado:
              if (linkEliminar) {
                celda17.appendChild(eliminar);
              }
              // Si no está asignada añadimos a la celda el botón de eliminar habilitado:
              else {
                celda17.appendChild(aElement);
              }

              // Añadimos la celda a la fila:
              fila.appendChild(celda17);

              // Añadimos la fila a la tabla:
              contenedorTabla.appendChild(fila);
            });
          }
          // En caso de que el buscador no contenga nada recorremos el array
          // que contiene todos los datos de las empresas:
          else {
            primerosElementos.forEach((item) => {
              // Creamos una fila:
              const fila = document.createElement("tr");

              // Construir las celdas de la fila con los datos recibidos,
              // le pasamos lo que queremos mostrar y una clase determinada:
              celdas(item.COD_EMPRESA, fila);
              celdas(item.TIPO, fila);
              celdas(item.RESPO_EMPRESA, fila);
              celdas(item.DNI_RESPONSABLE, fila);
              celdas(item.NOMBRE_EMPRESA, fila);
              celdas(item.LOCALIDAD_EMPRESA, fila);
              celdas(item.PROVINCIA_EMPRESA, fila);
              celdas(item.DIRECC_EMPRESA, fila);
              celdas(item.CP_EMPRESA, fila);
              celdas(item.CIF_EMPRESA, fila);
              celdas(item.LOCALIDAD_FIRMA, fila);
              celdas(item.FECHA_FIRMA, fila);
              if (
                typeof item.ANEXO_0 === "object" ||
                typeof item.ANEXO_0A === "object" ||
                typeof item.ANEXO_0B === "object" ||
                typeof item.ANEXO_XVI === "object"
              ) {
                celdas("", fila);
                celdas("", fila);
                celdas("", fila);
                celdas("", fila);
              } else {
                celdas(
                  item.ANEXO_0.split("/")[item.ANEXO_0.split("/").length - 1],
                  fila
                );
                celdas(
                  item.ANEXO_0A.split("/")[item.ANEXO_0A.split("/").length - 1],
                  fila
                );
                celdas(
                  item.ANEXO_0B.split("/")[item.ANEXO_0B.split("/").length - 1],
                  fila
                );
                celdas(
                  item.ANEXO_XVI.split("/")[
                    item.ANEXO_XVI.split("/").length - 1
                  ],
                  fila
                );
              }

              // Creamos la celda para el botón de editar:
              const celdaEditar = document.createElement("td");

              // Creamos el enlace y le especificamos
              // la dirección, la clase y el texto que queremos mostrar:
              const enlaceEditar = document.createElement("a");
              enlaceEditar.href =
                "editarEmpresa.php?COD_EMPRESA=" + item.COD_EMPRESA;
              enlaceEditar.className = "btn botones";
              enlaceEditar.textContent = "Editar";

              // Agregamos el enlace a la celda:
              celdaEditar.appendChild(enlaceEditar);
              fila.appendChild(celdaEditar);

              // Verificamos si el COD_EMPRESA está en idsEmpresas:
              var linkEliminar = idsEmpresas.includes(item.COD_EMPRESA);

              // Creamos el botón de eliminar para cuando la empresa esté asignada:
              const eliminar = document.createElement("div");
              eliminar.className = "deselected btn btn-secondary";

              // Creamos un span para mostrar en caso de que la empresa esté asignada:
              const spanElement = document.createElement("span");
              spanElement.className = "texto-deselected";
              spanElement.textContent = "Hay alumnos asignados";

              // Le añadimos el texto a mostrar y el span:
              eliminar.appendChild(document.createTextNode("Eliminar"));
              eliminar.appendChild(spanElement);

              // Creamos el botón de eliminar, donde le pondremos el texto a mostrar,
              // una clase determinada y la dirección para eliminar la empresa seleccionada:
              const aElement = document.createElement("a");
              aElement.href = "eliminar.php?COD_EMPRESA=" + item.COD_EMPRESA;
              aElement.className = "btn btn-danger";
              aElement.textContent = "Eliminar";

              // Creamos una nueva celda, donde meteremos el botón:
              const celda17 = document.createElement("td");

              // En caso de que la empresa está asignada, añadimos a la celda el botón deshabilitado:
              if (linkEliminar) {
                celda17.appendChild(eliminar);
              }
              // Si no está asignada añadimos a la celda el botón de eliminar habilitado:
              else {
                celda17.appendChild(aElement);
              }

              // Añadimos la celda a la fila:
              fila.appendChild(celda17);

              // Añadimos la fila a la tabla:
              contenedorTabla.appendChild(fila);
            });
          }

          // Resolvemos la promesa:
          resolve();
        })
        // En caso de que el fetch vaya mal:
        .catch((error) => {
          // Rechazamos la promesa:
          reject(error);
        });
    });
  }

  // Función para actualizar la página:
  function actualizarPaginacion() {
    // Retornamos una promesa:
    return new Promise((resolve, reject) => {
      // Utilizamos fetch para acceder a los datos de las empresas:
      fetch(`${url}`)
        .then((response) => response.json())
        .then((data) => {
          // Almacenamos en una variable la longitud del array
          // que contiene los datos de las empresas:
          const totalRegistros = data.empresas.length;

          // Calculamos el total de páginas que tenemos que mostrar:
          const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);

          // Accedemos al menú de paginación y lo vaciamos:
          const paginationList = document.getElementById("pagination-list");
          paginationList.innerHTML = "";

          // Construir el botón para ir a la página anterior
          // y le añadimos la función necesaria:
          const botonAnterior = document.createElement("a");
          botonAnterior.textContent = "Anterior";
          botonAnterior.href = "#";
          botonAnterior.classList.add("page-link");
          botonAnterior.addEventListener("click", (event) => {
            event.preventDefault();
            // En caso de que la página en la que estamos es mayor a 1 (la principal),
            // volveríamos a la página anterior:
            if (paginaActual > 1) {
              paginaActual--;
              // Cargamos el contenido en la página que corresponde:
              cargarContenido(paginaActual)
                .then(() => {
                  // Actualizamos la paginación:
                  actualizarPaginacion();
                })
                .catch((error) => {
                  // En caso de error:
                  console.error("Error al cargar los datos:", error);
                });
            }
          });

          // Creamos un elemento para la lista y lo añadimos al menú de paginación:
          const listItemAnterior = document.createElement("li");
          listItemAnterior.classList.add("page-item");
          listItemAnterior.appendChild(botonAnterior);
          paginationList.appendChild(listItemAnterior);

          // Bucle para crear los botones de paginación dependiendo del total de páginas que haya:
          for (let i = 1; i <= totalPaginas; i++) {
            // Creamos el enlace y le añadimos la función:
            const enlace = document.createElement("a");
            enlace.textContent = i;
            enlace.href = "#";
            enlace.classList.add("page-link");
            enlace.addEventListener("click", (event) => {
              event.preventDefault();
              // LLamamos a la función pasándole la página en la que estamos:
              cargarContenido(i)
                .then(() => {
                  // Actualizamos la paginación:
                  actualizarPaginacion();
                })
                .catch((error) => {
                  // En caso de error:
                  console.error("Error al cargar los datos:", error);
                });
            });

            // Creamos los elementos para la lista y los añadimos al menú de paginación:
            const listItem = document.createElement("li");
            listItem.classList.add("page-item");
            listItem.appendChild(enlace);
            paginationList.appendChild(listItem);
          }

          // Construir el botón para ir a la página siguiente
          // y le añadimos la función necesaria:
          const botonSiguiente = document.createElement("a");
          botonSiguiente.textContent = "Siguiente";
          botonSiguiente.href = "#";
          botonSiguiente.classList.add("page-link");
          botonSiguiente.addEventListener("click", (event) => {
            event.preventDefault();
            // En caso de que la página en la que estamos sea menor que el total de páginas que haya,
            // pasaríamos a la siguiente página:
            if (paginaActual < totalPaginas) {
              paginaActual++;
              cargarContenido(paginaActual)
                .then(() => {
                  // Actualizamos la paginación:
                  actualizarPaginacion();
                })
                .catch((error) => {
                  // En caso de error:
                  console.error("Error al cargar los datos:", error);
                });
            }
          });

          // Creamos un elemento para la lista y lo añadimos al menú de paginación:
          const listItemSiguiente = document.createElement("li");
          listItemSiguiente.classList.add("page-item");
          listItemSiguiente.appendChild(botonSiguiente);
          paginationList.appendChild(listItemSiguiente);

          // Resolvemos la promesa:
          resolve();
        })
        // En caso de que el fetch vaya mal:
        .catch((error) => {
          // Rechazamos la promesa:
          reject(error);
        });
    });
  }

  // Función para cargar el contenido en la página inicial:
  cargarContenido(paginaActual)
    .then(() => {
      // Retornamos función para actualizar la paginación
      return actualizarPaginacion();
    })
    .catch((error) => {
      // Mostramos un mensaje en caso de error:
      console.error("Error al cargar los datos:", error);
    });
}

// Llamamos a la función para mostrar todo, pasándole como parámetros la URL y el número de empresas que queremos mostrar por pantalla:
paginarContenido(
  "http://localhost:3000/Proyecto%20Julio%20Verne/gestion_practicas/php%20ayuda/Funciones/datosEmpresas.php",
  6
);
// Le añadimos la función al input que hace de buscador, pasándole como parámetros la URL y el número de empresas que queremos mostrar por pantalla:
buscador.addEventListener("input", function () {
  paginarContenido(
    "http://localhost:3000/Proyecto%20Julio%20Verne/gestion_practicas/php%20ayuda/Funciones/datosEmpresas.php",
    6
  );
});

function celdas(texto, fila) {
  const celda = document.createElement("td");
  celda.textContent = texto;
  celda.classList.add("listaEmpresa");
  fila.appendChild(celda);
}
