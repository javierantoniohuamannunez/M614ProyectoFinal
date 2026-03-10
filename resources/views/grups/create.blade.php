<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nou Grup - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Nou Grup
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
                        <form action="{{ route('grups.store') }}" method="POST">
                            @csrf

                            <!-- Nombre del grupo -->
                            <div class="mb-6">
                                <label for="nom" class="block text-gray-700 font-medium mb-2">
                                    Nom del Grup *
                                </label>
                                <input type="text" 
                                       name="nom" 
                                       id="nom"
                                       class="w-full border border-gray-300 rounded p-2 @error('nom') border-red-500 @enderror"
                                       value="{{ old('nom') }}"
                                       placeholder="Ex: 2DAW, 1ASIX"
                                       required>
                                @error('nom')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Aula -->
                            <div class="mb-6">
                                <label for="aula" class="block text-gray-700 font-medium mb-2">
                                    Aula Assignada *
                                </label>
                                <input type="text" 
                                       name="aula" 
                                       id="aula"
                                       class="w-full border border-gray-300 rounded p-2 @error('aula') border-red-500 @enderror"
                                       value="{{ old('aula') }}"
                                       placeholder="Ex: A101, B205"
                                       required>
                                @error('aula')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tutor -->
                            <div class="mb-8">
                                <label for="professor_id" class="block text-gray-700 font-medium mb-2">
                                    Tutor del Grup *
                                </label>
                                
                                @if($professorsLliures && $professorsLliures->count() > 0)
                                    <select name="professor_id" 
                                            id="professor_id"
                                            class="w-full border border-gray-300 rounded p-2 @error('professor_id') border-red-500 @enderror"
                                            required>
                                        <option value="">-- Selecciona un professor --</option>
                                        @foreach($professorsLliures as $professor)
                                            <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                                                {{ $professor->nom }} {{ $professor->cognoms }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('professor_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-gray-500 text-sm mt-1">
                                        {{ $professorsLliures->count() }} professors disponibles (sense grup)
                                    </p>
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-4">
                                        <p class="text-yellow-700">
                                            No hi ha professors disponibles. Tots els professors ja tenen un grup assignat.
                                        </p>
                                    </div>
                                    <p class="text-red-500 text-sm font-medium mb-4">
                                        ⚠️ No es pot crear un grup sense tutor assignat.
                                    </p>
                                    <div class="flex gap-2">
                                        <a href="{{ route('professors.create') }}" 
                                           class="bg-blue-600 text-white px-6 py-2 rounded font-medium hover:bg-blue-700">
                                            + Crear nou professor
                                        </a>
                                        <a href="{{ route('grups.index') }}" 
                                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm font-medium">
                                            Tornar al llistat
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Botones -->
                            <div class="pt-6 border-t border-gray-200 flex gap-4">
                                <a href="{{ route('grups.index') }}" 
                                   class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-medium">
                                    Cancel·lar
                                </a>
                                
                                @if($professorsLliures && $professorsLliures->count() > 0)
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded font-medium hover:bg-blue-700">
                                    Crear Grup
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <!-- Mensaje para usuarios no autenticados -->
                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6 text-center">
                        <p class="text-gray-600 mb-4">
                            Necessites estar autenticat per crear nous grups.
                        </p>
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Iniciar sessió
                        </a>
                        <a href="{{ route('grups.index') }}" 
                           class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 font-medium">
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