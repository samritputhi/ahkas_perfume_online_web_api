<?php

namespace App\Ahkas\Support;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use Storage;

if (!function_exists('makeErrorNotifyMessage')) {
    function makeErrorNotifyMessage($exception): string
    {
        $message = 'Code: ' . $exception->getCode() . PHP_EOL;
        $message .= 'File: ' . $exception->getFile() . PHP_EOL;
        $message .= 'Line: ' . $exception->getLine() . PHP_EOL;
        $message .= 'Message: ' . $exception->getMessage() . PHP_EOL;
        $message .= 'Url: ' . config('app.url');

        return $message;
    }
}

// if (!function_exists('user')) {
//     function user(): UserModel
//     {
//         return request()->user();
//     }
// }


if (!function_exists('asJson')) {
    function asJson(mixed $message, int $status = 200): JsonResponse
    {
        $data = $message;

        if (is_string($message)) {
            $data = ['message' => $message];
        }


        return response()->json($data, $status);
    }
}

if (!function_exists('asPagination')) {
    function asPagination(mixed $paginator): JsonResponse
    {
        $pagination = $paginator->toArray();

        unset($pagination['first_page_url']);
        unset($pagination['last_page_url']);
        unset($pagination['prev_page_url']);
        unset($pagination['next_page_url']);
        unset($pagination['from']);
        unset($pagination['last']);
        unset($pagination['links']);
        unset($pagination['path']);

        return asJson($pagination);
    }
}

if (!function_exists('priceFormat')) {
    function priceFormat($value, $prefix = ' $'): string
    {
        return $prefix . number_format($value);
    }
}



if (!function_exists('uploadImage')) {
    function uploadImage($path, $image): string
    {
        $upLoad = Storage::disk()->put($path, $image);
        $upLoad = Storage::disk()->url($upLoad);
        return $upLoad;
    }
}

if (!function_exists('unique_random')) {

    function unique_random($table, $col, $chars = 12)
    {

        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do {
            // Generate random string of characters
            $random = Str::random($chars);

            // Check if it's already testing
            // If so, don't query the database again
            if (in_array($random, $tested)) {
                continue;
            }

            // Check if it is unique in the database
            $count = DB::table($table)->where($col, '=', $random)->count();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if ($count == 0) {
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters

        } while (!$unique);

        return strtoupper($random);
    }
}
