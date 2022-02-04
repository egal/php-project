<?php

namespace Egal\Core\Route;

use Illuminate\Support\Arr;

class PendingResourceRegistration extends \Illuminate\Routing\PendingResourceRegistration
{
    /**
     * The resource registrar.
     *
     * @var ResourceRegistrar
     */
    protected $registrar;

    /**
     * Create a new pending resource registration instance.
     *
     * @param ResourceRegistrar $registrar
     * @param string $name
     * @param string $controller
     * @param array $options
     * @param array $routeDefaults
     */
    public function __construct(ResourceRegistrar $registrar, string $name, string $controller, array $options)
    {
        parent::__construct(
            $registrar,
            $name,
            $controller,
            array_merge(
                [
                    'except' => ['restore', 'batchRestore'],
                ],
                $options
            ),
        );
    }

    /**
     * Enables "restore" operation on the resource.
     *
     * @return $this
     */
    public function withSoftDeletes(): PendingResourceRegistration
    {
        $except = Arr::get($this->options, 'except');

        unset($except[array_search('restore', $except, true)]);
        unset($except[array_search('batchRestore', $except, true)]);

        $this->except($except);

        return $this;
    }

    /**
     * Disables batch operations on the resource.
     *
     * @return $this
     */
    public function withoutBatch(): PendingResourceRegistration
    {
        $except = Arr::get($this->options, 'except');

        $except = array_merge($except, ['batchStore', 'batchUpdate', 'batchDestroy', 'batchRestore']);

        $this->except($except);

        return $this;
    }

    public function register()
    {
        $this->registered = true;

        return $this->registrar->register(
            $this->name, $this->controller, $this->options
        );
    }
}





