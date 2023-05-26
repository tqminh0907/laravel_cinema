<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Models\MovieGenres;

class MovieGenresController extends Controller
{
    public function movie_genres()
    {
        $movieGenres = MovieGenres::orderBy('id', 'DESC')->Paginate(10);
        return view('admin.movie_genres.list', ['movieGenres' => $movieGenres]);
    }

    public function postCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:movie_genres'
        ], [
            'name.required' => "Please enter movie genre",
            'name.unique' => 'Movie genre exists'
        ]);
        MovieGenres::create($request->all());
        return redirect('admin/movie_genres')->with('success', 'Added Successfully!');
    }

    public function postEdit(Request $request, $id)
    {
        $movieGenres = MovieGenres::find($id);
        $request->validate([
            'name' => 'required|unique:movie_genres'
        ], [
            'name.required' => "Please enter movie genre",
            'name.unique' => 'Movie genre exists'
        ]);
        $movieGenres->update($request->all());
        return redirect('admin/movie_genres')->with('success', 'Updated Successfully!');
    }

    public function delete($id)
    {
        $movie_genres = MovieGenres::find($id);
        $check = count($movie_genres->movies);
        if($check ==0){
            MovieGenres::destroy($id);
            return response()->json(['success' => 'Delete Successfully']);
        }
        else{
            return response()->json(['error' => "Can't delete because Movie Generes exist Movie" ]);
        }
    }
}
