<?php

namespace Egal\Core\Http;

use Egal\Core\Facades\Rest;
use Egal\Core\Rest\Filter\Parser as FilterParser;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{

    public function index(Request $request, string $modelClass)
    {
        $filter = (new FilterParser)->parse($request->get('filter'));
        return response()->json(Rest::index($modelClass, $filter))->setStatusCode(Response::HTTP_OK);
    }

    public function create(Request $request, string $modelClass)
    {
        if ($request->getContentType() !== 'json') {
            throw new Exception('Unsupported content type!'); # TODO: Replace to additional exception class!
        }

        $attributes = json_decode($request->getContent(), true);

        Rest::create($modelClass, $attributes);

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function show(Request $request, $key, string $modelClass)
    {
        return response()->json(Rest::show($modelClass, $key))->setStatusCode(Response::HTTP_OK);
    }

    public function update(Request $request, $key, string $modelClass)
    {
        if ($request->getContentType() !== 'json') {
            throw new Exception('Unsupported content type!'); # TODO: Replace to additional exception class!
        }

        $attributes = json_decode($request->getContent(), true);

        Rest::update($modelClass, $key, $attributes);

        return response()->noContent();
    }

    public function delete(Request $request, $key, string $modelClass)
    {
        Rest::delete($modelClass, $key);

        return response()->noContent();
    }

}
