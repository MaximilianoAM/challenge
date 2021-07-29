<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

return [
    'resource' => [
        'index' => [
            'message' => Lang::get('success.resource.index'),
            'code' => 'resource.index.success',
            'statusCode' => Response::HTTP_OK,
        ],

        'show' => [
            'message' => Lang::get('success.resource.show'),
            'code' => 'resource.show.success',
            'statusCode' => Response::HTTP_OK,
        ],

        'update' => [
            'message' => Lang::get('success.resource.update'),
            'code' => 'resource.update.success',
            'statusCode' => Response::HTTP_OK,
        ],

        'delete' => [
            'message' => Lang::get('success.resource.delete'),
            'code' => 'resource.delete.success',
            'statusCode' => Response::HTTP_OK,
        ],

        'store' => [
            'message' => Lang::get('success.resource.store'),
            'code' => 'resource.store.success',
            'statusCode' => Response::HTTP_CREATED,
        ],
    ],
];
