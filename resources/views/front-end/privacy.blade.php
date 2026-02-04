@extends('layouts.main')
@section('title')
@lang('Privacy.bread-crumb') - Best Deals and Discounts | CouponsArena
@endsection
@section('description')
Find the best deals, discounts, and coupons on CouponsArena. Save money on your favorite products from top brands.
@endsection
@section('keywords','deals, discounts, coupons, savings, affiliate marketing')

    @section('main-content')


<div class="container">
<nav class=" breadcrumb" aria-label="breadcrumb" style="background-color: #f8f9fa; border-radius: 0.25rem; padding: 10px;">
<ol class="breadcrumb mb-0">
<li class="breadcrumb-item">
<a href="{{ url(app()->getLocale() . '/') }}" class="text-decoration-none text-primary" style="font-weight: 500;">@lang('message.home')</a>
</li>
<li class="breadcrumb-item active" aria-current="page" style="font-weight: 600; color: #6c757d;">@lang('Privacy.bread-crumb')</li>
</ol>
</nav>
<div class="container text-dark ">
    <div class="text-center">
        {{-- <div class="image-container">
            <img src="{{asset('images/contact.png')}}" alt="Image" class=" pri img-fluid shadow border-info" />
        </div>
         --}}

      <h1 class="mt-3 mb-4">@lang('Privacy.heading-1')</h1>
    </div>

    <div class="row">
      <div class="col-md-12 mx-auto mb-4">
        <p>
            @lang('Privacy.p-1')
        </p>
        <span class="text-center fw-bold">@lang('Privacy.span-1')</span>
      </div>
    </div>

<section class=" privacy py-3">
    <div class="row">
        <div class="col-md-18 mx-auto">
          <h2>@lang('Privacy.heading-2')</h2>
          <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="me-3">
                  <i class="fas fa-user-circle text-primary fs-4"></i>@lang('Privacy.span-2')
                </span>
                <span class="badge bg-primary rounded-pill">@lang('Privacy.p-2')</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="me-3">
                  <i class="fas fa-shield-alt text-primary fs-4"></i> @lang('Privacy.span-3')
                </span>
                <span class="badge bg-primary rounded-pill">@lang('Privacy.p-3')</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="me-3">
                  <i class="fas fa-link text-primary fs-4"></i> @lang('Privacy.span-4')
                </span>
                <span class="badge bg-primary rounded-pill">@lang('Privacy.p-4')</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="me-3">
                  <i class="fas fa-cog text-primary fs-4"></i> @lang('Privacy.span-5')
                </span>
                <p class="ms-auto mb-0">@lang('Privacy.p-5')</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="me-3">
                  <i class="fas fa-user-friends text-primary fs-4"></i> @lang('Privacy.span-6')
                </span>
                <p class="ms-auto mb-0">@lang('Privacy.p-6')</p>
              </li>

                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-shield-alt text-primary fs-4"></i>@lang('Privacy.span-7')
                    </span>
                  <p class="ms-auto mb-0">@lang('Privacy.p-7')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-balance-scale text-primary fs-4"></i>@lang('Privacy.span-8')
                    </span>
                   <p class="ms-auto mb-0">@lang('Privacy.p-8')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-sign-out-alt text-primary fs-4"></i> @lang('Privacy.span-9')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-9')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-user-edit text-primary fs-4"></i> @lang('Privacy.span-10')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-10')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-cookie-bite text-primary fs-4"></i>@lang('Privacy.span-11')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-11')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-ban text-primary fs-4"></i> @lang('Privacy.span-12')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-12')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-map-marker-alt text-primary fs-4"></i>@lang('Privacy.span-13')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-13')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-sync-alt text-primary fs-4"></i>@lang('Privacy.span-14')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-14')</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-envelope text-primary fs-4"></i>@lang('Privacy.span-15')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-15') <a href="mailto: contact@CouponsArena.com"> contact@CouponsArena.com</a>.</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="me-3">
                      <i class="fas fa-file-alt text-primary fs-4"></i> @lang('Privacy.span-16')
                    </span>
                    <p class="ms-auto mb-0">@lang('Privacy.p-16')</p>
                  </li>


              </ul>

        </div>
      </div>
</section>

  </div>


</div>
</div>
@endsection
@push('styles')
  <style>
    .privacy .fas {
    color: rgb(0, 140, 255);
    }

    .container {
    font-family: Arial, sans-serif;
    margin-top: 20px;
    }

    .list-group-item i {
    margin-right: 10px;
    }

    .h2 {
    margin-top: 30px;
    }

    .key-points {
    margin-top: 20px;
    }
  </style>
@endpush