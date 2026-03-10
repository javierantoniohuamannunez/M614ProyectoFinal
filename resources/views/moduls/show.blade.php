<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $modul->nom }} - Institut Carles Vallbona</title>
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
                        Detalls del Mòdul
                    </h2>
                    <a href="{{ route('moduls.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        ← Tornar al llistat
                    </a>
                </div>
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

                <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <!-- Información básica -->
                        <div class="mb-8">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ $modul->nom }}
                            </h1>
                            <div class="flex flex-wrap gap-4 mb-4">
                                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $modul->hores }} hores
                                </div>
                                <div class="text-gray-600">
                                    ID: {{ $modul->id }}
                                </div>
                                <div class="text-gray-600">
                                    Creat: {{ $modul->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Información -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Información del profesor -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg text-gray-900 mb-3">👨‍🏫 Professor assignat</h3>
                                @if($modul->professor)
                                    <div class="flex items-center gap-4">
                                        @if($modul->professor->foto)
                                            <img src="{{ asset('uploads/fotos/' . $modul->professor->foto) }}"
                                                 alt="Foto de {{ $modul->professor->nom }}"
                                                 class="w-12 h-12 rounded-full object-cover border border-gray-300">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-lg">👨‍🏫</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium">{{ $modul->professor->nom }} {{ $modul->professor->cognoms }}</p>
                                            <p class="text-sm text-gray-600">{{ $modul->professor->email }}</p>
                                            <a href="{{ route('professors.show', $modul->professor) }}"
                                               class="text-blue-600 hover:text-blue-800 text-sm">
                                                Veure perfil →
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">No té professor assignat</p>
                                        @auth
                                        <a href="{{ route('moduls.edit', $modul) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            Assignar professor
                                        </a>
                                        @endauth
                                    </div>
                                @endif
                            </div>

                            <!-- Estadísticas -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg text-gray-900 mb-3">📊 Estadístiques</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center">
                                        <p class="text-2xl font-bold text-purple-600">
                                            {{ $modul->alumnes ? $modul->alumnes->count() : 0 }}
                                        </p>
                                        <p class="text-sm text-gray-600">Alumnes</p>
                                    </div>
                                    <div class="text-center">
                                        @php
                                            $mitjana = $modul->alumnes ? $modul->alumnes->avg('pivot.nota') : null;
                                        @endphp
                                        <p class="text-2xl font-bold text-green-600">
                                            @if(!is_null($mitjana))
                                                {{ number_format($mitjana, 1) }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600">Nota mitjana</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alumnos matriculados -->
                        <div class="mb-8">
                            <h3 class="font-bold text-xl text-gray-900 mb-4">👥 Alumnes matriculats</h3>
                            
                            @if($modul->alumnes && $modul->alumnes->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nom</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Grup</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nota</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Accions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($modul->alumnes as $alumne)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3">
                                                        <div class="font-medium">{{ $alumne->nom }} {{ $alumne->cognoms }}</div>
                                                        <div class="text-sm text-gray-500">DNI: {{ $alumne->dni }}</div>
                                                    </td>
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
                                                        @if($alumne->pivot->nota !== null)
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                                @if($alumne->pivot->nota >= 5) bg-green-100 text-green-800
                                                                @elseif($alumne->pivot->nota >= 3) bg-yellow-100 text-yellow-800
                                                                @else bg-red-100 text-red-800
                                                                @endif">
                                                                {{ $alumne->pivot->nota }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400">No avaluat</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <a href="{{ route('alumnes.show', $alumne) }}" 
                                                           class="text-blue-600 hover:text-blue-800">
                                                            Veure
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500">Encara no hi ha alumnes matriculats en aquest mòdul.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Botones de acción -->
                        @auth
                        @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                        <div class="pt-6 border-t border-gray-200 flex gap-4">
                            <a href="{{ route('moduls.edit', $modul) }}" 
                               class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                ✏️ Editar
                            </a>
                        @endif
                        @if(auth()->user()->rol === 'admin')
                            <form action="{{ route('moduls.destroy', $modul) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Estàs segur que vols eliminar aquest mòdul?')"
                                        class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>