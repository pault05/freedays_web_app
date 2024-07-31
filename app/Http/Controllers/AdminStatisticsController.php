<?php

namespace App\Http\Controllers;
use App\Models\FreeDaysRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficialHoliday;

class AdminStatisticsController extends Controller{
    public function index()
    {

        $companyId = auth()->user()->company_id;

        $statistics = $this->getStatistics($companyId);
        $requestsByCategory = $this->getUserByStatistics($companyId);
        $daysPerYear = $this->getDaysPerYear($companyId);
        $daysPerMonth = $this -> getDaysPerMonth($companyId);
        $formattedData = $this ->getFormattedData( $companyId);


        return view('admin_statistics',[
            'statistics' => $statistics,
            'requestsByCategory' => $requestsByCategory,
            'daysPerYear' => $daysPerYear,
            'daysPerMonth' => $daysPerMonth,
            'formattedData' => $formattedData

        ]);


    }

    private function getStatistics($companyId)
    {
        $freeDayRequets = FreeDaysRequest::approved()
            ->applySecurity($companyId)
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

    private function getUserByStatistics($companyId)
    {
        $freeDaysRequests = FreeDaysRequest::approved()
            ->applySecurity($companyId)
            ->with('category')
            ->get();

        return $freeDaysRequests->groupBy('category.name')->map(function($items){
            return $items->count();
        });
    }

    private function getDaysPerYear($companyId){
        $allFreeDays = FreeDaysRequest::approved()
            ->applySecurity($companyId)
            ->with('category')
            ->get();

        return $allFreeDays->groupBy(function($request){
            return Carbon::parse($request['starting_date'])->year;
        })->map(function ($yearRequests){
            return $yearRequests->sum('days');
        })->toArray();
    }



    private function isWorkingDay(Carbon $date, array $officialHolidays): bool
    {
        return !$date->isWeekend() && !in_array($date->format('Y-m-d'), $officialHolidays);
    }

    private function formattedMonth($date)
    {
        return $date->format('F Y');
    }
    private function getDaysPerMonth($companyId)
    {
        $companyId = auth()->user()->company_id;
        $freeDaysRequests = FreeDaysRequest::approved()
            ->applySecurity($companyId)
            ->get();

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

    private function getFormattedData($companyId)
    {
        $years = FreeDaysRequest::selectRaw('YEAR(starting_date) as year')
            ->approved()
            ->applySecurity($companyId)
            ->distinct()
            ->pluck('year');

        $categories = Category::all();
        $users = User::where('company_id', $companyId)->get();
        $chartData = [];

        foreach ($years as $year) {
            foreach ($users as $user) {

                $userData = ['user' => "{$user->first_name} {$user->last_name}", 'year' => $year];

                foreach ($categories as $category) {
                    $count = FreeDaysRequest::where('user_id', $user->id)
                        ->applySecurity($companyId)
                        ->where('category_id', $category->id)
                        ->whereYear('starting_date', $year)
                        ->count();

                    $userData[$category->name] = $count;
                }
                $chartData[] = $userData;
            }
        }

        return [
            'years' => $years,
            'categories' => $categories->pluck('name')->toArray(),
            'categoryColors' => $categories->pluck('color','name')->toArray(),
            'data' => $chartData,
            //fn este pentru functie anonima
            'users' => $users->map(fn($user) => "{$user->first_name} {$user->last_name}")->toArray()
        ];
    }

}
