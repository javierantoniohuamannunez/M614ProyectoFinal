<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnes - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Llistat d'Alumnes
                </h2>
            </div>
        </header>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Mensajes -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filtros (simplificados) -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">Filtres</h3>
                    
                    <form method="GET" action="{{ route('alumnes.index') }}" class="space-y-4">
                        <!-- Búsqueda -->
                        <div>
                            <label class="block text-gray-700 mb-1">Cerca per DNI o Cognoms</label>
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                   class="w-full border border-gray-300 rounded p-2"
                                   placeholder="Ex: 12345678A o García">
                        </div>
                        
                        <!-- Nota mínima -->
                        <div>
                            <label class="block text-gray-700 mb-1">Nota Mínima (0-10)</label>
                            <input type="number" name="nota_minima" value="{{ $notaMinima ?? '' }}"
                                   min="0" max="10" step="0.1"
                                   class="w-full border border-gray-300 rounded p-2"
                                   placeholder="Ex: 5.0">
                        </div>

                        <!-- Grup -->

                        <div>
                            <label class="block text-gray-700 mb-1">Grup</label>
                            <select name="grup_id"
                                id="grup_id"
                                class="w-full border border-gray-300 rounded p-2 @error('professor_id') border-red-500 @enderror"
                                >
                                    <option value="">-- Selecciona un grup --</option>
                                @foreach($grups as $grup)
                                        <option value="{{ $grup->id }}" {{ old('grup_id') == $grup->id ? 'selected' : '' }}>
                                            {{ $grup->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Operador (simple) -->
                        <div>
                            <label class="block text-gray-700 mb-2">Operador</label>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="operador" value="and" 
                                           {{ ($operador ?? 'and') === 'and' ? 'checked' : '' }} class="mr-2">
                                    <span>AND (tots)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="operador" value="or" 
                                           {{ ($operador ?? 'and') === 'or' ? 'checked' : '' }} class="mr-2">
                                    <span>OR (almenys un)</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('alumnes.index') }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Netejar
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Aplicar
                            </button>
                        </div>
                    </form>
                </div>

               <!-- Botón crear destacado -->
                <div class="mb-6">
                    @auth
                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                    <a href="{{ route('alumnes.create') }}" 
                    class="px-4 py-2 rounded-lg font-medium shadow hover:opacity-90"
                    style="background: #1e40af; color: white;">
                        + Nou Alumne
                    </a>
                    @endif
                    @endauth
                </div>

                <!-- Tabla de alumnos -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    @if($alumnes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nom</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">DNI</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Email</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Grup</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Mòduls</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Accions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($alumnes as $alumne)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="font-medium">{{ $alumne->nom }} {{ $alumne->cognoms }}</div>
                                                @if($alumne->telefon)
                                                    <div class="text-sm text-gray-500">📞 {{ $alumne->telefon }}</div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">{{ $alumne->dni }}</td>
                                            @if($alumne->email)
                                                <td class="px-4 py-3">{{ $alumne->email }}</td>
                                            @else
                                                <td class="px-4 py-3">---</td>
                                            @endif
                                            <td class="px-4 py-3">
                                                @if($alumne->grup)
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                                        {{ $alumne->grup->nom }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($alumne->moduls->count() > 0)
                                                    <div class="text-sm">
                                                        <span class="font-medium">{{ $alumne->moduls->count() }} mòduls</span>
                                                        @php
                                                            $mitjana = $alumne->moduls->avg('pivot.nota');
                                                        @endphp
                                                        @if($mitjana)
                                                            <div class="text-gray-600">
                                                                Mitjana: {{ number_format($mitjana, 2) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">Cap</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('alumnes.show', $alumne) }}" 
                                                       class="text-blue-600 hover:text-blue-800">
                                                        Veure
                                                    </a>
                                                    
                                                    @auth
                                                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                                                    <a href="{{ route('alumnes.edit', $alumne) }}" 
                                                       class="text-green-600 hover:text-green-800">
                                                        Editar
                                                    </a>
                                                    @endif
                                                    @if(auth()->user()->rol === 'admin')
                                                    <form action="{{ route('alumnes.destroy', $alumne) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Eliminar {{ $alumne->nom }}?')"
                                                                class="text-red-600 hover:text-red-800">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @endauth
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Estadísticas simples -->
                        <div class="p-4 bg-gray-50 border-t border-gray-200">
                            <h4 class="font-bold mb-2">Resum</h4>
                            <div class="grid grid-cols-4 gap-4 text-center">
                                <div>
                                    <p class="text-xl font-bold">{{ $alumnes->count() }}</p>
                                    <p class="text-sm text-gray-600">Total</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-green-600">
                                        {{ $alumnes->where('grup_id', '!=', null)->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Amb grup</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-blue-600">
                                        {{ $alumnes->filter(fn($a) => $a->moduls->count() > 0)->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Amb mòduls</p>
                                </div>
                                <div>
                                    @php
                                        $totalNotes = 0;
                                        $notesCount = 0;
                                        foreach($alumnes as $alumne) {
                                            foreach($alumne->moduls as $modul) {
                                                if ($modul->pivot->nota !== null) {
                                                    $totalNotes += $modul->pivot->nota;
                                                    $notesCount++;
                                                }
                                            }
                                        }
                                        $mitjanaNotes = $notesCount > 0 ? $totalNotes / $notesCount : 0;
                                    @endphp
                                    <p class="text-xl font-bold text-purple-600">
                                        {{ number_format($mitjanaNotes, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-600">Mitjana notes</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">No s'han trobat alumnes.</p>
                            @auth
                            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                            <a href="{{ route('alumnes.create') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                + Crear primer alumne
                            </a>
                            @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>