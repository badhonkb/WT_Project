const searchInput = document.getElementById('search');
const filterSelect = document.getElementById('filter');
const invoiceTable = document.querySelector('#invoice-table tbody');
const modal = document.getElementById('invoice-modal');
const modalContent = document.getElementById('invoice-details');
const closeModal = document.querySelector('.modal .close');


function fetchInvoices() {
    const search = searchInput.value;
    const filter = filterSelect.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../php/invoiceController.php?action=fetch&search=${search}&filter=${filter}`, true);
    xhr.onload = function() {
        if(this.status === 200) {
            invoiceTable.innerHTML = this.responseText;
            attachButtons();
        }
    }
    xhr.send();
}


function attachButtons() {
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.onclick = function() {
            const id = this.dataset.id;
            fetchInvoiceDetails(id, false);
        };
    });

    document.querySelectorAll('.print-btn').forEach(btn => {
        btn.onclick = function() {
            const id = this.dataset.id;
            fetchInvoiceDetails(id, true);
        };
    });
}


function fetchInvoiceDetails(id, print=false) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../php/invoiceController.php?action=details&id=${id}`, true);
    xhr.onload = function() {
        if(this.status === 200) {
            const data = JSON.parse(this.responseText);

            let html = `<h2 style="text-align:center; font-weight:bold;">Medical Shop Management System</h2>
                        <p style="text-align:center;">Uttara Model Town, Dhaka</p>
                        <p>Customer: ${data.sale.customer_name} | Phone: ${data.sale.phone} | Date: ${data.sale.created_at}</p>
                        <table border="1" cellpadding="5" cellspacing="0" width="100%">
                        <tr><th>Medicine</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>`;

            data.items.forEach(item => {
                html += `<tr>
                            <td>${item.name}</td>
                            <td>${item.quantity}</td>
                            <td>${item.price}</td>
                            <td>${item.subtotal}</td>
                         </tr>`;
            });

            html += `<tr><td colspan="3">Total</td><td>${data.sale.total}</td></tr>`;
            html += `<tr><td colspan="3">Discount</td><td>${data.sale.discount}</td></tr>`;
            html += `<tr><td colspan="3">Grand Total</td><td>${data.sale.grand_total}</td></tr></table>`;
            html += `<p style="text-align:center; margin-top:20px;">Thank you for your purchase!</p>`;

            if(print) {
                const printWin = window.open('', '', 'width=800,height=600');
                printWin.document.write('<html><head><title>Invoice</title></head><body>' + html + '</body></html>');
                printWin.document.close();
                printWin.print();
            } else {
                modalContent.innerHTML = html;
                modal.style.display = 'block';
            }
        }
    }
    xhr.send();
}


closeModal.onclick = function() { modal.style.display = 'none'; }
window.onclick = function(e) { if(e.target == modal) modal.style.display = 'none'; }

searchInput.addEventListener('input', fetchInvoices);
filterSelect.addEventListener('change', fetchInvoices);

window.onload = fetchInvoices;
