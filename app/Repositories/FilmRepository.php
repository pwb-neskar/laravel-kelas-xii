<?php

namespace App\Repositories;

use App\Models\Film;
use App\Interfaces\FilmRepositoryInterface;

class FilmRepository implements FilmRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return Film::all();
    }

    public function store(array $data){
        return Film::create($data);
    }

    public function update(array $data, $id){
        return Film::whereId($id)->update($data);
    }

    public function delete($id){
        return Film::destroy($id);
    }
}
