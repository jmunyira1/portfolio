<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $webCat = SkillCategory::where('name', 'Web Development')->first();
        $stMarks = Client::where('name', 'St. Marks')->first();
        $php = Skill::where('name', 'PHP')->first();
        $laravel = Skill::where('name', 'Laravel')->first();
        $js = Skill::where('name', 'JavaScript')->first();
        $bs = Skill::where('name', 'Bootstrap')->first();
        $react = Skill::where('name', 'React.js')->first();
        $python = Skill::where('name', 'Python')->first();

        $projects = [
            [
                'data' => [
                    'skill_category_id' => $webCat?->id,
                    'client_id' => null,
                    'title' => 'Academic Project & Milestone Tracker',
                    'slug' => 'academic-project-milestone-tracker',
                    'summary' => 'A project management platform to coordinate and track academic research projects between students and supervisors.',
                    'description' => 'A robust project management platform designed to coordinate and track the progress of academic or professional research projects. It facilitates the workflow between students and supervisors by breaking projects down into measurable milestones and sub-criteria, ensuring transparent progress monitoring and document version control.',
                    'key_features' => [
                        'Tiered Milestone Framework — define project phases and detailed grading criteria with assigned maximum marks',
                        'Project Registration & Approval Workflow — formal process for students to register titles for supervisor review',
                        'Visual Progress Dashboard — real-time progress bars showing completion percentages',
                        'Document Versioning System — automated version tracking for student submissions',
                        'Stakeholder Management — dedicated modules for student and supervisor profiles',
                        'Interactive Evaluation Tools — Bootstrap accordions and modals for criteria management',
                    ],
                    'url' => 'https://project-tracker.munyira.co.ke',
                    'github_url' => null,
                    'is_software' => true,
                    'featured' => true,
                    'published' => true,
                    'sort_order' => 0,
                ],
                'skills' => [$php, $laravel, $bs, $js],
            ],
            [
                'data' => [
                    'skill_category_id' => $webCat?->id,
                    'client_id' => null,
                    'title' => 'QR-Based School Book Management System',
                    'slug' => 'qr-school-book-management',
                    'summary' => 'A digital book tracking system for schools using QR codes to manage textbook circulation and student borrowing.',
                    'description' => 'Specialized inventory and circulation tool developed to streamline the tracking of textbooks and library resources within a secondary school. Replaces manual registers with a digital workflow using unique QR code labels.',
                    'key_features' => [
                        'QR Code Label Generation — automatically generate unique labels for books based on ISBN and serial numbers',
                        'Student Possession Tracking — monitor real-time status of books and borrowing history',
                        'Simplified Issuing & Returns — streamlined module that updates the database on book return',
                        'Form-Based Categorization — organize books by Form and type',
                        'Scanning & Identification Interface — displays book details upon reading a QR label',
                        'Printable Reports — generate and print student-specific book lists',
                    ],
                    'url' => 'https://books.munyira.co.ke/',
                    'github_url' => null,
                    'is_software' => true,
                    'featured' => true,
                    'published' => true,
                    'sort_order' => 1,
                ],
                'skills' => [$php, $bs, $js],
            ],
            [
                'data' => [
                    'skill_category_id' => $webCat?->id,
                    'client_id' => null,
                    'title' => 'Attachment Activity & Skills Log',
                    'slug' => 'attachment-activity-skills-log',
                    'summary' => 'A logging system for industrial attachment students to document daily activities and skills acquired.',
                    'description' => 'A logging system developed for attachees to document their daily activities, departmental rotations, and technical skills acquired during an industrial attachment.',
                    'key_features' => [
                        'Daily Attachment Logging — streamlined entry of work dates, departments, and task descriptions',
                        'Skill Acquisition Tracking — dedicated fields to record technical or soft skills gained',
                        'Log Management & Editing — full CRUD system using interactive modals',
                        'Organized Progress View — chronological table of all entries sorted by work date',
                        'Input Validation & Feedback — server-side sanitization and real-time alerts',
                    ],
                    'url' => 'https://attachment.munyira.co.ke/',
                    'github_url' => null,
                    'is_software' => true,
                    'featured' => false,
                    'published' => true,
                    'sort_order' => 2,
                ],
                'skills' => [$php, $bs, $js],
            ],
            [
                'data' => [
                    'skill_category_id' => $webCat?->id,
                    'client_id' => null,
                    'title' => 'Project Financial Lifecycle Manager',
                    'slug' => 'project-financial-lifecycle-manager',
                    'summary' => 'An internal management tool to track the financial lifecycle and documentation of service-based jobs.',
                    'description' => 'Custom-built internal management tool designed to track the financial lifecycle and documentation of service-based jobs. Centralizes project oversight by monitoring real-time profitability and automating essential business paperwork.',
                    'key_features' => [
                        'Document Generation — produces Quotations, Invoices, and Receipts via modal-based iframe system',
                        'Profitability Dashboard — automatically calculates revenue, costs, and net expected profit',
                        'Payment & Balance Tracking — manages multi-channel payments (Cash, M-Pesa, Cheque)',
                        'Deliverables Management — system for managing line-item services, quantities, and pricing',
                        'Internal Cost Logging — records overheads and project-specific expenses',
                    ],
                    'url' => 'https://project-cost-billing-manager.munyira.co.ke/',
                    'github_url' => null,
                    'is_software' => true,
                    'featured' => false,
                    'published' => true,
                    'sort_order' => 3,
                ],
                'skills' => [$php, $bs, $js],
            ],
            [
                'data' => [
                    'skill_category_id' => $webCat?->id,
                    'client_id' => $stMarks?->id,
                    'title' => 'CCTV Installation',
                    'slug' => 'cctv-installation',
                    'summary' => 'Installed a network CCTV system for St. Marks.',
                    'description' => 'Planned, installed and configured a network CCTV surveillance system.',
                    'key_features' => [],
                    'url' => null,
                    'github_url' => null,
                    'is_software' => false,
                    'featured' => false,
                    'published' => true,
                    'sort_order' => 4,
                ],
                'skills' => [],
            ],
        ];

        foreach ($projects as $item) {
            $project = Project::updateOrCreate(
                ['slug' => $item['data']['slug']],
                $item['data']
            );

            // Attach skills
            $skillIds = collect($item['skills'])
                ->filter()
                ->pluck('id')
                ->toArray();

            $project->skills()->sync($skillIds);
        }

    }
}
