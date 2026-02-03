<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>

    {{-- Tailwind CDN (ideal só pra dev/teste) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        bg: '#0f172a',
                        card: '#020617',
                        primary: '#38bdf8'
                    }
                }
            }
        }
    </script>
</head>

<body class="dark bg-bg min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-card rounded-2xl shadow-xl p-8">

        <h1 class="text-3xl font-bold text-white text-center mb-6">
            Criar conta
        </h1>

        {{-- Erros de validação --}}
        @if ($errors->any())
            <div class="bg-red-500/20 text-red-400 text-sm p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
         @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm text-gray-400 mb-1">Nome</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-primary"
                >
            </div>

            <div>   
                <label class="block text-sm text-gray-400 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-primary"
                >
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Senha</label>
                <div class="relative">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-primary"
                    >
                    <button type="button"
                        onclick="togglePassword('password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                        ver
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Confirmar senha</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-primary"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-primary text-slate-900 font-semibold py-2 rounded-lg hover:bg-sky-400 transition">
                Cadastrar
            </button>
        </form>

        <p class="text-gray-500 text-sm text-center mt-6">
            Já tem conta?
            <a href="{{ route('login') }}" class="text-primary hover:underline">Entrar</a>
        </p>

    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>
