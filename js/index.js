import { ajax } from "./xhr.js";
import { getLogoBoxes, getBoxesWithOutLogo } from "./read.js";
import { renderPaginate } from "./pagination.js";
import { renderTable } from "./table.js";
import {
  validateInputs,
  showSuccessMessage,
  validateResponse,
} from "./validation.js";
import { resetForm, removeButtonToCancelEdit } from "./helpers.js";

// ====================  get all records =======================
document.addEventListener("DOMContentLoaded", getLogoBoxes);

// ===================== pagination =============================

document.addEventListener("click", (e) => {
  // paginate content 1,2,3 ...
  if (e.target.textContent && e.target.localName == "a") {
    ajax({
      url: `../api/BoxesWithLogo.php?pagina=${e.target.textContent}`,
      success: (res) => {
        renderTable(res);
        renderPaginate(res);
      },
      error: () => {
        console.log("error al renderizar la paginacion");
      },
    });
  }

  // arrow right
  let $pagination = document.querySelector(".pagination");

  if (e.target.classList.contains("next") && e.target.localName == "i") {
    if (e.target.name <= $pagination.childElementCount - 3) {
      ajax({
        url: `../api/BoxesWithLogo.php?pagina=${e.target.name + 1}`,
        success: (res) => {
          renderTable(res);
          renderPaginate(res);
        },
        error: () => {
          console.log("error al renderizar la paginacion");
        },
      });
    } else {
      return false;
    }
  }
  // arrow left
  if (e.target.classList.contains("back") && e.target.localName == "i") {
    if (e.target.name >= 2) {
      ajax({
        url: `../api/BoxesWithLogo.php?pagina=${e.target.name - 1}`,
        success: (res) => {
          renderTable(res);
          renderPaginate(res);
        },
        error: () => {
          console.log("error al renderizar la paginacion");
        },
      });
    } else {
      return false;
    }
  }
});
// ==============================================================

// establecer valor de cero al input a la carga del documento
document.addEventListener("DOMContentLoaded", (e) => {
  let $input = document.querySelector(".logo");
  $input.setAttribute("value", 0);
});

// cambiar el estado al hacer click en el checkbox
document.addEventListener("click", (e) => {
  if (e.target.matches(".logo")) {
    if (e.target.checked) {
      return (e.target.value = 1);
    }
    e.target.value = 0;
  }
});

// ===================================================================================================
// logica para insertar registros en la bbdd

document.addEventListener("submit", (e) => {
  const $registry = e.target.registry.value.trim(),
    $ingress = e.target.ingress.value.trim(),
    $egrees = e.target.egrees.value.trim(),
    $stock = e.target.stock.value.trim(),
    $logo = e.target.logo.value.trim(),
    $id = e.target.id.value.trim(),
    $form = document.querySelector(".crud_form"),
    $alert = document.querySelector(".alert-container");

  let isItValid = validateInputs($ingress, $egrees, $stock, $logo, $registry);

  if (e.target === $form) {
    e.preventDefault();

    if (!e.target.id.value) {
      if (isItValid) {
        ajax({
          url: "../api/Create.php",
          method: "POST",
          success: (res) => {
            validateResponse(res);
            getLogoBoxes();
            resetForm();
            showSuccessMessage();
          },
          error: (res) => {
            console.log(`Error al enviar los datos ${res}`);
          },
          data: `ingress=${$ingress}&egrees=${$egrees}&stock=${$stock}&logo=${$logo}&registry=${$registry}`,
        });
      } else {
        // TODO Crear un metodo manejador de mensajes de error y exito
        // =============================================================================
        let $span = $alert.querySelector("span"),
          $b = $span.querySelector("b");

        $alert.classList.remove("none");
        $b.textContent = "Porfavor rellene los campos correctamente.";

        setTimeout(() => {
          $alert.classList.add("none");
        }, 5000);
        // =============================================================================
      }
    } else {
      // UPDATE REGISTER - EDITAR REGISTRO
      if (isItValid) {
        ajax({
          url: "../api/Update.php",
          method: "POST",
          success: (res) => {
            validateResponse(res);
            getLogoBoxes();
            resetForm();
            removeButtonToCancelEdit();
          },
          error: (res) => {
            console.log(`Error al enviar los datos ${res}`);
          },
          data: `id=${$id}&registry=${$registry}&ingress=${$ingress}&egrees=${$egrees}&stock=${$stock}&logo=${$logo}`,
        });
      }
    }
  }
});

// ============================================================================================

// ================= destroy button to cancel edit ==============================================

// listener for when user presses cancel button

document.addEventListener("click", (e) => {
  let $title = document.querySelector(".crud_title"),
    $h5 = $title.querySelector("h5"),
    $form = document.querySelector(".crud_form"),
    $formEditButton = document.querySelector(".btn-reset");

  // if user press cancel edit button
  if (e.target.matches(".btn-reset")) {
    $h5.textContent = "Formulario";
    $form.submit.textContent = "Agregar";
    $form.registry.value = "";
    $form.ingress.value = "";
    $form.egrees.value = "";
    $form.stock.value = "";
    $form.id.value = "";
    $form.logo.value = 0;
    $form.logo.checked = false;

    // hide button to cancel edit
    $formEditButton.classList.add("none");
  }

  // if user press edit icon
  if (e.target.matches(".edit")) {
    $h5.textContent = "Editar registro";
    $form.submit.textContent = "Editar";
    $form.id.value = e.target.dataset.id;
    $form.registry.value = e.target.dataset.registry;
    $form.ingress.value = e.target.dataset.ingress;
    $form.egrees.value = e.target.dataset.egrees;
    $form.stock.value = e.target.dataset.stock;

    if (e.target.dataset.logo == 0) {
      $form.logo.value = 0;
      $form.logo.checked = false;
    } else {
      $form.logo.value = 1;
      $form.logo.checked = true;
    }

    // show button to cancel edit
    $formEditButton.classList.remove("none");
  }
});

