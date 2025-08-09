<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request)
    {
        $key = $request->delete_date;

        // キャンセルしたい日付と同じ予約日付、かつ「自分の予約枠」だけ取得
        $setting = ReserveSettings::where('setting_reserve', $key)
            ->whereHas('users', function ($q) {
                $q->where('users.id', Auth::id());
            })
            ->firstOrFail();

        // 予約解除（中間テーブルから自分を外す）
        $setting->users()->detach(Auth::id());

        // 定員がnullでなければ1戻す
        if (!is_null($setting->limit_users)) {
            $setting->increment('limit_users');
        }

        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
