<?php

namespace App\Http\Services;

use App\Models\Game;
use App\Models\Genre;

class GameService
{
    public function paginate(string $count)
    {
        return Game::with('genres')->paginate($count);
    }

    public function store(array $data)
    {
        $game = Game::create($data);
        return $this->associate($game, $data['genres']);
    }

    public function update(Game $game, array $data)
    {
        $game->update($data);
        return $this->associate($game, $data['genres']);
    }

    public function destroy(Game $game)
    {
        $game->genres()->detach();
        $game->delete();
    }

    public function associate(Game $game, string $genres)
    {
        $genresIds = [];
        foreach (explode(',', $genres) as $genreTitle) {
            $genre = $game::where('title', $genreTitle)->first();
            if($genre) {
                array_push($genresIds, $genre->id);
                continue;
            }
            $tag = Genre::create(['title' => $genreTitle]);
            array_push($genresIds, $tag->id);
        }
        $game->genres()->sync($genresIds);

        return $game->id;
    }
}