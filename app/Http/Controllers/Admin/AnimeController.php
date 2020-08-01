<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Episode;
use App\Models\AnimeImage;
use DB;
use Requests as API;
class AnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listLancamento()
    {
        $animeEpisode = Episode::orderBy('id','desc')->paginate(20);

        return Response()->json($animeEpisode->values()->all());
    }
    public function findEpisodeAnimeApi(Request $request){
        DB::table('categories')->orderBy('id')->chunk(100, function ($categorias) {
            foreach ($categorias as $categoria) {
                $response = API::get($categoria->link_posts);
                if($response->body != []){
                    $episodes = json_decode($response->body);

                    foreach($episodes as $category){
                        $responseEpisode = API::get($category->link);
                        $html = explode("\r\n",$responseEpisode->body);
                       
                        foreach($html as $linha ){
                            if(preg_match('/<source/', $linha)){
                                $linkPlay = $linha;
                            }
                        }

                        sleep(3);
                        $hasEpisode = Episode::where('episode_id_orion', $category->id)->first();

                        if(!$hasEpisode){
                            $episode = new Episode;
                            $episode->episode_id_orion = $category->id;
                            $episode->categorie_id_orion = json_encode($category->categories);
                            $episode->categorie_id = $categoria->id;
                            $episode->slug = $category->slug;
                            $episode->title = $category->title->rendered;
                            $episode->link_original = $category->link;
                            $episode->link_original_post = "";
                            
                            $episode->link_player_episode = $linkPlay;
                
                            $episode->description = $category->content->rendered;
                            $episode->save();
                        }else{
    
                            $hasEpisode->episode_id_orion = $category->id;
                            $hasEpisode->categorie_id_orion = json_encode($category->categories);
                            $hasEpisode->categorie_id = $categoria->id;
                            $hasEpisode->slug = $category->slug;
                            $hasEpisode->title = $category->title->rendered;
                            $hasEpisode->link_original = $category->link;
                            $hasEpisode->link_original_post = "";
                            
                            $hasEpisode->link_player_episode = $linkPlay[0];
                
                            $hasEpisode->description = $category->content->rendered;
                            $hasEpisode->save();
                        }
                        

                    }
                }

            }
        });
        return Response()->json(['error' => false, 'message' => 'Episodios Atualizadas com sucesso']);

    }

    public function getAnimesImage(){
        $animeList = Category::paginate(100);
        $aniList = [];
            foreach ($animeList as $categoria) {
                $countImage =AnimeImage::where('anime_id',$categoria->id)->count();
                if($countImage < 11){
                    array_push($aniList, array('id' => $categoria->id, 'name' => $categoria->title));
                }
            }
 
        return Response()->json($aniList);
        
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
