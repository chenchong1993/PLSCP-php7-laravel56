<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'api/apiUserAdd',
        'api/apiUserDelete/{uid}',
        'api/apiUserUpdate/{uid}',
        'api/apiSearchResult',
        'api/apiGetUid',
        'api/apiAddUserLocation',
        'api/apiAddObs'
    ];
}
