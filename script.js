const searchForm = document.querySelector(".search-form");
const searchBtn = document.querySelector("#search-btn");
const cartItem = document.querySelector(".cart-items-container");
const cartBtn = document.querySelector("#cart-btn");
const navbar = document.querySelector(".navbar");
const menuBtn = document.querySelector("#menu-btn");

searchBtn.addEventListener("click", () => {
  searchForm.classList.toggle("active");
  document.addEventListener("click", (e) => {
    if (
      !e.composedPath().includes(searchBtn) &&
      !e.composedPath().includes(searchForm)
    ) {
      searchForm.classList.remove("active");
    }
  });
});

cartBtn.addEventListener("click", () => {
  cartItem.classList.toggle("active");
  document.addEventListener("click", (e) => {
    if (
      !e.composedPath().includes(cartBtn) &&
      !e.composedPath().includes(cartItem)
    ) {
      cartItem.classList.remove("active");
    }
  });
});

menuBtn.addEventListener("click", () => {
  navbar.classList.toggle("active");
  document.addEventListener("click", (e) => {
    if (
      !e.composedPath().includes(navbar) &&
      !e.composedPath().includes(menuBtn)
    ) {
      navbar.classList.remove("active");
    }
  });
});

var sitePlusMinus = function () {
  var value,
    quantity = document.getElementsByClassName("quantity-container");

  function createBindings(quantityContainer) {
    var quantityAmount =
      quantityContainer.getElementsByClassName("quantity-amount")[0];
    var increase = quantityContainer.getElementsByClassName("increase")[0];
    var decrease = quantityContainer.getElementsByClassName("decrease")[0];
    increase.addEventListener("click", function (e) {
      increaseValue(e, quantityAmount);
    });
    decrease.addEventListener("click", function (e) {
      decreaseValue(e, quantityAmount);
    });
  }

  function init() {
    for (var i = 0; i < quantity.length; i++) {
      createBindings(quantity[i]);
    }
  }

  function increaseValue(event, quantityAmount) {
    value = parseInt(quantityAmount.value, 10);

    console.log(quantityAmount, quantityAmount.value);

    value = isNaN(value) ? 0 : value;
    value++;
    quantityAmount.value = value;
  }

  function decreaseValue(event, quantityAmount) {
    value = parseInt(quantityAmount.value, 10);

    value = isNaN(value) ? 0 : value;
    if (value > 0) value--;

    quantityAmount.value = value;
  }

  init();
};
sitePlusMinus();
