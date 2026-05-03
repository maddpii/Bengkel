@extends('layout.app')

@section('title', 'Beranda - Bengkel Mobil')

@push('styles')
<style>
    .review-carousel {
        margin: 0 -12px;
    }

    .review-slide {
        height: 100%;
        padding: 12px;
    }

    .review-card {
        background: #fff;
        border-radius: 26px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 28px;
    }

    .review-stars {
        color: #c97b2a;
        font-size: 1.05rem;
        letter-spacing: 0.18rem;
    }

    .review-text {
        color: #45515f;
        line-height: 1.8;
        margin: 16px 0 22px;
        min-height: 116px;
    }

    .review-user {
        align-items: center;
        display: flex;
        gap: 14px;
        margin-top: auto;
    }

    .review-avatar,
    .review-avatar-fallback {
        border-radius: 50%;
        flex: 0 0 54px;
        height: 54px;
        width: 54px;
    }

    .review-avatar {
        object-fit: cover;
    }

    .review-avatar-fallback {
        align-items: center;
        background: linear-gradient(135deg, #ffb36b 0%, #f04d4d 100%);
        color: #fff;
        display: inline-flex;
        font-size: 1rem;
        font-weight: 800;
        justify-content: center;
    }

    .review-name {
        color: #17212b;
        font-weight: 700;
    }

    .review-vehicle {
        color: #7b8794;
        font-size: 0.92rem;
        margin-top: 4px;
    }

    .review-carousel .slick-track {
        display: flex !important;
    }

    .review-carousel .slick-slide {
        height: inherit !important;
    }

    .review-carousel .slick-dots {
        bottom: -42px;
    }

    .review-carousel .slick-dots li button:before {
        color: #f04d4d;
        font-size: 10px;
        opacity: 0.25;
    }

    .review-carousel .slick-dots li.slick-active button:before {
        opacity: 0.85;
    }
</style>
@endpush

@section('content')
    @php
        $heroUrl = $site->hero_image ? asset('storage/'.$site->hero_image) : asset('pato/images/slide1-01.jpg');
        $gallery = $site->gallery_images ?? [];
        $heroPrimaryLink = filled($site->hero_primary_cta_link) ? url($site->hero_primary_cta_link) : url('/bookings/create');
        $heroHighlights = collect([$site->hero_highlight_1, $site->hero_highlight_2, $site->hero_highlight_3])->filter();
    @endphp

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger">{{ session('error') }}</div>
        </div>
    @endif

    <section class="section-slide">
        <div class="wrap-slick1">
            <div class="slick1">
                <div
                    class="item-slick1 item1-slick1"
                    style="background-image: url('{{ $heroUrl }}');"
                >
                    <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                        <span class="caption1-slide1 txt1 t-center animated visible-false m-b-15" data-appear="fadeInDown">
                            {{ $site->hero_badge ?: 'Servis Mobil Tepercaya' }}
                        </span>

                        <h2 class="caption2-slide1 tit1 t-center animated visible-false m-b-20" data-appear="fadeInUp">
                            {{ $site->hero_title ?: 'Bengkel Mobil' }}
                        </h2>

                        <p class="txt5 t-center animated visible-false m-b-30" data-appear="fadeInUp" style="max-width: 760px; color: #fff; line-height: 1.8;">
                            {{ $site->hero_subtitle ?: 'Servis terpercaya untuk kendaraan Anda' }}
                            @if ($site->hero_description)
                                <br>
                                <span style="display:inline-block;margin-top:10px;font-size:1rem;">
                                    {{ $site->hero_description }}
                                </span>
                            @endif
                        </p>

                        <div class="wrap-btn-slide1 animated visible-false d-flex flex-wrap justify-content-center" data-appear="zoomIn">
                            <a href="{{ $heroPrimaryLink }}" class="btn1 flex-c-m size1 txt3 trans-0-4">
                                {{ $site->hero_primary_cta_text ?: 'Booking Sekarang' }}
                            </a>
                        </div>

                        @if ($heroHighlights->isNotEmpty())
                            <div class="animated visible-false m-t-30 d-flex flex-wrap justify-content-center gap-2" data-appear="fadeInUp">
                                @foreach ($heroHighlights as $highlight)
                                    <span style="background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.22); border-radius: 999px; color: #fff; padding: 10px 16px; font-size: .92rem;">
                                        {{ $highlight }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="wrap-slick1-dots"></div>
        </div>
    </section>

    <section class="section-welcome bg1-pattern p-t-120 p-b-105">
        <a id="about"></a>
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-t-45 p-b-30">
                    <div class="wrap-text-welcome t-center">
                        <span class="tit2 t-center">Tentang Bengkel</span>

                        <h3 class="tit3 t-center m-b-35 m-t-5">
                            {{ $site->hero_title ?: 'Bengkel Mobil' }}
                        </h3>

                        <p class="t-center m-b-22 size3 m-l-r-auto">
                            {{ $site->about_text }}
                        </p>

                        <a href="{{ $heroPrimaryLink }}" class="txt4">
                            {{ $site->hero_primary_cta_text ?: 'Booking Sekarang' }}
                            <i class="fa fa-long-arrow-right m-l-10" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 p-b-30">
                    <div class="wrap-pic-w size2 bo-rad-10 hov-img-zoom m-l-r-auto">
                        <img src="{{ $heroUrl }}" alt="Hero Bengkel" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-intro" id="intro">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-intro parallax100 t-center p-t-135 p-b-158" style="background-image: url('{{ $heroUrl }}');">
                        <span class="tit2 p-l-15 p-r-15">
                            Info
                        </span>
                        <h3 class="tit4 t-center p-l-15 p-r-15 p-t-3">Jam & Layanan</h3>
                        <p class="txt3 t-center p-l-15 p-r-15 p-t-20">
                            {{ $site->extra_info }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-gallery p-b-100">
        <a id="gallery"></a>
        <div class="container">
            <div class="row">
                <div class="col-12 t-center m-b-45">
                    <span class="tit2 t-center">Galeri</span>
                    <h3 class="tit3 t-center m-b-35 m-t-5">Dokumentasi Bengkel</h3>
                </div>
            </div>

            @if (count($gallery) > 0)
                <div class="wrap-gallery-footer flex-w">
                    @foreach ($gallery as $img)
                        <a class="item-gallery-footer wrap-pic-w" href="{{ asset('storage/'.$img) }}" data-lightbox="gallery-footer">
                            <img src="{{ asset('storage/'.$img) }}" alt="GALLERY">
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted">
                    Belum ada galeri.
                </div>
            @endif
        </div>
    </section>

    <section class="section-gallery p-b-100">
        <div class="container">
            <div class="row">
                <div class="col-12 t-center m-b-45">
                    <span class="tit2 t-center">Ulasan</span>
                    <h3 class="tit3 t-center m-b-35 m-t-5">Cerita Pelanggan Setelah Servis</h3>
                </div>
            </div>

            @if (($reviews ?? collect())->isNotEmpty())
                <div class="review-carousel">
                    @foreach ($reviews as $review)
                        <div class="review-slide">
                            <div class="review-card">
                                <div class="review-stars">
                                    {{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', 5 - (int) $review->rating) }}
                                </div>
                                <p class="review-text">
                                    "{{ $review->review_text }}"
                                </p>
                                <div class="review-user">
                                    @if ($review->user?->profile_photo_url)
                                        <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}" class="review-avatar">
                                    @else
                                        <span class="review-avatar-fallback">{{ $review->user?->initials ?? 'PL' }}</span>
                                    @endif
                                    <div>
                                        <div class="review-name">{{ $review->user?->name ?? 'Pelanggan' }}</div>
                                        <div class="review-vehicle">
                                            {{ trim(($review->transaction?->booking?->vehicle?->brand ?? '') . ' ' . ($review->transaction?->booking?->customer_vehicle_model ?? '')) ?: 'Servis kendaraan' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted">
                    Belum ada ulasan pelanggan.
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function ($) {
        var $carousel = $('.review-carousel');

        if (!$carousel.length || $carousel.hasClass('slick-initialized')) {
            return;
        }

        var totalSlides = $carousel.children().length;

        $carousel.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            infinite: totalSlides > 3,
            autoplay: totalSlides > 3,
            autoplaySpeed: 5000,
            adaptiveHeight: false,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        infinite: totalSlides > 2,
                        autoplay: totalSlides > 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        infinite: totalSlides > 1,
                        autoplay: totalSlides > 1
                    }
                }
            ]
        });
    })(jQuery);
</script>
@endpush
