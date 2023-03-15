<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\NewsResource;
use App\Repository\Interfaces\NewsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends BaseController
{
    // this newsRepository Interface
    protected $newsRepository;
    public function __construct(NewsRepositoryInterface $newsRepositoryInterface)
    {
        $this->newsRepository = $newsRepositoryInterface;
    }

    public function index()
    {
        $news = NewsResource::collection($this->newsRepository->indexNews());
        return response()->json([
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return $this->sendError('Posted error. ', $validator->errors(), 422);
        }
        // return $request->all();
        $this->newsRepository->storeNews($request->title, $request->description, $request->file('image'));
        return $this->sendResponse('success', 'Malumotlar yuklandi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = NewsResource::collection($this->newsRepository->showNews($id));
        return $this->sendResponse('News.', $news);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validator = Validator::make($request->all(), $this->rules());
        // if ($validator->fails()) {
        //     return $this->sendError('error. ', $validator->errors(), 422);
        // }
        return $request;
        // $this->newsRepository->updateNews($request->title, $request->description, $request->file('image'), $id);
        // return $this->sendResponse('update.', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->newsRepository->destroyNews($id);
        return $this->sendResponse('Delete. ', 'Deleted Successfully');
    }

    protected function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ];
    }
}
