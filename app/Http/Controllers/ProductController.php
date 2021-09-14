<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     *  Este  Metodo Lista todos los productos filtrando 
     *  por el nombre ó codigo la  optención de la base 
     *  de datos con un parametro recibido por la request 
     *  denominado 'filter'.
     * 
     *  Si no hay 'filter' obtendra todos los productos.
     */
    public function index(Request $request)
    {   

        $input  = $request->all();
        # Verificar si la request trae un parametro 'filter'
        if (isset($input['filter'])) 
        { 
            $filter = $input['filter'];
            $products = Product::with('user')->where("code", "=", $filter)->orwhere("name", "like", "%{$filter}%")->paginate(5);
        }
        
        # Mostrar todos los productos (sin filtrar)
        $products = Product::with('user')->paginate(10);
        return response()->json(['success' => True, 'Products' => $products], 200);
    }

    
    /**
     *  Obtención de un producto de la base de datos 
     *  por su identificador 'id'. 
     */
    public function show($id)   {   
           
        $product = Product::with('user')->findOrFail($id);
        return response()->json(['success' => True, 'Product' => $product], 200);
    }

    /**
     *  Eliminación de un producto de la base
     *  correspondiente al id 
     */
    public function destroy($id) {
        
        $deleted = Product::destroy($id);
        return response()->json(['success'=> True,  'message'=> 'Product eliminado exitosamente.'], 204);

    }


    public function store(CreateProductRequest $request) {

        $input = $request->all();
        $input['user_id'] = 1;
        $product = Product::create($input);
        return response()->json(['success' => True, 'message' => 'insercion exitosa'], 201);
    }


    public function update(UpdateProductRequest $request, $id) {
        
        $input = $request->all();
        $product = Product::findOrFail($id);
        $product->update($input);
        return response()->json(['success' => True, 'message' => 'Actualizacion exitosa'], 200);
    }

    public function set_like($id) {

        $product = Product::findOrFail($id);
        $product->like = $product->like + 1;
        $product->save();
        return response()->json(['success' => True, 'message' => 'like exitoso'], 200);
    }

    public function set_dislike($id) {

        $product = Product::findOrFail($id);
        $product->dislike = $product->dislike + 1;
        $product->save();
        return response()->json(['success' => True, 'message' => 'dislike exitoso'], 200);
    }

    public function set_image(Request $request, $id) {

        $product = Product::findOrFail($id);
        $product->url_image = $this->upload_image($request->image, $id);
        $product->save();
        return response()->json(['success' => True, 'message' => 'image upload successfully'], 200);
    }

    private function upload_image($file, $id) {

        $file_name = time() . "_{$id}." . $file->getClientOriginalExtension(); # Nombre unico de la imagen
        $file->move(\public_path('images'), $file_name);
        return $file_name;

    }


}
