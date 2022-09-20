<?php

namespace App\Http\Services;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GenreService
{
    public function paginate()
    {
        return Genre::paginate();
    }

    public function store(array $data)
    {
        $data['user_id'] = Auth::user()->id;
        $genre = Genre::create($data);
        return $genre->id;
    }

    public function update(Genre $genre, array $data)
    {
        Gate::authorize('update', $genre);
        $genre->update($data);
        return $genre->id;
    }

    public function destroy(Genre $genre)
    {
        Gate::authorize('delete', $genre);
        $genre->delete();
    }
}