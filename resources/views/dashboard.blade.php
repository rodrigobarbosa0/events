<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Estoque</title>

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

<body class="dark bg-bg min-h-screen text-white">

    <!-- NAVBAR -->
    <nav class="bg-card border-b border-slate-800 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-primary">Estoque | Loja de Roupas</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-gray-300 hover:text-red-400 transition">
                Sair
            </button>
        </form>
    </nav>

    <!-- CONTEÚDO -->
    <main class="p-6 space-y-6 max-w-7xl mx-auto">

        <!-- CARDS -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-card p-6 rounded-xl shadow">
                <p class="text-gray-400 text-sm">Total de Produtos</p>
                <h2 class="text-3xl font-bold mt-2">128</h2>
            </div>

            <div class="bg-card p-6 rounded-xl shadow">
                <p class="text-gray-400 text-sm">Itens em Falta</p>
                <h2 class="text-3xl font-bold mt-2 text-red-400">5</h2>
            </div>

            <div class="bg-card p-6 rounded-xl shadow">
                <p class="text-gray-400 text-sm">Categorias</p>
                <h2 class="text-3xl font-bold mt-2">7</h2>
            </div>

        </section>

        <!-- TABELA -->
        <section class="bg-card rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Produtos em Estoque</h3>

                <button
                    class="bg-primary text-slate-900 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-sky-400 transition">
                    + Novo Produto
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-gray-400 border-b border-slate-800">
                        <tr>
                            <th class="text-left py-2">Produto</th>
                            <th class="text-left py-2">Categoria</th>
                            <th class="text-left py-2">Tamanho</th>
                            <th class="text-left py-2">Qtd</th>
                            <th class="text-left py-2">Preço</th>
                            <th class="text-right py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">

                        <tr>
                            <td class="py-3">Camiseta Básica</td>
                            <td>Camisas</td>
                            <td>M</td>
                            <td>20</td>
                            <td>R$ 49,90</td>
                            <td class="text-right space-x-2">
                                <button class="text-primary hover:underline">Editar</button>
                                <button class="text-red-400 hover:underline">Excluir</button>
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3">Calça Jeans</td>
                            <td>Calças</td>
                            <td>42</td>
                            <td>8</td>
                            <td>R$ 129,90</td>
                            <td class="text-right space-x-2">
                                <button class="text-primary hover:underline">Editar</button>
                                <button class="text-red-400 hover:underline">Excluir</button>
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3">Jaqueta Moletom</td>
                            <td>Casacos</td>
                            <td>G</td>
                            <td>0</td>
                            <td>R$ 159,90</td>
                            <td class="text-right space-x-2">
                                <button class="text-primary hover:underline">Editar</button>
                                <button class="text-red-400 hover:underline">Excluir</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </section>

    </main>

</body>
</html>
