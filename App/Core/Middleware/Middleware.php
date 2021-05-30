<?php


namespace App\Core\Middleware;


use App\Core\Request;
use Closure;

/**
 * Implementasi middleware
 * @see http://esbenp.github.io/2015/07/31/implementing-before-after-middleware/
 * @package App\Core\Middleware
 */
class Middleware implements MiddlewareContracts
{
    private $layers;

    private $parameters;

    public function __construct(array $layers = [], $parameters = null)
    {
        $this->layers = $layers;
        $this->parameters = $parameters;
    }

    public function layer($layers)
    {
        if ($layers instanceof Middleware) {
            $layers = $layers->toArray();
        }

        if ($layers instanceof MiddlewareContracts) {
            $layers = [$layers];
        }

        if (!is_array($layers)) {
            throw new \InvalidArgumentException(get_class($layers) . " bukan middleware.");
        }

        return new static(array_merge($this->layers, $layers));
    }

    /**
     * Run middleware around core function and pass an
     * object through it
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $coreFunction = $this->createCoreFunction($next);

        $layers = array_reverse($this->layers);

        $next = array_reduce($layers, function($nextLayer, $layer){
            return $this->createLayer($nextLayer, $layer);
        }, $coreFunction);

        return $next($request);
    }

    /**
     * Get the layers of this middleware, can be used to merge with another middleware
     * @return array
     */
    public function toArray()
    {
        return $this->layers;
    }

    /**
     * The inner function of the middleware.
     * This function will be wrapped on layers
     * @param  Closure $core the core function
     * @return Closure
     */
    private function createCoreFunction(Closure $core)
    {
        return function($object) use($core) {
            return $core($object);
        };
    }

    /**
     * Get an onion layer function.
     * This function will get the object from a previous layer and pass it inwards
     * @param  MiddlewareContracts $nextLayer
     * @param  MiddlewareContracts $layer
     * @return Closure
     */
    private function createLayer($nextLayer, $layer)
    {
        return function($request) use($nextLayer, $layer){
            return $layer->handle($request, $nextLayer, $layer->parameters);
        };
    }

}
