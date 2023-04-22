<?php

namespace Portfolio\Src\Strategies;

interface ApiController
{
    // Tipar? Ex.: Filters, Paginations e Sorting
    public function retrieve(array $options = null);

    // Middleware? Armazenar em um objeto, DTO?
    public function store(array $data);

    public function update(int $id, array $data);

    public function destroy(int $id);
}

?>