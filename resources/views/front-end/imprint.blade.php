@extends('layouts.main')
@section('title')
{{ __('imprint.imprint') }}
@endsection
@section('description')
Explore exclusive discounts and offers on top brands. Save money on your online shopping with CouponsArena.
@endsection
@section('keywords','deals, discounts, coupons, savings, affiliate marketing, promo codes, cashback, online shopping, special offers, vouchers, best prices, holiday sales, seasonal discounts, gift cards, price comparison, money-saving tips')
@section('style')
<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .breadcrumb {
        margin-bottom: 20px;
    }

    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb a.active {
        color: #333;
        font-weight: bold;
    }

    .text-main {
        line-height: 1.6;
    }

    .page-heading {
        font-size: 2em;
        margin-bottom: 10px;
        color: #000000;
    }

    .contact-info {
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .contact-info a {
        color: #000000;
        text-decoration: none;
    }

    .contact-info a:hover {
        color: #000000;
        text-decoration: underline;
    }
</style>
@endsection
@section('main-content')
    <div class="container text-capitalize">
        <nav aria-label="breadcrumb" style="background-color: #f8f9fa; border-radius: 0.25rem; padding: 10px;">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/" class="text-decoration-none text-primary" style="font-weight: 500;">{{ __('imprint.home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="font-weight: 600; color: #6c757d;">{{ __('imprint.active') }}</li>
            </ol>
        </nav>

        <div class="text-main text-dark">
            <h1 class="page-heading">{{ __('imprint.imprint') }}</h1>
            <h2>{{ __('imprint.contact_information') }}</h2>
            <div class="contact-info">
                <p><strong>{{ __('imprint.owner') }}</strong></p>
                <p><strong>Phone : +17473651163</strong></p>
                <p><strong>{{ __('imprint.address') }}</strong></p>
                <p><strong>@lang('message.contact')</strong> <a href="mailto:{{ __('imprint.contact_email') }}">{{ __('imprint.contact_email') }}</a></p>
            </div>
        </div>
    </div>
@endsection
