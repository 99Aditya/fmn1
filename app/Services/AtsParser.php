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

        return [
            'score' => $analysis['score'],
            'details' => $analysis['details'],
            'sections' => $analysis['sections'],
            'formatting' => $analysis['formatting'],
            'suggestions' => $analysis['suggestions'],
            'notes' => $notes,
            'raw' => mb_substr($text, 0, 5000), 
            'breakdown' => $analysis['breakdown'],
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
            'tables' => preg_match('/\t|\|\s*\w+|\bcolumns?\b|<w:tbl>/i', $text) === 1,
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

        return [
            'score' => $score,
            'details' => $details,
            'sections' => $sections,
            'formatting' => $formatting,
            'suggestions' => array_values(array_unique($suggestions)),
            'breakdown' => $breakdown,
        ];
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
        if (preg_match('/(\.png|\.jpg|\.jpeg|\.gif|logo|graph|chart|infographic)/i', $text)) {
            return true;
        }
        return preg_match('/\b(image|logo|graphic|chart|diagram)\b/i', $text) === 1;
    }
}
