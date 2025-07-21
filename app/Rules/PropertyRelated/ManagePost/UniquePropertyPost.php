<?php

namespace App\Rules\PropertyRelated\ManagePost;

use Closure;
use App\Models\PropertyRelated\PropertyInstance\PropertyCategory\ManageCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;

class UniquePropertyPost implements ValidationRule
{
    private $data;

    public function __construct($data, public string $message = 'The :attribute is required.')
    {
        $this->data = $data;
    }

    public function validate(string $attribute, mixed $value, Closure $fail, array $parameters = []): void
    {
        if ($this->data['type'] == Config::get('constants.status.category.sub')) {
            $manageCategory = ManageCategory::where('mainCategoryId', decrypt($this->data['mainCategoryId']))->get();
            if ($manageCategory->count() > 0) {
                $fail($this->message);
            }
        }
        if ($this->data['type'] == Config::get('constants.status.category.nested')) {
            $manageCategory = ManageCategory::where([
                ['mainCategoryId', decrypt($this->data['mainCategoryId'])],
                ['subCategoryId', decrypt($this->data['subCategoryId'])]
            ])->get();
            if ($manageCategory->count() > 0) {
                $fail($this->message);
            }
        }
    }
}
