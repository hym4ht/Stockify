<div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-4 flex flex-col justify-between min-h-[200px] border border-gray-300 dark:border-gray-700 transition-transform duration-300 hover:scale-105">
    <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-start space-x-3 mb-2">
        <span class="text-2xl">📤</span>
        <span>
            Transactions Out
            <br>
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                {{ $startDate }} – {{ $endDate }}
            </span>
        </span>
    </h2>
    <div class="text-3xl font-bold text-red-600 dark:text-red-400 mb-2">
        {{ $transactionsOutCount }}
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-300">
        Total barang keluar selama periode tersebut.
    </p>
</div>
