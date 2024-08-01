<?php

namespace App\Http\Controllers;
use App\Models\FreeDaysRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficialHoliday;

class StatisticsController extends Controller{
    public function index()
    {
        $userId = auth()->user()->id;
        $companyId = auth()->user()->company_id;

        $statistics = $this->getStatistics($userId,$companyId);
        $requestsByCategory = $this->getUserByStatistics($userId, $companyId);
        $daysPerYear = $this->getDaysPerYear($userId,$companyId);
        $daysPerMonth = $this -> getDaysPerMonth($userId, $companyId);
        $formattedData = $this ->getFormattedData($userId, $companyId);


        return view('statistics',[
            'statistics' => $statistics,
            'requestsByCategory' => $requestsByCategory,
            'daysPerYear' => $daysPerYear,
            'daysPerMonth' => $daysPerMonth,
            'formattedData' => $formattedData

        ]);


    }

    private function getStatistics($userId, $companyId)
    {
        $freeDayRequets = FreeDaysRequest::approved()
            ->applySecurity($companyId)
            ->where('user_id', $userId)
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

    private function getUserByStatistics($userId, $companyId)
    {
        $freeDaysRequests = FreeDaysRequest::approved()
            ->applySecurity($companyId)
            ->where('user_id', $userId)
            ->with('category')
            ->get();

        return $freeDaysRequests->groupBy('category.name')->map(function($items){
            return $items->count();
        });
    }

    private function getDaysPerYear($userId,$companyId){
        $allFreeDays = FreeDaysRequest::approved()
            ->applySecurity($companyId)
            ->where('user_id', $userId)
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
    private function getDaysPerMonth($userId, $companyId)
    {
        $freeDaysRequests = FreeDaysRequest::approved()
            ->applySecurity($companyId)
            ->where('user_id', $userId)
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


                $formattedMonth = $this->formattedMonth($start);
                $currentDays = $daysPerMonth->get($formattedMonth, 0);
                $daysPerMonth->put($formattedMonth, $currentDays + $daysInMonth);


                $start->addMonth()->startOfMonth();

            }
        }

        $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        $currentYear = Carbon::now()->year;

        return $months->mapWithKeys(function ($month) use ($daysPerMonth, $currentYear) {
            $formattedMonth = "{$month} {$currentYear}";
            return [$formattedMonth => $daysPerMonth->get($formattedMonth, 0)];
        });
    }

    private function getFormattedData($userId,$companyId)
    {
        $user = User::find($userId);
        $categories = Category::all();
        $years = $this->getDaysPerYear($userId, $companyId);

        $chartData = [];

        foreach ($years as $year => $totalYears) {

            $userData = ['year' => $year, 'user' => "{$user->first_name} {$user->last_name}"];


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

        return [
            'categories' => $categories->pluck('name'),
            'categoryColors' => $categories->pluck('color','name')->toArray(),
            'years' => array_keys($years),
            'data' => $chartData
        ];
    }

}
