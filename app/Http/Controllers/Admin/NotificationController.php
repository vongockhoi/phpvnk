<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyNotificationRequest;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Coupon;
use App\Models\Notification;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use App\Constants\Notification as NotificationConts;

class NotificationController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $notifications = Notification::with(['target', 'media'])->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        abort_if(Gate::denies('notification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $targets = Coupon::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.notifications.create', compact('targets'));
    }

    public function store(StoreNotificationRequest $request)
    {
        $request['status'] = NotificationConts::STATUS['UNSENT']; // chua gui
        $notification = Notification::create($request->all());

        if ($request->input('icon', false)) {
            $notification->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $notification->id]);
        }

        return redirect()->route('admin.notifications.index');
    }

    public function edit(Notification $notification)
    {
        abort_if(Gate::denies('notification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $targets = Coupon::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $notification->load('target');

        return view('admin.notifications.edit', compact('targets', 'notification'));
    }

    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $notification->update($request->all());

        if ($request->input('icon', false)) {
            if (!$notification->icon || $request->input('icon') !== $notification->icon->file_name) {
                if ($notification->icon) {
                    $notification->icon->delete();
                }
                $notification->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($notification->icon) {
            $notification->icon->delete();
        }

        return redirect()->route('admin.notifications.index');
    }

    public function show(Notification $notification)
    {
        abort_if(Gate::denies('notification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $notification->load('target');

        return view('admin.notifications.show', compact('notification'));
    }

    public function destroy(Notification $notification)
    {
        abort_if(Gate::denies('notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $notification->delete();

        return back();
    }

    public function massDestroy(MassDestroyNotificationRequest $request)
    {
        Notification::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('notification_create') && Gate::denies('notification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Notification();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
