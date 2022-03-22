import { ajax } from "./xhr.js";

let $form = document.querySelector(".crud_form"),
  ingress = $form.ingress,
  egrees = $form.egrees,
  stock = $form.stock,
  inputHidden = $form.id,
  logoSwitch = $form.logo;

const getDataWithLogo = () => {

  ajax({
    url:"../api/BoxesWithLogo.php",
    success: (res) => {
      if (localStorage.getItem("whith_logo")) {
        localStorage.removeItem("with_logo");
        localStorage.setItem("with_logo", JSON.stringify(res));
      } else {
        localStorage.setItem("with_logo", JSON.stringify(res));
      }
    },error: (res) => { console.log('checkbox - switch | error get boxes ');},
  })

  return JSON.parse(localStorage.getItem("with_logo"));
};

const getDataWithOutLogo = () => {

  ajax({
    url:"../api/BoxesWithOutLogo.php",
    success: (res) => {
      if (localStorage.getItem("with_out_logo")) {
        localStorage.removeItem("with_out_logo");
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      } else {
        localStorage.setItem("with_out_logo", JSON.stringify(res));
      }
    },error: (res) => { console.log('checkbox - switch | error get boxes ');},
  })

  return JSON.parse(localStorage.getItem("with_out_logo"));

};

const getSubtraction = () => {
  return parseInt(ingress.value) - parseInt(egrees.value);
};

const hasKeys = (data) => {
  if (data == null) {
    return console.error(`La funcion hasKeys() espera recibir un array, recibe: ${null}`);
  }

  return data.length !== 0;
};

// isInputValueHidden
const isEditing = () => inputHidden.value !== "";

const setStock = (data) => {
  stock.value = getSubtraction() + data[0].stock;
};

const setStockWhenEdit = (data) => {
  
  if (data.length == 1 ) {
    stock.value = getSubtraction();
    
  } else {
    stock.value = getSubtraction() + data[1].stock;
  }

};

const calWithOutStock = () => {
  stock.value = getSubtraction();
};

const calStock = (data) => {
  isEditing() ? setStockWhenEdit(data) : setStock(data);
};

export const calcHandler = (e) => {
  if (
    e.target.matches(".ingress") ||
    e.target.matches(".egrees") ||
    e.target.matches(".logo-switch")
  ) {
    if (logoSwitch.checked) {
      // con logo

      hasKeys(getDataWithLogo())
      ? calStock(getDataWithLogo())
      : calWithOutStock();
    } else {
      // sin logo
  
      hasKeys(getDataWithOutLogo())
        ? calStock(getDataWithOutLogo())
        : calWithOutStock();
    }
  }
};
