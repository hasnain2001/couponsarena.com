@extends('layouts.main')
@section('title')
@lang('terms.title')
@endsection
@section('description','Find the best deals, discounts, and coupons on CouponsArena. Save money on your favorite products from top brands.')
@section('keywords','')
@section('style')

    <!-- Styles -->
    <style>


        /* .contain {
            max-width: 800px;
            margin: 50px auto;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border-top: 4px solid #007bff;
            border-bottom: 4px solid #007bff;
        } */

        h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            color: #030303;
            text-align: center;
            font-weight: 700;
            position: relative;

        }

        h1:before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            width: 345px;
            height: 3px;
            background-color: #000000;

            border-radius: 5px;
        }

        h2 {
            font-size: 1.8rem;
            margin-top: 35px;
            margin-bottom: 20px;
            color: #000000;
            border-left: 4px solid #000000;
            padding-left: 15px;
            position: relative;
        }

        h2:before {
            content: "\f0f6";
            font-family: "FontAwesome";
            position: absolute;
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: #000000;
        }

        .terms p,
            li {
                font-size: 1.05rem;
                line-height: 1.8;
                /* margin-bottom: 15px; */
                color: #555;
            }



            .divider {
                height: 1px;
                background-color: #e1e1e1;
                margin: 40px 0;
            }

            .contact-info ul {
                padding-left: 0;
                list-style-type: none;
            }

            .contact-info ul li {
                margin-bottom: 10px;
                font-size: 1.1rem;
            }

            .contact-info ul li .fas {
                margin-right: 10px;
                color: #007bff;
            }

            @media (max-width: 768px) {
                .container {
                    padding: 20px;
                    margin: 20px auto;
                }

                h1 {
                    font-size: 2.3rem;
                }

                h2 {
                    font-size: 1.6rem;
                }


            }
    </style>
@endsection
@section('main-content')
<main class="terms">
    <div class="container">
        <nav aria-label="breadcrumb" style="background-color: #f8f9fa; border-radius: 0.25rem; padding: 10px;">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/" class="text-decoration-none text-primary" style="font-weight: 500;">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="font-weight: 600; color: #6c757d;">@lang('terms.title')</li>
            </ol>
        </nav>
    </div>
            <div class="container">
                <h1 class="card-title">@lang('terms.title')</h1>

                <section class="welcome-section">
                    <h2>@lang('terms.welcome_title')</h2>
                    <p>@lang('terms.welcome_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.user_agreement_title')</h2>
                    <p>@lang('terms.user_agreement_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.use_of_website_title')</h2>
                    <p>@lang('terms.use_of_website_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.account_registration_title')</h2>
                    <p>@lang('terms.account_registration_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.content_title')</h2>
                    <p>@lang('terms.content_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.user_submitted_content_title')</h2>
                    <p>@lang('terms.user_submitted_content_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.links_to_third_party_websites_title')</h2>
                    <p>@lang('terms.links_to_third_party_websites_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.termination_title')</h2>
                    <p>@lang('terms.termination_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.limitation_of_liability_title')</h2>
                    <p>@lang('terms.limitation_of_liability_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.indemnification_title')</h2>
                    <p>@lang('terms.indemnification_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.governing_law_title')</h2>
                    <p>@lang('terms.governing_law_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.changes_to_terms_title')</h2>
                    <p>@lang('terms.changes_to_terms_text')</p>
                </section>

                <section class="welcome-section">
                    <h2>@lang('terms.contact_us_title')</h2>
                    <p>@lang('terms.contact_us_text')</p>
                    <ul>
                        <li>@lang('terms.email')</li>
                    </ul>
                </section>
            </div>
</main>
@endsection
