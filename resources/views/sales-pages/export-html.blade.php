<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $salesPage->product_name }} - Sales Page</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #111827;
            line-height: 1.6;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .hero {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            color: white;
            padding: 80px 0;
        }
        .eyebrow {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            opacity: 0.85;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: 52px;
            line-height: 1.1;
            margin: 0 0 20px;
        }
        .hero p {
            font-size: 20px;
            margin: 0 0 28px;
            opacity: 0.95;
        }
        .price {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.15);
            margin-bottom: 28px;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            background: white;
            color: #4338ca;
            text-decoration: none;
            padding: 14px 24px;
            border-radius: 10px;
            font-weight: bold;
        }
        .section {
            padding: 56px 0;
        }
        .section h2 {
            font-size: 34px;
            margin: 0 0 18px;
        }
        .section p {
            margin: 0;
            color: #374151;
        }
        .grid {
            display: grid;
            gap: 20px;
        }
        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }
        .grid-3-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 22px;
        }
        .muted {
            color: #6b7280;
        }
        .info-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 22px;
        }
        .info-item {
            margin-bottom: 18px;
        }
        .info-item:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-weight: bold;
            margin-bottom: 4px;
        }
        .testimonial {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 14px;
        }
        .testimonial:last-child {
            margin-bottom: 0;
        }
        .testimonial-name {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .cta-box {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 16px;
            padding: 22px;
        }
        .footer {
            padding: 30px 0 60px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }
            .hero p {
                font-size: 18px;
            }
            .grid-3-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
@php
    $benefits = json_decode($salesPage->benefits ?? '[]', true);
    $features = json_decode($salesPage->features_breakdown ?? '[]', true);
    $socialProofs = json_decode($salesPage->social_proof ?? '[]', true);
    $cta = json_decode($salesPage->cta ?? '{}', true);

    if (! is_array($benefits)) {
        $benefits = [];
    }

    if (! is_array($features)) {
        $features = [];
    }

    if (! is_array($socialProofs)) {
        $socialProofs = [];
    }

    if (! is_array($cta)) {
        $cta = [];
    }

    $formattedPrice = $salesPage->price;

    if (is_numeric(preg_replace('/[^\d]/', '', (string) $salesPage->price))) {
        $formattedPrice = 'Rp' . number_format((int) preg_replace('/[^\d]/', '', (string) $salesPage->price), 0, ',', '.');
    }
@endphp

<section class="hero">
    <div class="container">
        <div class="eyebrow">AI Sales Page Preview</div>
        <h1>{{ $salesPage->headline ?? 'Your headline goes here' }}</h1>
        <p>{{ $salesPage->subheadline ?? 'Your subheadline goes here' }}</p>

        @if ($formattedPrice)
            <div class="price">{{ $formattedPrice }}</div>
        @endif

        <div>
            <a href="#" class="cta-button">
                {{ $cta['button_text'] ?? 'Get Started' }}
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container grid-3-layout">
        <div>
            <div class="section" style="padding-top: 0;">
                <h2>Product Description</h2>
                <p>{{ $salesPage->description ?: 'No description provided.' }}</p>
            </div>

            <div class="section" style="padding-top: 0;">
                <h2>Benefits</h2>
                @if (!empty($benefits))
                    <div class="grid grid-2">
                        @foreach ($benefits as $benefit)
                            <div class="card">
                                <h3 style="margin-top:0; margin-bottom:10px;">{{ $benefit['name'] ?? '-' }}</h3>
                                <p class="muted">{{ $benefit['description'] ?? '-' }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="muted">No benefits available.</p>
                @endif
            </div>

            <div class="section" style="padding-top: 0;">
                <h2>Features</h2>
                @if (!empty($features))
                    <div class="grid grid-2">
                        @foreach ($features as $feature)
                            <div class="card">
                                <h3 style="margin-top:0; margin-bottom:10px;">{{ $feature['title'] ?? '-' }}</h3>
                                <p class="muted">{{ $feature['description'] ?? '-' }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="muted">No features available.</p>
                @endif
            </div>
        </div>

        <div>
            <div class="info-box" style="margin-bottom: 22px;">
                <h3>Quick Info</h3>

                <div class="info-item">
                    <div class="info-label">Product Name</div>
                    <div>{{ $salesPage->product_name ?: '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Target Audience</div>
                    <div>{{ $salesPage->target_audience ?: '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Price</div>
                    <div>{{ $formattedPrice ?: '-' }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Unique Selling Points</div>
                    <div>{{ $salesPage->unique_selling_points ?: '-' }}</div>
                </div>
            </div>

            <div class="info-box" style="margin-bottom: 22px;">
                <h3>Social Proof</h3>

                @if (!empty($socialProofs))
                    @foreach ($socialProofs as $proof)
                        <div class="testimonial">
                            <div class="testimonial-name">{{ $proof['name'] ?? '-' }}</div>
                            <div class="muted">"{{ $proof['quote'] ?? '-' }}"</div>
                        </div>
                    @endforeach
                @else
                    <p class="muted">Social proof placeholder will appear here.</p>
                @endif
            </div>

            <div class="cta-box">
                <h3>Call To Action</h3>
                <p>{{ $cta['button_text'] ?? 'Get Started Now' }}</p>
            </div>
        </div>
    </div>
</section>

<div class="footer">
    Generated by AI Sales Page Generator
</div>
</body>
</html>