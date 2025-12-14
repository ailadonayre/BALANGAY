import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

async function initAdminCharts() {
    const revenueCanvas = document.getElementById('chart-revenue');
    const productsCanvas = document.getElementById('chart-products');
    const tribeCanvas = document.getElementById('chart-tribe');

    try {
        const res = await fetch('/api/public/analytics');
        if (!res.ok) return;
        const data = await res.json();

        // Monthly revenue line
        if (revenueCanvas && data.monthly_revenue) {
            const labels = data.monthly_revenue.map(m => m.label);
            const values = data.monthly_revenue.map(m => m.value);
            new Chart(revenueCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Revenue',
                        data: values,
                        borderColor: '#5B5843',
                        backgroundColor: 'rgba(91,88,67,0.08)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { ticks: { callback: val => '₱' + val } } }
                }
            });
        }

        // Products donut
        if (productsCanvas) {
            const approved = data.approved_products || 0;
            const pending = data.pending_products || 0;
            const others = Math.max((data.total_products || 0) - approved - pending, 0);
            new Chart(productsCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Other'],
                    datasets: [{
                        data: [approved, pending, others],
                        backgroundColor: ['#5B5843', '#E4DDCC', '#443A35']
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
        }

        // Sellers by tribe bar
        if (tribeCanvas && data.sellers_by_tribe) {
            const labels = data.sellers_by_tribe.map(s => s.indigenous_tribe || 'Unknown');
            const values = data.sellers_by_tribe.map(s => s.count);
            new Chart(tribeCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{ label: 'Sellers', data: values, backgroundColor: '#5B5843' }]
                },
                options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            });
        }
    } catch (e) {
        console.error('Admin Charts load error', e);
    }
}

document.addEventListener('DOMContentLoaded', initAdminCharts);

export default initAdminCharts;
