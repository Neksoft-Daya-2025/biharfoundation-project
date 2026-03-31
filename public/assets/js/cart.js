(function() {
    'use strict';

    const cartSidebar = document.getElementById('cart-sidebar');
    const cartOverlay = document.getElementById('cart-overlay');
    const cartToggleDesktop = document.getElementById('cart-toggle-btn-desktop');
    const cartToggleMobile = document.getElementById('cart-toggle-btn-mobile');
    const cartCloseBtn = document.getElementById('cart-close-btn');
    const cartItemsList = document.getElementById('cart-items-list');
    const cartEmpty = document.getElementById('cart-empty');
    const cartFooter = document.getElementById('cart-footer');
    const cartBadgeDesktop = document.getElementById('cart-badge-desktop');
    const cartBadgeMobile = document.getElementById('cart-badge-mobile');

    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Open cart
    function openCart() {
        if (!cartSidebar || !cartOverlay) return;
        cartSidebar.classList.remove('translate-x-full');
        cartOverlay.classList.remove('hidden');
        cartOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
        loadCart();
    }

    // Close cart
    function closeCart() {
        if (!cartSidebar || !cartOverlay) return;
        cartSidebar.classList.add('translate-x-full');
        cartOverlay.classList.add('hidden');
        cartOverlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Load cart from server
    function loadCart() {
        fetch('/cart')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartUI(data);
                }
            })
            .catch(error => {
                console.error('Error loading cart:', error);
            });
    }

    // Update cart UI
    function updateCartUI(data) {
        if (!data) return;
        
        const itemCount = data.item_count || 0;
        
        // Update badges
        if (cartBadgeDesktop) {
            if (itemCount > 0) {
                cartBadgeDesktop.textContent = itemCount;
                cartBadgeDesktop.classList.remove('hidden');
            } else {
                cartBadgeDesktop.classList.add('hidden');
            }
        }
        if (cartBadgeMobile) {
            cartBadgeMobile.textContent = itemCount;
        }

        // Update cart items
        if (itemCount === 0) {
            if (cartEmpty) {
                cartEmpty.style.display = 'block';
            }
            if (cartItemsList) {
                cartItemsList.style.display = 'none';
            }
            if (cartFooter) {
                cartFooter.style.display = 'none';
            }
        } else {
            if (cartEmpty) {
                cartEmpty.style.display = 'none';
            }
            if (cartItemsList) {
                cartItemsList.style.display = 'block';
                // Render items
                cartItemsList.innerHTML = (data.items || []).map(item => `
                    <div style="display: flex; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb; margin-bottom: 1rem;" data-product-id="${item.product_id}">
                        <div style="width: 80px; height: 80px; flex-shrink: 0; border-radius: 0.5rem; overflow: hidden; background: #f3f4f6;">
                            ${item.image ? `<img src="${item.image}" alt="${item.name || 'Product'}" style="width: 100%; height: 100%; object-fit: cover;">` : ''}
                        </div>
                        <div style="flex: 1;">
                            <h3 style="font-weight: 600; color: #111827; margin: 0 0 0.25rem; font-size: 1rem;">${item.name || 'Product'}</h3>
                            <p style="font-size: 0.875rem; color: #4b5563; margin: 0 0 0.5rem;">€${parseFloat(item.price || 0).toFixed(2)}</p>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <button onclick="updateCartQuantity(${item.product_id}, ${item.quantity - 1})" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid #d1d5db; border-radius: 0.25rem; background: white; cursor: pointer;">-</button>
                                <span style="width: 32px; text-align: center; font-weight: 600;">${item.quantity}</span>
                                <button onclick="updateCartQuantity(${item.product_id}, ${item.quantity + 1})" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 1px solid #d1d5db; border-radius: 0.25rem; background: white; cursor: pointer;">+</button>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <p style="font-weight: 700; color: #111827; margin: 0 0 0.5rem;">€${parseFloat(item.subtotal || 0).toFixed(2)}</p>
                            <button onclick="removeFromCart(${item.product_id})" style="color: #dc2626; font-size: 0.875rem; border: none; background: transparent; cursor: pointer; padding: 0;">Remove</button>
                        </div>
                    </div>
                `).join('');
            }
            if (cartFooter) {
                cartFooter.style.display = 'block';
            }

            // Update totals
            const subtotalEl = document.getElementById('cart-subtotal');
            const deliveryFeeEl = document.getElementById('cart-delivery-fee');
            const totalEl = document.getElementById('cart-total');
            
            if (subtotalEl) subtotalEl.textContent = '€' + parseFloat(data.subtotal || 0).toFixed(2);
            if (deliveryFeeEl) deliveryFeeEl.textContent = '€' + parseFloat(data.delivery_fee || 0).toFixed(2);
            if (totalEl) totalEl.textContent = '€' + parseFloat(data.total || 0).toFixed(2);
        }
    }

    // Add to cart
    window.addToCart = function(productId, quantity = 1) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCart();
                openCart();
            } else {
                alert('Failed to add item to cart');
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            alert('Error adding item to cart');
        });
    };

    // Update cart quantity
    window.updateCartQuantity = function(productId, quantity) {
        if (quantity < 1) {
            removeFromCart(productId);
            return;
        }

        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCart();
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
        });
    };

    // Remove from cart
    window.removeFromCart = function(productId) {
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCart();
            }
        })
        .catch(error => {
            console.error('Error removing from cart:', error);
        });
    };

    // Event listeners
    if (cartToggleDesktop) {
        cartToggleDesktop.addEventListener('click', openCart);
    }
    if (cartToggleMobile) {
        cartToggleMobile.addEventListener('click', openCart);
    }
    if (cartCloseBtn) {
        cartCloseBtn.addEventListener('click', closeCart);
    }
    if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCart);
    }

    // Load cart on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadCart);
    } else {
        loadCart();
    }
})();
