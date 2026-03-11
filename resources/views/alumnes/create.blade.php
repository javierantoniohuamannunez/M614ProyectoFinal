<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nou Alumne - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Crear alumne              
                  </h2>
            </div>
        </header>

        <main class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Mensajes -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <strong>Error!</strong>
                        <ul class="mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Cookie info (simple) -->
                @if($ultimGrup)
                    <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-6">
                        <p class="text-blue-800">
                            <strong>Info:</strong> S'ha preseleccionat el grup <strong>{{ $ultimGrup->nom }}</strong> 
                            per ser l'últim que vas seleccionar.
                        </p>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('alumnes.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                    @csrf

                    <!-- Información básica -->
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Dades de l'Alumne</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Nom -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" value="{{ old('nom') }}" 
                                   class="w-full border border-gray-300 rounded p-2" required>
                        </div>

                        <!-- Cognoms -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Cognoms <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="cognoms" value="{{ old('cognoms') }}" 
                                   class="w-full border border-gray-300 rounded p-2" required>
                        </div>

                        <!-- DNI -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                DNI <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="dni" value="{{ old('dni') }}" 
                                   class="w-full border border-gray-300 rounded p-2" 
                                   placeholder="12345678A" required>
                        </div>
                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded p-2"
                                required>
                        </div>

                        <!-- Data Naixement -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Data de Naixement <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="data_naixement" value="{{ old('data_naixement') }}" 
                                   class="w-full border border-gray-300 rounded p-2" required>
                        </div>

                        <!-- Telèfon -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Telèfon
                            </label>
                            <input type="tel" name="telefon" value="{{ old('telefon') }}" 
                                   class="w-full border border-gray-300 rounded p-2">
                        </div>

                        <!-- Grup -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Grup
                            </label>
                            <select name="grup_id" class="w-full border border-gray-300 rounded p-2">
                                <option value="">-- Selecciona un grup --</option>
                                @foreach($grups as $grup)
                                    <option value="{{ $grup->id }}" 
                                        {{ old('grup_id', $ultimGrup->id ?? '') == $grup->id ? 'selected' : '' }}>
                                        {{ $grup->nom }} ({{ $grup->aula }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Módulos -->
                    <h3 class="text-lg font-bold mb-4 text-gray-800 mt-8">Mòduls Matriculats</h3>
                    
                    @if($moduls->count() > 0)
                        <div class="mb-6">
                            <p class="text-gray-600 mb-3">Selecciona els mòduls i posa la nota si vols:</p>
                            
                            <div class="space-y-3">
                                @foreach($moduls as $modul)
                                    <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                                        <div class="flex items-start">
                                            <input type="checkbox" 
                                                   name="moduls[{{ $modul->id }}][seleccionat]" 
                                                   value="1" 
                                                   id="modul-{{ $modul->id }}"
                                                   class="mt-1 mr-3"
                                                   onchange="toggleNota({{ $modul->id }})">
                                            <div class="flex-1">
                                                <label for="modul-{{ $modul->id }}" class="font-medium cursor-pointer">
                                                    {{ $modul->nom }}
                                                </label>
                                                <p class="text-sm text-gray-500">
                                                    {{ $modul->hores }} hores
                                                    @if($modul->professor)
                                                        · Professor: {{ $modul->professor->nom }}
                                                    @endif
                                                </p>
                                                
                                                <div class="mt-2">
                                                    <label class="text-sm text-gray-600 mr-2">Nota:</label>
                                                    <input type="number" 
                                                           name="moduls[{{ $modul->id }}][nota]" 
                                                           id="nota-{{ $modul->id }}"
                                                           class="border border-gray-300 rounded p-1 w-20"
                                                           min="0" max="10" step="0.1"
                                                           placeholder="0-10"
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 mb-6">No hi ha mòduls disponibles.</p>
                    @endif

                    <!-- Simular error (para transacciones) -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="simular_error" class="mr-2">
                            <span class="text-red-600 font-medium">
                                Simular error (per provar transaccions)
                            </span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1">
                            Si marques això, es simularà un error i no es guardarà res.
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('alumnes.index') }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            ← Tornar
                        </a>
                        
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded font-medium hover:bg-blue-700">
                            Crear Alumne
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function toggleNota(modulId) {
            const checkbox = document.getElementById('modul-' + modulId);
            const notaInput = document.getElementById('nota-' + modulId);
            
            if (checkbox.checked) {
                notaInput.disabled = false;
            } else {
                notaInput.disabled = true;
                notaInput.value = '';
            }
        }
        
        // Inicializar notas según checkboxes ya marcados (si hay errores de validación)
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($moduls as $modul)
                @if(old("moduls.{$modul->id}.seleccionat") == '1')
                    toggleNota({{ $modul->id }});
                    document.getElementById('modul-{{ $modul->id }}').checked = true;
                @endif
            @endforeach
        });
    </script>
</body>
</html>