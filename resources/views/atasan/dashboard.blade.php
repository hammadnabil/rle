@extends('layouts.app')

@section('content')
<div class="min-h-screen flex bg-gray-100">
 
   


    
    <main class="flex-1 p-10">
        <div class="bg-white rounded-lg shadow-lg p-8 transition hover:shadow-xl">
            <h1 class="text-2xl font-semibold text-gray-800 mb-2">Dashboard Atasan</h1>
             <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>


            
        </div>
    </main>
</div>
@endsection
