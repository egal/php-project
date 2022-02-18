<?php

namespace Egal\Core\Http;

use Egal\Core\Facades\Rest;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{

    public function index(Request $request, string $modelClass)
    {
        return response()->json(Rest::index($modelClass))->setStatusCode(Response::HTTP_OK);
    }

    public function create(Request $request, string $modelClass)
    {
        if ($request->getContentType() !== 'json') {
            throw new Exception('Unsupported content type!'); # TODO: Replace to additional exception class!
        }

        $attributes = json_decode($request->getContent(), true);

        Rest::create($modelClass, $attributes);

        return response()->setStatusCode(Response::HTTP_CREATED);
    }

}
