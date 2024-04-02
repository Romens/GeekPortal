<?php

namespace App\Http\Controllers\Posts;

use App\Http\Requests\Posts\IndexPostsRequest;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostReactionRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Resources\Posts\PostsCollectionResource;
use App\Http\Resources\Posts\PostsResource;
use App\Models\Posts\Post;
use App\Services\Posts\PostsService;
use App\Services\Posts\Reaction\PostReactionService;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class PostsController
{
    public function index(IndexPostsRequest $request, PostsService $postsService): ResourceCollection
    {
        $postsPagination = $postsService->getPagination($request->getPdo(), $request->user());

        return new PostsCollectionResource($postsPagination);
    }

    public function store(StorePostRequest $request, PostsService $postsService)
    {
        $author = $request->user();
        $post = $postsService->create($request->getPdo(), $author);

        return new PostsResource($post);

    }

    public function show(string $postUrl, PostsService $postsService)
    {
        $post = $postsService->getOne($postUrl);

        if (! $post) {
            abort(404);
        }

        return new PostsResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post, PostsService $postsService)
    {
        $post = $postsService->update($request->getPdo(), $post);

        return new PostsResource($post);
    }

    public function destroy(Post $post): Response
    {
        Gate::authorize('delete', $post);

        return response()->noContent();
    }

    public function setReaction(
        Post $post,
        UpdatePostReactionRequest $request,
        PostReactionService $postReactionService
    ): JsonResponse {
        $dto = $request->getPdo();
        $postReactionService->setUserReactions($dto, $post, $request->user());

        $statistics = PostReactionService::getReactionStatistics($post);

        return response()->json([
            'data' => [
                'reactions' => $statistics,
            ],
        ]);
    }

    public function unsetReaction(UpdatePostReactionRequest $request, Post $post, PostReactionService $postReactionService): JsonResponse
    {
        $dto = $request->getPdo();
        $postReactionService->unsetUserReactions($dto, $post, $request->user());

        $statistics = PostReactionService::getReactionStatistics($post);

        return response()->json([
            'data' => [
                'reactions' => $statistics,
            ],
        ]);
    }
}
