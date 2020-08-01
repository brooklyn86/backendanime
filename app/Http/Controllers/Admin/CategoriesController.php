<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AnimeImage;
use Requests as API;
class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function findCategoryApi(Request $request){
        $hasPage = 1;
        $countPage = 1;

        if(isset($request->category_id)){

        }else{
            while($hasPage == 1){
                $response = API::get("https://www.animesorion.tube/wp-json/wp/v2/categories?page=".$countPage);
                if($response->body != []){
                    $categories = json_decode($response->body);
                    foreach($categories as $category){
                        $hasCategory = Category::where('categorie_id_orion', $category->id)->first();
                        
                        if(!$hasCategory){
                            $categoria = new Category;
                            $categoria->categorie_id_orion = $category->id;
                            $categoria->slug = $category->slug;
                            $categoria->title = $category->name;
                            $categoria->link_original=  $category->_links->self[0]->href;
                            $categoria->link_posts = $category->_links->{'wp:post_type'}[0]->href;
                            $categoria->description = $category->description;
                            $categoria->quantidadeAnimes =$category->count;
                            $categoria->save();  
                        }else{
                            $hasCategory->categorie_id_orion = $category->id;
                            $hasCategory->slug = $category->slug;
                            $hasCategory->title = $category->name;
                            $hasCategory->link_original=  $category->_links->self[0]->href;
                            $hasCategory->link_posts = $category->_links->{'wp:post_type'}[0]->href;
                            $hasCategory->description = $category->description;
                            $hasCategory->quantidadeAnimes =$category->count;
                            $hasCategory->save();
                        }
                    }
                    sleep(4);
                    $countPage++;
                }else{
                    $hasPage = 0;
                }
            }
            return Response()->json(['error' => false, 'message' => 'Categorias Atualizadas com sucesso']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
