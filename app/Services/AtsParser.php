<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class AtsParser
{
    public function parse(string $filePath): array
    {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $text = '';
        $notes = [];

        if (!file_exists($filePath)) {
            return [
                'score' => 0,
                'details' => [],
                'sections' => [],
                'formatting' => [],
                'suggestions' => ['File not found.'],
                'notes' => ['File not found.'],
                'raw' => '',
                'breakdown' => [],
            ];
        }

        if ($ext === 'txt') {
            $text = file_get_contents($filePath);
        } elseif ($ext === 'docx') {
            $text = $this->extractDocxText($filePath, $notes);
        } elseif ($ext === 'doc') {
            $text = $this->extractDocText($filePath, $notes);
        } elseif ($ext === 'pdf') {
            $text = $this->extractPdfText($filePath, $notes);
        } else {
            $notes[] = 'Unsupported resume format. Upload PDF, DOCX, DOC, or TXT.';
        }

        $text = trim($text ?? '');
        if ($text === '') {
            $notes[] = 'Unable to extract text from this document. Please upload a text-based resume file.';
        }

        $analysis = $this->analyzeText($text, $notes);
        $contact = $this->extractContact($text);
        $skills = $this->extractSkills($text);

        $wordCount = $text === '' ? 0 : str_word_count($text);

        return [
            'score' => $analysis['score'],
            'details' => $analysis['details'],
            'sections' => $analysis['sections'],
            'formatting' => $analysis['formatting'],
            'suggestions' => $analysis['suggestions'],
            'notes' => $notes,
            'raw' => mb_substr($text, 0, 5000),
            'breakdown' => $analysis['breakdown'],
            'extra' => $analysis['extra'] ?? [],
            'contact' => $contact,
            'skills_found' => $skills['flat'],
            'skills_grouped' => $skills['grouped'],
            'word_count' => $wordCount,
        ];
    }

    private function analyzeText(string $text, array &$notes): array
    {
        $lower = mb_strtolower($text);
        $lines = preg_split('/\r?\n/', $text);

        $sections = $this->discoverSections($lines, $lower);
        $blocks = $this->parseSectionBlocks($lines);
        $header = $this->detectResumeHeader($lines, $lower);
        $headline = $this->detectProfessionalHeadline($blocks['header'] ?? []);
        $bulletCount = $this->countBulletPoints($lines);
        $metricsCount = $this->countAchievementMetrics($lower);
        $keywordsCount = $this->countKeywords($lower);
        $actionVerbCount = $this->countActionVerbs($lower);
        $summaryQuality = $this->evaluateSummaryQuality($blocks['summary'] ?? [], $lower);
        $dateRangeCount = $this->countDateRanges($lower);
        $experienceEntries = $this->countExperienceEntries($blocks['experience'] ?? []);
        $firstPerson = $this->detectFirstPerson($lower);
        $weakPhraseCount = $this->countWeakPhrases($lower);

        $formatting = [
            'bullets' => $bulletCount > 2,
            'dates' => $dateRangeCount >= 1,
            'email' => preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $text) === 1,
            'phone' => preg_match('/(\+?\d[\d\s().-]{6,}\d)/', $text) === 1,
            'headings' => $this->detectSectionHeadings($lines) >= 4,
            'tables' => $this->detectTableLayout($text),
            'page_numbers' => preg_match('/\b(page\s+\d+|\d+\s+of\s+\d+)\b/i', $text) === 1,
            'images_or_graphics' => $this->detectGraphicsLikeContent($text),
            'header' => $header,
            'skills_formatting' => $this->detectSkillsSection($blocks['skills'] ?? []),
            'chronological_dates' => $dateRangeCount >= 2,
            'experience_entries' => $experienceEntries > 0,
            'headline' => $headline,
            'no_weak_phrases' => $weakPhraseCount === 0,
            'no_first_person' => !$firstPerson,
        ];

        $details = [
            'email' => $formatting['email'],
            'phone' => $formatting['phone'],
            'experience' => $sections['experience'],
            'skills' => $sections['skills'],
            'education' => $sections['education'],
            'summary' => $sections['summary'],
            'projects' => $sections['projects'],
            'certifications' => $sections['certifications'],
            'achievements' => $sections['achievements'],
            'bullets' => $formatting['bullets'],
            'dates' => $formatting['dates'],
            'headings' => $formatting['headings'],
            'action_verbs' => $actionVerbCount >= 5,
            'metrics' => $metricsCount >= 2,
            'keywords' => $keywordsCount >= 4,
            'summary_quality' => $summaryQuality >= 3,
            'header' => $header,
            'headline' => $headline,
            'chronological_dates' => $formatting['chronological_dates'],
            'experience_entries' => $formatting['experience_entries'],
            'no_first_person' => $formatting['no_first_person'],
            'no_weak_phrases' => $formatting['no_weak_phrases'],
        ];

        $baseScore = 10;
        $breakdown = [
            'base' => $baseScore,
            'contact_score' => 0,
            'structure_score' => 0,
            'achievement_score' => 0,
            'format_score' => 0,
            'quality_score' => 0,
            'penalty' => 0,
        ];

        $breakdown['contact_score'] += $details['email'] ? 5 : 0;
        $breakdown['contact_score'] += $details['phone'] ? 5 : 0;
        $breakdown['contact_score'] += $details['header'] ? 4 : 0;
        $breakdown['contact_score'] += $details['headline'] ? 3 : 0;

        $breakdown['structure_score'] += $sections['summary'] ? 6 : 0;
        $breakdown['structure_score'] += $sections['experience'] ? 10 : 0;
        $breakdown['structure_score'] += $sections['education'] ? 5 : 0;
        $breakdown['structure_score'] += $sections['skills'] ? 4 : 0;
        $breakdown['structure_score'] += $details['headings'] ? 3 : 0;
        $breakdown['structure_score'] += $details['chronological_dates'] ? 2 : 0;
        $breakdown['structure_score'] += $details['experience_entries'] ? 2 : 0;

        $breakdown['achievement_score'] += $details['metrics'] ? 6 : 0;
        $breakdown['achievement_score'] += $details['action_verbs'] ? 6 : 0;
        $breakdown['achievement_score'] += $details['summary_quality'] ? 4 : 0;
        $breakdown['achievement_score'] += $details['keywords'] ? 4 : 0;

        $breakdown['format_score'] += $details['bullets'] ? 4 : 0;
        $breakdown['format_score'] += $details['dates'] ? 4 : 0;
        $breakdown['format_score'] += ($details['skills_formatting'] ?? false) ? 4 : 0;
        $breakdown['format_score'] += $details['no_weak_phrases'] ? 4 : 0;
        $breakdown['format_score'] += $details['no_first_person'] ? 3 : 0;

        $breakdown['quality_score'] += $summaryQuality;

        if (!$sections['summary']) {
            $breakdown['penalty'] += 8;
            $notes[] = 'Professional summary/objective section missing.';
        }
        if (!$sections['experience']) {
            $breakdown['penalty'] += 12;
            $notes[] = 'Experience section not detected.';
        }
        if (!$sections['education']) {
            $breakdown['penalty'] += 6;
            $notes[] = 'Education section not detected.';
        }
        if (!$sections['skills']) {
            $breakdown['penalty'] += 6;
            $notes[] = 'Skills section not detected.';
        }
        if (!$details['email']) {
            $breakdown['penalty'] += 8;
            $notes[] = 'Contact email not found.';
        }
        if (!$details['phone']) {
            $breakdown['penalty'] += 6;
            $notes[] = 'Contact phone number not found.';
        }
        if (!$details['header']) {
            $breakdown['penalty'] += 6;
            $notes[] = 'Header information is not clear; add name, title, and contact details at the top.';
        }
        if (!$details['headline']) {
            $breakdown['penalty'] += 4;
            $notes[] = 'Professional headline or title not detected; add a role-focused headline near your name.';
        }
        if ($sections['experience'] && !$details['experience_entries']) {
            $breakdown['penalty'] += 5;
            $notes[] = 'Experience section is present but lacks clearly parsed role or date entries.';
        }
        if ($sections['experience'] && !$details['chronological_dates']) {
            $breakdown['penalty'] += 4;
            $notes[] = 'Experience entries should include date ranges for ATS-friendly chronology.';
        }
        if (!$details['headings']) {
            $breakdown['penalty'] += 4;
            $notes[] = 'Headings are not strong enough; use clear section titles such as Experience, Education, and Skills.';
        }
        if (!$details['bullets']) {
            $breakdown['penalty'] += 4;
            $notes[] = 'Bullet points improve readability and parsing; convert long paragraphs into concise bullets.';
        }
        if (!$details['metrics']) {
            $breakdown['penalty'] += 5;
            $notes[] = 'No measurable achievements found; include numbers, percentages, or outcomes.';
        }
        if (!$details['action_verbs']) {
            $breakdown['penalty'] += 4;
            $notes[] = 'Use stronger action verbs to describe impact and responsibilities.';
        }
        if (!$details['no_first_person']) {
            $breakdown['penalty'] += 3;
            $notes[] = 'Avoid first-person pronouns like I, me, or my in resume content.';
        }
        if (!$details['no_weak_phrases']) {
            $breakdown['penalty'] += 2;
            $notes[] = 'Weak language such as responsible for or tasked with should be replaced with stronger impact statements.';
        }
        if ($formatting['tables']) {
            $breakdown['penalty'] += 12;
            $notes[] = 'Possible table or column layout detected; this can break ATS parsing.';
        }
        if ($formatting['images_or_graphics']) {
            $breakdown['penalty'] += 10;
            $notes[] = 'Image or graphic-like content detected; avoid using images for important text.';
        }
        if ($formatting['page_numbers']) {
            $breakdown['penalty'] += 2;
            $notes[] = 'Page numbers are fine, but verify the resume is still ATS-friendly across pages.';
        }

        if (trim($text) === '') {
            $breakdown['penalty'] += 25;
        }

        $len = mb_strlen($text);
        if ($len > 0 && $len < 500) {
            $breakdown['penalty'] += 10;
            $notes[] = 'Resume is very short; add more achievements, impact metrics, and role context.';
        } elseif ($len > 4500) {
            $breakdown['penalty'] += 5;
            $notes[] = 'Resume is very long; keep the most relevant experience and remove outdated details.';
        }

        $suggestions = [];
        if (!$details['email']) {
            $suggestions[] = 'Add a professional email address in the header.';
        }
        if (!$details['phone']) {
            $suggestions[] = 'Include a phone number in your contact details.';
        }
        if (!$formatting['header']) {
            $suggestions[] = 'Ensure the top of the resume has your name, title, and contact details in a single header block.';
        }
        if (!$details['headline']) {
            $suggestions[] = 'Add a concise headline describing your role and strengths, such as Senior Product Manager or Data Engineer.';
        }
        if (!$sections['summary']) {
            $suggestions[] = 'Add a strong professional summary at the top with your value proposition and career focus.';
        }
        if ($summaryQuality < 3 && $details['summary']) {
            $suggestions[] = 'Strengthen the summary by focusing on results, role type, and core strengths in 2–4 concise sentences.';
        }
        if (!$sections['experience']) {
            $suggestions[] = 'Add a detailed Experience section with roles, companies, and date ranges.';
        }
        if ($sections['experience'] && !$details['experience_entries']) {
            $suggestions[] = 'Convert each experience role to a clear entry with employer, title, and dates.';
        }
        if (!$sections['skills']) {
            $suggestions[] = 'Add a Skills section showing technical keywords and tools relevant to your role.';
        }
        if (!($details['skills_formatting'] ?? false) && $sections['skills']) {
            $suggestions[] = 'Format the Skills section as a clean list or comma-separated keywords for ATS readability.';
        }
        if (!$sections['education']) {
            $suggestions[] = 'Add an Education section with degrees, institutions, and completion years.';
        }
        if (!$details['dates']) {
            $suggestions[] = 'Add explicit date ranges for each role and education entry.';
        }
        if (!$details['bullets']) {
            $suggestions[] = 'Use bullet points for responsibilities and achievements to improve readability.';
        }
        if (!$details['metrics']) {
            $suggestions[] = 'Add quantifiable achievements with numbers, percentages, or measurable business impact.';
        }
        if (!$details['action_verbs']) {
            $suggestions[] = 'Use strong action verbs such as led, developed, managed, improved, and delivered.';
        }
        if (!$details['no_first_person']) {
            $suggestions[] = 'Remove first-person pronouns like I, me, or my from resume sentences.';
        }
        if (!$details['no_weak_phrases']) {
            $suggestions[] = 'Replace weak phrases such as responsible for with stronger impact statements.';
        }
        if ($formatting['tables']) {
            $suggestions[] = 'Remove tables and columns; use simple single-column text for ATS compatibility.';
        }
        if ($formatting['images_or_graphics']) {
            $suggestions[] = 'Remove images, logos, and graphics from the resume because ATS cannot read them reliably.';
        }
        if (!$details['headings']) {
            $suggestions[] = 'Use clear headings for each section instead of dense text blocks.';
        }
        if ($keywordsCount < 4) {
            $suggestions[] = 'Include more role-specific keywords and tools that match the job you are targeting.';
        }

        if (empty($suggestions)) {
            $suggestions[] = 'The resume has a strong professional structure; maintain clear headings, keywords, and ATS-safe formatting.';
        }

        $score = $breakdown['base'] + $breakdown['contact_score'] + $breakdown['structure_score'] + $breakdown['achievement_score'] + $breakdown['format_score'] + $breakdown['quality_score'] - $breakdown['penalty'];
        $score = max(0, min(100, $score));
        $breakdown['total'] = $score;
        $breakdown['metrics_found'] = $metricsCount;
        $breakdown['action_verbs_found'] = $actionVerbCount;
        $breakdown['keywords_found'] = $keywordsCount;
        $breakdown['date_ranges_found'] = $dateRangeCount;
        $breakdown['experience_entries_found'] = $experienceEntries;
        $breakdown['weak_phrases_found'] = $weakPhraseCount;

        $extra = $this->buildInsights($details, $sections, $formatting, $breakdown, $summaryQuality, $score, $text, $lower);

        return [
            'score' => $score,
            'details' => $details,
            'sections' => $sections,
            'formatting' => $formatting,
            'suggestions' => array_values(array_unique($suggestions)),
            'breakdown' => $breakdown,
            'extra' => $extra,
        ];
    }

    /**
     * Build the advanced analytics layer: per-category gauges, a granular
     * pass/fail checklist, ranked improvement opportunities (with the exact
     * points each one recovers), a projected score, keyword analysis and
     * concrete before/after rewrites taken from the candidate's own resume.
     */
    private function buildInsights(array $details, array $sections, array $formatting, array $breakdown, int $summaryQuality, int $score, string $text, string $lower): array
    {
        // Each check: [category, label, passed, points (recoverable), fix]
        $checks = [
            // Contact (max 17)
            ['contact', 'Email address', $details['email'], 5, 'Add a professional email address to your header.'],
            ['contact', 'Phone number', $details['phone'], 5, 'Add a phone number to your contact details.'],
            ['contact', 'Clear header block', $details['header'], 4, 'Group your name, title and contact info in one block at the very top.'],
            ['contact', 'Professional headline', $details['headline'], 3, 'Add a role-focused headline under your name, e.g. “Senior Data Analyst”.'],

            // Structure (max 32)
            ['structure', 'Professional summary', $sections['summary'], 6, 'Add a 2–4 sentence summary highlighting your value and focus.'],
            ['structure', 'Experience section', $sections['experience'], 10, 'Add an Experience section with roles, companies and dates.'],
            ['structure', 'Education section', $sections['education'], 5, 'Add an Education section with degrees, institutions and years.'],
            ['structure', 'Skills section', $sections['skills'], 4, 'Add a dedicated Skills section with relevant tools and keywords.'],
            ['structure', 'Clear section headings', $details['headings'], 3, 'Use clear headings such as Experience, Education and Skills.'],
            ['structure', 'Dated experience entries', $details['chronological_dates'], 2, 'Give every role a clear start–end date range.'],
            ['structure', 'Parseable role entries', $details['experience_entries'], 2, 'List each role as “Title — Company (dates)” on its own line.'],

            // Achievements (max 20)
            ['achievements', 'Quantified achievements', $details['metrics'], 6, 'Back up results with numbers, %, revenue or other measurable impact.'],
            ['achievements', 'Strong action verbs', $details['action_verbs'], 6, 'Start bullets with verbs like Led, Built, Delivered, Optimized.'],
            ['achievements', 'Results-focused summary', $details['summary_quality'], 4, 'Rewrite the summary around outcomes and strengths, not duties.'],
            ['achievements', 'Role-specific keywords', $details['keywords'], 4, 'Mirror keywords from your target job descriptions.'],

            // Formatting (max 19)
            ['formatting', 'Bullet points', $details['bullets'], 4, 'Convert dense paragraphs into concise bullet points.'],
            ['formatting', 'Date ranges present', $details['dates'], 4, 'Add explicit date ranges to roles and education.'],
            ['formatting', 'ATS-safe skills list', ($formatting['skills_formatting'] ?? false), 4, 'Format skills as a clean comma or bullet separated list.'],
            ['formatting', 'No weak phrasing', $details['no_weak_phrases'], 4, 'Replace weak phrases like “responsible for” with impact statements.'],
            ['formatting', 'No first-person pronouns', $details['no_first_person'], 3, 'Remove “I”, “me”, “my” — resumes use an implied subject.'],
        ];

        $catMeta = [
            'contact'      => ['label' => 'Contact Info',  'max' => 17, 'color' => '#2563eb'],
            'structure'    => ['label' => 'Structure',     'max' => 32, 'color' => '#7c3aed'],
            'achievements' => ['label' => 'Achievements',  'max' => 20, 'color' => '#0ea5e9'],
            'formatting'   => ['label' => 'Formatting',    'max' => 19, 'color' => '#10b981'],
            'quality'      => ['label' => 'Writing Depth', 'max' => 5,  'color' => '#f59e0b'],
        ];

        // Aggregate earned points per category from the checks.
        $earned = ['contact' => 0, 'structure' => 0, 'achievements' => 0, 'formatting' => 0, 'quality' => 0];
        $checkList = [];
        $opportunities = [];
        foreach ($checks as [$cat, $label, $passed, $points, $fix]) {
            $passed = (bool) $passed;
            if ($passed) {
                $earned[$cat] += $points;
            } else {
                $opportunities[] = ['label' => $label, 'points' => $points, 'fix' => $fix, 'category' => $catMeta[$cat]['label']];
            }
            $checkList[] = ['category' => $catMeta[$cat]['label'], 'label' => $label, 'passed' => $passed, 'points' => $points, 'fix' => $fix];
        }
        // Writing depth is graded (0–5) rather than pass/fail.
        $earned['quality'] = $summaryQuality;
        if ($summaryQuality < 5) {
            $opportunities[] = [
                'label' => 'Deeper professional summary',
                'points' => 5 - $summaryQuality,
                'fix' => 'Expand the summary to 30–120 words with specialism, seniority and a headline achievement.',
                'category' => 'Writing Depth',
            ];
        }

        // Category gauges (percentage of max achieved) + radar benchmark.
        $categories = [];
        $benchmarkPct = 85; // what a strong, ATS-ready resume typically scores
        foreach ($catMeta as $key => $meta) {
            $val = $earned[$key];
            $pct = $meta['max'] > 0 ? (int) round(($val / $meta['max']) * 100) : 0;
            $categories[] = [
                'key' => $key,
                'label' => $meta['label'],
                'earned' => $val,
                'max' => $meta['max'],
                'pct' => $pct,
                'color' => $meta['color'],
                'benchmark' => $benchmarkPct,
                'status' => $pct >= 80 ? 'strong' : ($pct >= 50 ? 'fair' : 'weak'),
            ];
        }

        // Rank opportunities by impact (points) descending.
        usort($opportunities, fn($a, $b) => $b['points'] <=> $a['points']);

        // Projected score after fixing the top 3 opportunities, and the ceiling.
        $top3 = array_sum(array_map(fn($o) => $o['points'], array_slice($opportunities, 0, 3)));
        $allFixable = array_sum(array_map(fn($o) => $o['points'], $opportunities));
        $projected = min(100, $score + $top3);
        $potential = min(100, $score + $allFixable);

        // Weakest category (where the score is lagging most).
        $weakest = null;
        foreach ($categories as $c) {
            if ($weakest === null || $c['pct'] < $weakest['pct']) {
                $weakest = $c;
            }
        }

        return [
            'categories'     => $categories,
            'checks'         => $checkList,
            'opportunities'  => $opportunities,
            'projected'      => $projected,
            'potential'      => $potential,
            'weakest'        => $weakest,
            'keywords'       => $this->analyzeKeywords($lower),
            'examples'       => $this->findImprovementExamples($text),
            'passed_count'   => count(array_filter($checkList, fn($c) => $c['passed'])),
            'total_count'    => count($checkList),
        ];
    }

    /**
     * Return which common industry keywords were found vs. recommended additions.
     */
    private function analyzeKeywords(string $lower): array
    {
        $keywords = ['leadership', 'strategy', 'management', 'agile', 'scrum', 'cloud', 'analytics', 'optimization', 'automation', 'collaboration', 'communication', 'stakeholder', 'project management', 'problem solving', 'data', 'design', 'testing', 'security', 'performance', 'delivery'];
        $found = [];
        $missing = [];
        foreach ($keywords as $kw) {
            if (strpos($lower, $kw) !== false) {
                $found[] = $kw;
            } else {
                $missing[] = $kw;
            }
        }
        return [
            'found' => array_slice($found, 0, 12),
            'missing' => array_slice($missing, 0, 6),
            'found_count' => count($found),
        ];
    }

    /**
     * Pull real lines from the resume that use weak language or first-person
     * voice and generate a concrete stronger rewrite for each.
     */
    private function findImprovementExamples(string $text): array
    {
        $lines = preg_split('/\r?\n/', $text);
        $examples = [];

        $map = [
            'responsible for' => 'Led',
            'was responsible for' => 'Led',
            'in charge of' => 'Directed',
            'duties included' => 'Delivered',
            'tasked with' => 'Owned',
            'worked on' => 'Developed',
            'assisted with' => 'Supported',
            'helped with' => 'Drove',
            'participated in' => 'Contributed to',
        ];

        foreach ($lines as $line) {
            if (count($examples) >= 3) break;
            $clean = trim(preg_replace('/^[\s\-•*\x{2022}]+/u', '', $line));
            if (mb_strlen($clean) < 18 || mb_strlen($clean) > 180) continue;
            $low = mb_strtolower($clean);

            foreach ($map as $weak => $strong) {
                if (strpos($low, $weak) !== false) {
                    $after = preg_replace('/' . preg_quote($weak, '/') . '/i', $strong, $clean, 1);
                    $after = ucfirst(trim($after));
                    $reason = 'Replaced weak phrase “' . $weak . '” with the action verb “' . $strong . '”';
                    if (!preg_match('/\d/', $after)) {
                        $after = rtrim($after, '.') . ', achieving [add a measurable result].';
                        $reason .= ' and added a quantified result';
                    }
                    $examples[] = ['before' => $clean, 'after' => $after, 'reason' => $reason . '.'];
                    continue 2;
                }
            }
        }

        // Fill remaining slots with first-person fixes.
        if (count($examples) < 3) {
            foreach ($lines as $line) {
                if (count($examples) >= 3) break;
                $clean = trim(preg_replace('/^[\s\-•*\x{2022}]+/u', '', $line));
                if (mb_strlen($clean) < 18 || mb_strlen($clean) > 180) continue;
                if (preg_match('/\b(I|my|me)\b/', $clean)) {
                    $after = preg_replace('/\b(I|We)\s+/', '', $clean);
                    $after = preg_replace('/\b(my|our)\s+/i', '', $after);
                    $after = ucfirst(trim($after));
                    if ($after === '' || $after === $clean) continue;
                    $examples[] = [
                        'before' => $clean,
                        'after' => $after,
                        'reason' => 'Removed first-person voice — resumes read stronger with an implied subject.',
                    ];
                }
            }
        }

        return $examples;
    }

    private function extractPdfText(string $filePath, array &$notes): string
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();
            if (trim($text) === '') {
                $notes[] = 'PDF text extraction returned no searchable text.';
            }
            return $text;
        } catch (\Throwable $exception) {
            $notes[] = 'PDF file could not be parsed cleanly; the file may be a scanned image or contain unsupported formatting.';
            return '';
        }
    }

    private function extractDocxText(string $filePath, array &$notes): string
    {
        $zip = new \ZipArchive();
        if ($zip->open($filePath) === true) {
            $index = $zip->locateName('word/document.xml');
            if ($index !== false) {
                $data = $zip->getFromIndex($index);
                $zip->close();
                if (strpos($data, '<w:tbl') !== false) {
                    $notes[] = 'Document contains tables which may break ATS parsing.';
                }
                return preg_replace('/<[^>]+>/', ' ', $data);
            }
            $zip->close();
            $notes[] = 'Unable to extract document.xml from DOCX.';
            return '';
        }

        $notes[] = 'Unable to open DOCX file.';
        return '';
    }

    private function extractDocText(string $filePath, array &$notes): string
    {
        if (!function_exists('shell_exec')) {
            $notes[] = 'DOC file parsing requires shell access, which is unavailable.';
            return '';
        }

        $escaped = escapeshellarg($filePath);
        $text = trim(shell_exec("antiword {$escaped} 2>nul"));
        if ($text === '') {
            $notes[] = 'Unable to extract text from DOC file; please convert to DOCX or PDF.';
        }
        return $text;
    }

    private function containsAny(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }

    private function countActionVerbs(string $text): int
    {
        $verbs = ['led', 'managed', 'developed', 'built', 'designed', 'delivered', 'optimized', 'launched', 'improved', 'coordinated', 'organized', 'executed', 'implemented', 'drove', 'created', 'increased', 'reduced', 'streamlined', 'mentored', 'negotiated', 'accelerated', 'launched', 'transformed', 'owned', 'spearheaded'];
        $count = 0;
        foreach ($verbs as $verb) {
            if (strpos($text, $verb) !== false) {
                $count++;
            }
        }
        return $count;
    }

    private function countDateRanges(string $text): int
    {
        preg_match_all('/\b\d{4}\b.*?\b\d{4}\b|\b\d{4}–\d{4}\b|\b\d{4}-\d{4}\b/i', $text, $matches);
        return count($matches[0] ?? []);
    }

    private function countExperienceEntries(array $experienceLines): int
    {
        $count = 0;
        foreach ($experienceLines as $line) {
            if (preg_match('/\b\d{4}\b.*?\b\d{4}\b|\b\d{4}–\d{4}\b|\b\d{4}-\d{4}\b/i', $line)) {
                $count++;
            }
            if (preg_match('/\b(at|with|for|as)\b/i', $line) && preg_match('/\b(Manager|Engineer|Developer|Analyst|Specialist|Consultant|Director|Coordinator)\b/i', $line)) {
                $count++;
            }
        }
        return min($count, 12);
    }

    private function detectFirstPerson(string $text): bool
    {
        return preg_match('/\b(I|me|my|we|our|us)\b/i', $text) === 1;
    }

    private function countWeakPhrases(string $text): int
    {
        $weakPhrases = ['responsible for', 'tasked with', 'duties included', 'worked on', 'assisted with', 'helped', 'participated in', 'supporting'];
        $count = 0;
        foreach ($weakPhrases as $phrase) {
            if (strpos($text, $phrase) !== false) {
                $count++;
            }
        }
        return $count;
    }

    private function detectProfessionalHeadline(array $headerLines): bool
    {
        foreach ($headerLines as $line) {
            if (preg_match('/\b(Engineer|Manager|Director|Specialist|Consultant|Analyst|Developer|Designer|Coordinator|Administrator|Architect|Lead|Principal|Senior|VP|Vice President)\b/i', $line)) {
                return true;
            }
        }
        return false;
    }

    private function discoverSections(array $lines, string $lower): array
    {
        $sections = [
            'summary' => false,
            'experience' => false,
            'education' => false,
            'skills' => false,
            'projects' => false,
            'certifications' => false,
            'achievements' => false,
        ];

        foreach ($lines as $line) {
            $clean = trim(mb_strtolower($line));
            if ($clean === '') {
                continue;
            }
            if (!$sections['summary'] && preg_match('/\b(summary|objective|professional summary|about me)\b/i', $clean)) {
                $sections['summary'] = true;
            }
            if (!$sections['experience'] && preg_match('/\b(experience|work experience|professional experience|career history)\b/i', $clean)) {
                $sections['experience'] = true;
            }
            if (!$sections['education'] && preg_match('/\b(education|academic|degree|university|college|certification)\b/i', $clean)) {
                $sections['education'] = true;
            }
            if (!$sections['skills'] && preg_match('/\b(skills|technical skills|key skills|areas of expertise|competencies)\b/i', $clean)) {
                $sections['skills'] = true;
            }
            if (!$sections['projects'] && preg_match('/\b(projects?|product launches?|programs?)\b/i', $clean)) {
                $sections['projects'] = true;
            }
            if (!$sections['certifications'] && preg_match('/\b(certifications?|certificate|licensed)\b/i', $clean)) {
                $sections['certifications'] = true;
            }
            if (!$sections['achievements'] && preg_match('/\b(awards|accomplishments|achievements|recognition|honors)\b/i', $clean)) {
                $sections['achievements'] = true;
            }
        }

        return $sections;
    }

    private function parseSectionBlocks(array $lines): array
    {
        $blocks = [];
        $current = 'header';
        foreach ($lines as $line) {
            $clean = trim($line);
            if ($clean === '') {
                continue;
            }
            if (preg_match('/^(summary|objective|professional summary|about me)$/i', $clean)) {
                $current = 'summary';
                continue;
            }
            if (preg_match('/^(experience|work experience|professional experience|career history)$/i', $clean)) {
                $current = 'experience';
                continue;
            }
            if (preg_match('/^(education|academic background)$/i', $clean)) {
                $current = 'education';
                continue;
            }
            if (preg_match('/^(skills|technical skills|key skills|areas of expertise|competencies)$/i', $clean)) {
                $current = 'skills';
                continue;
            }
            if (preg_match('/^(projects?|product launches?|programs?)$/i', $clean)) {
                $current = 'projects';
                continue;
            }
            if (preg_match('/^(certifications?|certificate|licensed)$/i', $clean)) {
                $current = 'certifications';
                continue;
            }
            if (preg_match('/^(awards|accomplishments|achievements|recognition|honors)$/i', $clean)) {
                $current = 'achievements';
                continue;
            }
            $blocks[$current][] = $clean;
        }
        return $blocks;
    }

    private function detectResumeHeader(array $lines, string $lower): bool
    {
        $headerLines = array_slice($lines, 0, 6);
        $hasName = false;
        $hasTitle = false;
        $hasContact = false;

        foreach ($headerLines as $line) {
            $clean = trim($line);
            if ($clean === '') {
                continue;
            }
            if (!$hasContact && preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $clean)) {
                $hasContact = true;
            }
            if (!$hasContact && preg_match('/(\+?\d[\d\s().-]{6,}\d)/', $clean)) {
                $hasContact = true;
            }
            if (!$hasTitle && preg_match('/\b(Engineer|Manager|Director|Specialist|Consultant|Analyst|Developer|Designer|Coordinator|Administrator|Architect)\b/i', $clean)) {
                $hasTitle = true;
            }
            if (!$hasName && preg_match('/^[A-Z][a-z]+(\s+[A-Z][a-z]+)+$/', $clean)) {
                $hasName = true;
            }
        }

        return $hasContact && ($hasName || $hasTitle);
    }

    private function countBulletPoints(array $lines): int
    {
        $count = 0;
        foreach ($lines as $line) {
            if (preg_match('/^[\s]*[-•*\x{2022}]\s+/u', $line)) {
                $count++;
            }
        }
        return $count;
    }

    private function countAchievementMetrics(string $text): int
    {
        $patterns = [
            '/\b\d+%\b/',
            '/\b(\d+\.?\d*)\s*(million|billion|k|m)\b/i',
            '/\b(\d+\.?\d*)\s*(revenue|growth|sales|customers|clients|users|leads|accounts|costs|savings|time)\b/i',
            '/\b(improved|reduced|increased|decreased|boosted|optimized|delivered)\s+\d+/i',
        ];
        $count = 0;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text)) {
                $count++;
            }
        }
        return $count;
    }

    private function countKeywords(string $text): int
    {
        $keywords = ['leadership', 'strategy', 'product', 'agile', 'scrum', 'cloud', 'aws', 'azure', 'python', 'javascript', 'sql', 'analytics', 'optimization', 'customer', 'stakeholder', 'project', 'delivery', 'compliance'];
        $count = 0;
        foreach ($keywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                $count++;
            }
        }
        return $count;
    }

    private function evaluateSummaryQuality(array $summaryLines, string $lower): int
    {
        if (empty($summaryLines)) {
            return 0;
        }

        $summaryText = implode(' ', $summaryLines);
        $wordCount = str_word_count($summaryText);
        $score = 0;

        if ($wordCount >= 30 && $wordCount <= 130) {
            $score += 5;
        } elseif ($wordCount >= 18) {
            $score += 3;
        } elseif ($wordCount > 0) {
            $score += 1;
        }

        if ($this->containsAny($lower, ['specialize', 'seasoned', 'experienced', 'proven', 'driven', 'skilled', 'focused', 'results', 'impact'])) {
            $score += 1;
        }
        if (preg_match('/\b(I|me|my)\b/i', $summaryText)) {
            $score = max(0, $score - 1);
        }

        return min(5, $score);
    }

    private function detectSkillsSection(array $skillsBlock): bool
    {
        if (empty($skillsBlock)) {
            return false;
        }

        foreach ($skillsBlock as $line) {
            if (preg_match('/[,•\-|;]/', $line)) {
                return true;
            }
        }

        return false;
    }

    private function detectSectionHeadings(array $lines): int
    {
        $count = 0;
        foreach ($lines as $line) {
            $clean = trim($line);
            if ($clean === '') {
                continue;
            }
            if (preg_match('/^(summary|experience|education|skills|projects|certifications|awards|objective|work experience|professional summary|achievements|career history)$/i', $clean)) {
                $count++;
                continue;
            }
            if (preg_match('/^[A-Z][A-Za-z\s]{2,}[A-Z]$/', $clean) && strlen($clean) < 45) {
                $count++;
            }
        }
        return min($count, 12);
    }

    private function detectGraphicsLikeContent(string $text): bool
    {
        // Only flag genuine embedded-image references, not domain words like
        // "chart", "graph" or "image" that legitimately appear in resume content.
        return preg_match('/\.(png|jpe?g|gif|svg|bmp)\b/i', $text) === 1;
    }

    private function detectTableLayout(string $text): bool
    {
        // DOCX table markup is a definite signal.
        if (stripos($text, '<w:tbl') !== false) {
            return true;
        }
        // Otherwise look for genuine columnar rows: several lines that each
        // contain multiple tab stops or pipe separators.
        $rows = 0;
        foreach (preg_split('/\r?\n/', $text) as $line) {
            if (substr_count($line, "\t") >= 2 || substr_count($line, '|') >= 2) {
                $rows++;
            }
        }
        return $rows >= 3;
    }

    private function extractContact(string $text): array
    {
        $contact = [
            'name' => null,
            'title' => null,
            'email' => null,
            'phone' => null,
            'location' => null,
            'linkedin' => null,
            'github' => null,
            'website' => null,
        ];

        // Normalise: collapse repeated spaces inside lines (PDFs often inject them) but keep line breaks.
        $rawLines = preg_split('/\r?\n/', $text);
        $lines = [];
        foreach ($rawLines as $l) {
            $l = trim(preg_replace('/[ \t]{2,}/', ' ', $l));
            if ($l !== '') {
                $lines[] = $l;
            }
        }

        // --- Email ---
        if (preg_match('/[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}/i', $text, $m)) {
            $contact['email'] = strtolower($m[0]);
        }

        // --- Phone --- (require a phone-like token, avoid catching years/date ranges)
        if (preg_match('/(\+?\d{1,3}[\s.\-]?)?(\(?\d{2,4}\)?[\s.\-]?){2,4}\d{2,4}/', $text, $m)) {
            $candidate = trim($m[0]);
            $digits = preg_replace('/\D/', '', $candidate);
            if (strlen($digits) >= 7 && strlen($digits) <= 15) {
                $contact['phone'] = $candidate;
            }
        }

        // --- LinkedIn / GitHub / Website ---
        if (preg_match('#(?:https?://)?(?:www\.)?linkedin\.com/(?:in|pub)/[A-Za-z0-9_\-/%]+#i', $text, $m)) {
            $contact['linkedin'] = rtrim($m[0], '/');
        }
        if (preg_match('#(?:https?://)?(?:www\.)?github\.com/[A-Za-z0-9_\-]+#i', $text, $m)) {
            $contact['github'] = rtrim($m[0], '/');
        }
        if (preg_match('#https?://[A-Za-z0-9.\-]+\.[A-Za-z]{2,}(?:/[A-Za-z0-9_\-./%]*)?#i', $text, $m)) {
            $url = rtrim($m[0], '/');
            if (!preg_match('/linkedin\.com|github\.com|mailto:/i', $url)) {
                $contact['website'] = $url;
            }
        }

        // --- Name --- search the first lines for a human-looking name.
        $headerKeywords = '/\b(resume|cv|curriculum|profile|summary|objective|experience|education|skills|contact|phone|email|address|linkedin|github|portfolio|references)\b/i';
        foreach (array_slice($lines, 0, 10) as $line) {
            if (strlen($line) < 3 || strlen($line) > 50) continue;
            if (preg_match($headerKeywords, $line)) continue;
            if (preg_match('/[@\d]/', $line)) continue; // skip emails / phones / addresses
            $words = preg_split('/\s+/', $line);
            if (count($words) < 2 || count($words) > 4) continue;

            // Title Case "John Doe"  OR  ALL CAPS "JOHN DOE"
            if (preg_match('/^[A-Z][a-z\'.\-]+(\s+[A-Z][a-z\'.\-]+){1,3}$/', $line)
                || preg_match('/^[A-Z][A-Z\'.\-]+(\s+[A-Z][A-Z\'.\-]+){1,3}$/', $line)) {
                $contact['name'] = $this->titleCase($line);
                break;
            }
        }

        // --- Professional title / headline --- usually the line just after the name.
        $titlePattern = '/\b(Engineer|Developer|Manager|Director|Designer|Analyst|Consultant|Specialist|Architect|Administrator|Coordinator|Lead|Scientist|Officer|Executive|Accountant|Marketer|Strategist|Recruiter|Researcher|Programmer|Intern|Associate|Founder|Freelancer)\b/i';
        foreach (array_slice($lines, 0, 8) as $line) {
            if ($contact['name'] && stripos($line, $contact['name']) !== false) continue;
            if (preg_match('/[@]/', $line) || strlen($line) > 60) continue;
            if (preg_match($titlePattern, $line)) {
                $contact['title'] = $line;
                break;
            }
        }

        // --- Location --- "City, ST" / "City, Country" or after a Location: label.
        if (preg_match('/\b(?:location|address|based in|city)\s*[:\-]\s*([A-Za-z][A-Za-z .\-]+,\s*[A-Za-z][A-Za-z .]+)/i', $text, $m)) {
            $contact['location'] = trim($m[1]);
        } elseif (preg_match('/\b([A-Z][a-z]+(?:\s[A-Z][a-z]+)?),\s*([A-Z]{2}|[A-Z][a-z]+)\b/', implode("\n", array_slice($lines, 0, 12)), $m)) {
            // Avoid mistaking a name for a location
            if (!$contact['name'] || stripos($m[0], $contact['name']) === false) {
                $contact['location'] = trim($m[0]);
            }
        }

        return $contact;
    }

    private function titleCase(string $value): string
    {
        return preg_replace_callback('/[A-Za-z\']+/', fn($w) => ucfirst(strtolower($w[0])), $value);
    }

    /**
     * Detect skills grouped by category. Returns a flat de-duplicated list,
     * plus the grouped map under the '_grouped' key for richer display.
     */
    private function extractSkills(string $text): array
    {
        $catalog = [
            'Languages' => [
                'PHP' => '/\bPHP\b/i', 'JavaScript' => '/\b(JavaScript|JS)\b/i', 'TypeScript' => '/\bTypeScript\b/i',
                'Python' => '/\bPython\b/i', 'Java' => '/\bJava\b(?!Script)/i', 'C#' => '/\bC#|\.NET\b/i',
                'C++' => '/\bC\+\+/i', 'Go' => '/\b(Golang|Go)\b/i', 'Ruby' => '/\bRuby\b/i',
                'Swift' => '/\bSwift\b/i', 'Kotlin' => '/\bKotlin\b/i', 'Rust' => '/\bRust\b/i',
                'SQL' => '/\bSQL\b/i', 'HTML' => '/\bHTML5?\b/i', 'CSS' => '/\bCSS3?\b/i',
            ],
            'Frameworks' => [
                'Laravel' => '/\bLaravel\b/i', 'React' => '/\bReact(?:\.js)?\b/i', 'Vue.js' => '/\bVue(?:\.js)?\b/i',
                'Angular' => '/\bAngular\b/i', 'Node.js' => '/\bNode(?:\.js)?\b/i', 'Express' => '/\bExpress(?:\.js)?\b/i',
                'Django' => '/\bDjango\b/i', 'Flask' => '/\bFlask\b/i', 'Spring' => '/\bSpring\b/i',
                'Next.js' => '/\bNext(?:\.js)?\b/i', 'Tailwind' => '/\bTailwind\b/i', 'Bootstrap' => '/\bBootstrap\b/i',
                'jQuery' => '/\bjQuery\b/i', 'CodeIgniter' => '/\bCodeIgniter\b/i',
            ],
            'Databases' => [
                'MySQL' => '/\bMySQL\b/i', 'PostgreSQL' => '/\b(PostgreSQL|Postgres)\b/i', 'MongoDB' => '/\bMongoDB\b/i',
                'Redis' => '/\bRedis\b/i', 'SQLite' => '/\bSQLite\b/i', 'Oracle' => '/\bOracle\b/i',
                'Firebase' => '/\bFirebase\b/i', 'Elasticsearch' => '/\bElasticsearch\b/i',
            ],
            'Cloud & DevOps' => [
                'AWS' => '/\bAWS\b/i', 'Azure' => '/\bAzure\b/i', 'GCP' => '/\b(GCP|Google Cloud)\b/i',
                'Docker' => '/\bDocker\b/i', 'Kubernetes' => '/\b(Kubernetes|K8s)\b/i', 'Git' => '/\bGit(?:Hub|Lab)?\b/i',
                'CI/CD' => '/\b(CI\/CD|Jenkins|GitHub Actions)\b/i', 'Terraform' => '/\bTerraform\b/i',
                'Linux' => '/\bLinux\b/i', 'Nginx' => '/\bNginx\b/i',
            ],
            'Tools & Methods' => [
                'REST API' => '/\bREST(?:ful)?\b/i', 'GraphQL' => '/\bGraphQL\b/i', 'Agile' => '/\bAgile\b/i',
                'Scrum' => '/\bScrum\b/i', 'Jira' => '/\bJira\b/i', 'Figma' => '/\bFigma\b/i',
                'Photoshop' => '/\bPhotoshop\b/i', 'Excel' => '/\bExcel\b/i', 'Power BI' => '/\bPower ?BI\b/i',
                'Tableau' => '/\bTableau\b/i',
            ],
        ];

        $grouped = [];
        $flat = [];
        foreach ($catalog as $category => $patterns) {
            foreach ($patterns as $skill => $pattern) {
                if (preg_match($pattern, $text)) {
                    $grouped[$category][] = $skill;
                    $flat[] = $skill;
                }
            }
        }

        return [
            'flat' => array_values(array_unique($flat)),
            'grouped' => $grouped,
        ];
    }
}
