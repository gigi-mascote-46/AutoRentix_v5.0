<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat com IA</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f3f6fa] min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!--  -->
        <div class="m-8 text-center">
            <h1 class="text-3xl font-bold text-[#0b1320]">Converse com a IA</h1>
            <p class="text-gray-600 mt-2">Assistente virtual inteligente</p>
        </div>

        <!-- Form com input para a -->
        <form action="{{ route('ia.enviar') }}" method="post" class="flex gap-2">
            @csrf
            <input type="text" name="mensagem" class="flex-1 p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-[#9c6cfe] focus:border-[#9c6cfe] outline-none" placeholder="Insira a sua mensagem..." required>
            <button type="submit" class="px-6 py-4 text-white bg-[#9c6cfe] rounded-lg transition-all duration-300 focus:ring-2 focus:ring-[#9c6cfe] focus:ring-opacity-50 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#9c6cfe] focus:ring-opacity-50">
                Enviar
            </button>
        </form>

        <!-- Mensagem de erro -->
        @isset($error)
        <div class="mt-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">Erro:</span> {{ $error }}
        </div>
        @endisset

        <!-- Mostra mensagem enviada e resposta -->
        @isset($resposta)
        <div class="mt-6 space-y-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-gray-900">Sua mensagem:</h3>
                <p class="mt-2 text-gray-700">{{ $mensagem }}</p>
            </div>
            <div class="p-4 bg-purple-50 rounded-lg">
                <h3 class="font-semibold text-gray-900">Resposta da IA:</h3>
                <p class="mt-2 text-gray-700">{{ $resposta }}</p>
            </div>
        </div>
        @endisset
    </div>

    <style>
        .message-in {
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</body>
</html>