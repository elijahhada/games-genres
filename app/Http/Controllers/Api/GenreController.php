<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Http\Services\GenreService;
use App\Models\Genre;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * @param GenreService $service
     * @return AnonymousResourceCollection
     */
    public function index(GenreService $service): AnonymousResourceCollection
    {
        return GenreResource::collection($service->paginate());
    }

    /**
     * @param GenreRequest $request
     * @param GenreService $service
     * @return GenreResource
     */
    public function store(GenreRequest $request, GenreService $service): GenreResource
    {
        $genreId = $service->store($request->all());
        return new GenreResource(Genre::find($genreId));
    }

    /**
     * @param Genre $genre
     * @return GenreResource
     */
    public function show(Genre $genre): GenreResource
    {
        return new GenreResource($genre);
    }

    /**
     * @param GenreRequest $request
     * @param Genre $genre
     * @param GenreService $service
     * @return GenreResource
     */
    public function update(GenreRequest $request, Genre $genre, GenreService $service): GenreResource
    {
        $genreId = $service->update($genre, $request->all());
        return new GenreResource(Genre::find($genreId));
    }

    /**
     * @param Genre $genre
     * @param GenreService $service
     * @return Response
     */
    public function destroy(Genre $genre, GenreService $service): Response
    {
        $service->destroy($genre);
        return response()->noContent();
    }
}
