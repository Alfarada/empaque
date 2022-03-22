import { clearChildElements } from "./helpers.js";

const d = document,
  $table = d.querySelector(".crud_table"),
  $form = d.querySelector(".crud_form"),
  $title = d.querySelector(".crud_title"),
  $template = d.getElementById("crud_template").content,
  $fragment = d.createDocumentFragment();

// clears all child elements of the table body
const clearAllChildElements = (element) => {
  let $node = $table.querySelector(element);

  while ($node.firstChild) {
    $node.removeChild($node.firstChild);
  }
};

export const renderTable = (res) => {
  clearAllChildElements("tbody");

  res.forEach((el) => {
    let { registry, ingress, egrees, stock, logo, id, lot } = el;

    console.log(res,$template.querySelector(".lot"));

    $template.querySelector(".registry").textContent = registry;
    $template.querySelector(".ingress").textContent = ingress;
    $template.querySelector(".egrees").textContent = egrees;
    $template.querySelector(".stock").textContent = stock;
    $template.querySelector(".lot").textContent = lot;
    // $template.querySelector(".logo").textContent = logo === 1 ? "si" : "no";

    if ($template.querySelector(".edit") != null) {
      $template.querySelector(".edit").dataset.id = id;
      $template.querySelector(".edit").dataset.registry = registry;
      $template.querySelector(".edit").dataset.ingress = ingress;
      $template.querySelector(".edit").dataset.egrees = egrees;
      $template.querySelector(".edit").dataset.stock = stock;
      $template.querySelector(".edit").dataset.logo = logo;
      $template.querySelector(".edit").dataset.lot = lot;
    }

    if ($template.querySelector(".delete-icon") != null) {
      $template.querySelector(".delete-icon").dataset.id = id;
      $template.querySelector(".delete-icon").dataset.registry = registry;
      $template.querySelector(".delete-icon").dataset.ingress = ingress;
      $template.querySelector(".delete-icon").dataset.egrees = egrees;
      $template.querySelector(".delete-icon").dataset.stock = stock;
      $template.querySelector(".delete-icon").dataset.logo = logo;
    }

    let $clone = d.importNode($template, true);
    $fragment.appendChild($clone);
  });

  // attach the fragment to the body of the table
  $table.querySelector("tbody").appendChild($fragment);

  // notify the value of the column stock
  notifyStock();
};

const notifyStock = () => {
  let $tbody = $table.querySelector("tbody");
  checkElements($tbody);
};

// checking that tbody table contains elements
const checkElements = ($tbody) => {
  if ($tbody.firstElementChild) {
    let $tr = $tbody.querySelector("tr"),
      $stock = $tr.children[3].textContent;

    // $form.stock.value = $stock; // set into form field stock

    if ($stock < 5000) showNotice($stock);
  }
};

// show card notice with short description
const showNotice = ($stock) => {
  let $cardNotice = document.querySelector(".notice"),
    $cardContent = $cardNotice.querySelector(".card-content"),
    $h6 = $cardContent.querySelector("h6");

  $h6.textContent = convertValue($stock);

  $cardNotice.classList.add("orange"); // add color
  $cardNotice.classList.remove("hide"); // show card
};

const convertValue = (number) => {
  if (number % 25 === 0) {
    return (
      "Solo hay disponible " +
      number / 25 +
      " bultos de cajas = " +
      number +
      " cajas"
    );
  }

  let excess = number % 25, // example 52 % 25 = 2
    newNumber =
      "Hay disponibles " +
      (number - excess) / 25 +
      " bultos" +
      " + " +
      excess +
      " unidades =  " +
      number +
      " cajas";
  return newNumber;
};
