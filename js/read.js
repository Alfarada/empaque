import { ajax } from "./xhr.js";
import { renderTable } from "./table.js";
import { renderPaginate } from "./pagination.js";

let $crudTable = document.querySelector(".crud_table"),
  $table = document.querySelector(".container-table"),
  $cardDescription = document.querySelector(".empty-database"),
  $p = $cardDescription.querySelector("p"),
  $cardNotice = document.querySelector(".notice");

export const getAll = () => {
  ajax({
    url: "../api/registro.php",
    success: (res) => {
      responseHandler(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
};

const responseHandler = (res) => {
  // if the response is an empty array
  if (res.length === 0) {
    return showNotice();
  }

  // if the response is error
  if (res.error) {
    return error(res);
  }

  console.log('renderiza todos los elementos');
  renderElements(res);
};

// show the table and hide the warnings
const showElements = () => {
  
  $table.classList.remove("hide");                 // show table
  $cardNotice.classList.add("hide");               // hide notice

  // hide card with short description
  // when database is empty
  $cardDescription.classList.add("hide");
};

const renderElements = (res) => {
  showElements();
  renderTable(res);
  renderPaginate(res);
};


const showNotice = () => {
  let $cardContent = $cardNotice.querySelector(".card-content"),
    $h6 = $cardContent.querySelector("h6");

  $h6.textContent = "No hay registros en la base de datos.";

  // if the card notice is orange, it changes to red
  if ($cardNotice.matches(".orange")) {

    $cardNotice.classList.replace("orange","red");  // change color
    $cardNotice.classList.remove("hide");           // show card
    $table.classList.add("hide");                   // hide table

    // show card with short description
    // when database is empty
    $cardDescription.classList.remove("hide");

  } else {
    $cardNotice.classList.add("red");               // add color
    $cardNotice.classList.remove("hide");           // show card
    $table.classList.add("hide");                   // hide table

    // show card with short description
    // when database is empty
    $cardDescription.classList.remove("hide");
  }
};

const error = (res) => {
  if (res.error)
    return console.error(`Error en los datos provenientes del servidor ${res}`);
};
