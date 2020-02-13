@extends('plantillas.plantilla')
@section('titulo')
    Listado Articulos
@endsection
@section('cabecera')
    Articulos:
@endsection
@section('contenido')
<div class="container">
<a href="{{route('articulos.create')}}" class="mb-3 btn btn-success normal">Añadir Articulo</a>
<form name="search" method="get" action="{{route('articulos.index')}}" class="form-inline float-right">
    <i class="fa fa-search fa-2x ml-2 mr-2" aria-hidden="true"></i>
    <select name='categoria' class='form-control mr-2' onchange="this.form.submit()">
        <option value='%'>Todos</option>
        @foreach($categorias as $categoria)
        @if($categoria==$request->categoria)
        <option selected>{{$categoria}}</option>

        @else
        <option >{{$categoria}}</option>
        @endif
        @endforeach
    </select>
    <select name="precio" class='form-control mr-2'>
        <option value="%">Todos</option>
        <option value="1">Menor de 20€</option>
        <option value="2">Entre 20 y 50</option>
        <option value="3">Mas de 50€</option>
    </select>
    {{-- <select name="marca_id" class="form-control" onchange="this.form.submit()">
        <option value='%'>Todos</option>
        <option value='-1'>Sin Marca</option>
        @foreach($marcas as $marca)
        @if($marca->id==$request->marca_id)
        <option value='{{$marca->id}}' selected>{{$marca->nombre}}</option>
        @else
        <option value='{{$marca->id}}'>{{$marca->nombre}}</option>
        @endif
        @endforeach
    </select> --}}


    <input type="submit" value="Buscar" class="btn btn-info ml-2">
</form>
</div>
<table class="table table-striped table-dark">
<thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Categoria</th>
        <th scope="col">Precio</th>
        <th scope="col">Stock</th>
        <th scope="col">Imagen</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($articulos as $articulo)
      <tr>
      <th scope="row">{{$articulo->id}}</th>
        <td>{{$articulo->nombre}}</td>
        <td>{{$articulo->categoria}}</td>
        <td>{{$articulo->precio}}</td>
        <td>{{$articulo->stock}}</td>
        <td><img src="{{asset($articulo->imagen)}}" width="90px" height='90px' class="rounded-circle"></td>
        <td>
        <form action="{{route("articulos.destroy", $articulo)}}">
            @csrf
            @method("DELETE")
            <a href='{{route('articulos.edit', $articulo)}}' class="btn btn-warning">Editar</a>
            {{-- <input type="submit" value="Borrar" name="borrar" class="btn btn-danger"> --}}
            <button type='submit' class="btn btn-danger" onclick="return confirm('¿Borrar Coche?')">
                Borrar</button>
            <a href="articulos.show" class="btn btn-info">Detalles</a>
        </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
{{-- {{$articulos->links()}} --}}
@endsection
