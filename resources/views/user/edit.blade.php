<x-app-layout>
    <x-slot name="header">
        <h2 class="font-senbold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('update', $user->id) }}">
                        @csrf

                        <input type="hidden" name="_method" value="PUT" />

                        {{-- {{ Auth::user()->_id }} --}}

                        @if (Auth::user()->role_id == '1')

                            <!-- Company -->
                            <div class="mt-4">
                                <x-label for="company_id" :value="__('Company')" />

                                <select name="company_id" id="company_id"
                                    class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    @foreach ($companies as $company)
                                        <option {{ $user->company_id == $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Role -->
                            <div class="mt-4">
                                <x-label for="role_id" :value="__('Role')" />

                                <select name="role_id" id="role_id"
                                    class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    @foreach ($roles as $role)
                                        <option {{ $user->role_id == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Department -->
                        <div class="mt-4">
                            <x-label for="department_id" :value="__('Department')" />

                            <select name="department_id" id="department_id"
                                class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="" selected>Bitte wählen</option>
                                @foreach ($departments as $department)
                                    <option {{ $user->department_id == $department->id ? 'selected' : '' }}
                                        value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department Name -->
                        <div class="mt-4">
                            <x-label for="department" :value="__('Internal Department Name')" />

                            <x-input id="department" class="block mt-1 w-full" type="text" name="department"
                                :value="($user->department)" autofocus />
                        </div>

                        <!-- Name -->
                        <div class="mt-4">
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="($user->name)"
                                required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="($user->email)" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Edit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
