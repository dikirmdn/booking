@props([
    'type' => 'info',
    'title' => null,
    'duration' => 5000,
    'position' => 'top-right'
])

@php
    $toastClasses = [
        'success' => 'bg-white border-l-4 border-green-500 shadow-lg',
        'error' => 'bg-white border-l-4 border-red-500 shadow-lg',
        'warning' => 'bg-white border-l-4 border-yellow-500 shadow-lg',
        'info' => 'bg-white border-l-4 border-blue-500 shadow-lg',
    ];

    $iconClasses = [
        'success' => 'text-green-500',
        'error' => 'text-red-500',
        'warning' => 'text-yellow-500',
        'info' => 'text-blue-500',
    ];

    $icons = [
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];

    $positionClasses = [
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
        'bottom-right' => 'bottom-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
        'bottom-center' => 'bottom-4 left-1/2 transform -translate-x-1/2',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'fixed z-50 max-w-sm w-full rounded-lg p-4 ' . $toastClasses[$type] . ' ' . $positionClasses[$position]]) }}
     x-data="{ 
         show: true,
         init() {
             if ({{ $duration }} > 0) {
                 setTimeout(() => { this.show = false }, {{ $duration }});
             }
         }
     }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     role="alert">
    
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 {{ $iconClasses[$type] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$type] }}" />
            </svg>
        </div>
        
        <div class="ml-3 flex-1">
            @if($title)
                <p class="font-semibold text-gray-900 mb-1">{{ $title }}</p>
            @endif
            
            <div class="text-sm text-gray-700">
                {{ $slot }}
            </div>
        </div>
        
        <div class="ml-4 flex-shrink-0 flex">
            <button @click="show = false" 
                    class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>