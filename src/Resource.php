<?php

namespace SoipoServices\ComfyDeploy;

use Saloon\Http\Connector;

class Resource
{
    public function __construct(protected Connector $connector)
    {
        //
    }
}
