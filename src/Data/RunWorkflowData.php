<?php

namespace SoipoServices\RunPod\Data;

use Exception;
use Saloon\Http\Response;

class RunWorkflowData
{
    /**
     * @param string $run_id
     */
    public function __construct(
        public string $run_id
    ) {
    }

    /**
     * @throws Exception
     */
    public static function fromResponse(Response $response): self
    {
        $data = $response->json();
        if (!is_array($data)) {
            throw new Exception('Invalid response');
        }

        return new RunWorkflowData(
            run_id: $data['run_id']
        );
    }
}