<?php

namespace App\Http\Controllers;
use App\Models\FreeDaysRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

//class StatisticsController extends Controller{
//
//    public function index()
//    {
//        $userId = auth()->user()->id;
//        $freeDaysRequests = FreeDaysRequest::where('user_id', $userId)->with('category')->get();
//        //dd($freeDaysRequests);
//        //$users = User::all();
//        $allFreeDays = FreeDaysRequest::with('category')->get();
//        //$daysInYear = FreeDaysRequest::whereYear('starting_date', '=', Carbon::now()->year)->get();
//
//
//        $daysInYear = FreeDaysRequest::where(function ($query) {
//            $currentYear = Carbon::now()->year;
//            $query->whereYear('starting_date', '=', $currentYear)
//                ->orWhereYear('ending_date', '=', $currentYear);
//        })->get();
//
//        //ASTA MERGE
//        $freeDaysArray = array();
//        $days = 0;
//        foreach ($allFreeDays as $request) {
//            //dd($request);
//            $year = Carbon::parse($request['starting_date'])->year;
//            //$days += $freeDaysRequests['days'];
//            $days += $request['days'];
//        }
//
//        $freeDaysArray = $allFreeDays->groupBy(function($request){
//            return Carbon::parse($request['starting_date'])->year;
//        })->map(function($yearrequests){
//            return $yearrequests->sum('days');
//        })->toArray();
//
//        //$freeDaysArray['year'] = $year;
//        //$freeDaysArray['days'] = $days;
//
//        //CU ASTA
////        $freeDaysArray = array (
////            array("2024",15),
////            array("2025",5),
////            array("2026",17),
////            array("2027",22)
////        );
//
////        $daysPerYear =[];
////        foreach ($freeDaysArray as $year => $days){
////            $daysPerYear[]=[$year, $days];
////        }
//
//        $data = $freeDaysRequests->map(function ($request){
//            $start = Carbon::parse($request->starting_date);
//            $end = Carbon::parse($request->ending_date);
//            $daysOff = $end->diffInDays($start) + 1;
//
//            return[
//                'month' => $start->format('F Y'),
//                'days' => $daysOff,
//            ];
//        });
//
//        $statistics = $data->groupBy('month')->map(function ($items){
//            return $items->sum('days');
//        });
//
//        $requestsByDescription = $freeDaysRequests->groupBy('category.name')->map(function($item,$key){
//            return $item->count();
//        });
//
//        $charData = $requestsByDescription->map(function ($count, $category_name){
//            return [$category_name, $count];
//        })->values()->toArray();
//
////        $daysPerMonth = $data->groupBy(function($item){
////            return Carbon::parse($item['month'])->format('F');
////        })->map(function ($item){
////            return $item->sum('days');
////        });
//
//        //dd($freeDaysRequests->toArray());
//
//        $daysPerMonth = $freeDaysRequests->map(function ($request) {
//            $start = Carbon::parse($request->starting_date);
//            $end = Carbon::parse($request->ending_date);
//            $daysOff = $start->diffInDays($end) + 1;
//
//            return [
//                'month' => $start->format('F'),
//                'days' => $daysOff,
//            ];
//        })->groupBy('month')->map(function ($items) {
//            return $items->sum('days');
//        });
//
//        $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
//        $daysPerMonth = $months->mapWithKeys(function ($month) use ($daysPerMonth) {
//            return [$month => $daysPerMonth->get($month, 0)];
//        });
//
//        //dd($daysPerMonth);
//
//        $freeDaysRequests = FreeDaysRequest::where('user_id', $userId)->with('category')->get();
//        $years = FreeDaysRequest::selectRaw('YEAR(starting_date) as year')
//            ->distinct()
//            ->pluck('year');
//
//        $categories = Category::all();
//        $charData = [];
//
//        //dd($categories);
//
//        foreach ($years as $year){
//            $yearData =[
//                'year' => $year,
//            ];
//            foreach ($categories as $category){
//                $count = FreeDaysRequest::where('user_id', $userId)
//                    ->where('category_id', $category->id)
//                    ->whereYear('starting_date', $year)
//                    ->count();
//
//
//                $yearData[$category->name]=$count;
//            }
//            $chartData[]=$yearData;
//        }
//
//        $formattedData = [
//            'years' => $years,
//            'categories' => $categories->pluck('name'),
//            'data' => $chartData
//        ];
//
//        //dd($formattedData);
//
//
//
//
//        return view('statistics',[
//            'statistics' => $statistics,
//            'requestsByDescription' => $requestsByDescription,
//            'charData' => $charData,
//            'daysPerYear' => $freeDaysArray,
//            'daysPerMonth' => $daysPerMonth,
//            'formattedData' => $formattedData
//
//        ]);
//
//        //dd($requestsByDescription);
//
//        //return view('statistics',compact('requestsByDescription'));
//    }
//
//}

class StatisticsController extends Controller{
    public function index()
    {
        $userId = auth()->user()->id;

        $statistics = $this->getStatistics($userId);
        $requestsByCategory = $this->getUserByStatistics($userId);
        $daysPerYear = $this->getDaysPerYear();
        $daysPerMonth = $this -> getDaysPerMonth($userId);
        $formattedData = $this ->getFormattedData($userId);



        return view('statistics',[
            'statistics' => $statistics,
            'requestsByCategory' => $requestsByCategory,
            'daysPerYear' => $daysPerYear,
            'daysPerMonth' => $daysPerMonth,
            'formattedData' => $formattedData

        ]);


    }

