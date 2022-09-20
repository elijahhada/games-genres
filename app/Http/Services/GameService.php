<?php

namespace App\Http\Services;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GameService
{
    public function paginate()
    {
        return Game::with('genres')->paginate();
    }

    public function store(array $data)
    {
        $data['user_id'] = Auth::user()->id;
        $game = Game::create($data);
        $game->genres()->sync($data['genres']);
        return $game->id;
    }

    public function update(Game $game, array $data)
    {
        Gate::authorize('update', $game);
        $game->update($data);
        $game->genres()->sync($data['genres']);
        return $game->id;
    }

    public function destroy(Game $game)
    {
        Gate::authorize('delete', $game);
        $game->genres()->detach();
        $game->delete();
    }
}