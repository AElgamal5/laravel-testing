<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    @if (auth()->user()->is_admin)
        <div class="py-1">
            <div class="p-6 text-blue-900 dark:text-blue-700">
                <a href="{{ route('products.create') }}">
                    Create New A Product
                </a>
            </div>
        </div>
    @else
        <br>
    @endif

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-colors duration-300">
        <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                    <th class="py-2 px-4 border border-gray-300 dark:border-gray-600">ID</th>
                    <th class="py-2 px-4 border border-gray-300 dark:border-gray-600">Name</th>
                    <th class="py-2 px-4 border border-gray-300 dark:border-gray-600">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $prodcut)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td
                            class="py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                            {{ $prodcut->id }}
                        </td>
                        <td
                            class="py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                            {{ $prodcut->name }}
                        </td>
                        <td
                            class="py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                            {{ $prodcut->price }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
