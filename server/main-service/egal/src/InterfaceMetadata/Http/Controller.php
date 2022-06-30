<?php

namespace Egal\InterfaceMetadata\Http;

use Egal\Core\Exceptions\HasData;
use Egal\Core\Exceptions\HasInternalCode;
use Egal\InterfaceMetadata\ComponentMetadata;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Controller
{
    public function show(Request $request)
    {
        try {
            $componentName = $request->input('component');
            $component = static::findComponentMetadata($componentName);
        } catch (Exception $exception) {
            $exceptionResponseData = [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'internal_code' => $exception instanceof HasInternalCode ? $exception->getInternalCode() : null,
                'data' => $exception instanceof HasData ? $exception->getData() : null
            ];
        }

        return response()->json([
            'message' => null,
            'data' => isset($component) ? $component->toArray() : null,
            'exception' => $exceptionResponseData ?? null
        ])->setStatusCode(isset($exceptionResponseData) ? $exceptionResponseData['code'] : Response::HTTP_OK);
    }

    private static function findComponentMetadata(mixed $componentName): ComponentMetadata
    {
        // TODO call MetadataManager (singleton) method findComponent (при инициалиции приложения addComponent из файла наподобие routes/api.php)
    }
}
