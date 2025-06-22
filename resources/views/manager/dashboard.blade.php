@extends('layouts.dashboard')

@section('content')

    {{-- MOBILE VIEW --}}
    <div class="md:hidden p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
            📊 Manager Gudang Dashboard
        </h1>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide p-2">
                    @include('example.layouts.partials.manager.cards.low-stack')
                </div>
                <div class="swiper-slide p-2">
                    @include('example.layouts.partials.manager.cards.incoming')
                </div>
                <div class="swiper-slide p-2">
                    @include('example.layouts.partials.manager.cards.outgoing')
                </div>
            </div>
        </div>
    </div>
    <div class="hidden md:block p-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            📊 Manager Gudang Dashboard
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @include('example.layouts.partials.manager.cards.low-stack')
            @include('example.layouts.partials.manager.cards.incoming')
            @include('example.layouts.partials.manager.cards.outgoing')
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                new Swiper(".mySwiper", {
                    slidesPerView: 1.1,
                    spaceBetween: 10,
                    loop: false,
                    grabCursor: true,
                });
            });
        </script>
    @endpush

@endsection
