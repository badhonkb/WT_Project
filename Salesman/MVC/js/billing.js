const searchInput = document.getElementById('medicineSearch');
const searchResults = document.getElementById('searchResults');
const cartTable = document.querySelector('#cartTable tbody');
const customerSelect = document.getElementById('customerSelect');
const discountInput = document.getElementById('discount');
const totalEl = document.getElementById('total');
const grandTotalEl = document.getElementById('grandTotal');
const payBtn = document.getElementById('payBtn');
const printBtn = document.getElementById('printBtn');
const notification = document.getElementById('notification');

let cart = [];


function showNotification(msg, type='success'){
    notification.textContent = msg;
    notification.className = 'notification ' + type;
    notification.style.display = 'block';
    setTimeout(()=>{notification.style.display='none';}, 3000);
}


searchInput.addEventListener('input', function(){
    const keyword = this.value;
    if(keyword.length < 1) { searchResults.innerHTML=''; return;}

    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../php/billingController.php?search=${encodeURIComponent(keyword)}`, true);
    xhr.onload = function(){
        if(xhr.status === 200){
            const data = JSON.parse(xhr.responseText);
            searchResults.innerHTML = '';
            data.forEach(med => {
                const div = document.createElement('div');
                div.textContent = med.name + ' | Price: ' + med.price + ' | Stock: ' + med.quantity;
                div.dataset.id = med.id;
                div.dataset.name = med.name;
                div.dataset.price = med.price;
                div.dataset.stock = med.quantity;
                div.addEventListener('click', ()=> addToCart(div.dataset));
                searchResults.appendChild(div);
            });
        }
    };
    xhr.send();
});


function addToCart(med){
    let id = med.id;
    let existing = cart.find(i => i.id==id);
    if(existing){
        if(existing.quantity < med.stock){
            existing.quantity++;
        } else {
            showNotification('Stock limit reached!', 'error');
        }
    } else {
        cart.push({id:id, name:med.name, price:parseFloat(med.price), quantity:1});
    }
    renderCart();
}


function renderCart(){
    cartTable.innerHTML = '';
    let total = 0;
    cart.forEach((item,i)=>{
        const subtotal = item.price * item.quantity;
        total += subtotal;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.name}</td>
            <td>${item.price.toFixed(2)}</td>
            <td><input type="number" min="1" value="${item.quantity}" data-index="${i}" class="qtyInput"></td>
            <td>${subtotal.toFixed(2)}</td>
            <td><div class="remove-item" data-index="${i}">X</div></td>
        `;
        cartTable.appendChild(tr);
    });
    totalEl.textContent = total.toFixed(2);
    updateGrandTotal();
    attachCartEvents();
}


function attachCartEvents(){
    document.querySelectorAll('.remove-item').forEach(btn=>{
        btn.onclick = function(){
            const i = this.dataset.index;
            cart.splice(i,1);
            renderCart();
        }
    });

    document.querySelectorAll('.qtyInput').forEach(input=>{
        input.onchange = function(){
            let idx = this.dataset.index;
            let val = parseInt(this.value);
            if(val <1) { showNotification('Quantity must be at least 1','error'); this.value=1; val=1;}
            cart[idx].quantity = val;
            renderCart();
        }
    });
}





payBtn.onclick = function(){
    const customer_id = customerSelect.value;
    if(!customer_id){ showNotification('Select a customer','error'); return; }
    if(cart.length<1){ showNotification('Cart is empty','error'); return; }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/billingController.php', true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.onload = function(){
        if(xhr.status===200){
            const data = JSON.parse(xhr.responseText);
            if(data.status=='success'){
                showNotification(data.message,'success');
                cart=[]; renderCart(); discountInput.value=0;
            } else {
                showNotification(data.message,'error');
            }
        }
    };
    const body = `submitSale=1&customer_id=${customer_id}&items=${encodeURIComponent(JSON.stringify(cart))}&discount=${discountInput.value}`;
    xhr.send(body);
}


printBtn.addEventListener('click', function () {
    if (cart.length === 0) {
        showNotification('Nothing to print', 'error');
        return;
    }

    let customerName = customerSelect.options[customerSelect.selectedIndex].text;
    let now = new Date().toLocaleString();

    let html = `
    <div style="text-align:center;font-weight:bold;">Medical Shop Management System</div>
    <div style="text-align:center;">Uttara Model Town, Dhaka</div>
    <hr>
    <div>Customer: ${customerName}</div>
    <div>Date: ${now}</div>
    <br>

    <table width="100%" border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Medicine</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    `;

    let total = 0;
    cart.forEach(item => {
        let sub = item.price * item.quantity;
        total += sub;
        html += `
        <tr>
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>${item.price.toFixed(2)}</td>
            <td>${sub.toFixed(2)}</td>
        </tr>`;
    });

    let discountPercent = parseFloat(discountInput.value) || 0;
    let discountAmount = total * discountPercent / 100;
    let grandTotal = total - discountAmount;

    html += `
        <tr><td colspan="3">Total</td><td>${total.toFixed(2)}</td></tr>
        <tr><td colspan="3">Discount (${discountPercent}%)</td><td>${discountAmount.toFixed(2)}</td></tr>
        <tr><td colspan="3"><b>Grand Total</b></td><td><b>${grandTotal.toFixed(2)}</b></td></tr>
    </table>
    `;

    let win = window.open('', '', 'width=800,height=600');
    win.document.write(html);
    win.document.close();
    win.print();
});
