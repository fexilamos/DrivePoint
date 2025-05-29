<form action="{{ route('pesquisa') }}" method="GET" class="space-y-4">
  <input type="text" name="modelo" placeholder="Modelo" class="border p-2 w-full">
  <input type="text" name="cor" placeholder="Cor" class="border p-2 w-full">
  <input type="text" name="transmissao" placeholder="Transmissão" class="border p-2 w-full">
  <input type="text" name="combustivel" placeholder="Combustível" class="border p-2 w-full">
  <input type="number" name="ano" placeholder="Ano" class="border p-2 w-full">
  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Pesquisar</button>
</form>
