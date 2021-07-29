<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\ListingModelRequest;
use App\Http\Requests\MakeTransactionRequest;
use App\Http\Requests\StoreOrUpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\CompanyAccount;
use App\Models\PersonAccount;
use App\Models\Transaction;
use App\Responses\FailureResponse;
use App\Responses\ModelResourceResponse;
use App\Responses\ResourceCollectionResponse;
use App\Responses\ResourceResponse;

class AccountController extends Controller
{
    /**
     * @return FailureResponse|ResourceCollectionResponse
     */
    public function index(ListingModelRequest $request)
    {
        try {
            $result = Account::fullTextSearch($request);
            $response = new ResourceCollectionResponse($result);
        } catch (AppException $e) {
            $response = new FailureResponse($e);
        }
        return $response;
    }

    /**
     * @param StoreOrUpdateAccountRequest $request
     * @return ResourceResponse
     */
    public function store(StoreOrUpdateAccountRequest $request): ResourceResponse
    {
        $requestData = $request->all();

        $account = new Account($requestData);
        $account->type = $requestData['type'];
        $account->save();

        $accountType = $account->type == Account::TYPE_COMPANY
            ? new CompanyAccount($requestData)
            : new PersonAccount($requestData);

        $accountType->ownerUser()->associate(
            $request->get('owner_user_id')
        );

        $accountType->account()->associate(
            $account->id
        );

        $accountType->save();

        return new ResourceResponse(
            AccountResource::make($account),
            ResourceResponse::RESPONSE_STORE
        );
    }

    /**
     * @param Account $account
     * @return ResourceResponse
     */
    public function show(Account $account): ResourceResponse
    {
        return new ResourceResponse(
            AccountResource::make($account),
            ResourceResponse::RESPONSE_SHOW
        );
    }

    /**
     * @param StoreOrUpdateAccountRequest $request
     * @param Account $account
     * @return ResourceResponse
     */
    public function update(StoreOrUpdateAccountRequest $request, Account $account): ResourceResponse
    {
        $requestData = $request->all();

        $account->update($requestData);

        $accountType = $account->type == Account::TYPE_COMPANY
            ? $account->companyAccount
            : $account->personAccount;

        $accountType->ownerUser()->associate(
            $request->get('owner_user_id')
        );

        $accountType->update($requestData);

        return new ResourceResponse(
            AccountResource::make($account),
            ResourceResponse::RESPONSE_UPDATE
        );
    }

    /**
     * @param Account $account
     * @return ResourceResponse
     */
    public function destroy(Account $account): ResourceResponse
    {
        return new ResourceResponse(
            AccountResource::make($account),
            ResourceResponse::RESPONSE_DELETE
        );
    }

    /**
     * @param MakeTransactionRequest $request
     * @return ResourceResponse
     */
    public function makeTransaction(MakeTransactionRequest $request, Account $account): ResourceResponse
    {
        $transaction = new Transaction($request->all());
        $transaction->account()->associate($account);
        $transaction->save();
        return new ModelResourceResponse(
            $transaction,
            ResourceResponse::RESPONSE_STORE
        );
    }
}
