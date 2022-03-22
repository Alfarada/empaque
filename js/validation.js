// form inputs validation
export const validateInputs = ($ingress, $egrees, $stock, $logo, $registry, $lot) => {
  if ($ingress == "" || isNaN($ingress)) {
    return false;
  } else if ($egrees == "" || isNaN($egrees)) {
    return false;
  } else if ($stock == "" || isNaN($stock)) {
    return false;
  } else if ($logo == "" || isNaN($logo)) {
    return false;
  } else if ($registry == "") {
    return false;
  } else if ($lot == "" || isNaN($lot)) {
    return false;
  } else if ($ingress == 0 && $egrees == 0 && $stock == 0 && $lot == 0) {
    return false;
  }

  return true;
};

// form validation succesfull

export const showSuccessMessage = () => {
  let $alert = document.querySelector(".alert-container"),
    $span = $alert.querySelector("span"),
    $b = $span.querySelector("b");

  $b.textContent = "Ha enviado los datos exitosamente.";
  $span.classList.replace("red-text", "green-text");
  $alert.classList.remove("none");

  setTimeout(() => {
    $b.textContent = "";
    $span.classList.replace("green-text", "red-text");
    $alert.classList.add("none");
  }, 5000);
};

// response validation
// Operación readyStateChange completada pero
// recibimos una respuesta válida con error
export const validateResponse = (res) => {
  if (res.error) {
    return console.log(`${res.error} : ${res.message}`);
  }

  return;
};
