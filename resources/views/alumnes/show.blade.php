<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $alumne->nom }} - Detalls</title>
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
                        Alumne: {{ $alumne->nom }} {{ $alumne->cognoms }}
                    </h2>
                    <a href="{{ route('alumnes.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        ← Tornar
                    </a>
                </div>
            </div>
        </header>

        <main class="py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Mensajes -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Información principal -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">Informació de l'Alumne</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Nom complet</p>
                            <p class="text-xl font-bold">{{ $alumne->nom }} {{ $alumne->cognoms }}</p>
                        </div>
                        
                        <div>
                            <p class="text-gray-600">DNI</p>
                            <p class="text-xl font-bold">{{ $alumne->dni }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Email</p>
                            <p class="text-xl">{{ $alumne->email }}</p>
                        
                        <div>
                            <p class="text-gray-600">Data de naixement</p>
                            <p class="text-xl">
                                @if($alumne->data_naixement)
                                    {{ $alumne->data_naixement->format('d/m/Y') }}
                                    ({{ $alumne->data_naixement->age }} anys)
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-gray-600">Telèfon</p>
                            <p class="text-xl">
                                {{ $alumne->telefon ?: '-' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-gray-600">Grup</p>
                            <p class="text-xl">
                                @if($alumne->grup)
                                    {{ $alumne->grup->nom }} ({{ $alumne->grup->aula }})
                                @else
                                    Sense grup
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">Estadístiques</h3>
                    
                    @php
                        $totalModuls = $alumne->moduls->count();
                        $aprovats = $alumne->moduls->where('pivot.nota', '>=', 5)->count();
                        $suspesos = $alumne->moduls->where('pivot.nota', '<', 5)->where('pivot.nota', '!=', null)->count();
                        $pendents = $alumne->moduls->where('pivot.nota', null)->count();
                        $mitjana = $totalModuls > 0 ? $alumne->moduls->avg('pivot.nota') : null;
                    @endphp
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="text-2xl font-bold text-blue-600">{{ $totalModuls }}</p>
                            <p class="text-gray-600">Total mòduls</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded">
                            <p class="text-2xl font-bold text-green-600">{{ $aprovats }}</p>
                            <p class="text-gray-600">Aprovats</p>
                        </div>
                        
                        <div class="bg-red-50 p-4 rounded">
                            <p class="text-2xl font-bold text-red-600">{{ $suspesos }}</p>
                            <p class="text-gray-600">Suspesos</p>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded">
                            <p class="text-2xl font-bold text-yellow-600">
                                {{ $mitjana ? number_format($mitjana, 2) : '-' }}
                            </p>
                            <p class="text-gray-600">Mitjana</p>
                        </div>
                    </div>
                </div>

                <!-- Módulos -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Mòduls Matriculats</h3>
                        <span class="text-gray-600">{{ $totalModuls }} mòduls</span>
                    </div>
                    
                    @if($totalModuls > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Mòdul</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Hores</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nota</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Estat</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($alumne->moduls as $modul)
                                        @php
                                            $nota = $modul->pivot->nota;
                                            if ($nota === null) {
                                                $color = 'text-yellow-600';
                                                $bg = 'bg-yellow-100';
                                                $estat = 'Pendent';
                                            } elseif ($nota >= 5) {
                                                $color = 'text-green-600';
                                                $bg = 'bg-green-100';
                                                $estat = 'Aprovat';
                                            } else {
                                                $color = 'text-red-600';
                                                $bg = 'bg-red-100';
                                                $estat = 'Suspes';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-3">{{ $modul->nom }}</td>
                                            <td class="px-4 py-3">{{ $modul->hores }} h</td>
                                            <td class="px-4 py-3">
                                                {{ $nota !== null ? number_format($nota, 1) : '-' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="{{ $bg }} {{ $color }} px-2 py-1 rounded-full text-xs">
                                                    {{ $estat }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">L'alumne no té mòduls matriculats.</p>
                    @endif
                </div>

                <!-- Botones -->
                @auth
                <div class="mt-6 flex justify-between">
                    <div>
                        <a href="{{ route('alumnes.index') }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Llistat alumnes
                        </a>
                    </div>
                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                    <div class="space-x-2">
                        <a href="{{ route('alumnes.edit', $alumne) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Editar
                        </a>
                    @endif
                    @if(auth()->user()->rol === 'admin')    
                        <form action="{{ route('alumnes.destroy', $alumne) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Eliminar aquest alumne?')"
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                Eliminar
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                @endauth
            </div>
        </main>
    </div>
</body>
</html>