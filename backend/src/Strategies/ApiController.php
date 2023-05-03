<?php

namespace Portfolio\Src\Strategies;

interface ApiController
{
    // Tipar? Ex.: Filters, Paginations e Sorting
    public function retrieve(array $options = null);

    // Middleware? Armazenar em um objeto, DTO?
    public function store(array|object $data, mixed ...$options);

    public function update(int|string $id, array $data);

    public function destroy(int|string $id);
}

?>
