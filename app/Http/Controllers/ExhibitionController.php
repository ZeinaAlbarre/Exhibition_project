<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\ExhibitionSectionRequest;
use App\Http\Requests\ExhibitionStatusRequest;
use App\Http\Requests\SearchExhibitionRequest;
use App\Http\Requests\UpdateExhibitionRequest;
use App\Http\Requests\VisitorSiginUpRequst;
use App\Http\Responses\Response;
use App\Services\ExhibitionService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function updateExhibition(UpdateExhibitionRequest $request,$id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->updateExhibition($request->validated(),$id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function addExhibitionSection(ExhibitionSectionRequest $request,$id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->addExhibitionSection($request->validated(),$id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function showEmployeeExhibition(): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->showEmployeeExhibition();
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function searchExhibition(SearchExhibitionRequest $request): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->searchExhibition($request->validated());
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function showExhibition($id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->showExhibition($id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function showExhibitionSection($section_id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->showExhibitionSection($section_id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function showAvailableExhibition(): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->showAvailableExhibition();
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function showAvailableCompanyExhibition(): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->showAvailableCompanyExhibition();
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

    public function changeExhibitionStatus(ExhibitionStatusRequest $request,$id): JsonResponse
    {
        $data=[];
        try{
            $data=$this->exhibitionService->changeExhibitionStatus($request->validated(),$id);
            return Response::Success($data['data'],$data['message']);
        }catch (\Throwable $th){
            $message=$th->getMessage();
            return Response::Error($data,$message);
        }

    }

}
