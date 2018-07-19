<?php

namespace WRonX\LumenRestObjectFetch;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RestObjectFetchMiddleware
{
    public function handle(Request $request, Closure $next, string $modelType) {
        
        if(!array_key_exists('id', $request->route()[2])) {
            Log::debug("No ID provided");
            
            throw new HttpException(400, 'ID not provided');
        }
        
        $objectId = $request->route()[2]['id'];
        
        $objectType = 'App\\Models\\' . $modelType;
        $object = $objectType::find($objectId);
        
        if($object === null) {
            Log::debug("No object with ID " . $objectId);
            throw new HttpException(404);
        }
        
        $request->attributes->add(['fetchedObject' => $object]);
        
        return $next($request);
    }
}
