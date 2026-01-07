<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lawyer;
use App\Models\Article;
use App\Models\Appointment;
use App\Models\LawyerCase;
use App\Models\LawyerAvailability;
use App\Models\Faq;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $this->createUsers();
        $this->createLawyers();
        $this->createArticles();
        $this->createAppointments();
        $this->createCases();
        $this->createAvailabilities();
        $this->createFaqs();
    }

    private function createUsers()
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@lawlite.com'],
            [
                'name' => 'System Admin',
                'phone' => '01700000000',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'language_preference' => 'en',
            ]
        );

        // Demo Lawyers
        $lawyers = [
            [
                'name' => 'Adv. Karim Ahmed',
                'email' => 'karim@lawlite.com',
                'phone' => '01711111111',
                'language_preference' => 'bn',
            ],
            [
                'name' => 'Adv. Fatima Rahman',
                'email' => 'fatima@lawlite.com',
                'phone' => '01722222222',
                'language_preference' => 'bn',
            ],
            [
                'name' => 'Adv. Mohammad Hasan',
                'email' => 'hasan@lawlite.com',
                'phone' => '01733333333',
                'language_preference' => 'en',
            ],
            [
                'name' => 'Adv. Nasreen Sultana',
                'email' => 'nasreen@lawlite.com',
                'phone' => '01744444444',
                'language_preference' => 'bn',
            ],
            [
                'name' => 'Adv. Rafiq Islam',
                'email' => 'rafiq@lawlite.com',
                'phone' => '01755555555',
                'language_preference' => 'en',
            ],
        ];

        foreach ($lawyers as $lawyer) {
            User::firstOrCreate(
                ['email' => $lawyer['email']],
                array_merge($lawyer, [
                    'password' => Hash::make('password123'),
                    'role' => 'lawyer',
                ])
            );
        }

        // Demo Users (Clients)
        $users = [
            [
                'name' => 'Rahim Uddin',
                'email' => 'rahim@example.com',
                'phone' => '01811111111',
                'language_preference' => 'bn',
            ],
            [
                'name' => 'Salma Begum',
                'email' => 'salma@example.com',
                'phone' => '01822222222',
                'language_preference' => 'bn',
            ],
            [
                'name' => 'Jahangir Alam',
                'email' => 'jahangir@example.com',
                'phone' => '01833333333',
                'language_preference' => 'en',
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat@example.com',
                'phone' => '01844444444',
                'language_preference' => 'bn',
            ],
            [
                'name' => 'Tanvir Hossain',
                'email' => 'tanvir@example.com',
                'phone' => '01855555555',
                'language_preference' => 'en',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                array_merge($user, [
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                ])
            );
        }
    }

    private function createLawyers()
    {
        $lawyerProfiles = [
            [
                'email' => 'karim@lawlite.com',
                'expertise' => 'Family Law, Divorce, Child Custody',
                'bio' => 'With over 15 years of experience in family law, I specialize in divorce proceedings, child custody disputes, and family settlements. I am committed to providing compassionate and effective legal representation.',
                'license_number' => 'BAR-2008-1234',
                'hourly_rate' => 3000,
                'city' => 'Dhaka',
                'latitude' => 23.8103,
                'longitude' => 90.4125,
                'education' => ['LLB - University of Dhaka', 'LLM - University of Dhaka'],
                'experience' => '15 years',
                'languages' => ['Bengali', 'English'],
            ],
            [
                'email' => 'fatima@lawlite.com',
                'expertise' => 'Corporate Law, Business Registration, Contracts',
                'bio' => 'I help businesses navigate complex legal requirements. From company registration to contract negotiations, I provide comprehensive corporate legal services to startups and established businesses.',
                'license_number' => 'BAR-2012-5678',
                'hourly_rate' => 4000,
                'city' => 'Dhaka',
                'latitude' => 23.7465,
                'longitude' => 90.3766,
                'education' => ['LLB - North South University', 'MBA - IBA, Dhaka University'],
                'experience' => '12 years',
                'languages' => ['Bengali', 'English', 'Hindi'],
            ],
            [
                'email' => 'hasan@lawlite.com',
                'expertise' => 'Criminal Law, Criminal Defense, Bail',
                'bio' => 'Experienced criminal defense attorney with a strong track record. I defend clients facing serious criminal charges and work tirelessly to protect their rights and freedom.',
                'license_number' => 'BAR-2010-9012',
                'hourly_rate' => 5000,
                'city' => 'Chittagong',
                'latitude' => 22.3569,
                'longitude' => 91.7832,
                'education' => ['LLB - Chittagong University', 'LLM - UK'],
                'experience' => '14 years',
                'languages' => ['Bengali', 'English'],
            ],
            [
                'email' => 'nasreen@lawlite.com',
                'expertise' => 'Property Law, Land Disputes, Real Estate',
                'bio' => 'Specializing in property law and land disputes in Bangladesh. I help clients with property registration, mutation, land disputes, and real estate transactions.',
                'license_number' => 'BAR-2015-3456',
                'hourly_rate' => 2500,
                'city' => 'Sylhet',
                'latitude' => 24.8949,
                'longitude' => 91.8687,
                'education' => ['LLB - Shahjalal University'],
                'experience' => '9 years',
                'languages' => ['Bengali', 'English', 'Sylheti'],
            ],
            [
                'email' => 'rafiq@lawlite.com',
                'expertise' => 'Immigration Law, Visa, Work Permits',
                'bio' => 'Immigration law specialist helping clients with visa applications, work permits, and immigration matters. I have helped hundreds of clients successfully navigate immigration processes.',
                'license_number' => 'BAR-2011-7890',
                'hourly_rate' => 3500,
                'city' => 'Dhaka',
                'latitude' => 23.7937,
                'longitude' => 90.4066,
                'education' => ['LLB - University of Dhaka', 'Certificate in Immigration Law - USA'],
                'experience' => '13 years',
                'languages' => ['Bengali', 'English', 'Arabic'],
            ],
        ];

        foreach ($lawyerProfiles as $profile) {
            $user = User::where('email', $profile['email'])->first();
            if ($user) {
                Lawyer::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'expertise' => $profile['expertise'],
                        'bio' => $profile['bio'],
                        'license_number' => $profile['license_number'],
                        'hourly_rate' => $profile['hourly_rate'],
                        'verification_status' => 'verified',
                        'documents' => json_encode(['nid' => 'verified', 'bar_certificate' => 'verified']),
                        'latitude' => $profile['latitude'],
                        'longitude' => $profile['longitude'],
                        'city' => $profile['city'],
                        'education' => $profile['education'],
                        'experience' => $profile['experience'],
                        'languages' => $profile['languages'],
                    ]
                );
            }
        }
    }

    private function createArticles()
    {
        $admin = User::where('role', 'admin')->first();

        $articles = [
            [
                'title' => 'Understanding Family Law in Bangladesh',
                'content' => '<h2>Introduction to Family Law</h2>
<p>Family law in Bangladesh governs matters related to marriage, divorce, child custody, and inheritance. The legal framework is primarily based on personal laws that vary according to religion.</p>
<h3>Key Areas of Family Law</h3>
<ul>
<li><strong>Marriage:</strong> Legal requirements and registration process</li>
<li><strong>Divorce:</strong> Grounds and procedures for dissolution of marriage</li>
<li><strong>Child Custody:</strong> Rights and responsibilities of parents</li>
<li><strong>Maintenance:</strong> Financial support obligations</li>
</ul>
<p>Understanding these laws is crucial for anyone going through family legal matters. Consulting with an experienced family lawyer can help navigate these complex issues.</p>',
                'language' => 'en',
            ],
            [
                'title' => 'বাংলাদেশে জমি বিরোধ নিষ্পত্তি',
                'content' => '<h2>জমি সংক্রান্ত আইনি বিষয়</h2>
<p>বাংলাদেশে জমি বিরোধ একটি সাধারণ সমস্যা। সঠিক আইনি পদক্ষেপ গ্রহণ করলে এই বিরোধ নিষ্পত্তি করা সম্ভব।</p>
<h3>জমি বিরোধের প্রধান কারণ</h3>
<ul>
<li>সীমানা বিরোধ</li>
<li>উত্তরাধিকার সংক্রান্ত জটিলতা</li>
<li>জাল দলিল</li>
<li>অবৈধ দখল</li>
</ul>
<p>একজন অভিজ্ঞ আইনজীবীর পরামর্শ নিন এবং আপনার অধিকার রক্ষা করুন।</p>',
                'language' => 'bn',
            ],
            [
                'title' => 'Starting a Business in Bangladesh: Legal Requirements',
                'content' => '<h2>Business Registration Guide</h2>
<p>Starting a business in Bangladesh requires compliance with various legal requirements. This guide covers the essential steps.</p>
<h3>Types of Business Entities</h3>
<ul>
<li><strong>Sole Proprietorship:</strong> Simplest form, owned by one person</li>
<li><strong>Partnership:</strong> Owned by two or more persons</li>
<li><strong>Private Limited Company:</strong> Separate legal entity with limited liability</li>
<li><strong>Public Limited Company:</strong> Can offer shares to public</li>
</ul>
<h3>Registration Process</h3>
<p>All businesses must register with RJSC (Registrar of Joint Stock Companies and Firms) and obtain necessary trade licenses from local authorities.</p>',
                'language' => 'en',
            ],
            [
                'title' => 'Your Rights During Police Arrest',
                'content' => '<h2>Know Your Constitutional Rights</h2>
<p>Every citizen of Bangladesh has certain fundamental rights protected by the Constitution, even during arrest.</p>
<h3>Key Rights During Arrest</h3>
<ul>
<li>Right to know the grounds of arrest</li>
<li>Right to consult and be defended by a lawyer</li>
<li>Right to be produced before a magistrate within 24 hours</li>
<li>Right against self-incrimination</li>
<li>Right to apply for bail</li>
</ul>
<p>If you or someone you know is arrested, immediately contact a criminal defense lawyer.</p>',
                'language' => 'en',
            ],
            [
                'title' => 'বিবাহ নিবন্ধন: কেন গুরুত্বপূর্ণ',
                'content' => '<h2>বিবাহ নিবন্ধনের প্রয়োজনীয়তা</h2>
<p>বাংলাদেশে বিবাহ নিবন্ধন আইনত বাধ্যতামূলক। এটি স্বামী-স্ত্রী উভয়ের অধিকার সুরক্ষা করে।</p>
<h3>নিবন্ধনের সুবিধা</h3>
<ul>
<li>আইনি স্বীকৃতি</li>
<li>সম্পত্তির অধিকার</li>
<li>সন্তানের বৈধতা</li>
<li>বিবাহ বিচ্ছেদে অধিকার সুরক্ষা</li>
</ul>
<p>বিবাহ নিবন্ধন না করলে আইনি জটিলতায় পড়তে পারেন।</p>',
                'language' => 'bn',
            ],
        ];

        foreach ($articles as $article) {
            Article::firstOrCreate(
                ['title' => $article['title']],
                array_merge($article, [
                    'author_id' => $admin ? $admin->id : null,
                    'published_at' => now()->subDays(rand(1, 30)),
                    'status' => 'published',
                ])
            );
        }
    }

    private function createAppointments()
    {
        $lawyers = Lawyer::with('user')->get();
        $clients = User::where('role', 'user')->get();

        if ($lawyers->isEmpty() || $clients->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'pending', 'confirmed', 'completed', 'cancelled'];
        $types = ['online', 'in-person'];

        foreach ($lawyers as $lawyer) {
            foreach ($clients->take(3) as $index => $client) {
                $status = $statuses[$index % count($statuses)];
                $date = now()->addDays(rand(-10, 30));

                Appointment::firstOrCreate(
                    [
                        'lawyer_id' => $lawyer->id,
                        'user_id' => $client->id,
                        'date' => $date->toDateString(),
                    ],
                    [
                        'time' => sprintf('%02d:00:00', rand(9, 17)),
                        'status' => $status,
                        'type' => $types[array_rand($types)],
                        'notes' => 'Demo appointment for showcase',
                        'payment_status' => $status === 'completed' ? 'paid' : 'pending',
                        'amount' => $lawyer->hourly_rate ?? 2000,
                    ]
                );
            }
        }
    }

    private function createCases()
    {
        $lawyers = Lawyer::all();
        $clients = User::where('role', 'user')->get();

        if ($lawyers->isEmpty() || $clients->isEmpty()) {
            return;
        }

        $cases = [
            [
                'title' => 'Property Dispute - Land Mutation',
                'description' => 'Client seeking legal assistance for land mutation and ownership dispute with neighboring property.',
                'status' => 'in_progress',
                'case_number' => 'CASE-2025-001',
                'court_location' => 'Dhaka District Court',
            ],
            [
                'title' => 'Divorce Proceedings',
                'description' => 'Mutual divorce case with child custody and alimony settlement discussions.',
                'status' => 'in_progress',
                'case_number' => 'CASE-2025-002',
                'court_location' => 'Family Court, Dhaka',
            ],
            [
                'title' => 'Criminal Defense - Theft Allegation',
                'description' => 'Client falsely accused of theft, seeking bail and defense representation.',
                'status' => 'pending',
                'case_number' => 'CASE-2025-003',
                'court_location' => 'Chief Metropolitan Magistrate Court',
            ],
            [
                'title' => 'Company Registration',
                'description' => 'Assistance with private limited company registration and documentation.',
                'status' => 'completed',
                'case_number' => 'CASE-2024-045',
                'court_location' => 'RJSC Office',
                'outcome' => 'Successfully registered',
            ],
            [
                'title' => 'Work Visa Application',
                'description' => 'Help with work visa application for overseas employment.',
                'status' => 'completed',
                'case_number' => 'CASE-2024-089',
                'court_location' => 'Immigration Office',
                'outcome' => 'Visa approved',
            ],
        ];

        foreach ($cases as $index => $caseData) {
            $lawyer = $lawyers[$index % $lawyers->count()];
            $client = $clients[$index % $clients->count()];

            LawyerCase::firstOrCreate(
                ['case_number' => $caseData['case_number']],
                array_merge($caseData, [
                    'lawyer_id' => $lawyer->id,
                    'user_id' => $client->id,
                    'client_name' => $client->name,
                    'client_email' => $client->email,
                    'client_phone' => $client->phone,
                    'hearing_date' => now()->addDays(rand(7, 60)),
                    'hearing_time' => sprintf('%02d:00:00', rand(10, 15)),
                ])
            );
        }
    }

    private function createAvailabilities()
    {
        $lawyers = Lawyer::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        foreach ($lawyers as $lawyer) {
            // Create availability for 4-5 random days
            $selectedDays = array_rand(array_flip($days), rand(4, 5));
            if (!is_array($selectedDays)) {
                $selectedDays = [$selectedDays];
            }

            foreach ($selectedDays as $day) {
                LawyerAvailability::firstOrCreate(
                    [
                        'lawyer_id' => $lawyer->id,
                        'day_of_week' => $day,
                    ],
                    [
                        'start_time' => '09:00:00',
                        'end_time' => '17:00:00',
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    private function createFaqs()
    {
        $faqs = [
            [
                'question' => 'How do I find a lawyer on LawLite?',
                'answer' => 'You can search for lawyers by expertise, location, or name using our search feature. Browse lawyer profiles to see their experience, ratings, and availability before booking a consultation.',
                'language' => 'en',
            ],
            [
                'question' => 'কিভাবে আমি একজন আইনজীবীর সাথে অ্যাপয়েন্টমেন্ট বুক করব?',
                'answer' => 'আইনজীবীর প্রোফাইলে যান এবং "অ্যাপয়েন্টমেন্ট বুক করুন" বাটনে ক্লিক করুন। আপনার সুবিধাজনক তারিখ ও সময় নির্বাচন করুন এবং পেমেন্ট সম্পন্ন করুন।',
                'language' => 'bn',
            ],
            [
                'question' => 'What payment methods are accepted?',
                'answer' => 'We accept bKash, Nagad, Rocket, and card payments through SSLCommerz. All transactions are secure and encrypted.',
                'language' => 'en',
            ],
            [
                'question' => 'Can I have an online consultation?',
                'answer' => 'Yes! Many lawyers on LawLite offer online consultations via video call. When booking, select "Online" as your appointment type.',
                'language' => 'en',
            ],
            [
                'question' => 'আইনজীবীর ফি কত?',
                'answer' => 'প্রতিটি আইনজীবীর ফি তাদের প্রোফাইলে উল্লেখ আছে। ফি আইনজীবীর অভিজ্ঞতা এবং বিশেষজ্ঞতার উপর নির্ভর করে পরিবর্তিত হয়।',
                'language' => 'bn',
            ],
            [
                'question' => 'How do I contact customer support?',
                'answer' => 'You can reach our support team through the "Contact Us" page, or email us at support@lawlite.com. We typically respond within 24 hours.',
                'language' => 'en',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
