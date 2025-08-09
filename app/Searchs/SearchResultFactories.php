<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if($category == 'name'){
        // 名前検索で科目なし
      if(is_null($subjects)){
        $searchResults = new SelectNames();
      }else{
        // 名前検索で科目あり
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);

    }else if($category == 'id'){
      // ID検索で科目なし
      if(is_null($subjects)){
        $searchResults = new SelectIds();
      // ID検索で科目あり
      }else{
        $searchResults = new SelectIdDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);

    // どれでもない
    }else{
      $allUsers = new AllUsers();
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}