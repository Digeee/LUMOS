let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
let cartCount = cart.length;
let totalPrice = cart.reduce((sum, item) => sum + item.price, 0);
let isLoggedIn = false;


fetch('check_session.php')
    .then(response => response.json())
    .then(data => {
        isLoggedIn = data.isLoggedIn;
    })
    .catch(error => console.error("Error checking session:", error));

function showDetails(category) {
    const details = {
        'content-creators': { image: 'files/type1.jpg', title: 'Content Creators', price: 'Starting from $50' },
        'wedding-editing': { image: 'files/type2.jpg', title: 'Wedding Editing', price: 'Starting from $100' },
        'intros-logos': { image: 'files/type3.jpg', title: 'Intros & Logos', price: 'Starting from $30' },
        'film-cuts': { image: 'files/type4.jpg', title: 'Film Cuts', price: 'Starting from $150' },
        'trailer-cuts': { image: 'files/type9.jpg', title: 'Trailer Cuts', price: 'Starting from $100' },
        'documentaries': { image: 'files/type8.jpg', title: 'Documentaries', price: 'Starting from $300' }
    };

    const selected = details[category];
    if (selected) {
        document.getElementById('modal-image').src = selected.image;
        document.getElementById('modal-title').innerText = selected.title;
        document.getElementById('modal-price').innerText = selected.price;
        document.getElementById('modal').style.display = 'flex';
    }
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function addToCart(event, title, price) {
    event.stopPropagation();
    
    if (!isLoggedIn) {
        redirectToSignIn();
        return;
    }

    price = parseFloat(price);
    cart.push({ title, price });
    cartCount++;
    totalPrice += price;

    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateCartUI();
}

function orderNow(event, title, price) {
    event.stopPropagation();
    
    if (!isLoggedIn) {
        redirectToSignIn();
        return;
    }

    price = parseFloat(price);
    localStorage.setItem("selectedProduct", JSON.stringify({ title, price }));
    window.location.href = "checkout page.html";
}

function updateCartUI() {
    document.getElementById("cart-counter").innerText = cartCount;

    const cartItems = document.getElementById("cart-items");
    cartItems.innerHTML = "";

    cart.forEach(item => {
        const li = document.createElement("li");
        li.innerText = `${item.title} - $${item.price.toFixed(2)}`;
        cartItems.appendChild(li);
    });

    document.getElementById("cart-total").innerText = `Total: $${totalPrice.toFixed(2)}`;
}

function toggleCart() {
    const cartModal = document.getElementById("cart-modal");
    cartModal.style.display = cartModal.style.display === "flex" ? "none" : "flex";
}

function clearCart() {
    cart = [];
    cartCount = 0;
    totalPrice = 0;
    sessionStorage.removeItem("cart");
    updateCartUI();
    toggleCart();
}

function redirectToCheckout() {
    if (!isLoggedIn) {
        redirectToSignIn();
        return;
    }

    localStorage.setItem("cartDetails", JSON.stringify(cart));
    localStorage.setItem("totalPrice", totalPrice.toFixed(2));
    window.location.href = "checkout page.html";
}

function redirectToSignIn() {
    alert("You must sign in first!");
    window.location.href = "auth.php";
}

async function checkSession() {
    try {
        const response = await fetch('check_session.php');
        const data = await response.json();
        isLoggedIn = data.isLoggedIn; // Ensure it's updated before using
    } catch (error) {
        console.error("Error checking session:", error);
    }
}

// Run session check on page load
checkSession();


// Ensure the cart UI updates on page load
updateCartUI();

