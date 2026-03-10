<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professors - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Llistat de Professors
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

                <!-- Botón crear destacado -->
                <div class="mb-6">
                    @auth
                    <a href="{{ route('professors.create') }}" 
                    class="px-4 py-2 rounded-lg font-medium shadow hover:opacity-90"
                    style="background: #1e40af; color: white;">
                        + Nou Professor
                    </a>
                    @endauth
                </div>

                <!-- Tabla de profesores -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    @if($professors->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Foto</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nom</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Email</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Mòduls</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Accions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($professors as $professor)
                                        <tr class="hover:bg-gray-50">
                                            <!-- Foto -->
                                            <td class="px-4 py-3">
                                                @if($professor->foto)
                                                    <img src="{{ asset('uploads/fotos/' . $professor->foto) }}"
                                                         alt="Foto" 
                                                         class="w-12 h-12 rounded-full object-cover border border-gray-300">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <span class="text-lg">👨‍🏫</span>
                                                    </div>
                                                @endif
                                            </td>
                                            
                                            <!-- Nombre -->
                                            <td class="px-4 py-3">
                                                <div class="font-medium">{{ $professor->nom }} {{ $professor->cognoms }}</div>
                                            </td>
                                            
                                            <!-- Email -->
                                            <td class="px-4 py-3">{{ $professor->email }}</td>
                                            
                                            <!-- Módulos -->
                                            <td class="px-4 py-3">
                                                @if($professor->moduls->count() > 0)
                                                    <div class="text-sm">
                                                        <span class="font-medium">{{ $professor->moduls->count() }} mòduls</span>
                                                        <div class="text-gray-600">
                                                            Total hores: {{ $professor->moduls->sum('hores') }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">Cap</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Acciones -->
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('professors.show', $professor) }}" 
                                                       class="text-blue-600 hover:text-blue-800">
                                                        Veure
                                                    </a>
                                                    
                                                    @auth
                                                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                                                    <a href="{{ route('professors.edit', $professor) }}" 
                                                       class="text-green-600 hover:text-green-800">
                                                        Editar
                                                    </a>
                                                    @endif
                                                    @if(auth()->user()->rol === 'admin')
                                                    <form action="{{ route('professors.destroy', $professor) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Eliminar {{ $professor->nom }}?')"
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
                                    <p class="text-xl font-bold">{{ $professors->count() }}</p>
                                    <p class="text-sm text-gray-600">Total</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-green-600">
                                        {{ $professors->whereNotNull('foto')->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Amb foto</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-blue-600">
                                        {{ $professors->filter(fn($p) => $p->moduls->count() > 0)->count() }}
                                    </p>
                                    <p class="text-sm text-gray-600">Imparteixen</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-purple-600">
                                        {{ $professors->sum(fn($p) => $p->moduls->sum('hores')) }}
                                    </p>
                                    <p class="text-sm text-gray-600">Hores totals</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">No s'han trobat professors.</p>
                            @auth
                            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                            <a href="{{ route('professors.create') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                + Crear primer professor
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