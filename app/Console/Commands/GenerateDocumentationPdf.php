<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\CommonMark\CommonMarkConverter;
use Dompdf\Dompdf;
use Dompdf\Options;

class GenerateDocumentationPdf extends Command
{
    protected $signature   = 'docs:pdf';
    protected $description = 'Génère DOCUMENTATION.pdf depuis DOCUMENTATION.md avec les couleurs CFM';

    public function handle(): int
    {
        $mdPath  = base_path('DOCUMENTATION.md');
        $outPath = base_path('DOCUMENTATION.pdf');

        if (!file_exists($mdPath)) {
            $this->error('DOCUMENTATION.md introuvable.');
            return self::FAILURE;
        }

        $this->info('Conversion Markdown → HTML…');

        $converter = new CommonMarkConverter([
            'html_input'         => 'allow',
            'allow_unsafe_links' => false,
        ]);

        $rawMd    = file_get_contents($mdPath);
        $bodyHtml = $converter->convert($rawMd)->getContent();
        $bodyHtml = $this->postProcess($bodyHtml);

        $this->info('Génération du PDF (dompdf)…');

        $date = date('d/m/Y');
        $html = $this->buildHtml($bodyHtml, $date);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        $options->set('dpi', 150);
        $options->set('defaultMediaType', 'print');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($outPath, $dompdf->output());

        $this->info("PDF généré : {$outPath}");
        return self::SUCCESS;
    }

    private function postProcess(string $html): string
    {
        $html = str_replace('<table>', '<table class="doc-table">', $html);
        $html = str_replace('<pre>', '<pre class="code-block">', $html);
        return $html;
    }

