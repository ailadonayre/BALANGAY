import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

async function initSellerCharts() {
    const canvas = document.getElementById('seller-sales-chart');
    if (!canvas) return;

    try {
        const res = await fetch('/api/seller/analytics', { credentials: 'same-origin' });
        if (!res.ok) return;
        const data = await res.json();

        const labels = (data.monthly_sales || []).map(m => m.label);
        const values = (data.monthly_sales || []).map(m => m.value);

        new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: { labels, datasets: [{ label: 'Sales', data: values, borderColor: '#5B5843', backgroundColor: 'rgba(91,88,67,0.06)', fill: true, tension: 0.3 }] },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => '₱' + v } } } }
        });
    } catch (e) {
        console.error('Seller chart error', e);
    }
}

document.addEventListener('DOMContentLoaded', initSellerCharts);

export default initSellerCharts;
