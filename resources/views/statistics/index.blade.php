<x-layouts.main-content title="Statistics" heading="Statistics" subheading="User and Product Data Overview">
    <!-- Importa Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@can('admin')
    <div class="container mx-auto p-6 bg-white rounded shadow mt-6 text-gray-900 dark:text-gray-50 dark:bg-gray-900">




        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">User Data</h2>
                <p>Total Active Administrators: {{ $numAdminsAtivos }}</p>
                <p>Total Active Employees: {{ $numEmployeesAtivos }}</p>
                <p>Total Active Customers: {{ $numCustomersAtivos }}</p>
                <p>Total Blocked Users: {{ $numDeUserBloqueados }}</p>
                <p>Total Male "Population": {{ $usersMasculino }}</p>
                <p>Total Female "Population": {{ $usersFeminino }}</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-4">Product Data</h2>
                <p>Number of Categories: {{ $totalCategories }}</p>
                <p>Total Products: {{ $totalProducts }}</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mt-10">
            <div>
                <h3 class="text-lg font-semibold mb-2">Products by Category</h3>
                <canvas id="categoryChart"></canvas>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Revenue by Month</h3>
                <canvas id="purchaseChart"></canvas>
            </div>


       </div>
       @endcan
        <div class="mt-10">
    <h2 class="text-xl font-semibold mb-4">My Personal Statistics</h2>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold mb-2">Orders Overview</h3>
            <p>Total Orders Made: {{ $orders->count() }}</p>
            <p>Total Items Ordered: {{ $orders->sum(fn($order) => $order->items->sum('quantity')) }}</p>
            <p>Total Spent: {{ number_format($orders->sum('total'), 2) }} €</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-2">Recent Orders</h3>
            <ul class="list-disc ml-4">
                @forelse ($orders->take(5) as $order)
                    <li>
                        <strong>#{{ $order->id }}</strong> -
                        {{ $order->date->format('d/m/Y') }} -
                        {{ number_format($order->total, 2) }} €
                    </li>
                @empty
                    <li>No orders found.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

    </div>

    <script>
        const categoryLabels = @json($categoryLabels);
        const categoryCounts = @json($categoryCounts);
        const purchaseLabels = @json($purchaseLabels);
        const purchaseTotals = @json($purchaseTotals);

        let categoryChart = null;
        let purchaseChart = null;

        function renderCharts() {
            if (categoryChart) {
                categoryChart.destroy();
            }
            if (purchaseChart) {
                purchaseChart.destroy();
            }

            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            categoryChart = new Chart(ctxCategory, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Products per Category',
                        data: categoryCounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxPurchase = document.getElementById('purchaseChart').getContext('2d');
            purchaseChart = new Chart(ctxPurchase, {
                type: 'line',
                data: {
                    labels: purchaseLabels,
                    datasets: [{
                        label: 'Revenue (€)',
                        data: purchaseTotals,
                        fill: true,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderCharts();
        });

        // Se usares Livewire, podes adicionar isto para redesenhar depois de updates:
        if (window.Livewire) {
            Livewire.hook('message.processed', () => {
                renderCharts();
            });
        }
    </script>
</x-layouts.main-content>
