<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Регистрация нового пользователя
        </h2>
    </x-slot>
    <div class="flex justify-center mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
            <li class="mr-1" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="teacher-tab" data-tabs-target="#teacher" type="button" role="tab" aria-controls="teacher" aria-selected="false">Teacher</button>
            </li>
            <li class="mr-1" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="student-tab" data-tabs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="false">Student</button>
            </li>
            <li class="mr-1" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="parent-tab" data-tabs-target="#parent" type="button" role="tab" aria-controls="parent" aria-selected="false">Parent</button>
            </li>
            <li role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="admin-tab" data-tabs-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="false">Admin</button>
            </li>
        </ul>
    </div>
    <div id="myTabContent" class="flex items-center max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="hidden w-full px-6 py-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
            <form method="POST" action="{{ route('register') }}">
                @csrf
        
                <input type="hidden" name="role" id="role" type="text" value="teacher">

                <!-- id -->
                <div>
                    <x-input-label for="id" :value="__('ИИН')" />
                    <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id')" required autofocus />
                    <x-input-error :messages="$errors->get('id')" class="mt-2" />
                </div>
        
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <!-- middleName -->
                <div>
                    <x-input-label for="middlename" :value="__('Отчество(необязательно)')" />
                    <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')"/>
                    <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
                </div>
                
                <!-- Surname -->
                <div>
                    <x-input-label for="surname" :value="__('Surname')" />
                    <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
        
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <!-- position -->
                <div>
                    <x-input-label for="position" :value="__('Должность')" />
                    <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')"/>
                    <x-input-error :messages="$errors->get('position')" class="mt-2" />
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="hidden w-full px-6 py-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="student" role="tabpanel" aria-labelledby="student-tab">
            <form method="POST" action="{{ route('register') }}">
                @csrf
        
                <!-- id -->
                <div>
                    <x-input-label for="id" :value="__('ИИН')" />
                    <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id')" required autofocus />
                    <x-input-error :messages="$errors->get('id')" class="mt-2" />
                </div>
        
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <!-- middleName -->
                <div>
                    <x-input-label for="middlename" :value="__('Отчество(необязательно)')" />
                    <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')"/>
                    <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
                </div>
                
                <!-- Surname -->
                <div>
                    <x-input-label for="surname" :value="__('Surname')" />
                    <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
        
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <!-- year -->
                <div>
                    <x-input-label for="year" :value="__('Год поступления')" />
                    <x-text-input id="year" class="block mt-1 w-full" type="number" min=2013 max="{{ date('Y');}}" name="year" value=2018 />
                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                </div>
                
                <!-- grade -->
                <div>
                    <x-input-label for="grade" :value="__('Класс')" />
                    <x-select-input id="grade" name="grade" :options="['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']" required/>
                    <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                </div>
                
                <input type="hidden" name="role" type="text" value="student">
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="hidden w-full px-6 py-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="parent" role="tabpanel" aria-labelledby="parent-tab">
            <form method="POST" action="{{ route('register') }}">
                @csrf
        
                <!-- id -->
                <div>
                    <x-input-label for="id" :value="__('ИИН')" />
                    <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id')" required autofocus />
                    <x-input-error :messages="$errors->get('id')" class="mt-2" />
                </div>
        
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <!-- middleName -->
                <div>
                    <x-input-label for="middlename" :value="__('Отчество(необязательно)')" />
                    <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')"/>
                    <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
                </div>
                
                <!-- Surname -->
                <div>
                    <x-input-label for="surname" :value="__('Surname')" />
                    <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
        
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                
                <input type="hidden" name="role" type="text" value="parent">
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="hidden w-full px-6 py-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="admin" role="tabpanel" aria-labelledby="admin-tab">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <input type="hidden" name="role" type="text" value="admin">
        
                <!-- id -->
                <div>
                    <x-input-label for="id" :value="__('ИИН')" />
                    <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id')" required autofocus />
                    <x-input-error :messages="$errors->get('id')" class="mt-2" />
                </div>
        
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <!-- middleName -->
                <div>
                    <x-input-label for="middlename" :value="__('Отчество(необязательно)')" />
                    <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')"/>
                    <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
                </div>
                
                <!-- Surname -->
                <div>
                    <x-input-label for="surname" :value="__('Surname')" />
                    <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
        
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <!-- position -->
                <div>
                    <x-input-label for="position" :value="__('Должность')" />
                    <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')"/>
                    <x-input-error :messages="$errors->get('position')" class="mt-2" />
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
