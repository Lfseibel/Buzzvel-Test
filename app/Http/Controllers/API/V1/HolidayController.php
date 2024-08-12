<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\StoreHolidayRequest;
use App\Http\Requests\V1\UpdateHolidayRequest;
use App\Models\Holiday;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\HolidayResource;
use App\Http\Resources\V1\HolidayCollection;
use App\Filters\V1\HolidayFilter;
use App\Http\Requests\V1\BulkStoreHolidayRequest;
use App\Http\Requests\V1\DeleteHolidayRequest;
use App\Http\Requests\V1\ReadHolidayRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function checkUser($check)
    {
        $user = Auth::user();
        
        if ($check != $user->id) {
            $data = [
                'message' => 'You do not have access to this holiday',
            ];

            return response()->json($data, 401);
        }
        return null; // Return null if the user has access
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $filter = new HolidayFilter();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']] title[lk]=Final,participants[in]=Rafael,Peres
        
        $holidays = Holiday::where($filterItems)->where('user_id', '=', $user->id);

        return new HolidayCollection($holidays->paginate()->appends($request->query()));
    }

    public function pdf($id)
    {
        if(!$holiday = Holiday::find($id))
        {
            $data = [
                'message' => 'This holiday does not exist exist',
            ];
    
            return response()->json($data, 404);
        }
        
        if ($response = $this->checkUser($holiday->user_id)) {
            return $response;
        }

        $data = [
            'title' => $holiday->title,
            'description' => $holiday->description,
            'date' => $holiday->date,
            'location' => $holiday->location,
            'participants' => $holiday->participants
        ];
        
        $pdf = Pdf::loadView('pdf', $data);

        return $pdf->download('holiday.pdf');
    }

    public function store(StoreHolidayRequest $request)
    {
        $user = Auth::user();

        $requestData = $request->all();

        $requestData['user_id'] = $user->id;

        return new HolidayResource(Holiday::create($requestData));
    }

    public function bulkStore(BulkStoreHolidayRequest $request)
    {
        $user = Auth::user();

        $bulk = collect($request->all())->map(function ($item) use ($user) {
            $item['user_id'] = $user->id;
            return $item;
        });

        Holiday::insert($bulk->toArray());

        $data = [
            'message' => 'Stored all holidays succesfully',
        ];

        return response()->json($data);
    }

    public function show(Holiday $holiday, ReadHolidayRequest $request)
    {
        if ($response = $this->checkUser($holiday->user_id)) {
            return $response;
        }
        return new HolidayResource($holiday); 
    }

    public function update(UpdateHolidayRequest $request, Holiday $holiday)
    {
        if ($response = $this->checkUser($holiday->user_id)) {
            return $response;
        }

        $data = [
            'message' => 'Holiday updated succesfully',
        ];

        $holiday->update($request->all());
        
        return response()->json($data, 200);
    }

    public function destroy(DeleteHolidayRequest $request,Holiday $holiday)
    {
        if ($response = $this->checkUser($holiday->user_id)) {
            return $response;
        }

        $data = [
            'message' => 'Holiday '.$holiday->title.' deleted succesfully',
        ];

        $holiday->delete();
        return response()->json($data);
    }
}