// ====================================================================================
// logica para eliminar los registros de la bbdd
// ELIMINAR

document.addEventListener("click", (e) => {
  if (e.target.matches(".delete-icon")) {
    let $deleteIcon = document.querySelector(".delete-icon"),
      $modalContent = document.querySelector(".modal-content"),
      $modalFooter = document.querySelector(".modal-footer");

    $modalContent.querySelector("p").innerHTML = `
    Esta seguro de que quiere eliminar el siguiente registro:
    <table class="crud_table centered responsive-table">
      <thead>
        <tr>
          <th scope="col">fecha</th>
          <th scope="col">Ingreso</th>
          <th scope="col">Egreso</th>
          <th scope="col">Stock</th>
          <th scope="col">Logo</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>${$deleteIcon.dataset.registry}</td>
          <td>${$deleteIcon.dataset.ingress}</td>
          <td>${$deleteIcon.dataset.egrees}</td>
          <td>${$deleteIcon.dataset.stock}</td>
          <td>${$deleteIcon.dataset.logo == 1 ? "si" : "no"}</td>
          </tr>
          </tbody>
          </table>`;

    let $acceptButton = $modalFooter.querySelector(".accept-modal");
    $acceptButton.dataset.id = e.target.dataset.id;
  }
});

document.addEventListener("DOMContentLoaded", function (e) {
  var elems = document.querySelectorAll(".modal");
  var instances = M.Modal.init(elems);
});

document.addEventListener("click", (e) => {

  let $btnLogo = document.querySelector('.btn-logo');

  if (e.target.matches(".accept-modal")) {
    
    if ($btnLogo.classList.contains('is-actived')) {
      ajax({
        url: "../api/Delete.php",
        method: "POST",
        success: (res) => {
          validateResponse(res);
          getLogoBoxes();
        },
        error: (res) => {
          console.error("Error en eliminar el registro", res);
        },
        data: `id=${e.target.dataset.id}&logo=${1}`,
      });
    } else {

      ajax({
        url: "../api/Delete.php",
        method: "POST",
        success: (res) => {
          validateResponse(res);
          getBoxesWithOutLogo();
        },
        error: (res) => {
          console.error("Error en eliminar el registro", res);
        },
        data: `id=${e.target.dataset.id}&logo=${0}`,
      });
    }
  }

  if (e.target.matches(".modal-close.red.btn")) {
    location.reload();
  }
});

// ============  real-time calculator in the form =============

document.addEventListener("change", (e) => calHandler(e));
document.addEventListener("keyup", (e) => calHandler(e));

// calculator handler
const calHandler = (e) => {
  let $form = document.querySelector(".crud_form"),
    $table = document.querySelector(".crud_table"),
    $tbody = $table.querySelector("tbody"),
    $ingress = $form.ingress,
    $egrees = $form.egrees,
    $stock = $form.stock;

  // if changes match selectors
  if (e.target.matches(".ingress") || e.target.matches(".egrees")) {
    // calculating new stock value with old value
    const calAll = () => {
      let $tr = $tbody.querySelector("tr"),
        $oldStock = $tr.children[3].textContent,
        a = parseInt($ingress.value), // a = ingres.value
        b = parseInt($egrees.value),  // b = egrees.value
        c = parseInt($oldStock);      // c = oldStcok.value

      $stock.value = a - b + c;       // stock.value = result
    };

    // calculating stock value
    const calPartial = () => {
      let a = parseInt($ingress.value),
        b = parseInt($egrees.value);

      $stock.value = a - b;
    };

    // checking the existence of values ​​in the body table
    $tbody.firstElementChild ? calAll() : calPartial();
  }
};

// ============  real-time calculator in the form =============

// TODO !
document.addEventListener("click", (e) => {

  let $btnWithOutLogo = document.querySelector('.section_table').lastElementChild,
    $btnLogo = document.querySelector('.section_table').firstElementChild,
    $table = document.querySelector(".crud_table"),
    $tbody = $table.querySelector("tbody");

  const BTN_LOGO = '.btn-logo',
    BTN_WITHOUT_LOGO = '.btn-without-logo';

  // if the user clicks on the button " with logo "
  if (e.target.matches(BTN_LOGO) || e.target.matches(`${BTN_LOGO} *`)) {

    $btnWithOutLogo.classList.remove('is-actived');
    $btnWithOutLogo.classList.add('blue-text');

    $btnLogo.classList.add("is-actived");
    $btnLogo.classList.remove("blue-text");

    getLogoBoxes();

  }

  // if the user clicks on the button " without logo "
  if (e.target.matches(BTN_WITHOUT_LOGO) || e.target.matches(`${BTN_WITHOUT_LOGO} *`)) {

    $btnWithOutLogo.classList.add("is-actived");
    $btnWithOutLogo.classList.remove("blue-text");

    $btnLogo.classList.remove("is-actived");
    $btnLogo.classList.add("blue-text");

    getBoxesWithOutLogo();

  }

});
