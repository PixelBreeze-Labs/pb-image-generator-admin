<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorLogController extends Controller
{
    public function logError(Request $request)
    {
        Log::error('AJAX Error:', [
            'error' => $request->error,
            'url' => $request->url(),
            'user' => auth()->id() ?? 'guest',
            'timestamp' => now()
        ]);

        return response()->json(['status' => 'logged']);
    }
}
