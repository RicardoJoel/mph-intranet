@extends('layouts.app')
@section('content')
<div class="fila">
    <div class="columna columna-1">
        <div class="title2">
            <h6>Entidades > Independientes ></h6>
        </div>
    </div>
</div>
<div class="fila">
    <div class="columna columna-1">
        <table class="tablealumno index">
            <thead>
                <th width="10%">Código</th>
                <th width="20%">Nombre completo</th>
                <th width="20%">Perfil</th>
                <th width="15%">Tipo de documento</th>
                <th width="15%">N° Documento</th>   
                <th width="10%">Celular</th>
                <th width="5%">Editar</th>
                <th width="5%">Borrar</th>
            </thead>
            <tbody>
                @foreach ($freelancers as $freelancer)
                <tr>
                    <td><center>{{ $freelancer->code }}</center></td>
                    <td>{{ $freelancer->fullname }}</td>
                    <td>{{ $freelancer->profile_id != 49 ? $freelancer->profile->name ?? '' : $freelancer->other }}</td>
                    <td>{{ $freelancer->documentType->name ?? '' }}</td>
                    <td><center>{{ $freelancer->document }}</center></td>
                    <td><center>{{ $freelancer->codeMobile }}</center></td>
                    <td><center><a class="btn btn-secondary btn-xs" href="{{ action('FreelancerController@edit', $freelancer->id) }}" ><span class="glyphicon glyphicon-pencil"></span></a></center></td>
                    <td>
                        <center>
                        <form action="{{ action('FreelancerController@destroy', $freelancer->id) }}" method="post">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('¿Realmente desea eliminar el independiente seleccionado?')"><span class="glyphicon glyphicon-trash"></span></button>
                        </form>
                        </center>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="fila">
    <div class="space2"></div>
    <center>
    <div class="columna columna-1">
        <a href="{{ route('freelancers.create') }}" class="btn-effie"><i class="fa fa-plus"></i>&nbsp;Nuevo</a>
        <a href="{{ route('home') }}" class="btn-effie-inv"><i class="fa fa-home"></i>&nbsp;Ir al inicio</a>
    </div>
    </center>
</div>
@endsection