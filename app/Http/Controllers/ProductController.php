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


        return response()->json(['success'=> False, 'message'=> $error->getMessage()], 500);

    }

    
    /**
     *  Obtención de un producto de la base de datos 
     *  por su identificador 'id'. 
     */
    public function show($id)
    {
        try {
            $product = Product::with('user')->find($id);

            # Verificar si se obtiene algún producto con el 'id' dado
            if ($product) {
                return response()->json(['success' => True, 'Product' => $product], 200);
            } else {
                return response()->json(['success' => False, 'message' => 'Producto no encontrado'], 404);
            }  

        } catch (\Exception $error){
            return response()->json(['success'=> False, 'message'=> $error->getMessage()], 500);
        } 
    }

    /**
     *  Eliminación de un producto de la base
     *  correspondiente al id 
     */
    public function destroy($id) {
        try {
            $deleted = Product::destroy($id);
            if ($deleted == True) {
                return response()->json(['success'=> True,  'message'=> 'Product eliminado exitosamente.'], 204);
            } else {
                return response()->json(['success'=> False, 'message'=> 'Error al intentar eliminar el producto.'], 404);
            }
        } catch (\Exception $error){
            return response()->json(['success'=> False, 'message'=> $error->getMessage()], 500);
        }
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

        $product = Product::find($id);
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
