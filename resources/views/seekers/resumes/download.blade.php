<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->title ?? 'Resume' }} - {{ $resume->user->name }}</title>
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 2cm 1cm;
            margin-bottom: 1cm;
        }
        .header-content {
            display: flex;
            align-items: center;
            gap: 1.5cm;
        }
        .avatar {
            width: 2.5cm;
            height: 2.5cm;
            border-radius: 50%;
            border: 0.3cm solid white;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1cm;
            font-weight: bold;
        }
        .user-info h1 {
            font-size: 0.8cm;
            margin: 0 0 0.2cm 0;
            font-weight: bold;
        }
        .user-info .title {
            font-size: 0.5cm;
            opacity: 0.9;
            margin-bottom: 0.3cm;
        }
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5cm;
            font-size: 0.35cm;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.2cm;
        }
        .section {
            margin-bottom: 0.8cm;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 0.6cm;
            font-weight: bold;
            color: #2563eb;
            border-bottom: 0.1cm solid #2563eb;
            padding-bottom: 0.2cm;
            margin-bottom: 0.4cm;
        }
        .summary {
            font-size: 0.4cm;
            text-align: justify;
        }
        .skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.2cm;
        }
        .skill-tag {
            background: #dbeafe;
            color: #1e40af;
            padding: 0.1cm 0.3cm;
            border-radius: 0.2cm;
            font-size: 0.35cm;
            font-weight: 500;
        }
        .experience-item, .education-item {
            margin-bottom: 0.4cm;
            padding-left: 0.4cm;
            border-left: 0.1cm solid #2563eb;
        }
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.2cm;
        }
        .item-title {
            font-size: 0.45cm;
            font-weight: bold;
            color: #1f2937;
        }
        .item-subtitle {
            font-size: 0.4cm;
            color: #2563eb;
            font-weight: 500;
        }
        .item-date {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.1cm 0.3cm;
            border-radius: 0.2cm;
            font-size: 0.35cm;
            font-weight: 500;
        }
        .item-description {
            font-size: 0.38cm;
            color: #4b5563;
        }
        .footer {
            text-align: center;
            margin-top: 1cm;
            padding-top: 0.5cm;
            border-top: 0.05cm solid #e5e7eb;
            font-size: 0.35cm;
            color: #6b7280;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="header-content">
            @if($resume->user->profile_photo_path && file_exists(public_path('storage/' . $resume->user->profile_photo_path)))
                <img src="{{ public_path('storage/' . $resume->user->profile_photo_path) }}"
                     alt="{{ $resume->user->name }}"
                     class="avatar">
            @else
                <div class="avatar">
                    {{ strtoupper(substr($resume->user->name, 0, 1)) }}
                </div>
            @endif
            <div class="user-info">
                <h1>{{ $resume->user->name }}</h1>
                <div class="title">{{ $resume->title ?? 'Professional' }}</div>
                <div class="contact-info">
                    @if($resume->user->email)
                        <div class="contact-item">
                            <span>📧</span>
                            <span>{{ $resume->user->email }}</span>
                        </div>
                    @endif
                    @if($resume->user->phone)
                        <div class="contact-item">
                            <span>📞</span>
                            <span>{{ $resume->user->phone }}</span>
                        </div>
                    @endif
                    @if($resume->user->address)
                        <div class="contact-item">
                            <span>📍</span>
                            <span>{{ $resume->user->address }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Summary -->
    @if($resume->summary)
    <div class="section">
        <div class="section-title">Professional Summary</div>
        <div class="summary">{{ $resume->summary }}</div>
    </div>
    @endif

    <!-- Skills Section -->
    @if($resume->skills && count($resume->skills) > 0)
    <div class="section">
        <div class="section-title">Skills & Expertise</div>
        <div class="skills">
            @foreach($resume->skills as $skill)
                <span class="skill-tag">{{ $skill }}</span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Work Experience -->
    @if($resume->experience && count($resume->experience) > 0)
    <div class="section">
        <div class="section-title">Work Experience</div>
        @foreach($resume->experience as $experience)
            <div class="experience-item">
                <div class="item-header">
                    <div>
                        <div class="item-title">{{ $experience['position'] ?? 'Position' }}</div>
                        <div class="item-subtitle">{{ $experience['company'] ?? 'Company' }}</div>
                    </div>
                    <span class="item-date">
                        {{ $experience['start_date'] ?? '' }} - {{ $experience['end_date'] ?? 'Present' }}
                    </span>
                </div>
                @if(isset($experience['description']))
                    <div class="item-description">{{ $experience['description'] }}</div>
                @endif
            </div>
        @endforeach
    </div>
    @endif

    <!-- Education -->
    @if($resume->education && count($resume->education) > 0)
    <div class="section">
        <div class="section-title">Education</div>
        @foreach($resume->education as $education)
            <div class="education-item">
                <div class="item-header">
                    <div>
                        <div class="item-title">{{ $education['degree'] ?? 'Degree' }}</div>
                        <div class="item-subtitle">{{ $education['institution'] ?? 'Institution' }}</div>
                    </div>
                    <span class="item-date">{{ $education['year'] ?? '' }}</span>
                </div>
                @if(isset($education['description']))
                    <div class="item-description">{{ $education['description'] }}</div>
                @endif
            </div>
        @endforeach
    </div>
    @endif

    <!-- Certifications -->
    @if($resume->certifications && count($resume->certifications) > 0)
    <div class="section">
        <div class="section-title">Certifications</div>
        @foreach($resume->certifications as $certification)
            <div class="experience-item">
                <div class="item-header">
                    <div class="item-title">{{ $certification['name'] ?? 'Certification' }}</div>
                    <span class="item-date">{{ $certification['year'] ?? '' }}</span>
                </div>
                @if(isset($certification['issuer']))
                    <div class="item-subtitle">Issued by: {{ $certification['issuer'] }}</div>
                @endif
            </div>
        @endforeach
    </div>
    @endif

    <!-- Languages -->
    @if($resume->languages && count($resume->languages) > 0)
    <div class="section">
        <div class="section-title">Languages</div>
        @foreach($resume->languages as $language)
            <div class="experience-item">
                <div class="item-header">
                    <div class="item-title">{{ $language['name'] ?? 'Language' }}</div>
                    <span class="item-date" style="text-transform: capitalize;">
                        {{ $language['proficiency'] ?? '' }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('F j, Y') }} • {{ config('app.name', 'JobPortal') }}
    </div>
</body>
</html>
