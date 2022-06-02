<?php

namespace Egal\Core\Http;

use Egal\Core\Facades\FilterParser;
use Egal\Core\Facades\Rest;
use Egal\Core\Facades\SelectParser;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{

    public function index(Request $request, string $modelClass)
    {
        $filter = FilterParser::parse($request->get('filter'));
//        $select = SelectParser::parse($request->get('select'));
        return response()->json([
            'message' => null,
            'data' => Rest::index($modelClass, $filter)
        ]);
    }

    public function show(Request $request, $key, string $modelClass)
    {
        return response()->json([
            'message' => null,
            'data' => Rest::show($modelClass, $key)
        ]);
    }

    public function create(Request $request, string $modelClass)
    {
        if ($request->getContentType() !== 'json') {
            throw new Exception('Unsupported content type!'); # TODO: Replace to additional exception class!
        }

        $attributes = json_decode($request->getContent(), true);

        return response()->json([
            'message' => 'Created successfully',
            'data' => Rest::create($modelClass, $attributes)
        ]);
    }

    public function update(Request $request, $key, string $modelClass)
    {
        if ($request->getContentType() !== 'json') {
            throw new Exception('Unsupported content type!'); # TODO: Replace to additional exception class!
        }

        $attributes = json_decode($request->getContent(), true);

        return response()->json([
            'message' => 'Updated successfully',
            'data' => Rest::update($modelClass, $key, $attributes)
        ]);
    }

    public function delete(Request $request, $key, string $modelClass)
    {
        Rest::delete($modelClass, $key);

        return response()->json([
            'message' => 'Deleted successfully',
            'data' => null
        ]);
    }

}
