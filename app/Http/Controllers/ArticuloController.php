<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categorias=["Bazar","Hogar","Electronica"];
        $precios=[1=>'Menor de 20€',2=>'Entre 20 y 50',3=>'Mas de 50€'];


        $miCategoria=$request->get('categoria');
        $miPrecio=$request->get('precio');

        $articulos=Articulo::orderBy('nombre')
        ->categoria($miCategoria)
        ->precio($miPrecio)
        ->paginate(3);

        return view('articulos.index', compact('articulos','categorias','request'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("articulos.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre"=>["required"],
            "precio"=>["required"],
            "stock"=>["required"]
        ]);
        if($request->has('imagen')){
            $request->validate([
                'imagen'=>['image']
            ]);

            $file=$request->file('imagen');

            $nombre='articulos/'.time().'_'.$file->getClientOriginalName();

            Storage::disk('public')->put($nombre, \File::get($file));

            $articulo=Articulo::create($request->all());

            $articulo->update(['imagen'=>"img/$nombre"]);
        }
        else{
            Articulo::create($request->all());
        }
        return redirect()->route('articulos.index')->with("mensaje", "Articulo Guardado");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        return view('articulos.detalle', compact('articulo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        $categorias=["Bazar","Hogar","Electronica"];
        return view("articulos.edit",compact("articulo","categorias"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            "nombre"=>["required"],
            "precio"=>["required"],
            "stock"=>["required"]
        ]);
        //compruebo si he subido archiivo
        if($request->has('imagen')){
            $request->validate([
                'imagen'=>['image']
            ]);
            //Todo bien hemos subido un archivo y es de imagen
            $file=$request->file('imagen');
            //Creo un nombre
            $nombre='articulos/'.time().'_'.$file->getClientOriginalName();
            //Guardo el archivo de imagen
            Storage::disk('public')->put($nombre, \File::get($file));
            //si he subido un afoto nueva booro la vieja, SALVO que sea default.jpg
            if(basename($articulo->imagen)!='default.jpg'){
                unlink($articulo->imagen);
            }
            //ahora actualizo el articuloe
            $articulo->update($request->all());
            $articulo->update(['imagen'=>"img/$nombre"]);
        }
        else{
            $articulo->update($request->all());
        }
        return redirect()->route('articulos.index')->with("mensaje", "articuloe Modificado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        $articulo->delete();
        Session::flash('borradoM', "Articulo borrado con exito");
        return redirect()->route("articulos.index");
    }
}
