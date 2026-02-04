@extends('layouts.main')
@section('title')
@lang('cookies/message.cookies_title')
@endsection
@section('description')
Find the best deals, discounts, and coupons on CouponsArena. Save money on your favorite products from top brands.
@endsection
@section('keywords','deals, discounts, coupons, savings, affiliate marketing')
@section('main-content')


<div class="container my-5">
    <nav aria-label="breadcrumb" style="background-color: #f8f9fa; border-radius: 0.25rem; padding: 10px;">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none text-primary" style="font-weight: 500;">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page" style="font-weight: 600; color: #6c757d;">@lang('cookies/message.cookies_title')</li>
        </ol>
    </nav>

    <div class="text-main">
        <h1 class="page-heading text-center mb-4">@lang('cookies/message.cookies_title')</h1>
        <h2 class="mt-4">@lang('message.heading-1')</h2>
        <p>@lang('cookies/message.info_use')</p>

        <h2 class="mt-4">@lang('message.heading-2')</h2>
        <p>@lang('message.what_are_cookies')</p>

        <h2 class="mt-4">@lang('cookies/message.heading-3')</h2>
        <p>@lang('message.security_privacy')</p>

        <h2 class="mt-4">@lang('message.heading-4')</h2>
        <p>@lang('message.registration_subscription')</p>

        <h2 class="mt-4">@lang('cookies/message.heading-5')</h2>
        <p>@lang('message.personalisation')</p>

        <h2 class="mt-4">@lang('cookies/message.heading-6')</h2>
        <p>@lang('message.analytics')</p>

        <h2 class="mt-4">@lang('cookies/message.heading-7')</h2>
        <p>@lang('message.third_party_cookies')</p>
    </div>
</div>

@endsection
