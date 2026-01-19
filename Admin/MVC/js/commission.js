document.addEventListener("DOMContentLoaded", () => {

    const dayFilter = document.getElementById("dayFilter");
    const salesmanFilter = document.getElementById("salesmanFilter");
    const tbody = document.getElementById("commissionBody");

    function loadSalesmen() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/commissionController.php?action=salesmen");
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            data.forEach(s => {
                const opt = document.createElement("option");
                opt.value = s.salesman_email;
                opt.textContent = s.salesman_email;
                salesmanFilter.appendChild(opt);
            });
        };
        xhr.send();
    }

    function loadReport() {
        const days = dayFilter.value;
        const email = salesmanFilter.value;

        const xhr = new XMLHttpRequest();
        xhr.open("GET", `../php/commissionController.php?action=report&days=${days}&email=${email}`);
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            tbody.innerHTML = "";

            let i = 1;
            data.forEach(row => {
                tbody.innerHTML += `
                    <tr>
                        <td>${i++}</td>
                        <td>${row.salesman_email}</td>
                        <td>${row.grand_total}</td>
                        <td>${row.commission}</td>
                        <td>${row.created_at}</td>
                    </tr>
                `;
            });
        };
        xhr.send();
    }

    dayFilter.onchange = loadReport;
    salesmanFilter.onchange = loadReport;

    loadSalesmen();
    loadReport();
});
