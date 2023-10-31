<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SquareController extends Controller
{
    function square($number) {
        // square root using algorithm
        if ($number < 0) {
            // status code 400 means bad request
            return response()->json([
                'error' => 'Invalid number'
            ], 400);
        }
    
        // Initialize the initial guess and the precision
        $guess = $number / 2;
        $precision = 0.00001;
    
        while (abs(($guess * $guess) - $number) > $precision) {
            $guess = ($guess + ($number / $guess)) / 2;
        }

        // save to database
        $execution_time = microtime(true) - LARAVEL_START;
        DB::table('log_sqrt')->insert([
            'number' => $number,
            'result' => $guess,
            'execution_time' => $execution_time,
            'type' => 'api',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    
        return response()->json([
            'number' => $number,
            'square_root' => $guess
        ]);
    }

    // call square procedure from database
    function square_db($number) {
        // square root using algorithm
        if ($number < 0) {
            // status code 400 means bad request
            return response()->json([
                'error' => 'Invalid number'
            ], 400);
        }
        $result = 0;
    
        $result = DB::statement('CALL square_root(?, @result)', array($number));
        $result = DB::select('SELECT @result as result')[0]->result;

        // save to database
        $execution_time = microtime(true) - LARAVEL_START;
        DB::table('log_sqrt')->insert([
            'number' => $number,
            'result' => $result,
            'execution_time' => $execution_time,
            'type' => 'plsql',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'number' => $number,
            'square_root' => $result
        ]);
    }
}
