@section('contentFormPedido')
<form id="formCrearPedido">
    <input type="hidden" id="_tokenPedido" name="_tokenPedido" value="{{csrf_token()}}" />
    <div class="panel panel-info">
        <div class="panel-heading">Nuevo Pedido</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <label>Vendedor</label>
                    <input id="Vendedor" name="Vendedor" type="text" value="{{$nombreVendedor}}" class="form-control" readonly>
                    <span class="invalid-feedback" role="alert" id="errorVendedor"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Cliente</label>
                    <select id="Cliente_id" name="Cliente_id"  class="form-control">
                        <option value="">Seleccionar</option>
                        @foreach($ListClientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->Identificacion }}-{{ $cliente->Nombre }} {{ $cliente->Apellidos }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback" role="alert" id="errorCliente_id"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Comentario</label>
                    <textarea id="Comentario" name="Comentario" type="text" class="form-control"></textarea>
                    <span class="invalid-feedback" role="alert" id="errorComentario"></span>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input type="button" class="form-control btn btn-success" value="Crear" onclick="guardarPedido(this)">
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
</form>
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/JsPDF/dist/jspdf.min.js') }}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Cliente_id').fastselect({
                placeholder: 'Seleccione el cliente',
                searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>

@endsection
