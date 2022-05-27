<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\HashTag;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
use App\Models\ProductUnit;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::pluck('name', 'id')->prepend('Chọn nhà hàng', '');
        $categories = ProductCategory::pluck('name', 'id')->prepend('Chọn thể loại', '');
        $product_units = ProductUnit::pluck('name', 'id')->prepend('Chọn đơn vị', '');

        $products = Product::with(['category', 'status', 'restaurants', 'media', 'categories']);

        if (!empty($request->restaurant_id)) {
            $restaurant_id = $request->restaurant_id;
            $products = $products->whereHas("restaurants", function($q) use ($restaurant_id) {
                $q->where("restaurant_id", $restaurant_id);
            });
        }

        if (!empty($request->product_category_id)) {
            $product_category_id = $request->product_category_id;
            $products = $products->whereHas("categories", function($q) use ($product_category_id) {
                $q->where("product_category_id", $product_category_id);
            });
        }

        if (!empty($request->is_price_change)) {
            $products = $products->where("is_price_change", $request->is_price_change == 1 ? 1 : 0);
        }

        if (!empty($request->type)) {
            $products = $products->where("type", $request->type);
        }

        if (!empty($request->price_discount)) {
            if ($request->price_discount == 1) {
                $products = $products->whereNotNull("price_discount");
            } else {
                $products = $products->whereNull("price_discount");
            }
        }

        if (!empty($request->product_unit_id)) {
            $products = $products->where("product_unit_id", $request->product_unit_id);
        }

        $products = $products->get();

        return view('admin.products.index', compact('products', 'restaurants', 'categories', 'product_units'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $statuses = ProductStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id');

        $hash_tags = HashTag::pluck('name', 'id');

        $product_units = ProductUnit::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.products.create', compact('categories', 'statuses', 'restaurants', 'hash_tags', 'product_units'));
    }

    public function store(StoreProductRequest $request)
    {
        $request['price'] = str_replace(",", "", $request->price);
        if(!empty($request['price_discount'])){
            $request['price_discount'] = str_replace(",", "", $request->price_discount);
        }
        $request['preparation_time'] = ($request->preparation_time_hour * 60) + $request->preparation_time_minute;

        $product = Product::create($request->all());
        $product->restaurants()->sync($request->input('restaurants', []));
        $product->hash_tags()->sync($request->input('hash_tags', []));
        $product->categories()->sync($request->input('categories', []));
        if ($request->input('avatar', false)) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
        }

        foreach ($request->input('featured_image', []) as $file) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('featured_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $product->id]);
        }

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $statuses = ProductStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id');

        $product->load('category', 'status', 'restaurants');

        $hash_tags = HashTag::pluck('name', 'id');

        $product_units = ProductUnit::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.products.edit', compact('categories', 'statuses', 'restaurants', 'product', 'hash_tags', 'product_units'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $request['price'] = str_replace(",", "", $request->price);
        if(!empty($request['price_discount'])){
            $request['price_discount'] = str_replace(",", "", $request->price_discount);
        }
        $request['preparation_time'] = ($request->preparation_time_hour * 60) + $request->preparation_time_minute;

        $product->update($request->all());
        $product->restaurants()->sync($request->input('restaurants', []));
        $product->hash_tags()->sync($request->input('hash_tags', []));
        $product->categories()->sync($request->input('categories', []));
        if ($request->input('avatar', false)) {
            if (!$product->avatar || $request->input('avatar') !== $product->avatar->file_name) {
                if ($product->avatar) {
                    $product->avatar->delete();
                }
                $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
            }
        } elseif ($product->avatar) {
            $product->avatar->delete();
        }

        if (count($product->featured_image) > 0) {
            foreach ($product->featured_image as $media) {
                if (!in_array($media->file_name, $request->input('featured_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $product->featured_image->pluck('file_name')->toArray();
        foreach ($request->input('featured_image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $product->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('featured_image');
            }
        }

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('category', 'status', 'restaurants', 'categories', 'product_unit');

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('product_create') && Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Product();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
