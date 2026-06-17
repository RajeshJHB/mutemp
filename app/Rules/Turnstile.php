<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Translation\PotentiallyTranslatedString;

class Turnstile implements ValidationRule
{
    /**
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.turnstile.secret_key');

        if (empty($secret)) {
            $fail('Turnstile is not configured. Please contact the site administrator.');

            return;
        }

        if (empty($value)) {
            $fail('Please complete the security check.');

            return;
        }

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->successful()) {
            $fail('Unable to verify security check. Please try again.');

            return;
        }

        if (! $response->json('success')) {
            $fail('Security check failed. Please try again.');
        }
    }
}
