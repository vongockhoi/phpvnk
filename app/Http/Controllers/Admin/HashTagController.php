<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHashTagRequest;
use App\Http\Requests\StoreHashTagRequest;
use App\Http\Requests\UpdateHashTagRequest;
use App\Models\HashTag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HashTagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('hash_tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hashTags = HashTag::all();

        return view('admin.hashTags.index', compact('hashTags'));
    }

    public function create()
    {
        abort_if(Gate::denies('hash_tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hashTags.create');
    }

    public function store(StoreHashTagRequest $request)
    {
        $hashTag = HashTag::create($request->all());

        return redirect()->route('admin.hash-tags.index');
    }

    public function edit(HashTag $hashTag)
    {
        abort_if(Gate::denies('hash_tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hashTags.edit', compact('hashTag'));
    }

    public function update(UpdateHashTagRequest $request, HashTag $hashTag)
    {
        $hashTag->update($request->all());

        return redirect()->route('admin.hash-tags.index');
    }

    public function show(HashTag $hashTag)
    {
        abort_if(Gate::denies('hash_tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.hashTags.show', compact('hashTag'));
    }

    public function destroy(HashTag $hashTag)
    {
        abort_if(Gate::denies('hash_tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hashTag->delete();

        return back();
    }

    public function massDestroy(MassDestroyHashTagRequest $request)
    {
        HashTag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
