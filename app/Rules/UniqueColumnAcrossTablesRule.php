<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueColumnAcrossTablesRule implements ValidationRule
{
    /**
     * Checks if a column value exists across different tables in database.
     *
     * @param array<string, string> $tables An associative array of table names and their error messages.
     */
    public function __construct(protected array $tables) {}

    /**
     * Run the validation rule.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->tables as $table => $message) {
            if (DB::table($table)->where($attribute, $value)->exists()) {
                $fail($message);
                return;
            }
        }
    }
}
