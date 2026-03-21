@extends('layouts.app')
@section('conteudo')
{{-- TERMINAR DE CONFIGURAR --}}
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Data</th>
                <th>Pedido</th>
                <th>Valor</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody id="tabela-comissao-corpo">
            </tbody>
    </table>
</div>

<div id="paginacao-historico" class="d-flex justify-content-center mt-3"></div>
@endsection