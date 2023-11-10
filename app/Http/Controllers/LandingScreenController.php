<?php

namespace App\Http\Controllers;

use App\Models\AdminTestimonial;
use App\Models\Faq;
use App\Models\LandingAboutUs;
use App\Models\SectionOne;
use App\Models\SectionThree;
use App\Models\SectionTwo;
use App\Models\ServiceSlider;
use App\Models\SubscriptionPlan;
use App\Repositories\SubscriptionPlanRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LandingScreenController extends Controller
{
    private $subscriptionPlanRepository;

    public function __construct(SubscriptionPlanRepository $subscriptionPlanRepo)
    {
        $this->subscriptionPlanRepository = $subscriptionPlanRepo;
    }

    public function index()
    {
        $data['sectionOne'] = SectionOne::with('media')->first();
        $data['sectionTwo'] = SectionTwo::first();
        $data['sectionThree'] = SectionThree::with('media')->first();
        $data['subscriptionPricingPlans'] = SubscriptionPlan::whereIsDefault(false)->toBase()->get();
        $data['testimonials'] = AdminTestimonial::with('media')->get();
        $data['faqs'] = Faq::toBase()->orderByDesc('created_at')->get();

        return view('landing.home.index')->with($data);
    }

    public function aboutUs()
    {
        $data['landingAboutUs'] = LandingAboutUs::first();
        $data['faqs'] = Faq::orderByDesc('created_at')->get();
        $data['subscriptionPricingMonthPlans'] = SubscriptionPlan::with(['plan', 'plans'])
            ->where('frequency', '=', SubscriptionPlan::MONTH)
            ->get();
        $data['subscriptionPricingYearPlans'] = SubscriptionPlan::with(['plan', 'plans'])
            ->where('frequency', '=', SubscriptionPlan::YEAR)
            ->get();

        return view('landing.home.about_us')->with($data);
    }

    public function services(): View
    {
        $data['subscriptionPricingMonthPlans'] = SubscriptionPlan::with(['plan', 'plans'])
            ->where('frequency', '=', SubscriptionPlan::MONTH)
            ->get();
        $data['subscriptionPricingYearPlans'] = SubscriptionPlan::with(['plan', 'plans'])
            ->where('frequency', '=', SubscriptionPlan::YEAR)
            ->get();
        $data['serviceSlider'] = ServiceSlider::get();
        $data['testimonials'] = AdminTestimonial::get();

        return view('landing.home.services')->with($data);
    }


    public function contactUs(): View
    {
        return view('landing.home.contact_us');
    }

    public function faq(): View
    {
        $faqs = Faq::orderByDesc('created_at')->get();

        return view('landing.home.faq', compact('faqs'));
    }

    public function pricing(): View
    {
        $data['subscriptionPricingMonthPlans'] = SubscriptionPlan::with(['plan', 'plans'])
            ->where('frequency', '=', SubscriptionPlan::MONTH)
            ->get();
        $data['subscriptionPricingYearPlans'] = SubscriptionPlan::with(['plan', 'plans'])
            ->where('frequency', '=', SubscriptionPlan::YEAR)
            ->get();

        return view('landing.home.pricing')->with($data);
    }

    public function changeLanguage(Request $request): RedirectResponse
    {
        Session::put('languageName', $request->input('languageName'));

        return redirect()->back();
    }
}
