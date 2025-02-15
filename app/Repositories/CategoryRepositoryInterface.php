<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;
    public function findById($id): Category;
    public function update($id, array $data): ?Category;
    public function delete($id): bool;
}