<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRatingRequest;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Models\Cart;
use App\Models\Rating;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RatingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rating_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ratings = Rating::with(['order'])->get();

        return view('admin.ratings.index', compact('ratings'));
    }

    public function create()
    {
        abort_if(Gate::denies('rating_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Cart::pluck('total_price', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.ratings.create', compact('orders'));
    }

    public function store(StoreRatingRequest $request)
    {
        $rating = Rating::create($request->all());

        return redirect()->route('admin.ratings.index');
    }

    public function edit(Rating $rating)
    {
        abort_if(Gate::denies('rating_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Cart::pluck('total_price', 'id')->prepend(trans('global.pleaseSelect'), '');

        $rating->load('order');

        return view('admin.ratings.edit', compact('orders', 'rating'));
    }

    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $rating->update($request->all());

        return redirect()->route('admin.ratings.index');
    }

    public function show(Rating $rating)
    {
        abort_if(Gate::denies('rating_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rating->load('order');

        return view('admin.ratings.show', compact('rating'));
    }

    public function destroy(Rating $rating)
    {
        abort_if(Gate::denies('rating_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rating->delete();

        return back();
    }

    public function massDestroy(MassDestroyRatingRequest $request)
    {
        Rating::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
