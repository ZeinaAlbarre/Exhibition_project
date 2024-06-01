<?php

namespace App\Services;

use App\Mail\AcceptCompanyemail;
use App\Mail\AcceptExhibitionEmail;
use App\Mail\RejectExhibitionEmail;
use App\Models\Exhibition;
use App\Models\Exhibition_organizer;
use App\Models\Media;
use App\Models\Section;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExhibitionService
{
    public function addExhibition($request):array
    {
        DB::beginTransaction();
        try{
            $exhibition=Exhibition::query()->create([
                'title'=>$request['title'],
                'body'=>$request['body'],
                'start_date'=>$request['start_date'],
                'end_date'=>$request['end_date'],
                'time'=>$request['time'],
                'price'=>$request['price'],
                'location'=>$request['location'],
                'status'=>0
            ]);
            $exhibitionOrganizer=Exhibition_organizer::query()->create([
                'exhibition_id'=>$exhibition['id'],
                'user_id'=>auth()->id(),
            ]);
            if(request()->hasFile('cover_img')){
                $img=Str::random(32).".".time().'.'.request()->cover_img->getClientOriginalExtension();
                $exhibition['cover_img']=$img;
                Storage::disk('public')->put($img, file_get_contents($request['cover_img']));
                $exhibition->save();
            }
            DB::commit();
            $data=$exhibition;
            $message = 'Exhibition added successfully. ';
            $code = 200;
            return ['data' => $data, 'message' => $message, 'code' => $code];

        }catch (\Exception $e) {
            DB::rollback();
            $data=[];
            $message = 'Error during adding exhibition. Please try again ';
            $code = 500;
            return ['data' => $data, 'message' => $e->getMessage(), 'code' => $code];

        }
    }
    public function showExhibitionRequest(): array
    {
        DB::beginTransaction();
        try {
            $exhibition=Exhibition::query()->where('status',0)->get();
            DB::commit();
            $data=$exhibition;
            $message='Exhibition requests have been successfully displayed. ';
            $code = 200;
        }catch (\Exception $e) {
            DB::rollback();
            $data=[];
            $message = 'Error during showing exhibition Request. Please try again ';
            $code = 500;
        }
        return ['data' => $data, 'message' => $message, 'code' => $code];
    }
    public function acceptExhibition($id):array
    {
        DB::beginTransaction();
        try {
            $exhibition=Exhibition::query()->find($id);
            $exhibitionOrganizer=Exhibition_organizer::query()->where('exhibition_id',$id)->first();
            $user_id=$exhibitionOrganizer['user_id'];
            $user=User::query()->find($user_id);
            $exhibition['status']=1;
            $exhibition->save();
            Mail::to($user->email)->send(new AcceptExhibitionEmail($user->name,$exhibition->title));
            DB::commit();
            $data=$exhibition;
            $message='Exhibition accepted successfully. ';
            $code = 200;
        }catch (\Exception $e) {
            DB::rollback();
            $data=[];
            $message = 'Error during accepting exhibition. Please try again ';
            $code = 500;
        }
        return ['data' => $data, 'message' => $message, 'code' => $code];
    }
    public function rejectExhibition($id):array
    {
        DB::beginTransaction();
        try {
            $exhibition=Exhibition::query()->find($id);
            $exhibitionOrganizer=Exhibition_organizer::query()->where('exhibition_id',$id)->first();
            $user_id=$exhibitionOrganizer['user_id'];
            $user=User::query()->find($user_id);
            Mail::to($user->email)->send(new RejectExhibitionEmail($user->name,$exhibition->title));
            $exhibition->delete();
            $exhibitionOrganizer->delete();
            DB::commit();
            $message='Exhibition rejected successfully. ';
            $code = 200;

        }catch (\Exception $e) {
            DB::rollback();
            $message = 'Error during rejecting exhibition. Please try again ';
            $code = 500;
        }
        return ['data' => [], 'message' => $message, 'code' => $code];
    }
    public function deleteExhibition($id):array
    {
        DB::beginTransaction();
        try {
            $exhibition=Exhibition::query()->find($id);
            $exhibitionOrganizer=Exhibition_organizer::query()->where('exhibition_id',$id)->first();
            $user_id=$exhibitionOrganizer['user_id'];
            $user=User::query()->find($user_id);
            $exhibition->delete();
            $exhibitionOrganizer->delete();
            DB::commit();
            $message='Exhibition deleted successfully. ';
            $code = 200;
            return ['data' => [], 'message' => $message, 'code' => $code];

        }catch (\Exception $e) {
            DB::rollback();
            $message = 'Error during deleting exhibition. Please try again ';
            $code = 500;
            return ['data' => [], 'message' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }
    public function updateExhibition($request,$id):array
    {
        DB::beginTransaction();
        try{
            $exhibition=Exhibition::query()->find($id);
            $exhibition->update([
                'title'=>$request['title'],
                'body'=>$request['body'],
                'start_date'=>$request['start_date'],
                'end_date'=>$request['end_date'],
                'time'=>$request['time'],
                'price'=>$request['price'],
            ]);
            if(request()->hasFile('cover_img')){
                $img=Str::random(32).".".time().'.'.request()->cover_img->getClientOriginalExtension();
                $exhibition['cover_img']=$img;
                Storage::disk('public')->put($img, file_get_contents($request['cover_img']));
                $exhibition->save();
            }
            DB::commit();
            $message='Exhibition updated successfully. ';
            $code = 200;
            return ['data' => $exhibition, 'message' => $message, 'code' => $code];
        }catch (\Exception $e) {
            DB::rollback();
            $message = 'Error during updating exhibition. Please try again ';
            $code = 500;
            return ['data' => [], 'message' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }

    //me


    public function addExhibitionSection($section_id,$exhibition_id)
    {
        $exhibition=Exhibition::query()->where('id', $exhibition_id)->first();
        $exhibition['section_id']=$section_id;
        $message = 'delete section successfully';
        $code = 200;
        $data = $exhibition;

        return ['data' => $data, 'message' => $message, 'code' => $code];
    }
    public function addExhibitionMedia($request,$exhibition_id)
    {

        $img = Str::random(32) . "." . time() . "." . $request->img->getClientOriginalExtension();

        $media = Media::query()->create([
            'mediable_id' => $exhibition_id,
            'mediable_type' => 'App\Models\Exhibition',
            'url' => $img
        ]);

        Storage::disk('public')->put($img, file_get_contents($request->file('img')));

        $message = 'add media successfully';
        $code = 200;
        $data = [];

        return ['data' => $data, 'message' => $message, 'code' => $code];
    }
    public function deleteExhibitionMedia($media_id)
    {

        $media = Media::query()->where('id','=',$media_id)->first();
        $media->delete();
        $media->save();

        $message = 'add media successfully';
        $code = 200;
        $data = [];

        return ['data' => $data, 'message' => $message, 'code' => $code];
    }


}
