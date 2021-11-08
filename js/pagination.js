import { clearChildElements } from "./helpers.js";

export const renderPaginate = (res) => {
  if (res.length) {
    let d = document,
      { page, numberpages } = res[0];

    // ======== clear list items =====================
    clearChildElements("ul");
    // ======== clear list items =====================

    // console.log(res, res[0]);

    left(page);

    for (let i = 1; i <= numberpages; i++) {
      let $ul = d.querySelector(".pagination"),
        $li = d.createElement("li"),
        $a = d.createElement("a");

      if (page == i) {
        // set atributes and values
        $li.classList.add("active");
        $a.textContent = i;

        // set elements
        $li.appendChild($a);
        $ul.appendChild($li);
      } else {
        // set atributes and values
        $li.classList.add("waves-effect");
        $a.textContent = i;
        // set elements
        $li.appendChild($a);
        $ul.appendChild($li);
      }
    }

    right(page, numberpages);
  }
};

// ================= left arrow ===================

const left = (page) => {
  // create elements
  let d = document,
    $ul = d.querySelector("ul"),
    $li = d.createElement("li"),
    $a = d.createElement("a"),
    $icon = d.createElement("i");

  // set atributes
  // $a.classList.add('blue');
  $icon.classList.add("material-icons");

  // set elements
  $a.appendChild($icon);
  $li.appendChild($a);

  // ========= disable/enabled back button =========

  if (page == 1) {
    $icon.textContent = "chevron_left";
    $icon.classList.add("back");
    $icon.name = page;
    $li.classList.add("disabled");
    $ul.appendChild($li);
  } else {
    $icon.classList.add("back");
    $icon.textContent = "chevron_left";
    $icon.name = page;
    $li.classList.add("waves-effect");
    $ul.appendChild($li);
  }
  // ========= disable/enabled back button =========
};

// ================= right arrow ===================

const right = (page, numberpages) => {
  // create elements
  let d = document,
    $ul = d.querySelector("ul"),
    $li = d.createElement("li"),
    $a = d.createElement("a"),
    $icon = d.createElement("i");

  // set atributes
  $icon.classList.add("material-icons");

  // set elements
  $a.appendChild($icon);
  $li.appendChild($a);

  // ========= disable/enabled next button =========

  if (page == numberpages) {
    $icon.textContent = "chevron_right";
    $icon.classList.add("next");
    $icon.name = page;
    $li.classList.add("disabled");
    $ul.appendChild($li);
  } else {
    $icon.textContent = "chevron_right";
    $icon.classList.add("next");
    $icon.name = page;
    $li.classList.add("waves-effect");
    $ul.appendChild($li);
  }

  // ========= disable/enabled next button =========
};
