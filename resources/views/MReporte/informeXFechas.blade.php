@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Informe por fechas</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="date" id="filtrofechaInicio" name="filtrofechaInicio"  min="2018-01-01" max="2050-12-31" />
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="filtrofechaFinal" name="filtrofechaFinal"  min="2018-01-01" max="2050-12-31" />
                            </div>
                            <div class="col-md-4">
                                <button onclick="ajaxRenderSectionVisualizarXRangoFechas($('#filtrofechaInicio').val(),$('#filtrofechaFinal').val())" type="button" class="btn btn-success">consultar</button>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-12">
                                <canvas id="ventasXfecha" class="img-responsive"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

