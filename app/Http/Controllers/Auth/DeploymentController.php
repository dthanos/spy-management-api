<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Process;

class DeploymentController extends Controller
{
    /**
     * Get Current Authenticated User Instance
     */
    public function deployment(): string
    {
        $response = Process::run('chmod u+x deployment && ./deployment');

        return $response->output();
    }
}
