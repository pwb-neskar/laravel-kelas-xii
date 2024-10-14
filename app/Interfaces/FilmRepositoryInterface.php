<?php

namespace App\Interfaces;

interface FilmRepositoryInterface
{
    //
    public function index();
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
}
