document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Horizontal Product Sliders Control
    const nextButtons = document.querySelectorAll('.slider-control-next');
    const prevButtons = document.querySelectorAll('.slider-control-prev');
    
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const slider = this.parentNode.querySelector('.carousel-inner-slider');
            if (slider) {
                // Scroll by about 3 card widths
                const scrollAmount = (slider.offsetWidth * 0.75);
                slider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const slider = this.parentNode.querySelector('.carousel-inner-slider');
            if (slider) {
                const scrollAmount = (slider.offsetWidth * 0.75);
                slider.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            }
        });
    });

    // 2. Newsletter Form Action Mock
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('.newsletter-input');
            if (emailInput.value) {
                alert('Thank you for subscribing! Your 15% discount code has been sent to ' + emailInput.value);
                emailInput.value = '';
            }
        });
    }

    // 3. Simple Product Detail Quantity Increment/Decrement
    const btnMinus = document.getElementById('btnMinus');
    const btnPlus = document.getElementById('btnPlus');
    const qtyInput = document.getElementById('qtyInput');
    
    if (btnMinus && btnPlus && qtyInput) {
        btnMinus.addEventListener('click', function() {
            let currentVal = parseInt(qtyInput.value);
            if (!isNaN(currentVal) && currentVal > 1) {
                qtyInput.value = currentVal - 1;
                updatePriceCalculation();
            }
        });
        
        btnPlus.addEventListener('click', function() {
            let currentVal = parseInt(qtyInput.value);
            if (!isNaN(currentVal) && currentVal < 10000) {
                qtyInput.value = currentVal + 1;
                updatePriceCalculation();
            }
        });

        qtyInput.addEventListener('change', function() {
            let currentVal = parseInt(qtyInput.value);
            if (isNaN(currentVal) || currentVal < 1) {
                qtyInput.value = 1;
            }
            updatePriceCalculation();
        });
    }

    // Dynamic Price update on Product Page if options change
    const finishSelect = document.getElementById('finishSelect');
    const paperSelect = document.getElementById('paperSelect');
    if (finishSelect || paperSelect || qtyInput) {
        if (finishSelect) finishSelect.addEventListener('change', updatePriceCalculation);
        if (paperSelect) paperSelect.addEventListener('change', updatePriceCalculation);
    }
    
    function updatePriceCalculation() {
        const basePriceEl = document.getElementById('basePrice');
        const totalPriceEl = document.getElementById('totalPrice');
        if (!basePriceEl || !totalPriceEl) return;
        
        const basePrice = parseFloat(basePriceEl.dataset.basePrice);
        let qty = 1;
        if (qtyInput) {
            qty = parseInt(qtyInput.value);
        }
        
        let multiplier = 1.0;
        
        if (finishSelect) {
            if (finishSelect.value === 'matte') multiplier += 0.0;
            else if (finishSelect.value === 'glossy') multiplier += 0.15; // 15% more
            else if (finishSelect.value === 'metallic') multiplier += 0.35; // 35% more
        }
        
        if (paperSelect) {
            if (paperSelect.value === 'standard') multiplier += 0.0;
            else if (paperSelect.value === 'premium') multiplier += 0.25; // 25% more
        }
        
        const singlePrice = basePrice * multiplier;
        const total = singlePrice * qty;
        
        totalPriceEl.textContent = '₹' + total.toFixed(2);
    }
});
