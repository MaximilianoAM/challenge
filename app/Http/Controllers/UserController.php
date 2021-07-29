<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\ListingModelRequest;
use App\Http\Requests\StoreOrUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Responses\FailureResponse;
use App\Responses\ModelResourceResponse;
use App\Responses\ResourceCollectionResponse;
use App\Responses\ResourceResponse;

class UserController extends Controller
{
    /**
     * @return FailureResponse|ResourceCollectionResponse
     */
    public function index(ListingModelRequest $request)
    {
        try {
            $result = User::fullTextSearch($request);
            $response = new ResourceCollectionResponse($result);
        } catch (AppException $e) {
            $response = new FailureResponse($e);
        }
        return $response;
    }

    /**
     * @param StoreOrUpdateUserRequest $request
     * @return ModelResourceResponse
     */
    public function store(StoreOrUpdateUserRequest $request): ModelResourceResponse
    {
        $user = new User($request->all());
        $user->save();
        return new ModelResourceResponse(
            $user,
            ResourceResponse::RESPONSE_STORE
        );
    }

    /**
     * @param User $user
     * @return ResourceResponse
     */
    public function show(User $user): ResourceResponse
    {
        return new ResourceResponse(
            UserResource::make($user),
            ResourceResponse::RESPONSE_SHOW
        );
    }

    /**
     * @param StoreOrUpdateUserRequest $request
     * @param User $user
     * @return ModelResourceResponse
     */
    public function update(StoreOrUpdateUserRequest $request, User $user): ModelResourceResponse
    {
        $user->update($request->all());
        return new ModelResourceResponse(
            $user,
            ResourceResponse::RESPONSE_UPDATE
        );
    }

    /**
     * @param User $user
     * @return ModelResourceResponse
     * @throws \Exception
     */
    public function destroy(User $user): ModelResourceResponse
    {
        $user->delete();
        return new ModelResourceResponse(
            $user,
            ResourceResponse::RESPONSE_DELETE
        );
    }
}
