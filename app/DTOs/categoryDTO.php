<?php


namespace App\DTOs;


class categoryDTO
{
    public function __construct(
        public string $name,
        public ?string $deparment_name = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            deparment_name: $data['deparment_name'] ?? null
        );
    }
}
