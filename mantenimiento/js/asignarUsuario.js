const InformáticaRadio = document.getElementById("InformáticaRadio");
const CentroRadio = document.getElementById("CentroRadio");
const selectProfesor = document.getElementById("selectProfesor");

InformáticaRadio.addEventListener("click", function () {
  if (InformáticaRadio.checked) {
    selectProfesor.style.display = "block";
  }
});

CentroRadio.addEventListener("click", function () {
  if (CentroRadio.checked) {
    selectProfesor.style.display = "none";
  }
});

const tipo_incidencia = document.getElementById("tipo_incidencia td");
console.log(tipo_incidencia);
