<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Services\ExhibitionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Responses\Response;


class ExhibitionController extends Controller
{
    private ExhibitionService $exhibitionService;
    public function __construct(ExhibitionService $exhibitionService){
        $this->exhibitionService=$exhibitionService;
    }

    public function addExhibition(ExhibitionRequest $request): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->addExhibition($request->validated());
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function showExhibitionRequest(): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->showExhibitionRequest();
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function acceptExhibition($id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->acceptExhibition($id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function rejectExhibition($id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->rejectExhibition($id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function deleteExhibition($id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->deleteExhibition($id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function updateExhibition(ExhibitionRequest $request,$id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->updateExhibition($request,$id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }
    }


}
