<?php

namespace App\Services;

use App\Models\Exhibition;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function AddFovorite($exhibition_id){
        DB::beginTransaction();
        try {
            $user=Auth::user()->id;
            $favorite=Favorite::query()->create([
                'user_id'=>$user,
                'exhibition_id'=>$exhibition_id,
            ]);
            DB::commit();
            $data = $favorite;
            $message = 'Favorite added successfully. ';
            $code = 200;
            return ['data' => $data, 'message' => $message, 'code' => $code];

        } catch (\Exception $e) {
            DB::rollback();
            $data = [];
            $message = 'Error during added favorite. Please try again ';
            $code = 500;
            return ['data' => $data, 'message' => $e->getMessage(), 'code' => $code];

        }

    }
    public function deleteFovorite($id){
        DB::beginTransaction();
        try {
            $favorite=Favorite::query()->find($id);
            $favorite->delete();
            DB::commit();
            $data = [];
            $message = 'Favorite deleted successfully. ';
            $code = 200;
            return ['data' => $data, 'message' => $message, 'code' => $code];

        } catch (\Exception $e) {
            DB::rollback();
            $data = [];
            $message = 'Error during deleted favorite. Please try again ';
            $code = 500;
            return ['data' => $data, 'message' => $e->getMessage(), 'code' => $code];

        }

    }
    public function ShowFovorite(){
        DB::beginTransaction();
        try {
            $user=Auth::user()->id;
            $favorite=Favorite::query()->where('user_id',$user)->get();
            DB::commit();
            $data = $favorite;
            $message = 'Favorites shown successfully. ';
            $code = 200;
            return ['data' => $data, 'message' => $message, 'code' => $code];

        } catch (\Exception $e) {
            DB::rollback();
            $data = [];
            $message = 'Error during show favorites. Please try again ';
            $code = 500;
            return ['data' => $data, 'message' => $e->getMessage(), 'code' => $code];

        }

    }
}
