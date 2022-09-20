<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Http\Services\GameService;
use App\Models\Game;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * @param GameService $service
     * @return AnonymousResourceCollection
     */
    public function index(GameService $service): AnonymousResourceCollection
    {
        return GameResource::collection($service->paginate());
    }

    /**
     * @param GameRequest $request
     * @param GameService $service
     * @return GameResource
     */
    public function store(GameRequest $request, GameService $service): GameResource
    {
        $gameId = $service->store($request->all());
        return new GameResource(Game::find($gameId));
    }

    /**
     * @param Game $game
     * @return GameResource
     */
    public function show(Game $game): GameResource
    {
        return new GameResource($game);
    }

    /**
     * @param GameRequest $request
     * @param Game $game
     * @param GameService $service
     * @return GameResource
     */
    public function update(GameRequest $request, Game $game, GameService $service): GameResource
    {
        $gameId = $service->update($game, $request->all());
        return new GameResource(Game::find($gameId));
    }

    /**
     * @param Game $game
     * @param GameService $service
     * @return Response
     */
    public function destroy(Game $game, GameService $service): Response
    {
        $service->destroy($game);
        return response()->noContent();
    }
}
