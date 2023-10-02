<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userApartments = Apartment::where('user_id', $user->id)->get();
        $userApartmentIds = $userApartments->pluck('id')->toArray();

        // Recupera i dati dei visitatori anziché delle visualizzazioni
        $visitors = Visitor::whereIn('apartment_id', $userApartmentIds)->get();

        // Calcola le statistiche sui visitatori
        $apartmentViews = $visitors->groupBy('apartment_id')->map(function ($visitors) {
            $viewsByYear = $visitors->groupBy(function ($visitor) {
                return Carbon::parse($visitor->viewed_at)->format('Y');
            });
        
            $yearlyViews = $viewsByYear->map(function ($views) {
                return count($views);
            });

            $viewsByMonth = $visitors->groupBy(function ($visitor) {
                return Carbon::parse($visitor->viewed_at)->format('F Y');
            });

            $monthlyViews = $viewsByMonth->map(function ($views) {
                return count($views);
            });

            $yearlyMonthlyViews = $viewsByYear->map(function ($views) use ($viewsByMonth) {
                $yearlyMonthlyViews = [];
                foreach ($viewsByMonth as $month => $monthViews) {
                    $yearlyMonthlyViews[$month] = count($monthViews);
                }
                return $yearlyMonthlyViews;
            });
            
            return [
                'total_views' => count($visitors),
                'yearly_views' => $yearlyViews,
                'monthly_views' => $monthlyViews,
                'yearly_monthly_views' => $yearlyMonthlyViews,
            ];
        });

        $viewsByApartmentAndYear = $visitors->groupBy('apartment_id')
            ->map(function ($apartmentVisitors) {
                return $apartmentVisitors->groupBy(function ($visitor) {
                    return Carbon::parse($visitor->viewed_at)->format('Y');
                })->map(function ($viewsByYear) {
                    return $viewsByYear->groupBy(function ($visitor) {
                        return Carbon::parse($visitor->viewed_at)->format('F Y');
                    })->map(function ($viewsByMonth) {
                        return count($viewsByMonth);
                    });
                });
            });

        $yearlyMonthlyViews = $apartmentViews->map(function ($apartmentViews) {
            $yearlyMonthlyViews = [];
            foreach ($apartmentViews['yearly_monthly_views'] as $yearlyMonthlyView) {
                foreach ($yearlyMonthlyView as $month => $views) {
                    if (!isset($yearlyMonthlyViews[$month])) {
                        $yearlyMonthlyViews[$month] = 0;
                    }
                    $yearlyMonthlyViews[$month] += $views;
                }
            }
            return $yearlyMonthlyViews;
        });

        $viewsByYear = $visitors->groupBy(function ($visitor) {
            return Carbon::parse($visitor->viewed_at)->format('Y');
        });

        $yearlyViews = $viewsByYear->map(function ($views) {
            return count($views);
        });

        $viewsByMonth = $visitors->groupBy(function ($visitor) {
            return Carbon::parse($visitor->viewed_at)->format('F Y');
        });

        $monthlyViews = $viewsByMonth->map(function ($views) {
            return count($views);
        });

        $years = $visitors->map(function ($visitor) {
            if ($visitor->viewed_at) {
                return Carbon::parse($visitor->viewed_at)->format('Y');
            }
            return null;
        })->filter()->unique()->toArray();
        
        rsort($years);

        $apartmentMessages = $userApartments->map(function ($apartment) {
            return [
                'apartment_id' => $apartment->id,
                'message_count' => $apartment->leads()->count(),
            ];
        });
        
        return view('admin.statistic.index', compact('visitors', 'user', 'years', 'userApartmentIds', 'apartmentViews', 'userApartments', 'yearlyViews', 'monthlyViews', 'yearlyMonthlyViews', 'viewsByApartmentAndYear', 'apartmentMessages'));
    }

    public function show($id)
    {
        // Trova l'appartamento con l'ID fornito
        $apartment = Apartment::findOrFail($id);
        
        // Altri passaggi necessari per visualizzare i dettagli dell'appartamento
        
        $user = Auth::user();
        $userApartments = Apartment::where('user_id', $user->id)->get();
        $userApartmentIds = $userApartments->pluck('id')->toArray();
        
        // Recupera i dati dei visitatori anziché delle visualizzazioni
        $visitors = Visitor::where('apartment_id', $id)->get();
        
        // Calcola le statistiche sui visitatori
        $viewsByMonthYear = $visitors->groupBy(function ($visitor) {
            return Carbon::parse($visitor->viewed_at)->format('M Y');
        });
    
        $monthlyViews = $viewsByMonthYear->map(function ($views) {
            return count($views);
        });
    
        $monthsYears = $visitors->map(function ($visitor) {
            if ($visitor->viewed_at) {
                return Carbon::parse($visitor->viewed_at)->format('Y-m');
            }
            return null;
        })->filter()->unique()->sort()->toArray();
        
        rsort($monthsYears);

        $startOfMonth = Carbon::create(2023, 1, 1)->startOfMonth();
        $endOfMonth = Carbon::create(2023, 9, 30)->endOfMonth();
    
        $apartmentMessages = $apartment->leads()
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->get();
    
        $messagesByMonthYear = $apartmentMessages->groupBy(function ($message) {
            return Carbon::parse($message->created_at)->format('M Y');
        });
    
        $monthlyMessages = $messagesByMonthYear->map(function ($messages) {
            return count($messages);
        });
    
        $monthsYearsMessages = $apartmentMessages->map(function ($message) {
            if ($message->created_at) {
                return Carbon::parse($message->created_at)->format('Y-m');
            }
            return null;
        })->filter()->unique()->sort();
        
        return view('admin.statistic.show', compact('apartment', 'visitors', 'user', 'monthsYears', 'userApartmentIds', 'userApartments', 'monthlyViews', 'apartmentMessages', 'monthlyMessages', 'monthsYearsMessages'));

    }
}