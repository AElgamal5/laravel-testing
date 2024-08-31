<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="p-6 text-blue-900 dark:text-blue-100">
            <a href="{{ route('products.create') }}">
                Create New A Product
            </a>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th class="px-3">No.</th>
                                <th class="px-3">Name</th>
                                <th class="px-3">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $prodcut)
                                <tr>
                                    <td class="px-3">{{ $prodcut->id }} </td>
                                    <td class="px-3">{{ $prodcut->name }} </td>
                                    <td class="px-3">{{ $prodcut->price }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
