export const ajax = (options) => {
  let { url, method, success, error, data } = options,
    $show = document.querySelector(".show"),
    $containerTable = document.querySelector(".container-table"),
    $loader = document.getElementById("loader"),
    $crudTable = document.querySelector(".crud_table"),
    $table = document.querySelector(".container-table"),
    $shortDescription = $table.querySelector(".short-description");

  const xhr = new XMLHttpRequest();

  // Open Loader ...
  // this loader is related to a short
  // description in the table
    $loader.classList.remove('hide');
    $crudTable.classList.add('hide');
    $shortDescription.classList.add("hide"); // short description
    
    xhr.addEventListener("readystatechange", (e) => {
      if (xhr.readyState !== 4) return;
      
      // close loader ...
      $loader.classList.add('hide');
      $crudTable.classList.remove('hide');
      $shortDescription.classList.remove("hide");

    if (xhr.status >= 200 && xhr.status < 300) {
      if (xhr.responseText) {
        let json = JSON.parse(xhr.responseText);
        return success(json);
      }
      console.log(xhr);
      console.error(
        "Error, la operacion readyStateChange ha sido completada pero se ha recibido una respuesta vacía, por favor verifique que el servidor envie una respuesta válida");
    } else {
      let message = xhr.statusText || "Ocurrio un error";
      error(`Error ${xhr.status}:${message}`);
    }
  });

  xhr.open(method || "GET", url);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // xhr.setRequestHeader("Content-type", "application/json;charset=utf-8");
  // xhr.send(JSON.stringify(data));
  xhr.send(data);
};
