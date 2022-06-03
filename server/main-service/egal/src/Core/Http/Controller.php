<?php

namespace Egal\Core\Http;

use Egal\Core\Facades\FilterParser;
use Egal\Core\Facades\Rest;
use Egal\Core\Facades\SelectParser;
use Egal\Core\Facades\ScopeParser;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{

    public function index(Request $request, string $modelClass)
    {
        $scope = ScopeParser::parse($request->get('scope'));
        $filter = FilterParser::parse($request->get('filter'));
        $select = SelectParser::parse($request->get('select'));

        try {
            $indexData = Rest::index($modelClass, $scope, $filter, $select);
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['exception' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }

        return response()->json([
            'message' => null,
            'data' => $indexData
        ]);
    }

    public function show(Request $request, $key, string $modelClass)
    {
        $select = SelectParser::parse($request->get('select'));

        try {
            $showData = Rest::show($modelClass, $key, $select);
        } catch (Exception $exception) {
            return response()->json(['exception' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }

        return response()->json([
            'message' => null,
            'data' => $showData
        ]);
    }

    public function create(Request $request, string $modelClass)
    {
        if ($request->getContentType() !== 'json') {
            throw new Exception('Unsupported content type!'); # TODO: Replace to additional exception class!
        }

        $attributes = json_decode($request->getContent(), true);

        try {
            $createData = Rest::create($modelClass, $attributes);
        } catch (Exception $exception) {
            return response()->json(['exception' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }

        return response()->json([
            'message' => 'Created successfully',
            'data' => $createData
        ]);
    }

    public function update(Request $request, $key, string $modelClass)
    {
        if ($request->getContentType() !== 'json') {
            throw new Exception('Unsupported content type!'); # TODO: Replace to additional exception class!
        }

        $attributes = json_decode($request->getContent(), true);

        try {
            $updateData = Rest::update($modelClass, $key, $attributes);
        } catch (Exception $exception) {
            return response()->json(['exception' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $updateData
        ]);
    }

    public function delete(Request $request, $key, string $modelClass)
    {
        try {
            Rest::delete($modelClass, $key);
        } catch (Exception $exception) {
            return response()->json(['exception' => $exception->getMessage()])->setStatusCode($exception->getCode());
        }

        return response()->json([
            'message' => 'Deleted successfully',
            'data' => null
        ]);
    }

}
