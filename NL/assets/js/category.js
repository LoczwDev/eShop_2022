$(document).ready(function () {
    const sliderRange = $("#slider-range");
    const amountFrom = $("#amout-from");
    const amountTo = $("#amout-to");
    const priceFromInput = $("input[name='product_price_from']");
    const priceToInput = $("input[name='product_price_to']");
    const maxValue = 10000000;
    console.log(sliderRange);
    sliderRange.slider({
        range: true,
        min: 0,
        max: maxValue,
        step: 1000,
        values: [priceFromInput.val(), priceToInput.val()],
        slide: function (event, ui) {
            const from = ui.values[0].toLocaleString("vi-VN") + "đ";
            const to = ui.values[1].toLocaleString("vi-VN") + "đ";

            amountFrom.text(from);
            amountTo.text(to);

            priceFromInput.val(ui.values[0]);
            priceToInput.val(ui.values[1]);
        }
    });

    const initialFrom = 0;
    const initialTo = parseInt(priceToInput.val());

    amountFrom.text(initialFrom.toLocaleString("vi-VN") + "đ");
    amountTo.text(initialTo.toLocaleString("vi-VN") + "đ");

    sliderRange.slider("values", [initialFrom, initialTo]);
});

const iconPlusList = document.querySelectorAll('.icon-plus');

iconPlusList.forEach(iconPlus => {
    iconPlus.addEventListener('click', function () {
        const sidebarSub = this.parentNode.nextElementSibling;
        sidebarSub.classList.toggle('active');
        this.classList.toggle('active');
    });
});

const checkColors = document.querySelectorAll('.check-color');

checkColors.forEach(checkColor => {
    const tooltip = checkColor.querySelector('.tooltip');
    const originalTitle = checkColor.getAttribute('data-original-title');

    tooltip.textContent = originalTitle;
});

function toggleSubChoose() {
    var subChoose = document.getElementById("subChoose");
    const iconDown = document.querySelector(".icon-down")
    if (subChoose.style.display === "none") {
        subChoose.style.display = "block";
        iconDown.classList.toggle('active');
    } else {
        subChoose.style.display = "none";
        iconDown.classList.remove('active');
    }
}