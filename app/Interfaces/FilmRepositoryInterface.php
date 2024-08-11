<?php

namespace App\Interfaces;

interface FilmRepositoryInterface
{
    //
    public function index();
    public function store(array $data);
}
