<?php

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Seeding articles...\n";

// Get a user to be the author (preferably a lawyer or admin)
$author = User::where('role', 'lawyer')->first() ?? User::first();

if (!$author) {
    echo "No user found to assign as author. Creating a dummy user.\n";
    $author = User::create([
        'name' => 'Legal Editor',
        'email' => 'editor@lawlite.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
}

$articles = [
    [
        'title' => 'Understanding Digital Security Act in Bangladesh',
        'content' => 'The Digital Security Act 2018 is a digital security law in Bangladesh. It was passed by the Parliament of Bangladesh in September 2018. The law is designed to ensure national digital security and enact laws regarding digital crime identification, prevention, suppression, and trial. It replaces the Information and Communication Technology Act, 2006. Key provisions include penalties for illegal access, damage to computer systems, and spreading negative propaganda.',
        'language' => 'en',
    ],
    [
        'title' => 'Land Registration Process in Bangladesh',
        'content' => 'Registering land in Bangladesh involves several steps. First, verify the record of rights (Khatian) from the Land Office. Then, prepare the sale deed. The deed must be presented to the Sub-Registrar\'s office. Registration fees, stamp duty, and other taxes must be paid. Once registered, the new owner must apply for mutation (Namjari) to update the record of rights in their name.',
        'language' => 'en',
    ],
    [
        'title' => 'Divorce Laws for Muslims in Bangladesh',
        'content' => 'Muslim marriage and divorce in Bangladesh are governed by Muslim Personal Law. A husband can divorce his wife by pronouncing Talaq. A wife can divorce if the power of Talaq-e-Tafweez is delegated to her in the Kabinnama. Otherwise, she can seek dissolution of marriage through the Family Court under the Dissolution of Muslim Marriages Act, 1939, on specific grounds like cruelty, desertion, or failure to provide maintenance.',
        'language' => 'en',
    ],
    [
        'title' => 'Labor Rights in Bangladesh: A Guide for Employees',
        'content' => 'The Bangladesh Labor Act, 2006, consolidates laws relating to employment of workers, relations between workers and employers, determination of minimum wages, payment of wages, compensation for injuries to workers during working hours, formation of trade unions, raising and settlement of industrial disputes, health, safety, welfare and working conditions and environment of workers and apprenticeship and matters ancillary thereto.',
        'language' => 'en',
    ],
    [
        'title' => 'How to File a GD (General Diary) in Police Station',
        'content' => 'A General Diary (GD) is a record of a complaint or information lodged at a police station. It is different from an FIR (First Information Report). A GD is usually filed for non-cognizable offenses or for lost items (like ID cards, phones). To file a GD, write an application to the Officer-in-Charge (OC) of the police station detailing the incident. Submit two copies; one will be kept by the police, and the other returned to you with a seal and GD number.',
        'language' => 'en',
    ],
    [
        'title' => 'বাংলাদেশের ডিজিটাল নিরাপত্তা আইন সম্পর্কে জানুন',
        'content' => 'ডিজিটাল নিরাপত্তা আইন ২০১৮ বাংলাদেশের একটি ডিজিটাল নিরাপত্তা আইন। এটি ২০১৮ সালের সেপ্টেম্বরে বাংলাদেশের সংসদে পাস হয়। এই আইনটি জাতীয় ডিজিটাল নিরাপত্তা নিশ্চিত করতে এবং ডিজিটাল অপরাধ শনাক্তকরণ, প্রতিরোধ, দমন ও বিচার সংক্রান্ত আইন প্রণয়নের জন্য তৈরি করা হয়েছে। এটি তথ্য ও যোগাযোগ প্রযুক্তি আইন, ২০০৬-এর স্থলাভিষিক্ত হয়েছে।',
        'language' => 'bn',
    ],
    [
        'title' => 'জমি রেজিস্ট্রেশন প্রক্রিয়া',
        'content' => 'বাংলাদেশে জমি রেজিস্ট্রেশন করার জন্য কয়েকটি ধাপ অনুসরণ করতে হয়। প্রথমে ভূমি অফিস থেকে খতিয়ান যাচাই করতে হয়। এরপর বিক্রয় দলিল প্রস্তুত করতে হয়। দলিলটি সাব-রেজিস্ট্রারের অফিসে উপস্থাপন করতে হয়। রেজিস্ট্রেশন ফি, স্ট্যাম্প ডিউটি এবং অন্যান্য কর পরিশোধ করতে হয়। রেজিস্ট্রেশন সম্পন্ন হলে, নতুন মালিককে নামজারি (মিউটেশন) করার জন্য আবেদন করতে হয়।',
        'language' => 'bn',
    ],
    [
        'title' => 'মুসলিম বিবাহ ও তালাক আইন',
        'content' => 'বাংলাদেশে মুসলিম বিবাহ ও তালাক মুসলিম ব্যক্তিগত আইন দ্বারা পরিচালিত হয়। একজন স্বামী তালাক উচ্চারণের মাধ্যমে তার স্ত্রীকে তালাক দিতে পারেন। কাবিননামায় তালাক-ই-তাফউইজ ক্ষমতা অর্পণ করা থাকলে স্ত্রীও তালাক দিতে পারেন। অন্যথায়, তিনি ১৯৩৯ সালের মুসলিম বিবাহ বিচ্ছেদ আইনের অধীনে পারিবারিক আদালতের মাধ্যমে নির্দিষ্ট কারণে বিবাহ বিচ্ছেদ চাইতে পারেন।',
        'language' => 'bn',
    ],
    [
        'title' => 'ভোক্তা অধিকার সংরক্ষণ আইন',
        'content' => 'ভোক্তা অধিকার সংরক্ষণ আইন, ২০০৯ বাংলাদেশে ভোক্তাদের অধিকার সুরক্ষার জন্য প্রণীত একটি আইন। এই আইনের অধীনে কোনো বিক্রেতা যদি পণ্যের মোড়কে ওজন, পরিমাণ, উপাদান, ব্যবহার বিধি, সর্বোচ্চ খুচরা বিক্রয় মূল্য, উৎপাদনের তারিখ, প্যাকেটজাতকরণের তারিখ এবং মেয়াদ উত্তীর্ণের তারিখ উল্লেখ না করেন, তবে তা অপরাধ হিসেবে গণ্য হবে। ভোক্তারা জাতীয় ভোক্তা অধিকার সংরক্ষণ অধিদপ্তরে অভিযোগ দায়ের করতে পারেন।',
        'language' => 'bn',
    ],
    [
        'title' => 'পারিবারিক সহিংসতা (প্রতিরোধ ও সুরক্ষা) আইন',
        'content' => 'পারিবারিক সহিংসতা (প্রতিরোধ ও সুরক্ষা) আইন, ২০১০ পারিবারিক সহিংসতা রোধে একটি গুরুত্বপূর্ণ আইন। এই আইনটি নারী ও শিশুদের পারিবারিক নির্যাতন থেকে রক্ষা করার জন্য প্রণীত হয়েছে। শারীরিক, মানসিক, যৌন বা অর্থনৈতিক যেকোনো ধরনের নির্যাতন এই আইনের আওতায় পড়ে। ভুক্তভোগীরা আদালতের মাধ্যমে সুরক্ষা আদেশ, বাসস্থান আদেশ এবং ক্ষতিপূরণ আদেশ চাইতে পারেন।',
        'language' => 'bn',
    ]
];

foreach ($articles as $data) {
    Article::create([
        'title' => $data['title'],
        'content' => $data['content'],
        'author_id' => $author->id,
        'language' => $data['language'],
        'published_at' => Carbon::now(),
    ]);
    echo "Created article: {$data['title']} ({$data['language']})\n";
}

echo "Seeding complete.\n";
