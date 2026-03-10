<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar {{ $alumne->nom }} - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800">
                        Editar: {{ $alumne->nom }} {{ $alumne->cognoms }}
                    </h2>
                    <a href="{{ route('alumnes.show', $alumne) }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        ← Tornar
                    </a>
                </div>
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

                <!-- Información actual -->
                <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-6">
                    <p class="text-blue-800">
                        <strong>Info:</strong> Creat el {{ $alumne->created_at->format('d/m/Y') }} • 
                        {{ $alumne->moduls->count() }} mòduls • 
                        @if($alumne->grup)
                            Grup: {{ $alumne->grup->nom }}
                        @else
                            Sense grup
                        @endif
                    </p>
                </div>

                <!-- Formulario -->
                <form action="{{ route('alumnes.update', $alumne) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                    @csrf
                    @method('PUT')

                    <!-- Información básica -->
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Dades de l'Alumne</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Nom -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" value="{{ old('nom', $alumne->nom) }}" 
                                   class="w-full border border-gray-300 rounded p-2" required>
                        </div>

                        <!-- Cognoms -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Cognoms <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="cognoms" value="{{ old('cognoms', $alumne->cognoms) }}" 
                                   class="w-full border border-gray-300 rounded p-2" required>
                        </div>

                        <!-- DNI -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                DNI <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="dni" value="{{ old('dni', $alumne->dni) }}" 
                                   class="w-full border border-gray-300 rounded p-2" required>
                        </div>
                                            
                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email" 
                                name="email" 
                                value="{{ old('email', $alumne->email) }}"
                                class="w-full border border-gray-300 rounded p-2"
                                required>
                        </div>

                        <!-- Data Naixement -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Data de Naixement <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="data_naixement" 
                                   value="{{ old('data_naixement', $alumne->data_naixement ? $alumne->data_naixement->format('Y-m-d') : '') }}" 
                                   class="w-full border border-gray-300 rounded p-2" required>
                        </div>

                        <!-- Telèfon -->
                        <div>
                            <label class="block text-gray-700 mb-1">
                                Telèfon
                            </label>
                            <input type="tel" name="telefon" value="{{ old('telefon', $alumne->telefon) }}" 
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
                                        {{ old('grup_id', $alumne->grup_id) == $grup->id ? 'selected' : '' }}>
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
                            <p class="text-gray-600 mb-3">Selecciona els mòduls i posa la nota:</p>
                            
                            <div class="space-y-3">
                                @foreach($moduls as $modul)
                                    @php
                                        $alumneModul = $alumne->moduls->firstWhere('id', $modul->id);
                                        $nota = old("moduls.{$modul->id}.nota", $alumneModul ? $alumneModul->pivot->nota : null);
                                        $selected = old("moduls.{$modul->id}.seleccionat", $alumneModul ? '1' : '0') == '1';
                                    @endphp
                                    
                                    <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                                        <div class="flex items-start">
                                            <input type="checkbox" 
                                                   name="moduls[{{ $modul->id }}][seleccionat]" 
                                                   value="1" 
                                                   id="modul-{{ $modul->id }}"
                                                   class="mt-1 mr-3"
                                                   onchange="toggleNota({{ $modul->id }})"
                                                   {{ $selected ? 'checked' : '' }}>
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
                                                           value="{{ $nota }}"
                                                           {{ !$selected ? 'disabled' : '' }}>
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
                    @if($moduls->count() > 5)
                        <p class=text-red-500>No pots matricular un alumne a més de 5 mòduls</p>
                    @endif

                    <!-- Estadísticas -->
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <h4 class="font-bold mb-2">Estadístiques</h4>
                        <div class="grid grid-cols-4 gap-4 text-center">
                            @php
                                $mitjana = $alumne->moduls->avg('pivot.nota');
                            @endphp
                            <div>
                                <p class="text-xl font-bold">{{ $mitjana ? number_format($mitjana, 1) : '-' }}</p>
                                <p class="text-sm text-gray-600">Mitjana</p>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-blue-600">{{ $alumne->moduls->count() }}</p>
                                <p class="text-sm text-gray-600">Total</p>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-green-600">
                                    {{ $alumne->moduls->where('pivot.nota', '>=', 5)->count() }}
                                </p>
                                <p class="text-sm text-gray-600">Aprovats</p>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-yellow-600">
                                    {{ $alumne->moduls->where('pivot.nota', null)->count() }}
                                </p>
                                <p class="text-sm text-gray-600">Pendents</p>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <div>
                            <a href="{{ route('alumnes.index') }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">
                                Llistat
                            </a>
                            <button type="reset" 
                                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                Netejar
                            </button>
                        </div>
                        
                        <div>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded font-medium hover:bg-green-700 mr-2">
                                Guardar
                            </button>
                            @auth
                            @if(auth()->user()->rol === 'admin')
                            <!-- Botón eliminar con confirmación -->
                            <button type="button"
                                    onclick="if(confirm('⚠️ Eliminar aquest alumne? No es pot desfer.')) { document.getElementById('delete-form').submit(); }"
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                Eliminar
                            </button>
                            @endif
                            @endauth
                        </div>
                    </div>
                </form>

                <!-- Formulario oculto para eliminar -->
                <form id="delete-form" action="{{ route('alumnes.destroy', $alumne) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
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
        
        // Inicializar según checkboxes ya marcados
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($moduls as $modul)
                @php
                    $alumneModul = $alumne->moduls->firstWhere('id', $modul->id);
                @endphp
                @if($alumneModul || old("moduls.{$modul->id}.seleccionat") == '1')
                    toggleNota({{ $modul->id }});
                @endif
            @endforeach
        });
    </script>
</body>
</html>