    private function getStatistics($userId)
    {
        $freeDayRequets = FreeDaysRequest::where('user_id', $userId)
            ->where('status','approved')
            ->with('category')
            ->get();

        $data = $freeDayRequets->map(function($request){
            $start = Carbon::parse($request->starting_date);
            $end = Carbon::parse($request->ending_date);
            $daysOff = $end->diffInDays($start)+1;

            return [
                'month'=> $start->format('F Y'),
                'days' => $daysOff,
            ];
        });

        return $data->groupBy('month')->map(function($items){
            return $items->sum('days');
        });
    }

    private function getUserByStatistics($userId)
    {
        $freeDaysRequests = FreeDaysRequest::where('user_id', $userId)
            ->where('status','approved')
            ->with('category')
            ->get();

        return $freeDaysRequests->groupBy('category.name')->map(function($items){
            return $items->count();
        });
    }

    private function getDaysPerYear(){
        $allFreeDays = FreeDaysRequest::where('status','approved')
            ->with('category')
            ->get();

        return $allFreeDays->groupBy(function($request){
            return Carbon::parse($request['starting_date'])->year;
        })->map(function ($yearRequests){
            return $yearRequests->sum('days');
        })->toArray();
}
//    private function getDaysPerYear()
//    {
//        $allFreeDays = FreeDaysRequest::with('category')->get();
//
//        $daysPerYear = $allFreeDays->flatMap(function ($request) {
//            $start = Carbon::parse($request->starting_date);
//            $end = Carbon::parse($request->ending_date);
//            $daysOff = $end->diffInDays($start) + 1;
//
//            $years = [];
//            for ($year = $start->year; $year <= $end->year; $year++) {
//                $startOfYear = Carbon::create($year, 1, 1);
//                $endOfYear = Carbon::create($year, 12, 31);
//
//                $startOfPeriod = $start->greaterThan($startOfYear) ? $start : $startOfYear;
//                $endOfPeriod = $end->lessThan($endOfYear) ? $end : $endOfYear;
//                $daysInYear = $endOfPeriod->diffInDays($startOfPeriod) + 1;
//
//                // Aggregate days in the year
//                if (isset($years[$year])) {
//                    $years[$year] += $daysInYear;
//                } else {
//                    $years[$year] = $daysInYear;
//                }
//            }
//
//            return $years;
//        })->reduce(function ($carry, $item) {
//            foreach ($item as $year => $days) {
//                if (isset($carry[$year])) {
//                    $carry[$year] += $days;
//                } else {
//                    $carry[$year] = $days;
//                }
//            }
//            return $carry;
//        }, []);
//
//        return $daysPerYear;
//    }


//    private function getDaysPerMonth($userId){
//        $freeDaysRequests = FreeDaysRequest::with('category')->get();
//
//        $daysPerMonth = $freeDaysRequests->map(function($request){
//            $start = Carbon::parse($request->starting_date);
//            $end = Carbon::parse($request->ending_date);
//            $daysOff = $end->diffInDays($start)+1;
//
//
//            return [
//                'month'=> $start->format('F'),
//                'days' => $daysOff,
//            ];
//        })->groupBy('month')->map(function($items){
//            return $items->sum('days');
//        });
//
//        $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
//        return $months->mapWithKeys(function ($month) use ($daysPerMonth){
//            return [$month => $daysPerMonth->get($month,0)];
//        });
//    }
    private function getDaysPerMonth($userId) {
        $freeDaysRequests = FreeDaysRequest::where('user_id', $userId)
            ->where('status','approved')
            ->get();
        $daysPerMonth = collect();

        foreach ($freeDaysRequests as $request) {
            $start = Carbon::parse($request->starting_date);
            $end = Carbon::parse($request->ending_date);

            if ($end->lessThan($start)) {
                continue;
            }

            while ($start->lte($end)) {
                $monthEnd = $start->copy()->endOfMonth();
                $daysInMonth = min($end->copy()->endOfMonth()->diffInDays($start) + 1, $monthEnd->diffInDays($start) + 1);

                $month = $start->format('F Y');
                $daysPerMonth->put($month, ($daysPerMonth->get($month, 0) + $daysInMonth));
                $start->addMonth()->startOfMonth();
            }
        }

        $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        $currentYear = Carbon::now()->year;

        return $months->mapWithKeys(function ($month) use ($daysPerMonth, $currentYear) {
            $formattedMonth = "{$month} {$currentYear}";
            return [$month => $daysPerMonth->get($formattedMonth, 0)];
        });
    }


    private function getFormattedData($userId)
    {
        $years = FreeDaysRequest::selectRaw('YEAR(starting_date) as year')
            ->where('status','approved')
            ->distinct()
            ->pluck('year');

        $categories = Category::all();
        $chartData = [];

        foreach ($years as $year) {
            $yearData = ['year' => $year];

            foreach ($categories as $category) {
                $count = FreeDaysRequest::where('user_id', $userId)
                    ->where('category_id', $category->id)
                    ->whereYear('starting_date', $year)
                    ->count();

                $yearData[$category->name] = $count;
            }
            $chartData[] = $yearData;
        }

        return [
            'years' => $years,
            'categories' => $categories->pluck('name'),
            'categoryColors' => $categories->pluck('color','name'),
            'data' => $chartData
        ];
    }

}
