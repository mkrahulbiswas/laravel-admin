<?php

namespace App\Rules\PropertyRelated;

use App\Models\PropertyRelated\PropertyAttributes;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniquePropertyAttributes implements ValidationRule
{
    private $data;

    public function __construct($data, public string $message = 'The :attribute is already taken.')
    {
        $this->data = $data;
    }

    public function validate(string $attribute, mixed $value, Closure $fail, array $parameters = []): void
    {
        if ($this->data['targetId'] == '') {
            $isExist = PropertyAttributes::where([
                ['name', $value],
                ['type', $this->data['type']],
            ])->get();
        } else {
            $isExist = PropertyAttributes::where([
                ['name', $value],
                ['type', $this->data['type']],
                ['id', '!=', $this->data['targetId']]
            ])->get();
        }
        if ($isExist->count() > 0) {
            $fail($this->message);
        }
    }
}
