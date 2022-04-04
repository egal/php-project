<?php

namespace Egal\Core\Database\Metadata;

use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Contracts\Validation\Rule as ValidationRuleContract;

class Field
{

    private string $name;
    private array $validationRules;
    private bool $fillable = false;

    public static function make(string $name): self
    {
        $model = new self();
        $model->setName($name);

        return $model;
    }

    private function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function required(): self
    {
        $this->validationRule('required');

        return $this;
    }

    public function fillable(bool $boolean = true): self
    {
        $this->fillable = $boolean;

        return $this;
    }

    # TODO: Check needed types.
    public function validationRule(string|ValidationRule|ValidationRuleContract $rule): self
    {
        $this->validationRules[] = $rule;

        return $this;
    }

    /**
     * @param array<string|ValidationRule|ValidationRuleContract> $rule
     * @return $this
     */
    public function validationRules(array $rules): self
    {
        foreach ($rules as $rule) {
            $this->validationRule($rule);
        }

        return $this;
    }

    public function getValidationRules(): array
    {
        return $this->validationRules;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isFillable(): bool
    {
        return $this->fillable;
    }

}
