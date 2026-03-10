<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $grup->nom }} - Institut Carles Vallbona</title>
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
                        Detalls del Grup
                    </h2>
                    <a href="{{ route('grups.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 font-medium">
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
                                {{ $grup->nom }}
                            </h1>
                            <div class="flex flex-wrap gap-4 mb-4">
                                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    🏫 {{ $grup->aula }}
                                </div>
                                <div class="text-gray-600">
                                    ID: {{ $grup->id }}
                                </div>
                                <div class="text-gray-600">
                                    Creat: {{ $grup->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Información del tutor -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="font-bold text-lg text-gray-900 mb-3">👨‍🏫 Tutor del grup</h3>
                                @if($grup->professor)
                                    <div class="flex items-center gap-4">
                                        @if($grup->professor->foto)
                                            <img src="{{ asset('uploads/fotos/' . $grup->professor->foto) }}"
                                                 alt="Foto de {{ $grup->professor->nom }}"
                                                 class="w-12 h-12 rounded-full object-cover border border-gray-300">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-lg">👨‍🏫</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium">{{ $grup->professor->nom }} {{ $grup->professor->cognoms }}</p>
                                            <p class="text-sm text-gray-600">{{ $grup->professor->email }}</p>
                                            <a href="{{ route('professors.show', $grup->professor) }}"
                                               class="text-blue-600 hover:text-blue-800 text-sm">
                                                Veure perfil →
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">No té tutor assignat</p>
                                        @auth
                                        <a href="{{ route('grups.edit', $grup) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            Assignar tutor
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
                                            {{ $grup->alumnes ? $grup->alumnes->count() : 0 }}
                                        </p>
                                        <p class="text-sm text-gray-600">Alumnes</p>
                                    </div>
                                    <div class="text-center">
                                        @php
                                            $mitjanaEdat = 0;
                                            $comptador = 0;
                                            if ($grup->alumnes) {
                                                foreach($grup->alumnes as $alumne) {
                                                    if ($alumne->data_naixement) {
                                                        $edat = now()->diffInYears($alumne->data_naixement);
                                                        $mitjanaEdat += $edat;
                                                        $comptador++;
                                                    }
                                                }
                                                if ($comptador > 0) {
                                                    $mitjanaEdat = $mitjanaEdat / $comptador;
                                                }
                                            }
                                        @endphp
                                        <p class="text-2xl font-bold text-green-600">
                                            @if($comptador > 0)
                                                {{ number_format($mitjanaEdat, 1) }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600">Edat mitjana</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alumnos del grupo -->
                        <div class="mb-8">
                            <h3 class="font-bold text-xl text-gray-900 mb-4">👥 Alumnes del grup</h3>
                            
                            @if($grup->alumnes && $grup->alumnes->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nom</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">DNI</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Data naixement</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Mòduls</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Accions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($grup->alumnes as $alumne)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3">
                                                        <div class="font-medium">{{ $alumne->nom }} {{ $alumne->cognoms }}</div>
                                                        @if($alumne->telefon)
                                                            <div class="text-sm text-gray-500">📞 {{ $alumne->telefon }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3">{{ $alumne->dni }}</td>
                                                    <td class="px-4 py-3">
                                                        @if($alumne->data_naixement)
                                                            {{ $alumne->data_naixement->format('d/m/Y') }}
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
                                    <p class="text-gray-500">Encara no hi ha alumnes en aquest grup.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Botones de acción -->
                        @auth
                        <div class="pt-6 border-t border-gray-200 flex gap-4">
                        @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'professor')
                            <a href="{{ route('grups.edit', $grup) }}" 
                               class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-medium">
                                ✏️ Editar
                            </a>
                        @endif
                        @if(auth()->user()->rol === 'admin')  
                            <form action="{{ route('grups.destroy', $grup) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Estàs segur que vols eliminar aquest grup?')"
                                        class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 font-medium">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        @endif
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>