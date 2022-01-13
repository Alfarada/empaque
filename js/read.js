import { ajax } from "./xhr.js";
import { renderTable } from "./table.js";
import { renderPaginate } from "./pagination.js";

let $crudTable = document.querySelector(".crud_table"),
  $table = document.querySelector(".container-table"),
  $shortDescription = $table.querySelector(".short-description"),
  // $cardDescription = document.querySelector(".empty-database"),
  $cardNotice = document.querySelector(".notice");

export const getBoxesWithLogo = () => {
  ajax({
    url: "../api/BoxesWithLogo.php",
    success: (res) => {

      
      if (localStorage.length === 0) {
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      } else if (localStorage.length !== 0) {
        localStorage.removeItem("with_out_logo");
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      } else {
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      }
      
      responseHandler(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
};

export const getBoxesWithOutLogo = () => {
  ajax({
    url: "../api/BoxesWithOutLogo.php",
    success: (res) => {
      
      if (localStorage.length === 0) {
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      } else if (localStorage.length !== 0) {
        localStorage.removeItem("with_out_logo");
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      } else {
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      }

      responseHandler(res);
    },
    error: (err) => {
      console.log(err);
    },
  });
}

export const responseHandler = (res) => {
  // if the response is an empty array
  if (res.length === 0) {
    return showNotice();
  }

  // if the response is error
  if (res.error) {
    return error(res);
  }

  renderElements(res);
};

// show the table and hide the warnings
const showElements = () => {

  $cardNotice.classList.add("hide");          // hide notice
  $shortDescription.classList.add("hide");    // hide short description
  $crudTable.classList.remove("hide");        // show crud table

};

const renderElements = (res) => {
  showElements();
  renderTable(res);
  renderPaginate(res);
};

//  Show card notice and hide/show crud table
const showNotice = () => {
  let $cardContent = $cardNotice.querySelector(".card-content"),
    $h6 = $cardContent.querySelector("h6");

  $h6.textContent = "No hay registros en la base de datos.";

  $shortDescription.classList.remove("hide");       // hide short description

  // if the card notice is orange, it changes to red
  if ($cardNotice.matches(".orange")) {

    $cardNotice.classList.replace("orange","red");  // change color
    $cardNotice.classList.remove("hide");           // show card
    $crudTable.classList.add("hide");               // hide table
    // $table.classList.add("hide");                   // hide table

    // and with short description
    // when database is empty
    // $cardDescription.classList.remove("hide");

  } else {
    $cardNotice.classList.add("red");               // add color
    $cardNotice.classList.remove("hide");           // show card
    $crudTable.classList.add("hide");               // hide table
    // $table.classList.add("hide");                // hide table

    // with short description
    // when database is empty
    // $cardDescription.classList.remove("hide");
  }
};

const error = (res) => {
  if (res.error)
    return console.error(`Error en los datos provenientes del servidor ${res}`);
};
