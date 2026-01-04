<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Exceptions\GeminiException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class AiFeaturesController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Show the AI Features page
     */
    public function index(): View
    {
        return view('ai.features');
    }

    /**
     * Get Dhara (Section) information from Bangladesh laws
     */
    public function getDhara(Request $request): JsonResponse
    {
        $data = $request->validate([
            'law_name' => 'required|string',
            'section' => 'required|string',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';

        $prompt = $language === 'bn'
            ? "আপনি বাংলাদেশের আইন বিশেষজ্ঞ। নিম্নলিখিত আইনের ধারা সম্পর্কে বিস্তারিত ব্যাখ্যা দিন:\n\nআইনের নাম: {$data['law_name']}\nধারা নম্বর: {$data['section']}\n\nঅনুগ্রহ করে নিম্নলিখিত বিষয়গুলো অন্তর্ভুক্ত করুন:\n১. ধারার পূর্ণ বাংলা পাঠ\n২. সহজ ভাষায় ব্যাখ্যা\n৩. শাস্তির বিধান (যদি থাকে)\n৪. প্রাসঙ্গিক উদাহরণ\n৫. সম্পর্কিত অন্যান্য ধারা"
            : "You are a Bangladesh law expert. Provide detailed explanation of the following law section:\n\nLaw Name: {$data['law_name']}\nSection Number: {$data['section']}\n\nPlease include:\n1. Full text of the section\n2. Simple explanation\n3. Punishment provisions (if any)\n4. Relevant examples\n5. Related sections";

        return $this->makeAiRequest($prompt, $language);
    }

    /**
     * Get legal term definitions (Dondobidhi/Legal Dictionary)
     */
    public function getLegalTerm(Request $request): JsonResponse
    {
        $data = $request->validate([
            'term' => 'required|string',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';

        $prompt = $language === 'bn'
            ? "আপনি বাংলাদেশের আইন বিশেষজ্ঞ এবং আইনি শব্দকোষ বিশেষজ্ঞ। নিম্নলিখিত আইনি শব্দ/পরিভাষার বিস্তারিত ব্যাখ্যা দিন:\n\nশব্দ/পরিভাষা: {$data['term']}\n\nঅনুগ্রহ করে নিম্নলিখিত বিষয়গুলো অন্তর্ভুক্ত করুন:\n১. সংজ্ঞা (বাংলা ও ইংরেজি)\n২. আইনি প্রেক্ষাপট\n৩. কোন আইনে ব্যবহৃত হয়\n৪. ব্যবহারিক উদাহরণ\n৫. সম্পর্কিত পরিভাষা"
            : "You are a Bangladesh law expert and legal dictionary specialist. Provide detailed explanation of the following legal term:\n\nTerm: {$data['term']}\n\nPlease include:\n1. Definition (in Bengali and English)\n2. Legal context\n3. Which laws use this term\n4. Practical examples\n5. Related terms";

        return $this->makeAiRequest($prompt, $language);
    }

    /**
     * Analyze legal document
     */
    public function analyzeDocument(Request $request): JsonResponse
    {
        $data = $request->validate([
            'document_text' => 'required|string|max:10000',
            'analysis_type' => 'required|string|in:summary,legal_issues,risks,recommendations',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';
        $analysisType = $data['analysis_type'];

        $analysisInstructions = [
            'summary' => $language === 'bn'
                ? "এই আইনি দলিলের সারসংক্ষেপ তৈরি করুন। মূল পয়েন্টগুলো, পক্ষসমূহ, এবং গুরুত্বপূর্ণ শর্তাবলী উল্লেখ করুন।"
                : "Create a summary of this legal document. Mention key points, parties involved, and important terms.",
            'legal_issues' => $language === 'bn'
                ? "এই দলিলে কোন আইনি সমস্যা বা ত্রুটি আছে কিনা চিহ্নিত করুন। বাংলাদেশের আইন অনুযায়ী বিশ্লেষণ করুন।"
                : "Identify any legal issues or defects in this document. Analyze according to Bangladesh law.",
            'risks' => $language === 'bn'
                ? "এই দলিলে কোন ঝুঁকি বা সম্ভাব্য সমস্যা আছে কিনা বিশ্লেষণ করুন। প্রতিটি পক্ষের জন্য ঝুঁকি মূল্যায়ন করুন।"
                : "Analyze any risks or potential problems in this document. Evaluate risks for each party.",
            'recommendations' => $language === 'bn'
                ? "এই দলিল উন্নত করার জন্য সুপারিশ দিন। কোন ধারা যোগ বা পরিবর্তন করা উচিত তা বলুন।"
                : "Provide recommendations to improve this document. Suggest clauses to add or modify."
        ];

        $prompt = $language === 'bn'
            ? "আপনি বাংলাদেশের একজন অভিজ্ঞ আইনজীবী। নিম্নলিখিত আইনি দলিল বিশ্লেষণ করুন:\n\n{$analysisInstructions[$analysisType]}\n\nদলিল:\n{$data['document_text']}"
            : "You are an experienced lawyer in Bangladesh. Analyze the following legal document:\n\n{$analysisInstructions[$analysisType]}\n\nDocument:\n{$data['document_text']}";

        return $this->makeAiRequest($prompt, $language);
    }

    /**
     * Case outcome predictor based on facts
     */
    public function predictCase(Request $request): JsonResponse
    {
        $data = $request->validate([
            'case_type' => 'required|string',
            'facts' => 'required|string|max:5000',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';

        $prompt = $language === 'bn'
            ? "আপনি বাংলাদেশের একজন অভিজ্ঞ আইনজীবী এবং আইনি বিশ্লেষক। নিম্নলিখিত মামলার তথ্যের উপর ভিত্তি করে বিশ্লেষণ করুন:\n\nমামলার ধরন: {$data['case_type']}\n\nতথ্যসমূহ:\n{$data['facts']}\n\nঅনুগ্রহ করে নিম্নলিখিত বিষয়গুলো বিশ্লেষণ করুন:\n১. প্রযোজ্য আইন ও ধারাসমূহ\n২. শক্তিশালী পয়েন্টসমূহ\n৩. দুর্বল পয়েন্টসমূহ\n৪. সম্ভাব্য ফলাফল বিশ্লেষণ\n৫. আইনি কৌশল সুপারিশ\n\nদ্রষ্টব্য: এটি শুধুমাত্র শিক্ষামূলক বিশ্লেষণ, প্রকৃত আইনি পরামর্শ নয়।"
            : "You are an experienced lawyer and legal analyst in Bangladesh. Analyze the following case based on the facts:\n\nCase Type: {$data['case_type']}\n\nFacts:\n{$data['facts']}\n\nPlease analyze:\n1. Applicable laws and sections\n2. Strong points\n3. Weak points\n4. Possible outcome analysis\n5. Legal strategy recommendations\n\nNote: This is educational analysis only, not actual legal advice.";

        return $this->makeAiRequest($prompt, $language);
    }

    /**
     * Get legal procedure guide
     */
    public function getProcedure(Request $request): JsonResponse
    {
        $data = $request->validate([
            'procedure_type' => 'required|string',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';

        $prompt = $language === 'bn'
            ? "আপনি বাংলাদেশের আইন বিশেষজ্ঞ। নিম্নলিখিত আইনি প্রক্রিয়ার বিস্তারিত গাইড দিন:\n\nপ্রক্রিয়া: {$data['procedure_type']}\n\nঅনুগ্রহ করে নিম্নলিখিত বিষয়গুলো অন্তর্ভুক্ত করুন:\n১. ধাপে ধাপে প্রক্রিয়া\n২. প্রয়োজনীয় কাগজপত্র\n৩. কোথায় আবেদন করতে হবে\n৪. সময়সীমা ও খরচ\n৫. গুরুত্বপূর্ণ টিপস"
            : "You are a Bangladesh law expert. Provide a detailed guide for the following legal procedure:\n\nProcedure: {$data['procedure_type']}\n\nPlease include:\n1. Step by step process\n2. Required documents\n3. Where to apply\n4. Timeline and costs\n5. Important tips";

        return $this->makeAiRequest($prompt, $language);
    }

    /**
     * Legal rights checker
     */
    public function checkRights(Request $request): JsonResponse
    {
        $data = $request->validate([
            'situation' => 'required|string|max:3000',
            'category' => 'required|string|in:consumer,property,family,criminal,labor,civil',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';

        $categoryNames = [
            'consumer' => $language === 'bn' ? 'ভোক্তা অধিকার' : 'Consumer Rights',
            'property' => $language === 'bn' ? 'সম্পত্তি অধিকার' : 'Property Rights',
            'family' => $language === 'bn' ? 'পারিবারিক আইন' : 'Family Law',
            'criminal' => $language === 'bn' ? 'ফৌজদারি আইন' : 'Criminal Law',
            'labor' => $language === 'bn' ? 'শ্রম আইন' : 'Labor Law',
            'civil' => $language === 'bn' ? 'দেওয়ানি আইন' : 'Civil Law',
        ];

        $prompt = $language === 'bn'
            ? "আপনি বাংলাদেশের আইন বিশেষজ্ঞ। নিম্নলিখিত পরিস্থিতিতে একজন নাগরিকের কী কী আইনি অধিকার রয়েছে তা বিশ্লেষণ করুন:\n\nবিভাগ: {$categoryNames[$data['category']]}\n\nপরিস্থিতি:\n{$data['situation']}\n\nঅনুগ্রহ করে নিম্নলিখিত বিষয়গুলো অন্তর্ভুক্ত করুন:\n১. প্রযোজ্য আইনি অধিকারসমূহ\n২. সংশ্লিষ্ট আইন ও ধারা\n৩. প্রতিকার পাওয়ার উপায়\n৪. কোথায় অভিযোগ করতে হবে\n৫. সতর্কতা ও পরামর্শ"
            : "You are a Bangladesh law expert. Analyze what legal rights a citizen has in the following situation:\n\nCategory: {$categoryNames[$data['category']]}\n\nSituation:\n{$data['situation']}\n\nPlease include:\n1. Applicable legal rights\n2. Relevant laws and sections\n3. Ways to get remedy\n4. Where to file complaints\n5. Cautions and advice";

        return $this->makeAiRequest($prompt, $language);
    }

    /**
     * Draft legal notice/application
     */
    public function draftDocument(Request $request): JsonResponse
    {
        $data = $request->validate([
            'document_type' => 'required|string|in:legal_notice,application,affidavit,contract,complaint',
            'details' => 'required|string|max:5000',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';

        $documentTypes = [
            'legal_notice' => $language === 'bn' ? 'আইনি নোটিশ' : 'Legal Notice',
            'application' => $language === 'bn' ? 'আবেদনপত্র' : 'Application',
            'affidavit' => $language === 'bn' ? 'হলফনামা' : 'Affidavit',
            'contract' => $language === 'bn' ? 'চুক্তিপত্র' : 'Contract',
            'complaint' => $language === 'bn' ? 'অভিযোগপত্র' : 'Complaint',
        ];

        $prompt = $language === 'bn'
            ? "আপনি বাংলাদেশের একজন অভিজ্ঞ আইনজীবী। নিম্নলিখিত তথ্যের উপর ভিত্তি করে একটি {$documentTypes[$data['document_type']]} খসড়া তৈরি করুন:\n\nবিবরণ:\n{$data['details']}\n\nঅনুগ্রহ করে:\n১. সঠিক আইনি ফরম্যাট ব্যবহার করুন\n২. প্রয়োজনীয় সব অংশ অন্তর্ভুক্ত করুন\n৩. বাংলাদেশের আইন অনুযায়ী সঠিক ভাষা ব্যবহার করুন\n৪. প্রাসঙ্গিক আইনের রেফারেন্স দিন"
            : "You are an experienced lawyer in Bangladesh. Draft a {$documentTypes[$data['document_type']]} based on the following details:\n\nDetails:\n{$data['details']}\n\nPlease:\n1. Use correct legal format\n2. Include all necessary sections\n3. Use appropriate legal language as per Bangladesh law\n4. Reference relevant laws";

        return $this->makeAiRequest($prompt, $language);
    }

    /**
     * Common helper for AI requests
     */
    private function makeAiRequest(string $prompt, string $language): JsonResponse
    {
        try {
            $result = $this->gemini->askQuestion($prompt, $language);
            return new JsonResponse(['ok' => true, 'result' => $result['answer'] ?? $result]);
        } catch (GeminiException $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            $retryAfter = $e->getRetryAfter() ?? 30;
            $status = $e->getCode() === 429 ? 429 : 502;
            $errorMessage = $language === 'bn'
                ? ($status === 429
                    ? 'AI কোটার সীমা অতিক্রম হয়েছে। অনুগ্রহ করে নতুন API কী বা বিলিং আপডেট করুন।'
                    : 'AI সেবা অনুপলব্ধ। অনুগ্রহ করে পরে আবার চেষ্টা করুন।')
                : ($status === 429
                    ? 'AI quota exceeded. Please update API key or billing.'
                    : 'AI service unavailable. Please try again later.');

            return new JsonResponse([
                'ok' => false,
                'error' => $errorMessage,
                'retry_after' => $retryAfter
            ], $status);
        } catch (\Exception $e) {
            Log::error('Unexpected error in AI Features: ' . $e->getMessage());
            return new JsonResponse([
                'ok' => false,
                'error' => $language === 'bn'
                    ? 'একটি অপ্রত্যাশিত ত্রুটি ঘটেছে।'
                    : 'An unexpected error occurred.'
            ], 500);
        }
    }

    // Extraordinary AI Features - Premium Tools

    /**
     * Calculate inheritance shares according to Islamic/Hindu law
     */
    public function calculateInheritance(Request $request): JsonResponse
    {
        $lang = $request->input('language', 'en');
        try {
            $request->validate([
                'law_system' => 'required|string',
                'deceased_gender' => 'required|string',
                'estate_value' => 'required|numeric',
                'sons' => 'required|integer',
                'daughters' => 'required|integer',
                'has_spouse' => 'required|boolean',
                'has_mother' => 'required|boolean',
                'has_father' => 'required|boolean',
                'language' => 'nullable|string|in:en,bn'
            ]);

            $system = $request->input('law_system');
            $gender = $request->input('deceased_gender');
            $estate = $request->input('estate_value');
            $sons = $request->input('sons');
            $daughters = $request->input('daughters');
            $spouse = $request->input('has_spouse');
            $mother = $request->input('has_mother');
            $father = $request->input('has_father');

            $prompt = "Act as an expert inheritance lawyer in Bangladesh. Calculate the inheritance shares for the following case:\n" .
                "Law System: " . ($system == 'islamic' ? 'Islamic Law (Faraid)' : 'Hindu Succession Law') . "\n" .
                "Deceased Gender: $gender\n" .
                "Total Estate Value: $estate BDT\n" .
                "Heirs: $sons Sons, $daughters Daughters\n" .
                "Spouse Alive: " . ($spouse ? 'Yes' : 'No') . "\n" .
                "Mother Alive: " . ($mother ? 'Yes' : 'No') . "\n" .
                "Father Alive: " . ($father ? 'Yes' : 'No') . "\n\n" .
                "Provide a detailed breakdown of shares (fraction and amount) for each heir according to Bangladesh law. " .
                "Explain the legal basis (Quranic verse or Hindu Law principle). " .
                "If there is any residue, explain where it goes.";

            if ($lang === 'bn') {
                $prompt .= "\n\nProvide the entire response in Bengali language.";
            }

            $result = $this->gemini->askQuestion($prompt);

            return response()->json([
                'ok' => true,
                'result' => $result['answer'] ?? $result
            ]);
        } catch (\Exception $e) {
            Log::error('Inheritance calculation error: ' . $e->getMessage());
            return response()->json([
                'ok' => false,
                'error' => $lang === 'bn' ? 'উত্তরাধিকার গণনায় ত্রুটি হয়েছে।' : 'Error calculating inheritance.'
            ], 500);
        }
    }

    /**
     * Build a comprehensive legal timeline
     */
    public function buildCaseTimeline(Request $request): JsonResponse
    {
        $lang = $request->input('language', 'en');
        try {
            $request->validate([
                'case_nature' => 'required|string',
                'start_date' => 'required|date',
                'events_description' => 'required|string',
                'language' => 'nullable|string|in:en,bn'
            ]);

            $nature = $request->input('case_nature');
            $startDate = $request->input('start_date');
            $events = $request->input('events_description');

            $prompt = "Act as a legal strategist in Bangladesh. Build a comprehensive legal timeline for a $nature case.\n" .
                "Start Date: $startDate\n" .
                "Events Description: $events\n\n" .
                "Create a chronological timeline of events. " .
                "For each event, identify if there are any legal deadlines or limitation periods (Tamadi) according to Bangladesh Limitation Act or relevant laws. " .
                "Highlight any missed deadlines or upcoming critical dates. " .
                "Format as a clear timeline list.";

            if ($lang === 'bn') {
                $prompt .= "\n\nProvide the entire response in Bengali language.";
            }

            $result = $this->gemini->askQuestion($prompt);

            return response()->json([
                'ok' => true,
                'result' => $result['answer'] ?? $result
            ]);
        } catch (\Exception $e) {
            Log::error('Timeline builder error: ' . $e->getMessage());
            return response()->json([
                'ok' => false,
                'error' => $lang === 'bn' ? 'টাইমলাইন তৈরিতে ত্রুটি হয়েছে।' : 'Error building timeline.'
            ], 500);
        }
    }
}
