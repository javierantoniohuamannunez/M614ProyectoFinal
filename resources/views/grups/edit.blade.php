<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Grup - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800">
                        Editar Grup
                    </h2>
                    <a href="{{ route('grups.show', $grup) }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 font-medium">
                        ← Tornar al detall
                    </a>
                </div>
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
                        <form action="{{ route('grups.update', $grup) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Información actual -->
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <h3 class="font-bold text-gray-700 mb-2">Grup: {{ $grup->nom }}</h3>
                                <div class="text-sm text-gray-600">
                                    <div>ID: {{ $grup->id }}</div>
                                    <div>Alumnes: {{ $grup->alumnes->count() }}</div>
                                    <div>Creat: {{ $grup->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>

                            <!-- Nombre del grupo -->
                            <div class="mb-6">
                                <label for="nom" class="block text-gray-700 font-medium mb-2">
                                    Nom del Grup *
                                </label>
                                <input type="text" 
                                       name="nom" 
                                       id="nom"
                                       class="w-full border border-gray-300 rounded p-2 @error('nom') border-red-500 @enderror"
                                       value="{{ old('nom', $grup->nom) }}"
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
                                       value="{{ old('aula', $grup->aula) }}"
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
                                
                                <!-- Tutor actual -->
                                @if($grup->professor)
                                    <div class="mb-4 p-3 bg-blue-50 rounded border border-blue-100">
                                        <p class="text-sm text-gray-600 mb-1">Tutor actual:</p>
                                        <p class="font-medium">{{ $grup->professor->nom }} {{ $grup->professor->cognoms }}</p>
                                    </div>
                                @endif

                                @if($professors->count() > 0)
                                    <select name="professor_id" 
                                            id="professor_id"
                                            class="w-full border border-gray-300 rounded p-2 @error('professor_id') border-red-500 @enderror"
                                            required>
                                        <option value="">-- Selecciona un professor --</option>
                                        @foreach($professors as $professor)
                                            <option value="{{ $professor->id }}" 
                                                    {{ old('professor_id', $grup->professor_id) == $professor->id ? 'selected' : '' }}>
                                                {{ $professor->nom }} {{ $professor->cognoms }}
                                                @if(!$professor->grup || $professor->grup->id == $grup->id)
                                                    - Disponible
                                                @else
                                                    - Ocupat ({{ $professor->grup->nom }})
                                                @endif
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
                                @endif
                            </div>

                            <!-- Botones -->
                            <div class="pt-6 border-t border-gray-200 flex gap-4">
                                <a href="{{ route('grups.show', $grup) }}" 
                                   class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-medium">
                                    Cancel·lar
                                </a>
                                
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-medium">
                                    Guardar canvis
                                </button>
                            </div>
                        </form>

                        <!-- Formulario para eliminar -->
                        @auth
                        @if(auth()->user()->rol === 'admin')
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="font-bold text-gray-900 mb-3">Eliminar grup</h3>
                            <p class="text-gray-600 mb-4 text-sm">
                                Atenció: Aquesta acció eliminarà el grup i totes les seves dades.
                                No es pot desfer.
                            </p>
                            <form action="{{ route('grups.destroy', $grup) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Estàs segur que vols eliminar aquest grup?')"
                                        class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 font-medium">
                                    🗑️ Eliminar grup
                                </button>
                            </form>
                        </div>
                        @endif
                        @endauth
                    </div>
                </div>
                @else
                <!-- Mensaje para usuarios no autenticados -->
                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6 text-center">
                        <p class="text-gray-600 mb-4">
                            Necessites estar autenticat per editar grups.
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