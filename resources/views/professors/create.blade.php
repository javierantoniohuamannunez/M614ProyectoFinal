<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nou Professor - Institut Carles Vallbona</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800">
                    Nou Professor
                </h2>
            </div>
        </header>

        <main class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Mensajes de error -->
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

                <!-- Formulario -->
                <form action="{{ route('professors.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="bg-white shadow-md rounded-lg p-6">
                    
                    @csrf

                    <!-- Nom -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nom" 
                               value="{{ old('nom') }}"
                               class="w-full border border-gray-300 rounded p-2"
                               required>
                    </div>

                    <!-- Cognoms -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">
                            Cognoms <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="cognoms" 
                               value="{{ old('cognoms') }}"
                               class="w-full border border-gray-300 rounded p-2"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full border border-gray-300 rounded p-2"
                               required>
                    </div>

                    <!-- Foto -->
                    <div class="mb-6">
                        <label class="block text-gray-700 mb-1">
                            Foto (opcional)
                        </label>
                        <input type="file" 
                               name="foto" 
                               class="w-full border border-gray-300 rounded p-2">
                        <p class="text-gray-500 text-sm mt-1">
                            Formats: JPG, PNG, GIF. Màxim 2MB.
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('professors.index') }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            ← Tornar
                        </a>
                        
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded font-medium hover:bg-blue-700">
                            Crear Professor
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>