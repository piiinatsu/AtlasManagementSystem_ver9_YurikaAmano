<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  // 表示する年月をセットする
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // 「2025年8月」のようなタイトルを作る
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    // いまの月を週ごとの配列に変換する
    $weeks = $this->getWeeks();
    // 表示中の月をコピーして変数に入れる（「その日が表示月かどうか」を調べる）
    $viewMonth = $this->carbon->copy();
    // 週ごとに繰り返す
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      // その週の各日を取得する
      $days = $week->getDays();
      foreach($days as $day){
        // 当月の1日と今日の日付を取得する
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");
        // このセルの日付が表示中の月かどうか
        $dayDate = Carbon::parse($day->everyDay());
        $isOtherMonth = !$dayDate->isSameMonth($viewMonth);

        // 背景色(当月1日〜当日までかを確認する)
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          // 当月過去日 → 薄いグレー
          $html[] = '<td class="calendar-td bg-light">';
        }else{
          if ($isOtherMonth) {
            // 前後月の日 → 濃いグレー
            $html[] = '<td class="calendar-td '.$day->getClassName().' bg-secondary">';
          } else {
            // 当月の今日・未来日 → 何もしない
            $html[] = '<td class="calendar-td '.$day->getClassName().'">';
          }
        }
        // 日付の表示部分（数字や残り枠など）
        $html[] = $day->render();

        // 予約済かどうか
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            // 当月過去日 & 予約済み → ○部参加 と表示
            $partNum = (int)$day->authReserveDate($day->everyDay())->first()->setting_part;
            $label = ['','１部参加','２部参加','３部参加'][$partNum] ?? ($partNum.'部参加');
            $html[] = '<p class="m-auto p-0 w-75 past-label" style="font-size:12px">'.$label.'</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            $html[] = '<input type="hidden" name="getDate[]" value="'. $day->everyDay() .'" form="reserveParts">';
          }else{
          // 今日以降 & 予約済 → モーダル起動キャンセルボタン
          $reserveId = $day->authReserveDate($day->everyDay())->first()->setting_reserve; // 予約ID
          $html[] = '<button type="button"
                      class="btn btn-danger p-0 w-75 cancel-btn"
                      style="font-size:12px"
                      data-reserve="'. $reserveId .'"
                      data-date="'. $day->everyDay() .'"
                      data-time="'. $reservePart .'">'
                    . $reservePart .
                    '</button>';
          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          $html[] = '<input type="hidden" name="getDate[]" value="'. $day->everyDay() .'" form="reserveParts">';
          }
        }else{
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            // 当月過去日 & 未予約 → 受付終了 と表示
            $html[] = '<p class="m-auto p-0 w-75 past-label" style="font-size:12px">受付終了</p>';
            $html[] = '<input type="hidden" name="getDate[]" value="'. $day->everyDay() .'" form="reserveParts">';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';

          }else{
            // 今日以降 & 未予約 → 部を選ぶフォームを表示
            $html[] = '<input type="hidden" name="getDate[]" value="'. $day->everyDay() .'" form="reserveParts">';
            $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}