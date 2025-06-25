<div
    class="rounded-xl shadow-xl p-8 flex flex-col justify-center hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
    <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-3">
        <span class="text-2xl">🔄</span>
        <span>
            Barang Masuk Hari Ini
            <small class="text-gray-500 dark:text-gray-400 ml-3">
                ({{ $startDate }} - {{ $endDate }})
            </small>
        </span>
    </h2>
    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">
        {{ $transactionsInCount }}
    </p>
</div>
