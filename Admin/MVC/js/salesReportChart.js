const names = chartData.map(d => d.salesman_email);
const bills = chartData.map(d => d.total_bills);

const canvas = document.getElementById('salesChart');
const ctx = canvas.getContext('2d');

canvas.height = 300;

let max = Math.max(...bills, 1);
let barWidth = 40;
let gap = 30;

bills.forEach((val, i) => {
    let x = 50 + i * (barWidth + gap);
    let height = (val / max) * 200;

    ctx.fillStyle = "#2c7be5";
    ctx.fillRect(x, 250 - height, barWidth, height);

    ctx.fillStyle = "#000";
    ctx.fillText(names[i], x, 270);
    ctx.fillText(val, x + 10, 240 - height);
});
