<?php

namespace SoipoServices\RunPod;

use Saloon\Http\Connector;

class Resource
{
    public function __construct(protected Connector $connector)
    {
        //
    }
}
