@extends('plantillas.plantilla')
@section('titulo')
    Nuevo Articulo
@endsection
@section('cabecera')
    Articulo:
@endsection
@section('contenido')
<div class="container mb-3 mt-3">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<form action="{{route('articulos.store')}}" name="añadirArticulo" method="post" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col">
        <input type="text" name="nombre" class="form-control" placeholder="Nombre" maxlength="20">
    </div>
    <div class="col">
        <select name='categoria' class="form-control">
          <option selected>Bazar</option>
          <option>Hogar</option>
          <option>Electronica</option>
      </select>
    </div>
    <div class="col">
        <input type="text" name="precio" class="form-control" placeholder="Precio">
    </div>
    <div class="col">
        <input type="text" name="stock" class="form-control" placeholder="Stock">
    </div>
</div>
<div class="row">
    <div class="col">
        <b>Imagen</b>&nbsp;<input type='file' name='imagen' accept="image/*">
    </div>
</div>
<div class="row">
    <div class="col">
        <input type='submit' value='Guardar' class='btn btn-success mr-3'>
        <input type='reset' value='Limpiar' class='btn btn-warning mr-3'>
        <a href={{route('articulos.index')}} class='ml-3 btn btn-info'>Volver</a>
    </div>
</div>
</form>
@endsection
