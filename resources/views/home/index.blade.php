@extends('layouts.app')

@section('title', $settings['name'] ?? 'Portfolio')
@section('meta_description', $settings['bio'] ?? '')

@section('content')

    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="hero-content">

            <div class="container">
                <div class="row">

                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="25">
                        <div class="hero-text">

                            <h2>{{ $settings['name'] }}</h2>


                            <p class="lead">I'm a <span class="typed"
                                                        data-typed-items="{{ $settings['tagline'] }}"></span>
                            </p>
                            <p class="description">{{ $settings['bio'] }}</p>
                            <p class="socials p-3">
                                @foreach($socials->where('is_primary', true) as $social)
                                    <a href="{{ $social->url }}">
                                        @if($social->icon)
                                            <i class="{{ $social->icon }}"></i>
                                        @endif
                                        {{ $social->value }}
                                    </a>
                                    |
                                @endforeach

                            </p>
                            <div class="hero-actions">
                                <a href="#portfolio" class="btn btn-primary">View My Work</a>
                                <a href="#contact" class="btn btn-outline">Get In Touch</a>
                            </div>

                            <div class="social-links">
                                @foreach($socials->where('is_primary', false) as $social)
                                    <a href="{{ $social->url }}" target="_blank"
                                       title="{{ $social->label }}">

                                        @if($social->icon)
                                            <i class="{{ $social->icon }}"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="25">
                        <div class="hero-visual">
                            <div class="profile-container">
                                <div class="profile-background"></div>
                                <img src="{{ asset('storage/' . $settings['avatar']) }}" alt="{{ $settings['name'] }}"
                                     class="profile-image">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->


    <!-- Skills Section -->
    <section id="skills" class="skills section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Skills</h2>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="25">

            <div class="row">
                @foreach($categories as $category)

                    <div class="col-lg-6  mb-3">
                        <div class="skills-category" data-aos="fade-up" data-aos-delay="25">
                            <h3> @if($category->icon)
                                    <i class="{{ $category->icon }}"></i>
                                @endif
                                {{ $category->name }}</h3>
                            <div class="skills-animation">
                                @foreach($category->skills as $skill)
                                    <div class="skill-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4>@if($skill->icon)
                                                    <i class="{{ $skill->icon }}"></i>
                                                @endif
                                                {{ $skill->name }}</h4>
                                            <span class="skill-percentage">{{ $skill->proficiency }}%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                 aria-valuenow="{{ $skill->proficiency }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                        @if($skill->comment)
                                            <div class="skill-tooltip">{{ $skill->comment }}
                                            </div>
                                        @endif

                                    </div>
                                @endforeach

                            </div>
                        </div><!-- End Frontend Skills -->
                    </div>
                @endforeach
            </div>

        </div>

    </section><!-- /Skills Section -->

    <!-- Resume Section -->
    <section id="resume" class="resume section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Experience</h2>

        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="25">


            <div class="resume-section" data-aos="fade-up">
                <h3><i class="bi bi-briefcase me-2"></i>Professional Experience</h3>


                @foreach($experiences as $exp)

                    <div class="resume-item">
                        <h4>{{ $exp->title }}</h4>
                        <h5>  {{ $exp->start_date->format('M Y') }}
                            - {{ $exp->is_current ? 'Present' : $exp->end_date?->format('M Y') }}</h5>
                        <p class="company"><i class="bi bi-building"></i>{{ $exp->client->name }}</p>
                        <ul>
                            @foreach($exp->responsibilities as $resp)
                                <li>{{ $resp }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endforeach


            </div>
            <!-- Education Section -->
            <div class="resume-section" data-aos="fade-up" data-aos-delay="25">
                <h3><i class="bi bi-mortarboard me-2"></i>Education</h3>
                @foreach($education as $edu)
                    <div class="resume-item">
                        <h4>{{ $edu->degree }}</h4>
                        <h5>       {{ $edu->start_year }}
                            — {{ $edu->is_current ? 'Present' : $edu->end_year }}</h5>
                        <p class="company"><i class="bi bi-building"></i> {{ $edu->institution }}
                            ,{{ $edu->location }}</p>
                        <p>{{ $edu->grade }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Portfolio</h2>
            <p>Some of my projects</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="25">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <div class="row">
                    <div class="col-lg-3 filter-sidebar">
                        <div class="filters-wrapper" data-aos="fade-right" data-aos-delay="25">
                            <ul class="portfolio-filters isotope-filters">
                                <li data-filter="*" class="filter-active">All Projects</li>
                                <li data-filter=".filter-software">Software</li>
                                <li data-filter=".filter-technical">Technical</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row gy-4 portfolio-container isotope-container" data-aos="fade-up"
                             data-aos-delay="25">


                            @foreach($projects as $project)
                                @php
                                    $isSoftware = $project['source'] === 'repo';
                                    $type       = $isSoftware ? 'software' : 'technical';
                                    $techColors = ['software' => '#7F77DD', 'technical' => '#1D9E75'];
                                    $color      = $techColors[$type];
                                @endphp

                                <div class="col-lg-6 col-md-6 portfolio-item isotope-item filter-{{ $type }}">
                                    <div class="portfolio-wrap">

                                        {{-- Image with graceful fallback --}}
                                        <div class="portfolio-img-wrap">
                                            <img
                                                src="{{ $project['cover'] ?? '' }}"
                                                alt="{{ $project['title'] }}"
                                                class="img-fluid portfolio-cover"
                                                loading="lazy"
                                                onerror="
                        this.style.display='none';
                        this.nextElementSibling.style.display='flex';
                    "
                                            >
                                            <div class="portfolio-placeholder" style="display:none;">
                    <span class="placeholder-initial">
                        {{ strtoupper(substr($project['title'], 0, 1)) }}
                    </span>
                                                <span class="placeholder-label">{{ $project['title'] }}</span>
                                            </div>
                                        </div>

                                        <div class="portfolio-info">
                                            <div class="content">
                                                <span class="category badge-{{ $type }}">{{ $type }}</span>
                                                <h4>{{ $project['title'] }}</h4>
                                                <p class="text-muted fs-13 mb-2 flex-grow-1">
                                                    {{ Str::limit($project['summary'], 100) }}
                                                </p>

                                                @if(!empty($project['tech']))
                                                    <div class="tech-tags">
                                                        @foreach(array_slice($project['tech'], 0, 4) as $tech)
                                                            <span class="tech-tag">{{ $tech }}</span>
                                                        @endforeach
                                                        @if(count($project['tech']) > 4)
                                                            <span class="tech-tag tech-tag--more">
                                    +{{ count($project['tech']) - 4 }} more
                                </span>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="portfolio-links">
                                                    @if(!empty($project['live_url']))
                                                        <a href="{{ $project['live_url'] }}" target="_blank"
                                                           class="btn btn-outline-secondary btn-sm px-3 fs-12">
                                                            Live <i class="ti ti-arrow-up-right fs-11"></i>
                                                        </a>
                                                    @endif
                                                    @if(!empty($project['github_url']))
                                                        <a href="{{ $project['github_url'] }}" target="_blank"
                                                           class="btn btn-outline-secondary btn-sm px-3 fs-12">
                                                            GitHub <i class="ti ti-arrow-up-right fs-11"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('projects.show', $project['slug']) }}"
                                                       title="More Details">
                                                        <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div><!-- End Portfolio Container -->
                    </div>
                </div>

            </div>

        </div>

    </section>
    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p> Have a project in mind or just want to say hi? Fill in the form or reach me at</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-3">
                    <h3>Socials</h3>

                    <div class="social-links d-flex flex-column gap-3">
                        @foreach($socials as $social)
                            <a href="{{ $social->url }}" target="_blank"
                               title="{{ $social->label }}"
                               class="d-inline-flex align-items-center justify-content-center rounded-circle border border-2 p-2"
                               style="width:50px; height:50px;">

                                @if($social->icon)
                                    <i class="{{ $social->icon }}"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-9">

                    <div class="contact-form">
                        <h3>Get In Touch</h3>
                        <p> Have a project in mind or just want to say hi? Fill in the form or reach me at</p>

                        <form method="POST" action="{{ route('contact.send') }}" class="php-email-form">
                            @csrf

                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                           value="{{ old('name') }}" required>
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email"
                                           value="{{ old('email') }}" required>
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                           required="">
                                </div>

                                <div class="col-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                              required=""></textarea>
                                </div>

                                <div class="col-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit" class="btn">Send Message</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
