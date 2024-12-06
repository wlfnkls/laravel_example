<x-app-layout>
    <x-slot name="header">
        <h2 class="font-senbold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session()->has('status'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-12">
            <div class="alert flex flex-row items-center bg-green-200 p-5 rounded border-b-2 border-green-300">
                <div
                    class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                    <span class="text-green-500">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </div>
                <div class="alert-content ml-4">
                    <div class="alert-title font-senbold text-lg text-green-800">
                        Success
                    </div>
                    <div class="alert-description text-sm text-green-600">
                        {{ session()->get('status') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->role_id == '1')
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form id="company" :action="route('dashboard')"
                    method="get">
                    <select name="company_id" id="company_id"
                        class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        @foreach ($companies as $company)
                            <option {{ app('request')->input('company_id') == $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <script>
            const company = document.getElementById('company_id');
            if (company) {
                company.addEventListener('change', ev => {
                    ev.preventDefault();
                    document.getElementById('company').submit();
                })
            }

        </script>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
                <table class='w-full whitespace-nowrap rounded-lg bg-white overflow-hidden'>
                    <thead class="bg-black">
                        <tr class="text-white text-left">
                            <th class="font-senbold text-sm uppercase px-6 py-4">
                            </th>
                            <th class="font-senbold text-sm uppercase px-6 py-4">
                                Name
                            </th>
                            <th class="font-senbold text-sm uppercase px-6 py-4">
                                Email
                            </th>
                            <th class="font-senbold text-sm uppercase px-6 py-4">
                                Department <span class="text-xs text-gray-400">(internal Name)</span>
                            </th>
                            <th class="font-senbold text-sm uppercase px-6 py-4">
                                Form sent
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr>
                                <td
                                    class="pl-6 py-4 {{ $user->id == Auth::user()->id ? 'bg-primary bg-opacity-20' : '' }}">
                                    <a href="{{ route('edit', $user->id) }}"
                                        class="py-2 px-4 shadow-md no-underline rounded-full bg-gray-500 text-white">edit</a>
                                </td>
                                {{-- {{ Auth::user()->id }} --}}
                                <td
                                    class="px-6 py-4 {{ $user->id == Auth::user()->id ? 'bg-primary bg-opacity-20' : '' }}">
                                    <p class="">
                                        {{ $user->name }}
                                    </p>
                                </td>
                                <td
                                    class="px-6 py-4 {{ $user->id == Auth::user()->id ? 'bg-primary bg-opacity-20' : '' }}">
                                    <p class="">
                                        {{ $user->email }}
                                    </p>
                                </td>
                                <td
                                    class="px-6 py-4 {{ $user->id == Auth::user()->id ? 'bg-primary bg-opacity-20' : '' }}">
                                    <p class="">
                                        {{-- {{dd($user->department()->first())}} --}}
                                        @if ($user->department()->first() !== null)
                                            {{ $user->department()->first()->name }} <span
                                                class="text-sm text-gray-400">({{ $user->department }})</span>
                                        @endif
                                    </p>
                                </td>
                                <td
                                    class="px-6 py-4 {{ $user->id == Auth::user()->id ? 'bg-primary bg-opacity-20' : '' }}">
                                    @if ($user->form_sent)
                                        <button
                                            class="py-2 px-4 shadow-md no-underline rounded-full bg-primary text-white">true</button>
                                    @else
                                        <button
                                            class="py-2 px-4 shadow-md no-underline rounded-full bg-red-700 text-white">false</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex justify-center space-x-48 bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto py-8">
                <canvas class="w-1/2" id="myDonut" data-js-sent="{{ count($results) }}"
                    data-js-not-sent="{{ count($users) }}"></canvas>
                @if (count($results) > 0)
                    <canvas id="myChart"></canvas>
                @else
                    <div class="self-center w-1/2 bg-gray-100 p-8 rounded-lg flex justify-center">
                        <h2 class="text-3xl">Es liegen noch keine Daten vor!</h2>
                        {{-- <p>Der Reifegrad Ihrer Firma hängt von den eingereichten Formularen und dessen Antworten ab.</p> --}}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- @if (count($results) > 0)
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto py-8">
                    <canvas id="myChart" max-width="200" max-height="200"></canvas>
                </div>
            </div>
        </div>
    @endif --}}

</x-app-layout>
