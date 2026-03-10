<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nou Mòdul - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Nou Mòdul
                </h2>
            </div>
        </header>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                

                @auth
                <!-- Mensajes de error -->
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <strong class="font-bold">Error!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario -->
                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <form action="{{ route('moduls.store') }}" method="POST">
                            @csrf

                            <!-- Nombre del módulo -->
                            <div class="mb-6">
                                <label for="nom" class="block text-gray-700 font-medium mb-2">
                                    Nom del Mòdul *
                                </label>
                                <input type="text" 
                                       name="nom" 
                                       id="nom"
                                       class="w-full border border-gray-300 rounded p-2 @error('nom') border-red-500 @enderror"
                                       value="{{ old('nom') }}"
                                       placeholder="Ex: Desenvolupament Web en Entorn Client"
                                       required>
                                @error('nom')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Horas -->
                            <div class="mb-6">
                                <label for="hores" class="block text-gray-700 font-medium mb-2">
                                    Nombre d'Hores *
                                </label>
                                <input type="number" 
                                       name="hores" 
                                       id="hores"
                                       class="w-full border border-gray-300 rounded p-2 @error('hores') border-red-500 @enderror"
                                       value="{{ old('hores', 64) }}"
                                       min="1"
                                       max="500"
                                       step="1"
                                       required>
                                @error('hores')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">
                                    Mínim 1 hora. Estàndard: 64h
                                </p>
                            </div>

                            <!-- Professor (opcional) -->
                            <div class="mb-8">
                                <label for="professor_id" class="block text-gray-700 font-medium mb-2">
                                    Professor assignat (opcional)
                                </label>
                                
                                @if($professors->count() > 0)
                                    <select name="professor_id" 
                                            id="professor_id"
                                            class="w-full border border-gray-300 rounded p-2 @error('professor_id') border-red-500 @enderror">
                                        <option value="">-- Sense assignar --</option>
                                        @foreach($professors as $professor)
                                            <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                                                {{ $professor->nom }} {{ $professor->cognoms }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('professor_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-gray-500 text-sm mt-1">
                                        {{ $professors->count() }} professors disponibles
                                    </p>
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4">
                                        <p class="text-yellow-700">
                                            No hi ha professors registrats. 
                                            <a href="{{ route('professors.create') }}" class="text-yellow-800 underline">
                                                Crear un professor
                                            </a>
                                        </p>
                                    </div>
                                    <input type="hidden" name="professor_id" value="">
                                @endif
                            </div>

                            <!-- Botones -->
                            <div class="pt-6 border-t border-gray-200 flex gap-4">
                                <a href="{{ route('moduls.index') }}" 
                                   class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
                                    ← Cancel·lar
                                </a>
                                
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                    Crear Mòdul
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <!-- Mensaje para usuarios no autenticados -->
                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6 text-center">
                        <p class="text-gray-600 mb-4">
                            Necessites estar autenticat per crear nous mòduls.
                        </p>
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Iniciar sessió
                        </a>
                        <a href="{{ route('moduls.index') }}" 
                           class="ml-2 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            Tornar al llistat
                        </a>
                    </div>
                </div>
                @endauth
            </div>
        </main>
    </div>
</body>
</html>