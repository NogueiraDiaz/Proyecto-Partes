// obtiene una referencia al botón de opción "Profesor"
const profesorRadio = document.getElementById("profesorRadio");
// obtiene una referencia al botón de opción "Personal de Mantenimiento"
const personalRadio = document.getElementById("personalRadio");
// obtiene una referencia al botón de opción "Personal de Conserje"
const conserjeRadio = document.getElementById("conserjeRadio");
// obtiene una referencia al botón de opción "Personal de Mantenimiento"
// const adminRadio = document.getElementById("adminRadio");
// obtiene una referencia al elemento select que contiene la lista desplegable
const selectPersonal = document.getElementById("selectPersonal");
const selectTutor = document.getElementById("tutor");

// obtiene una referencia al elemento input para el código de delphos
const inputdelphos = document.getElementById("delphos");

// Agrego un controlador de eventos para el botón de opción "Profesor"
profesorRadio.addEventListener("click", function () {
  // verifica si el botón de opción "Profesor" está seleccionado

  if (profesorRadio.checked) {
    // muestra la lista desplegable
    selectPersonal.style.display = "block";
    inputdelphos.style.display = "block";
    selectTutor.style.display = "block";

  } else  if (personalRadio.checked) {
    // oculta la lista desplegable
    selectPersonal.style.display = "none";
    inputdelphos.style.display = "none";
    selectTutor.style.display = "none";

  } else  if (conserjeRadio.checked) {
    // oculta la lista desplegable
    selectPersonal.style.display = "none";
    inputdelphos.style.display = "none";
    selectTutor.style.display = "none";

  }
});



// Agrego un controlador de eventos para cuando pulsemos el boton de "Personal de Mantenimiento"
personalRadio.addEventListener("click", function () {
  // verifica si el botón de opción "Profesor" está seleccionado

  if (personalRadio.checked) {
     // oculta la lista desplegable
     selectPersonal.style.display = "none";
     inputdelphos.style.display = "none";
     selectTutor.style.display = "none";

  }  if (conserjeRadio.checked) {
    // oculta la lista desplegable
    selectPersonal.style.display = "none";
    inputdelphos.style.display = "none";
    selectTutor.style.display = "none";

 } else if (profesorRadio.checked){
    // muestra la lista desplegable
    selectPersonal.style.display = "block";
    inputdelphos.style.display = "block";
    selectTutor.style.display = "block";

  }
});

// Agrego un controlador de eventos para cuando pulsemos el boton de "Personal de Consejería"
conserjeRadio.addEventListener("click", function () {
  // verifica si el botón de opción "Profesor" está seleccionado

  if (personalRadio.checked) {
     // oculta la lista desplegable
     selectPersonal.style.display = "none";
     inputdelphos.style.display = "none";
     selectTutor.style.display = "none";

  }  if (conserjeRadio.checked) {
    // oculta la lista desplegable
    selectPersonal.style.display = "none";
    inputdelphos.style.display = "none";
    selectTutor.style.display = "none";

 } else if (profesorRadio.checked){
    // muestra la lista desplegable
    selectPersonal.style.display = "block";
    inputdelphos.style.display = "block";
    selectTutor.style.display = "block";

  }
});
