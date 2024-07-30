<?php
namespace App\Http\Controllers;
use App\Models\FreeDaysRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\OfficialHoliday;
class AdminStatisticsController extends Controller
{
    public function index()
    {
        //$userId = auth()->user()->id;

        $userCompany = auth()->user()->company_id;

        $statistics = $this->getStatistics(auth()->user()->id);
        $requestsByCategory = $this->getUserByStatistics();
        $daysPerYear = $this->getDaysPerYear();
        $daysPerMonth = $this->getDaysPerMonth();
        $formattedData = $this->getFormattedData();


        return view('admin_statistics', [
            'statistics' => $statistics,
            'requestsByCategory' => $requestsByCategory,
            'daysPerYear' => $daysPerYear,
            'daysPerMonth' => $daysPerMonth,
            'formattedData' => $formattedData

        ]);


    }

    private function getStatistics($userId)
    {
        $freeDayRequests = FreeDaysRequest::where('user_id', $userId)
            ->where('status','approved')
            ->with('category')
            ->get();

        $data = $freeDayRequests->map(function ($request) {
            $start = Carbon::parse($request->starting_date);
            $end = Carbon::parse($request->ending_date);
            $daysOff = $end->diffInDays($start) + 1;

            return [
                'month' => $start->format('F Y'),
                'days' => $daysOff,
            ];
        });

        return $data->groupBy('month')->map(function ($items) {
            return $items->sum('days');
        });
    }

    private function getUserByStatistics()
    {
        $freeDaysRequests = FreeDaysRequest::where('status','approved')
            ->with('category')
            ->get();

        return $freeDaysRequests->groupBy('category.name')->map(function ($items) {
            return $items->count();
        });
    }

    private function getDaysPerYear()
    {
        $allFreeDays = FreeDaysRequest::where('status','approved')
            ->with('category')
            ->get();

        return $allFreeDays->groupBy(function ($request) {
            return Carbon::parse($request['starting_date'])->year;
        })->map(function ($yearRequests) {
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
    private function formattedMonth($date)
    {
        return $date->format('F Y');
    }

    private function isWorkingDay(Carbon $date, array $officialHolidays): bool
    {
        return !$date->isWeekend() && !in_array($date->format('Y-m-d'), $officialHolidays);
    }
    private function getDaysPerMonth()
    {
        $freeDaysRequests = FreeDaysRequest::where('status','approved')->get();
        $daysPerMonth = collect();

        $officialHolidays = OfficialHoliday::pluck('date')->map(function ($date){
            return Carbon::parse($date)->format('Y-m-d');
        })->toArray();

        foreach ($freeDaysRequests as $request) {
            $start = Carbon::parse($request->starting_date);
            $end = Carbon::parse($request->ending_date);

            if ($end->lessThan($start)) {
                continue;
            }

            while ($start->lte($end)) {
                $monthEnd = $start->copy()->endOfMonth();

                if($monthEnd->greaterThan($end)){
                    $monthEnd = $end;
                }

                $daysInMonth = 0;
                $currentDay = $start->copy();

                while($currentDay->lte($monthEnd)){
                    if($this->isWorkingDay($currentDay, $officialHolidays)){
                        $daysInMonth++;
                    }
                    $currentDay->addDay();
                }
//                if($monthEnd < $end) {
//                    $daysInMonth = round($start->diffInDays($monthEnd) + 1);
//                    //sa adaugi si pentru luna urmatoare
//                } else {
//                    $daysInMonth = round($start->diffInDays($end) + 1);
//                }

                $formattedMonth = $this->formattedMonth($start);
                $currentDays = $daysPerMonth->get($formattedMonth, 0);
                $daysPerMonth->put($formattedMonth, $currentDays + $daysInMonth);

                // merge pe luna urmatoare
                $start->addMonth()->startOfMonth();

//                //$month = $start->format('F Y');
//                $formattedMonth = $this->formattedMonth($start);
//                $currentDays = $daysPerMonth->get($formattedMonth, 0);
//               // dd($currentDays, $formattedMonth, $currentDays, $daysInMonth);
//                $daysPerMonth->put($formattedMonth, $currentDays + $daysInMonth);
//                $start->addMonth()->startOfMonth();
            }
        }

        $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        $currentYear = Carbon::now()->year;

        return $months->mapWithKeys(function ($month) use ($daysPerMonth, $currentYear) {
            $formattedMonth = "{$month} {$currentYear}";
            return [$formattedMonth => $daysPerMonth->get($formattedMonth, 0)];
        });
    }


    private function getFormattedData()
    {
        $categories = Category::all();
        $users = \App\Models\User::all();
        $chartData = [];

        $categoryColors = $categories->pluck('color','name');

        foreach ($users as $user) {
            $userData = ['user' => $user->name];

            foreach ($categories as $category) {
                $count = FreeDaysRequest::where('user_id', $user->id)
                        ->where('category_id', $category->id)
                        ->where('status','approved')
                        ->count();

                    $userData[$category->name] = $count;
                }
                $chartData[] = $userData;
            }

            return [
                'categories' => $categories->pluck('name'),
                'users' => $users->pluck('name'),
                'categoryColors' => $categoryColors,
                'data' => $chartData
            ];
        }

}

