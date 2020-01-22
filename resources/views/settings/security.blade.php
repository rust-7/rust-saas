@extends('app')

@section('title', 'Security Settings')

@section('content')
    <div class="bg-gray-100 min-h-screen pb-24">
        
        @include('partials.dashboard-header')

        <div class="container mx-auto max-w-3xl mt-8">
            <h1 class="text-2xl font-bold text-gray-700 px-6 md:px-0">Security Settings</h1>
            
            @include('settings.nav')

            <form action="{{ route('security.save') }}" method="POST" enctype="multipart/form-data">
                
                @csrf

                <div class="w-full bg-white rounded-lg mx-auto mt-8 flex overflow-hidden rounded-b-none">
                    <div class="w-1/3 bg-gray-100 p-8 hidden md:inline-block">
                        <h2 class="font-medium text-md text-gray-700 mb-4 tracking-wide">Security Settings</h2>
                        <p class="text-xs text-gray-500">Update your user password</p>
                    </div>
                    <div class="md:w-2/3 w-full">
                        <div class="py-8 px-16">
                            <label for="password" class="text-sm text-gray-600">Password</label>
                            <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-indigo-500" type="password" value="" name="password">
                        </div>
                        <hr class="border-gray-200">

                        <div class="py-8 px-16">
                            <label for="password_confirmation" class="text-sm text-gray-600">Password Confirmation</label>
                            <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-indigo-500" type="password" value="" name="password_confirmation">
                        </div>
                        <hr class="border-gray-200">
                    </div>
                </div>

                <div class="p-16 py-8 bg-white clearfix rounded-b-lg border-t border-gray-200">
                    <p class="float-left text-sm text-gray-500 tracking-tight mt-2">Click on Save to update your Security Settings</p>
                    <input type="submit" class="bg-green-500 text-white text-sm font-medium px-6 py-2 rounded float-right cursor-pointer" value="Save">
                </div>
            </form>
        </div>
    </div>
@endsection