    private function buildHtml(string $body, string $date): string
    {
        $css = '
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 9.5pt;
    line-height: 1.65;
    color: #1e293b;
    background: #fff;
}

@page { margin: 22mm 18mm 20mm 18mm; }

/* ── Page de couverture ── */
.cover {
    page-break-after: always;
    width: 100%;
    height: 277mm;
    background: #003f87;
    position: relative;
}

.cover-bar-top    { background: #f97316; height: 8mm; width: 100%; }
.cover-bar-bottom { background: rgba(0,0,0,.2); padding: 5mm 25mm;
                    position: absolute; bottom: 0; left: 0; right: 0; }

.cover-content { padding: 30mm 25mm; }

.cover-logo {
    display: inline-block;
    background: #fff;
    border-radius: 10pt;
    padding: 8pt 18pt;
    margin-bottom: 12mm;
}
.cover-logo span { font-size: 26pt; font-weight: bold; color: #003f87; }

.cover-org  { font-size: 9pt; color: rgba(255,255,255,.6); margin-bottom: 14mm; }
.cover-h1   { font-size: 30pt; font-weight: bold; color: #fff; line-height: 1.15; margin-bottom: 5mm; }
.cover-h2   { font-size: 13pt; color: #f97316; font-weight: bold; margin-bottom: 9mm; }
.cover-desc { font-size: 9.5pt; color: rgba(255,255,255,.72); line-height: 1.75; max-width: 130mm; margin-bottom: 16mm; }
.cover-rule { border: none; border-top: 2pt solid #f97316; width: 36mm; margin-bottom: 9mm; }

.cover-meta { font-size: 8.5pt; color: rgba(255,255,255,.7); line-height: 1.9; }
.cover-meta strong { color: #fff; }

.cover-footer { font-size: 7.5pt; color: rgba(255,255,255,.45); }

/* ── En-tête page courante ── */
.page-header {
    position: fixed; top: -16mm; left: 0; right: 0; height: 12mm;
    border-bottom: 1.5pt solid #f97316;
    padding-bottom: 3mm;
    display: table; width: 100%;
}
.ph-left  { display: table-cell; font-size: 7.5pt; color: #003f87; font-weight: bold; vertical-align: bottom; }
.ph-right { display: table-cell; font-size: 7.5pt; color: #94a3b8; text-align: right; vertical-align: bottom; }

/* ── Pied de page ── */
.page-footer {
    position: fixed; bottom: -14mm; left: 0; right: 0; height: 10mm;
    border-top: 1pt solid #e2e8f0; padding-top: 3mm;
    display: table; width: 100%;
}
.pf-left  { display: table-cell; font-size: 7pt; color: #94a3b8; vertical-align: top; }
.pf-right { display: table-cell; font-size: 7pt; color: #94a3b8; text-align: right; vertical-align: top; }

/* ── Titres ── */
h1 {
    font-size: 17pt; color: #003f87; font-weight: bold;
    margin-top: 10mm; margin-bottom: 4mm;
    padding-bottom: 3mm; border-bottom: 2pt solid #f97316;
    page-break-after: avoid;
}
h2 {
    font-size: 12.5pt; color: #003f87; font-weight: bold;
    margin-top: 8mm; margin-bottom: 3mm;
    padding-left: 4mm; border-left: 4pt solid #f97316;
    page-break-after: avoid;
}
h3 {
    font-size: 10pt; color: #0f172a; font-weight: bold;
    margin-top: 5mm; margin-bottom: 2mm;
    page-break-after: avoid;
}
h4 {
    font-size: 9pt; color: #475569; font-weight: bold;
    margin-top: 3mm; margin-bottom: 1.5mm;
    page-break-after: avoid;
}

p  { margin-bottom: 3mm; }
ul, ol { margin-left: 6mm; margin-bottom: 3mm; }
li { margin-bottom: 1.5mm; }
hr { border: none; border-top: 1pt solid #e2e8f0; margin: 5mm 0; }
a  { color: #003f87; text-decoration: none; }
strong { color: #0f172a; }

/* ── Tableaux ── */
.doc-table {
    width: 100%; border-collapse: collapse;
    margin-bottom: 5mm; font-size: 8pt;
    page-break-inside: avoid;
}
.doc-table th {
    background: #003f87; color: #fff; font-weight: bold;
    padding: 2.5mm 3.5mm; text-align: left; border: 1pt solid #002d63;
}
.doc-table td {
    padding: 2mm 3.5mm; border: 1pt solid #e2e8f0; vertical-align: top;
}
.doc-table tr:nth-child(even) td { background: #f8fafc; }

/* ── Code ── */
code {
    font-family: DejaVu Sans Mono, monospace; font-size: 7.5pt;
    background: #f1f5f9; color: #003f87;
    padding: 0.5mm 1.5mm; border-radius: 2pt;
}
.code-block {
    font-family: DejaVu Sans Mono, monospace; font-size: 7pt;
    background: #0f172a; color: #e2e8f0;
    padding: 3.5mm 4.5mm; border-radius: 4pt;
    border-left: 3pt solid #f97316;
    margin-bottom: 4mm; white-space: pre-wrap; word-wrap: break-word;
    page-break-inside: avoid;
}
.code-block code { background: transparent; color: #e2e8f0; padding: 0; font-size: 7pt; }

.doc-body { padding: 0; }
';

        return <<<HTMLDOC
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>{$css}</style>
</head>
<body>

<!-- COUVERTURE -->
<div class="cover">
    <div class="cover-bar-top"></div>
    <div class="cover-content">
        <div class="cover-logo"><span>CFM</span></div>
        <p class="cover-org">Campus Formations et M&eacute;tiers &mdash; Bobigny 93</p>
        <div class="cover-h1">Mini LMS<br>P&eacute;dagogique</div>
        <div class="cover-h2">Documentation Technique</div>
        <p class="cover-desc">
            Plateforme de gestion de l&rsquo;apprentissage d&eacute;velopp&eacute;e avec Laravel&nbsp;12,
            Bootstrap&nbsp;5 et int&eacute;gration IA via OpenRouter.<br>
            Gestion des formations, chapitres, quiz, apprenants et notes.
        </p>
        <hr class="cover-rule">
        <div class="cover-meta">
            <strong>Version</strong> 1.0 &nbsp;&mdash;&nbsp; <strong>Date</strong> {$date}<br>
            <strong>Framework</strong> Laravel 12 &nbsp;&mdash;&nbsp; <strong>Base de donn&eacute;es</strong> SQLite<br>
            <strong>Interface</strong> Bootstrap 5.3 &nbsp;&mdash;&nbsp; <strong>IA</strong> OpenRouter / Claude 3 Haiku
        </div>
    </div>
    <div class="cover-bar-bottom">
        <span class="cover-footer">Campus Formations et M&eacute;tiers &mdash; Bobigny, Seine-Saint-Denis (93) &mdash; Documentation confidentielle &copy; {$date}</span>
    </div>
</div>

<!-- EN-TÊTE -->
<div class="page-header">
    <span class="ph-left">CFM &mdash; Mini LMS P&eacute;dagogique</span>
    <span class="ph-right">Documentation Technique v1.0</span>
</div>

<!-- PIED DE PAGE -->
<div class="page-footer">
    <span class="pf-left">Campus Formations et M&eacute;tiers &mdash; Bobigny 93</span>
    <span class="pf-right">Page <span class="pagenum"></span></span>
</div>

<!-- CORPS -->
<div class="doc-body">
{$body}
</div>

</body>
</html>
HTMLDOC;
    }
}
