<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class InfoLogController extends Controller
{
    public function logInfo(Request $request)
    {
        $context = [
            'user_id' => Auth::id(),
            'url' => $request->header('referer'),
            'timestamp' => now(),
        ];

        if ($request->has('info')) {
            Log::info('Form Submission Info', array_merge($context, [
                'info_data' => $request->info
            ]));
        }

        return response()->json(['status' => 'logged']);
    }
}
