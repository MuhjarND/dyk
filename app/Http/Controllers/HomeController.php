<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Post;
use App\Category;
use App\ProfilePage;
use App\Slider;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $selectedMonth = request('agenda_month');
        $calendarMonth = now()->startOfMonth();

        if ($selectedMonth) {
            try {
                $calendarMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
            } catch (\Exception $exception) {
                $calendarMonth = now()->startOfMonth();
            }
        }

        $calendarStart = $calendarMonth->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $calendarMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $agendaItems = Agenda::active()
            ->whereBetween('agenda_date', [$calendarStart->toDateString(), $calendarEnd->toDateString()])
            ->orderBy('agenda_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($agenda) {
                return $agenda->agenda_date->format('Y-m-d');
            });

        $calendarDays = collect();
        $cursor = $calendarStart->copy();

        while ($cursor->lte($calendarEnd)) {
            $calendarDays->push([
                'date' => $cursor->copy(),
                'events' => $agendaItems->get($cursor->format('Y-m-d'), collect()),
                'isCurrentMonth' => $cursor->month === $calendarMonth->month,
                'isToday' => $cursor->isSameDay(now()),
            ]);
            $cursor->addDay();
        }

        $upcomingAgendas = Agenda::active()
            ->whereDate('agenda_date', '>=', now()->toDateString())
            ->orderBy('agenda_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $sliders = Slider::with('post')
            ->active()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $posts = Post::with(['category', 'author'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        $categories = Category::withCount(['posts' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        $totalPosts = Post::published()->count();
        $totalViews = Post::sum('views');
        $totalCategories = Category::count();

        return view('home', compact(
            'sliders', 'posts', 'categories', 'totalPosts', 'totalViews',
            'totalCategories', 'calendarMonth', 'calendarDays', 'upcomingAgendas'
        ));
    }

    public function profil()
    {
        $pages = ProfilePage::active()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('profil', compact('pages'));
    }

    public function profilShow($slug)
    {
        $page = ProfilePage::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $pages = ProfilePage::active()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('profil-show', compact('page', 'pages'));
    }

    public function kontak()
    {
        return view('kontak');
    }
}
