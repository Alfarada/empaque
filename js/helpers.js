export const clearChildElements = (element) => {
  let $node = document.querySelector(element);

  while ($node.firstChild) {
    $node.removeChild($node.firstChild);
  }
};

export const resetForm = () => {
  let $form = document.querySelector(".crud_form"),
    $title = document.querySelector(".crud_title");

  let $h5 = $title.querySelector("h5");
  $h5.textContent = "Formulario";
  $form.submit.textContent = "Enviar";

  $form.registry.value = "";
  $form.registry.classList.remove("valid");
  $form.ingress.value = "";
  $form.ingress.classList.remove("valid");
  $form.egrees.value = "";
  $form.egrees.classList.remove("valid");
  $form.stock.value = "";
  $form.stock.classList.remove("valid");
  $form.logo.value = 0;
  $form.logo.checked = false;
  $form.id.value = '';
};

export const removeButtonToCancelEdit = () => {
  let $formEditButton = document.querySelector(".btn-reset");
  $formEditButton.classList.add("none");
};
