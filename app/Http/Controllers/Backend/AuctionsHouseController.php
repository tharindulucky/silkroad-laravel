<?php

namespace App\Http\Controllers\Backend;

use App\AuctionsHouseLog;
use App\AuctionsHouseSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class AuctionsHouseController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backend.auctionshouse.index', [
            'settings' => AuctionsHouseSettings::first()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLog()
    {
        return view('backend.auctionshouse.log');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function showLogDatatables()
    {
        return DataTables::of(AuctionsHouseLog::query())->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'gold_fees' => 'required|integer|between:0,100',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator);
        }

        $requestToJsonArray = [
            'gold_fees' => $request->get('gold_fees') ?? 0
        ];

        $auctionsHouseSettings = AuctionsHouseSettings::first();
        if (empty($auctionsHouseSettings)) {
            AuctionsHouseSettings::create([
                'settings' => $requestToJsonArray
            ]);
        } else {
            $auctionsHouseSettings->settings = $requestToJsonArray;
            $auctionsHouseSettings->save();
        }

        return back()->with('success', trans('backend/notification.form-submit.success'));
    }
}
