<x-app-layout>
    <x-slot name="header">
        <h2 class="font-senbold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class='w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                    <thead class="bg-gray-50">
                        <tr class="text-gray-600 text-left">
                            <th class="font-senbold text-sm uppercase px-6 py-4">
                                ID
                            </th>
                            <th class="font-senbold text-sm uppercase px-6 py-4">
                                Name
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($companies as $company)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <p class="">
                                                {{ $company->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="">
                                        {{ $company->name }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>
