<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ConvertBanglaToEnglish
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('get')) {
            $input = $request->all();
            $input = $this->convertBanglaNumbersToEnglish($input);
            $request->query->replace($input);
        } elseif ($request->isMethod('post')) {
            $input = $request->all();
            $input = $this->convertBanglaNumbersToEnglish($input);
            $request->replace($input);
        }

        return $next($request);
    }

    private function convertBanglaNumbersToEnglish($data)
    {
        array_walk_recursive($data, function (&$value) {
            if (is_string($value)) {
                $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                $value = str_replace($banglaDigits, $englishDigits, $value);
            }
        });

        return $data;
    }

}
