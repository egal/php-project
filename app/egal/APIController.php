<?php

namespace App\egal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController
{
    public function index()
    {
         //validation
        return $this->service->index();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function create(Request $request)
    {
        return $this->service->create($request->only('attributes'));
    }

    public function update($id, Request $request)
    {
        return $this->service->update($id, $request->only('attributes'));
    }

    public function delete($id, Request $request)
    {
        return $this->service->delete($id);
    }

    public function relationIndex()
    {
        //validation
        return $this->service->index();
    }

    public function relationShow($id)
    {
        return $this->service->show($id);
    }

    public function relationCreate(Request $request)
    {
        return $this->service->create($request->only('attributes'));
    }

    public function relationUpdate($id, Request $request)
    {
        return $this->service->update($id, $request->only('attributes'));
    }

    public function relationDelete($id, Request $request)
    {
        return $this->service->delete($id);
    }
}
