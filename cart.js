
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function addToCart(item, variant, price, qty = 1) {
    const existingItem = cart.find(i => i.item === item && i.variant === variant);
    if (existingItem) {
        existingItem.quantity += qty;
    } else {
        cart.push({ item, variant, price, quantity: qty });
    }
    saveCart();
    updateCartCount();
    renderCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    saveCart();
    updateCartCount();
    renderCart();
}

function updateCartCount() {
    const cartCount = document.getElementById("cart-count");
    if (cartCount) {
        cartCount.innerText = cart.reduce((sum, i) => sum + i.quantity, 0);
    }
}

function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function renderCart() {
    const tbody = document.querySelector("#cart-table tbody");
    const totalElem = document.getElementById("cart-total");
    if (!tbody || !totalElem) return;

    tbody.innerHTML = "";
    let total = 0;

    cart.forEach((i, index) => {
        const subtotal = i.price * i.quantity;
        total += subtotal;
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${i.item}</td>
            <td>${i.variant}</td>
            <td>$${i.price.toFixed(2)}</td>
            <td>${i.quantity}</td>
            <td>$${subtotal.toFixed(2)}</td>
            <td><button onclick="removeFromCart(${index})">Remove</button></td>
        `;
        tbody.appendChild(row);
    });

    totalElem.innerText = `$${total.toFixed(2)}`;
}

document.addEventListener("DOMContentLoaded", () => {
    updateCartCount();
    renderCart();

    const orderForm = document.getElementById("order-form");
    if (orderForm) {
        orderForm.addEventListener("submit", (e) => {
            let cartSummary = cart.map(i =>
                `${i.quantity}x ${i.item} (${i.variant}) at $${i.price.toFixed(2)} each`
            ).join("\n");
            let total = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
            cartSummary += `\n\nTotal: $${total.toFixed(2)}`;

            let hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "cart";
            hiddenInput.value = cartSummary;

            orderForm.appendChild(hiddenInput);
        });
    }
});
