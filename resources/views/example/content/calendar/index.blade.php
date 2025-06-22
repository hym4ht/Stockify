@extends('example.layouts.default.main')

@section('title', 'Calendar')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-extrabold mb-8 text-gray-900 dark:text-gray-100 tracking-tight">Calendar</h1>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <button id="prevMonth"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500">
                    < </button>
                        <h2 id="monthYear" class="text-1.5xl font-semibold text-gray-900 dark:text-gray-100"></h2>
                        <button id="nextMonth"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500">
                             >
                        </button>
            </div>

            <div
                class="grid grid-cols-7 gap-4 text-center text-gray-700 dark:text-gray-300 font-semibold text-sm sm:text-base">
                <div class="text-red-600 dark:text-red-400">Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>

            <div id="calendarGrid" class="grid grid-cols-7 gap-4 mt-4 text-center text-sm sm:text-base">
                <!-- Days will be injected here by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const monthYear = document.getElementById('monthYear');
            const calendarGrid = document.getElementById('calendarGrid');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');

            let currentDate = new Date();

            function renderCalendar(date) {
                calendarGrid.innerHTML = '';

                const year = date.getFullYear();
                const month = date.getMonth();

                // Set month and year header
                const monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                monthYear.textContent = monthNames[month] + ' ' + year;

                // First day of the month
                const firstDay = new Date(year, month, 1);
                // Last day of the month
                const lastDay = new Date(year, month + 1, 0);
                // Day of week of first day (0=Sun, 6=Sat)
                const startDay = firstDay.getDay();
                // Number of days in month
                const daysInMonth = lastDay.getDate();

                // Fill in blank days before first day with previous month's dates faded
                const prevMonthLastDay = new Date(year, month, 0).getDate();
                for (let i = startDay - 1; i >= 0; i--) {
                    const prevDay = prevMonthLastDay - i;
                    const prevMonthCell = document.createElement('div');
                    prevMonthCell.textContent = prevDay;
                    prevMonthCell.classList.add('py-2', 'rounded', 'text-gray-400', 'dark:text-gray-600');
                    calendarGrid.appendChild(prevMonthCell);
                }

                // Fill in days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayCell = document.createElement('div');
                    dayCell.textContent = day;
                    dayCell.classList.add('py-2', 'rounded', 'cursor-pointer', 'hover:bg-blue-100', 'dark:hover:bg-blue-700', 'text-gray-900', 'dark:text-gray-300');
                    // Make Sundays red text
                    const dayOfWeek = (startDay + day - 1) % 7;
                    if (dayOfWeek === 0) {
                        dayCell.classList.add('text-red-600', 'dark:text-red-400');
                    }

                    // Highlight today
                    const today = new Date();
                    if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        dayCell.classList.add('bg-blue-600', 'text-white', 'font-bold');
                    }

                    calendarGrid.appendChild(dayCell);
                }

                // Fill in blank days after last day with next month's dates faded
                const totalCells = startDay + daysInMonth;
                const nextMonthDaysToShow = (7 - (totalCells % 7)) % 7;
                for (let i = 1; i <= nextMonthDaysToShow; i++) {
                    const nextMonthCell = document.createElement('div');
                    nextMonthCell.textContent = i;
                    nextMonthCell.classList.add('py-2', 'rounded', 'text-gray-400', 'dark:text-gray-600');
                    calendarGrid.appendChild(nextMonthCell);
                }
            }

            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
            });

            renderCalendar(currentDate);
        });
    </script>
@endsection