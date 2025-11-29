<?php

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Clearing existing articles...\n";
Article::truncate();

echo "Seeding detailed articles...\n";

// Get a user to be the author
$author = User::where('role', 'lawyer')->first() ?? User::first();

if (!$author) {
    $author = User::create([
        'name' => 'Legal Editor',
        'email' => 'editor@lawlite.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);
}

$articles = [
    [
        'title' => 'The Digital Security Act 2018: A Comprehensive Analysis of Cyber Laws in Bangladesh',
        'content' => "The Digital Security Act (DSA) 2018 is one of the most significant and discussed pieces of legislation in Bangladesh's recent history. Enacted to ensure national digital security and prevent cybercrimes, the law has far-reaching implications for freedom of speech, press freedom, and online conduct.

**Background and Purpose**
The DSA replaced the controversial Section 57 of the Information and Communication Technology (ICT) Act, 2006. The primary objective was to protect the state's digital infrastructure and citizens from cyber harassment, fraud, and defamation. However, the broad definitions of offenses have led to concerns about potential misuse.

**Key Provisions and Offenses**
1.  **Illegal Access and Hacking (Section 17):** Unauthorized entry into critical information infrastructures is a non-bailable offense, punishable by up to 14 years in prison or a fine of 1 crore BDT, or both.
2.  **Propaganda Against the Liberation War (Section 21):** Spreading propaganda against the Liberation War, the Father of the Nation, the National Anthem, or the National Flag is punishable by life imprisonment or a fine of 3 crore BDT.
3.  **Cyber Bullying and Harassment:** The act criminalizes offensive, false, or fear-inducing information sent via digital media.
4.  **Defamation (Section 29):** Publishing defamatory information online is punishable by up to 3 years in prison. This section links back to the Penal Code's definition of defamation but applies it specifically to the digital realm.
5.  **Hurting Religious Sentiments (Section 28):** Publishing content that hurts religious values or sentiments is a cognizable and non-bailable offense.

**Controversies and Criticisms**
Human rights organizations and journalist unions have criticized the act for its vague terminology. Terms like 'hurting the image of the state' or 'aggressive and frightening' are subjective and can be interpreted loosely to target dissent. The non-bailable nature of many sections means accused individuals can be detained for long periods without trial.

**Conclusion**
While the necessity of a law to combat cybercrime in an increasingly digital Bangladesh is undeniable, the balance between security and civil liberties remains a contentious issue. Citizens must be aware of their digital footprint, as ignorance of the law is not a valid defense.",
        'language' => 'en',
    ],
    [
        'title' => 'Land Registration and Property Transfer Laws in Bangladesh: A Step-by-Step Guide',
        'content' => "Land disputes account for a vast majority of criminal and civil cases in Bangladesh. Understanding the proper procedure for land registration and property transfer is crucial for safeguarding one's assets and avoiding lengthy litigation.

**The Registration Act, 1908**
Under Section 17 of the Registration Act, 1908, registration is mandatory for all documents involving the sale, gift, or exchange of immovable property valued at 100 BDT or more (which effectively means all property).

**Steps for Land Registration**
1.  **Verification of Title:** Before purchasing, the buyer must verify the 'Khatian' (Record of Rights), 'Porcha', and the chain of ownership. It is essential to check the latest mutation (Namjari) records to ensure the seller is the current legal owner.
2.  **Preparation of Deed (Dalil):** The sale deed must be drafted by a licensed deed writer or a lawyer. It should contain accurate details of the property, including the schedule (Mouza, JL No., Khatian No., Plot No.).
3.  **Payment of Fees and Taxes:**
    *   **Stamp Duty:** Typically 3% of the deed value.
    *   **Registration Fee:** Generally 1% of the deed value.
    *   **Local Government Tax:** Usually 2-3%.
    *   **VAT and Gain Tax:** Applicable depending on the location and nature of the property.
4.  **Execution at Sub-Registrar's Office:** Both the buyer and seller must be present at the local Sub-Registrar's office. The seller must sign the deed and provide fingerprints in the presence of witnesses.
5.  **Mutation (Namjari):** Registration alone is not enough. After obtaining the registered deed, the new owner must apply to the Assistant Commissioner (Land) for mutation. This process updates the government's Record of Rights (RoR) to reflect the new ownership.
6.  **Payment of Land Development Tax (Khajna):** The new owner must pay the annual land tax in their name to establish possession and ownership.

**Common Pitfalls**
*   Buying land based on a Power of Attorney without verifying the principal owner.
*   Ignoring the 'Baya' deeds (previous chain of documents).
*   Failing to complete the mutation process immediately after registration.

**Legal Remedies**
If a seller refuses to register the deed after receiving payment, the buyer can file a suit for Specific Performance of Contract under the Specific Relief Act, 1877.",
        'language' => 'en',
    ],
    [
        'title' => 'Labor Rights in Bangladesh: Understanding the Bangladesh Labor Act 2006',
        'content' => "The Bangladesh Labor Act, 2006 (amended in 2013 and 2018) is the primary legislation governing the relationship between employers and employees. It covers conditions of service, health, safety, welfare, working hours, and leave.

**Conditions of Service**
*   **Appointment Letter:** Every worker must be provided with an appointment letter and an ID card at the time of employment.
*   **Service Book:** A service book must be maintained for every worker, recording their service history.

**Working Hours and Overtime**
*   **Standard Hours:** The standard working time is 8 hours per day and 48 hours per week.
*   **Overtime:** Any work beyond 8 hours is considered overtime and must be paid at twice the ordinary rate of basic wages.
*   **Weekly Holiday:** Every worker is entitled to at least one full day of rest per week.

**Leave Entitlements**
1.  **Casual Leave:** 10 days per year with full wages.
2.  **Sick Leave:** 14 days per year with full wages (requires a medical certificate).
3.  **Annual Leave:** One day for every 18 days of work (in shops/commercial establishments) or every 22 days (in factories).
4.  **Festival Leave:** 11 days per year with full wages.
5.  **Maternity Leave:** Female workers are entitled to 16 weeks of maternity leave (8 weeks before and 8 weeks after delivery).

**Termination and Benefits**
*   **Termination by Notice:** A permanent worker must be given 120 days' notice (or pay in lieu) if terminated by the employer. A worker can resign with 60 days' notice.
*   **Gratuity:** A worker who has completed at least one year of continuous service is entitled to gratuity (compensation) at the rate of 30 days' wages for every completed year of service.
*   **Provident Fund:** While not mandatory for all, many establishments provide a provident fund where both employer and employee contribute.

**Health and Safety**
The Act mandates strict safety measures, including fire safety, cleanliness, ventilation, and the provision of first-aid appliances. Factories with 50 or more workers must have a safety committee.",
        'language' => 'en',
    ],
    [
        'title' => 'Family Law in Bangladesh: Marriage, Divorce, and Inheritance Rights',
        'content' => "Family law in Bangladesh is primarily personal law, meaning it depends on the religion of the individuals involved. The majority of the population follows Muslim Personal Law, while Hindus, Christians, and Buddhists follow their respective religious laws.

**Muslim Marriage and Divorce**
*   **Marriage (Nikah):** Marriage is a civil contract. Essential elements include proposal (Ijab), acceptance (Qubul), dower (Mahr), and witnesses. Registration of marriage is mandatory under the Muslim Marriages and Divorces (Registration) Act, 1974.
*   **Divorce (Talaq):** A husband can divorce his wife unilaterally. A wife can divorce if the power of 'Talaq-e-Tafweez' is delegated to her in the Kabinnama (marriage contract).
*   **Judicial Divorce:** Under the Dissolution of Muslim Marriages Act, 1939, a wife can seek divorce in court on grounds such as cruelty, desertion for two years, failure to provide maintenance, or the husband's imprisonment.

**Hindu Personal Law**
*   **Marriage:** Traditionally, Hindu marriage is a sacrament and indissoluble. However, recent legal precedents and social changes are slowly influencing this. Registration is optional but recommended.
*   **Divorce:** Traditional Hindu law does not recognize divorce. However, separation is possible under certain circumstances.

**Inheritance Rights**
*   **Muslim Law:** Inheritance is defined by the Quran. A daughter generally receives half the share of a son. A wife receives one-eighth of her husband's property if there are children, and one-fourth if there are none.
*   **Hindu Law:** Hindu women's rights to inheritance have been historically limited to a life interest. However, recent movements and court observations are pushing for broader rights for Hindu women to inherit property.

**Domestic Violence**
The Domestic Violence (Prevention and Protection) Act, 2010, provides protection to women and children from physical, psychological, sexual, and economic abuse. Victims can seek protection orders, residence orders, and compensation from the court.",
        'language' => 'en',
    ],
    [
        'title' => 'Cheque Dishonor Cases: Legal Remedies under the NI Act',
        'content' => "Cheque dishonor (bouncing of cheques) is a common financial offense in Bangladesh. Section 138 of the Negotiable Instruments (NI) Act, 1881, provides the legal framework for dealing with such cases.

**What Constitutes an Offense?**
An offense is committed if a cheque is returned unpaid by the bank due to insufficient funds or if it exceeds the arrangement made with the bank.

**Procedure for Filing a Case**
1.  **Presenting the Cheque:** The cheque must be presented to the bank within its validity period (usually 6 months).
2.  **Bank Memo:** If dishonored, the bank issues a memo stating the reason (e.g., 'Insufficient Funds').
3.  **Legal Notice:** The holder must send a legal notice to the drawer (issuer) within 30 days of receiving the dishonor memo. The notice must demand payment within 30 days.
4.  **Waiting Period:** The holder must wait for the 30-day notice period to expire.
5.  **Filing the Complaint:** If the payment is not made, a case must be filed in the Court of the Magistrate of the First Class within 30 days after the expiry of the notice period.

**Punishment**
If found guilty, the drawer can be punished with:
*   Imprisonment for a term which may extend to one year, OR
*   A fine which may extend to three times the amount of the cheque, OR
*   Both.

**Appeal**
A convicted person can appeal to the Sessions Court, but they must deposit 50% of the cheque amount before filing the appeal.

**Civil Remedy**
Apart from the criminal case under the NI Act, the holder can also file a civil suit for the recovery of the money under the Code of Civil Procedure, usually in the form of a Money Suit.",
        'language' => 'en',
    ],
    [
        'title' => 'জমি সংক্রান্ত বিরোধ ও আইনি প্রতিকার: একটি বিস্তারিত নির্দেশিকা',
        'content' => "বাংলাদেশে দেওয়ানি ও ফৌজদারি মামলার একটি বিশাল অংশ জমি সংক্রান্ত বিরোধ নিয়ে। সঠিক আইনি জ্ঞান থাকলে অনেক জটিলতা এড়ানো সম্ভব। জমি নিয়ে বিরোধ সাধারণত মালিকানা, দখল, সীমানা এবং দলিল সংক্রান্ত হয়ে থাকে।

**জমি নিয়ে বিরোধের ধরন**
১. **মালিকানা নিয়ে বিরোধ:** যখন একাধিক ব্যক্তি একই জমির মালিকানা দাবি করে।
২. **দখল বেদখল:** বৈধ মালিককে জোরপূর্বক উচ্ছেদ করা বা অবৈধভাবে জমি দখল করা।
৩. **জাল দলিল:** ভুয়া বা জাল দলিল তৈরি করে জমি দাবি করা।

**ফৌজদারি প্রতিকার (তাৎক্ষণিক ব্যবস্থা)**
যদি কেউ জোরপূর্বক জমি দখল করার চেষ্টা করে বা হুমকি দেয়, তবে ফৌজদারি কার্যবিধির ১৪৫ ধারার অধীনে নির্বাহী ম্যাজিস্ট্রেটের আদালতে মামলা করা যায়। এটি সাধারণত শান্তি বজায় রাখার জন্য করা হয়। মামলাটি বিরোধ দেখা দেওয়ার ২ মাসের মধ্যে করতে হয়। আদালত পুলিশের মাধ্যমে তদন্ত করে এবং প্রয়োজনে রিসিভার নিয়োগ করতে পারে।

**দেওয়ানি প্রতিকার (স্থায়ী সমাধান)**
মালিকানা বা স্বত্ব প্রমাণের জন্য দেওয়ানি আদালতে যেতে হয়।
*   **স্বত্ব ঘোষণার মোকদ্দমা (Declaration of Title):** সুনির্দিষ্ট প্রতিকার আইন, ১৮৭৭ এর ৪২ ধারা অনুযায়ী এই মামলা করা হয়।
*   **দখল পুনরুদ্ধারের মামলা:** যদি কেউ বেদখল হয়, তবে সুনির্দিষ্ট প্রতিকার আইনের ৮ বা ৯ ধারায় মামলা করা যায়।
    *   **৯ ধারা:** বেদখল হওয়ার ৬ মাসের মধ্যে মামলা করতে হয়। এখানে মালিকানা প্রমাণের প্রয়োজন নেই, শুধু পূর্ববর্তী দখল প্রমাণ করলেই চলে।
    *   **৮ ধারা:** মালিকানা প্রমাণ সাপেক্ষে ১২ বছরের মধ্যে এই মামলা করা যায়।

**নামজারি বা মিউটেশন**
জমি কেনার পর বা উত্তরাধিকার সূত্রে পাওয়ার পর অবশ্যই নিজের নামে নামজারি করতে হবে। নামজারি না থাকলে ভবিষ্যতে জমি বিক্রি করা বা খাজনা দেওয়া অসম্ভব হয়ে পড়ে। সহকারী কমিশনার (ভূমি) অফিসে আবেদন করে এটি সম্পন্ন করতে হয়।

**সতর্কতা**
জমি কেনার আগে অবশ্যই সিএস, এসএ, আরএস এবং সিটি জরিপের খতিয়ান যাচাই করতে হবে। বিক্রেতার নামে হাল সনের খাজনা পরিশোধ আছে কিনা তা দেখতে হবে।",
        'language' => 'bn',
    ],
    [
        'title' => 'পারিবারিক সহিংসতা (প্রতিরোধ ও সুরক্ষা) আইন, ২০১০: নারীর আইনি রক্ষাকবচ',
        'content' => "পারিবারিক সহিংসতা বা ডোমেস্টিক ভায়োলেন্স বাংলাদেশে একটি গুরুতর সামাজিক ব্যাধি। নারীদের সুরক্ষা দিতে সরকার 'পারিবারিক সহিংসতা (প্রতিরোধ ও সুরক্ষা) আইন, ২০১০' প্রণয়ন করেছে। এই আইনটি শুধুমাত্র শারীরিক নির্যাতন নয়, বরং মানসিক, যৌন এবং অর্থনৈতিক নির্যাতনকেও অপরাধ হিসেবে গণ্য করে।

**পারিবারিক সহিংসতা কী?**
*   **শারীরিক নির্যাতন:** মারধর, জখম করা বা জীবন বিপন্ন করা।
*   **মানসিক নির্যাতন:** অপমান করা, গালিগালাজ করা, চলাফেরায় বাধা দেওয়া বা আত্মহত্যায় প্ররোচিত করা।
*   **যৌন নির্যাতন:** যৌন হয়রানি বা জোরপূর্বক যৌন সম্পর্ক স্থাপন।
*   **অর্থনৈতিক নির্যাতন:** ভরণপোষণ না দেওয়া, মোহরানা পরিশোধ না করা, বা নারীর উপার্জিত অর্থ জোর করে নিয়ে নেওয়া।

**প্রতিকার পাওয়ার উপায়**
ভুক্তভোগী নারী বা তার পক্ষে যে কেউ (যেমন পুলিশ, সমাজসেবা কর্মকর্তা বা এনজিও) আদালতে আবেদন করতে পারেন।
১. **সুরক্ষা আদেশ (Protection Order):** আদালত নির্যাতনকারীকে ভুক্তভোগীর কাছে যেতে বা যোগাযোগ করতে নিষেধ করতে পারে।
২. **বসবাসের আদেশ (Residence Order):** ভুক্তভোগীকে বাড়ি থেকে বের করে দেওয়া যাবে না, বা তাকে নিরাপদ বাসস্থানের ব্যবস্থা করে দিতে হবে।
৩. **ক্ষতিপূরণ আদেশ:** নির্যাতনের ফলে শারীরিক বা মানসিক ক্ষতির জন্য আদালত আর্থিক ক্ষতিপূরণের আদেশ দিতে পারে।

**শাস্তি**
আদালতের সুরক্ষা আদেশ অমান্য করলে ৬ মাস পর্যন্ত কারাদণ্ড বা ১০,০০০ টাকা পর্যন্ত জরিমানা বা উভয় দণ্ড হতে পারে। পুনরাবৃত্তি করলে শাস্তি আরও কঠোর হতে পারে (২ বছর জেল বা ১ লাখ টাকা জরিমানা)।

**সচেতনতা**
অনেক নারী লজ্জায় বা ভয়ে মুখ খোলেন না। কিন্তু মনে রাখতে হবে, এই আইনটি তাদের সুরক্ষার জন্যই তৈরি। নিকটস্থ থানা, মহিলা বিষয়ক অধিদপ্তর বা মানবাধিকার সংস্থার সাহায্য নেওয়া যেতে পারে।",
        'language' => 'bn',
    ],
    [
        'title' => 'চেক ডিজঅনার মামলা: নেগোশিয়েবল ইনস্ট্রুমেন্ট অ্যাক্ট ১৮৮১ এর ১৩৮ ধারা',
        'content' => "ব্যবসায়িক বা ব্যক্তিগত লেনদেনে চেক একটি গুরুত্বপূর্ণ মাধ্যম। কিন্তু চেক বাউন্স বা ডিজঅনার হলে পাওনাদার চরম বিপাকে পড়েন। বাংলাদেশে চেক ডিজঅনারের মামলা নেগোশিয়েবল ইনস্ট্রুমেন্ট (NI) অ্যাক্ট, ১৮৮১-এর ১৩৮ ধারার অধীনে পরিচালিত হয়।

**কখন মামলা করা যায়?**
১. ব্যাংক অ্যাকাউন্টে পর্যাপ্ত টাকা না থাকলে।
২. স্বাক্ষর না মিললে বা অন্য কোনো কারণে ব্যাংক চেক ফেরত দিলে।

**মামলা করার ধাপসমূহ**
১. **চেক উপস্থাপন:** চেকটি ইস্যু করার তারিখ থেকে ৬ মাসের মধ্যে ব্যাংকে জমা দিতে হবে।
২. **লিগ্যাল নোটিশ:** চেক ডিজঅনার হওয়ার পর ব্যাংক থেকে একটি স্লিপ দেওয়া হয়। এই স্লিপ পাওয়ার ৩০ দিনের মধ্যে আইনজীবীর মাধ্যমে চেক দাতার কাছে লিগ্যাল নোটিশ পাঠাতে হবে। নোটিশে ৩০ দিনের মধ্যে টাকা পরিশোধের সময় দিতে হবে।
৩. **মামলা দায়ের:** নোটিশের মেয়াদ (৩০ দিন) শেষ হওয়ার পর যদি টাকা না পাওয়া যায়, তবে পরবর্তী ৩০ দিনের মধ্যে জুডিশিয়াল ম্যাজিস্ট্রেট আদালতে মামলা করতে হবে।

**শাস্তি**
অপরাধ প্রমাণিত হলে আদালত চেক দাতাকে সর্বোচ্চ ১ বছরের কারাদণ্ড অথবা চেকের টাকার তিনগুণ পর্যন্ত জরিমানা অথবা উভয় দণ্ড দিতে পারে।

**আপিল**
রায় ঘোষণার পর আসামী আপিল করতে চাইলে তাকে চেকের টাকার ৫০% আদালতে জমা দিয়ে আপিল করতে হবে।

**কিছু গুরুত্বপূর্ণ বিষয়**
*   চেকটি অবশ্যই কোনো বৈধ দেনা বা দায় পরিশোধের জন্য হতে হবে।
*   খালি চেক বা জামানত হিসেবে দেওয়া চেক নিয়ে আইনি জটিলতা হতে পারে, তাই লেনদেনে সতর্ক থাকা উচিত।
*   একই সাথে দেওয়ানি আদালতে টাকা আদায়ের জন্য 'মানি স্যুট' (Money Suit) করা যায়।",
        'language' => 'bn',
    ],
    [
        'title' => 'উত্তরাধিকার আইন: মুসলিম ও হিন্দু আইনে সম্পত্তি বন্টন',
        'content' => "উত্তরাধিকার আইন বাংলাদেশে ধর্মভিত্তিক। অর্থাৎ, মৃত ব্যক্তির ধর্ম অনুযায়ী তার সম্পত্তি বন্টন করা হয়।

**মুসলিম উত্তরাধিকার আইন**
মুসলিম আইনে সম্পত্তি বন্টন পবিত্র কুরআনের নির্দেশ অনুযায়ী হয়। প্রধান উত্তরাধিকারীরা হলেন:
*   **পুত্র ও কন্যা:** পুত্র যা পাবে, কন্যা তার অর্ধেক পাবে (২:১ অনুপাতে)।
*   **স্ত্রী:** স্বামী মারা গেলে স্ত্রী সম্পত্তির ১/৮ অংশ পাবেন (যদি সন্তান থাকে)। সন্তান না থাকলে ১/৪ অংশ পাবেন।
*   **স্বামী:** স্ত্রী মারা গেলে স্বামী ১/৪ অংশ পাবেন (যদি সন্তান থাকে)। সন্তান না থাকলে ১/২ অংশ পাবেন।
*   **বাবা ও মা:** মৃত ব্যক্তির সন্তান থাকলে বাবা ও মা প্রত্যেকে ১/৬ অংশ করে পাবেন।

**হিন্দু উত্তরাধিকার আইন**
বাংলাদেশে প্রচলিত হিন্দু আইনে নারীদের সম্পত্তির অধিকার কিছুটা সীমিত। তবে বর্তমানে এটি নিয়ে অনেক আলোচনা হচ্ছে।
*   **পুত্র:** বাবার সম্পত্তির পূর্ণ মালিক হন।
*   **কন্যা:** অবিবাহিত কন্যারা কিছু ক্ষেত্রে সম্পত্তির অধিকার পান, তবে বিবাহিত কন্যারা সাধারণত বাবার সম্পত্তির ভাগ পান না (যদি না বাবা উইল করে যান)।
*   **স্ত্রী:** স্বামী মারা গেলে স্ত্রী স্বামীর সম্পত্তিতে 'জীবনস্বত্ব' (Life Interest) পান। অর্থাৎ তিনি এটি ভোগদখল করতে পারবেন, কিন্তু সাধারণত বিক্রি করতে পারবেন না (আইনি প্রয়োজন ছাড়া)।

**উইল বা ওসিয়ত**
*   **মুসলিম আইন:** একজন মুসলিম তার মোট সম্পত্তির ১/৩ অংশের বেশি উইল করতে পারেন না। এবং উত্তরাধিকারীদের বরাবর উইল করা যায় না (অন্য ওয়ারিশদের সম্মতি ছাড়া)।
*   **হিন্দু আইন:** একজন হিন্দু তার সম্পূর্ণ সম্পত্তি উইল করে যে কাউকে দিয়ে যেতে পারেন।

সম্পত্তি বন্টন নিয়ে বিরোধ এড়াতে মৃত্যুর আগেই উইল করা বা পারিবারিক সমঝোতা করা বুদ্ধিমানের কাজ।",
        'language' => 'bn',
    ],
    [
        'title' => 'সাইবার অপরাধ ও ডিজিটাল নিরাপত্তা: নিরাপদ থাকার উপায় ও আইনি সহায়তা',
        'content' => "ইন্টারনেটের প্রসারের সাথে সাথে সাইবার অপরাধও বাড়ছে। ফেসবুক হ্যাকিং, ভুয়া আইডি খুলে অপপ্রচার, ব্ল্যাকমেইল, এবং অনলাইনে আর্থিক প্রতারণা এখন নিত্যদিনের ঘটনা।

**ডিজিটাল নিরাপত্তা আইন, ২০১৮**
এই আইনের মাধ্যমে বিভিন্ন সাইবার অপরাধের বিচার করা হয়।
*   **হ্যাকিং (ধারা ১৭):** কম্পিউটার বা ডিজিটাল ডিভাইসে অবৈধ প্রবেশ বা ক্ষতিসাধন করলে ১৪ বছর পর্যন্ত জেল বা ১ কোটি টাকা জরিমানা হতে পারে।
*   **মানহানি (ধারা ২৯):** অনলাইনে মানহানিকর তথ্য প্রকাশ করলে ৩ বছর জেল বা ৫ লাখ টাকা জরিমানা।
*   **ধর্মীয় অনুভূতিতে আঘাত (ধারা ২৮):** ইলেকট্রনিক বিন্যাসে ধর্মীয় মূল্যবোধে আঘাত করলে ৫ বছর জেল বা ১০ লাখ টাকা জরিমানা।
*   **অশ্লীলতা (ধারা ২৪):** পর্নোগ্রাফি বা অশ্লীল কন্টেন্ট ছড়ালে ১০ বছর পর্যন্ত জেল হতে পারে।

**সাইবার অপরাধের শিকার হলে করণীয়**
১. **প্রমাণ সংরক্ষণ:** স্ক্রিনশট, মেসেজ, ইউআরএল (URL) এবং অন্যান্য ডিজিটাল প্রমাণ সংরক্ষণ করুন। ডিলিট করবেন না।
২. **জিডি (GD) করা:** নিকটস্থ থানায় সাধারণ ডায়েরি (GD) করুন।
৩. **সাইবার ক্রাইম ইউনিটে যোগাযোগ:** পুলিশের সাইবার ক্রাইম ইনভেস্টিগেশন ডিভিশন বা কাউন্টার টেরোরিজম ইউনিটে অভিযোগ করা যায়। হটলাইন নম্বর বা তাদের ফেসবুক পেজেও যোগাযোগ করা যায়।
৪. **বিটিআরসি (BTRC):** আপত্তিকর কন্টেন্ট রিমুভ করার জন্য বিটিআরসিতে অভিযোগ জানানো যায়।

**সতর্কতা**
*   সোশ্যাল মিডিয়ায় শক্তিশালী পাসওয়ার্ড ব্যবহার করুন এবং টু-ফ্যাক্টর অথেনটিকেশন (2FA) চালু রাখুন।
*   অপরিচিত লিংকে ক্লিক করবেন না।
*   ব্যক্তিগত ছবি বা ভিডিও শেয়ার করার ক্ষেত্রে অত্যন্ত সতর্ক থাকুন।",
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
    echo "Created detailed article: {$data['title']} ({$data['language']})\n";
}

echo "Seeding complete.\n";
