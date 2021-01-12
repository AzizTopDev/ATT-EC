<?php

namespace Webkul\CMS\Http\Controllers\Shop;

use Webkul\CMS\Http\Controllers\Controller;
use Webkul\CMS\Models\ShopNotification;

class ShopNotificationController extends Controller
{
    /**
     * To hold the request variables from route file
     */
    protected $_config;

    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * To extract the page content and load it in the respective view file\
     *
     * @return view
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        $notification =  ShopNotification::where('display_flag', 1)->where('deleted_flag', 0)->first();
        $toggle_flag = isset($notification) ? false: true;
        return view($this->_config['view'], compact('toggle_flag'));
    }

    public function save()
    {
        $data = request()->all();

        if (isset($data['display-flag'])) {
            $data['display_flag'] = 1;
        } else {
            $data['display_flag'] = 0;
        }

        $notification = ShopNotification::create($data);

        if ($notification) {
            session()->flash('success', trans('admin::app.response.create-success', ['name' => 'ショップ通知']));
            return redirect()->route($this->_config['redirect']);
        }
    }

    public function edit($id)
    {
        $notification =  ShopNotification::where('display_flag', 1)->where('deleted_flag', 0)->where('id','!=',$id)->first();
        $toggle_flag = isset($notification) ? false: true;

        $notification = ShopNotification::findOrFail($id);
        return view($this->_config['view'], compact('notification', 'toggle_flag'));
    }

    public function update($id)
    {
        $notification = ShopNotification::findOrFail($id);

        $data = request()->all();

        if (isset($data['display-flag'])) {
            $data['display_flag'] = 1;
        } else {
            $data['display_flag'] = 0;
        }

        $notification->update($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'ショップ通知']));
        return redirect()->route($this->_config['redirect']);
    }

    public function delete($id)
    {
        $notification = ShopNotification::findOrFail($id);
        $data = [];
        $data['deleted_flag'] = 1;
        $data['deleted_at'] = date('Y-m-d H:i:s');
        $notification->update($data);

        session()->flash('success', trans('admin::app.cms.pages.delete-success'));

        return response()->json(['message' => true], 200);
    }
}
