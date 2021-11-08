export const ajax = (options) => {
  let { url, method, success, error, data } = options,
    $show = document.querySelector(".show"),
    $containerTable = document.querySelector(".container-table"),
    $loader = document.getElementById("loader");

  const xhr = new XMLHttpRequest();

  // Open Loader ...
    $loader.classList.remove('hide');
    $containerTable.classList.add('hide');
    
    xhr.addEventListener("readystatechange", (e) => {
      if (xhr.readyState !== 4) return;
      
      // close loader ...
      $loader.classList.add('hide');
      $containerTable.classList.remove('hide');

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
