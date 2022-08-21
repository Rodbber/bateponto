<x-app-layout-empresa>
    <form method="GET" action="{{ route('empresa.funcionario.cadastrar') }}">
        <x-button class="ml-3 mt-3">
            {{ __('Novo') }}
        </x-button>
    </form>
    <div id="app">
    </div>
</x-app-layout-empresa>
