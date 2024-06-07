// Tabs

$(document).ready(function () {
  $(".card-container").hide();
  $(".card-container:first-child").fadeIn();
  $(".list-tabs li").click(function () {
    $(".list-tabs li").removeClass("active-tab");
    $(this).addClass("active-tab");

    let content_tabs_id = $(this).children("a").attr("href");
    $(".card-container").hide();
    $(content_tabs_id).fadeIn();
    return false;
  });
});

// Open-sizeProduct
var riceProducts = document.querySelectorAll(".rice-product");

riceProducts.forEach(function (riceProduct) {
  var cartIcon = riceProduct.querySelector(".cart-icon");
  var sizeContainer = riceProduct.querySelector(".list-size");

  cartIcon.addEventListener("click", function (event) {
    event.preventDefault();

    // Ẩn tất cả các phần tử .list-size khác
    riceProducts.forEach(function (item) {
      if (item !== riceProduct) {
        var otherSizeContainer = item.querySelector(".list-size");
        otherSizeContainer.classList.remove("open");
      }
    });

    // Hiển thị hoặc ẩn .list-size của phần tử hiện tại
    sizeContainer.classList.toggle("open");
  });
});

// JS container-card
const cardContainers = document.querySelectorAll(".list-product__new");
const nxtBtn = document.querySelector(".nxt-btn");
const preBtn = document.querySelector(".pre-btn");
const scrollAmount = 300; // Số lượng cuộn cố định

if (nxtBtn !== null && preBtn !== null) {
  nxtBtn.addEventListener("click", () => {
    cardContainers.forEach((listProduct) => {
      listProduct.scrollLeft += scrollAmount;
    });
  });

  preBtn.addEventListener("click", () => {
    cardContainers.forEach((listProduct) => {
      listProduct.scrollLeft -= scrollAmount;
    });
  });
}


function handleLogout(e) {
  e.preventDefault();
  Swal.fire({
      icon: 'success',
      title: 'Thao tác thành công!',
      showConfirmButton: false,
      timer: 3000
  }).then(() => {
      // Submit form sau khi thông báo được hiển thị
      window.location.href = "./include/logout.php";
  });
}


