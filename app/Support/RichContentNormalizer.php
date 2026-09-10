<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

class RichContentNormalizer
{
    public static function normalize(?string $html): ?string
    {
        $html = self::normalizeLegacyFigures($html);

        if (blank($html) || ! str_contains(strtolower($html), '<li')) {
            return $html;
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previousUseInternalErrors = libxml_use_internal_errors(true);

        $document->loadHTML(
            '<?xml encoding="UTF-8"><div data-rich-content-root="true">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousUseInternalErrors);

        $xpath = new DOMXPath($document);

        /** @var DOMElement $listItem */
        foreach ($xpath->query('//li') as $listItem) {
            self::wrapListItemInlineContent($document, $listItem);
        }

        $root = $xpath->query('//*[@data-rich-content-root="true"]')->item(0);

        if (! $root instanceof DOMElement) {
            return $html;
        }

        $normalizedHtml = '';

        foreach ($root->childNodes as $childNode) {
            $normalizedHtml .= $document->saveHTML($childNode);
        }

        return $normalizedHtml;
    }

    public static function normalizeLegacyFigures(?string $html): ?string
    {
        if (blank($html) || ! str_contains(strtolower($html), '<figure')) {
            return $html;
        }

        $html = preg_replace('/<figure\b([^>]*)>/i', '<div data-rich-content-figure="true"$1>', $html);
        $html = preg_replace('/<\/figure>/i', '</div>', $html);
        $html = preg_replace('/<figcaption\b([^>]*)>/i', '<p data-rich-content-caption="true"$1>', $html);

        return preg_replace('/<\/figcaption>/i', '</p>', $html);
    }

    private static function wrapListItemInlineContent(DOMDocument $document, DOMElement $listItem): void
    {
        $firstMeaningfulChild = self::firstMeaningfulChild($listItem);

        if ($firstMeaningfulChild instanceof DOMElement && strtolower($firstMeaningfulChild->tagName) === 'p') {
            return;
        }

        $paragraph = $document->createElement('p');
        $listItem->insertBefore($paragraph, $listItem->firstChild);

        while (($node = $paragraph->nextSibling) instanceof DOMNode) {
            if ($node instanceof DOMElement && self::isBlockElement($node)) {
                break;
            }

            $paragraph->appendChild($node);
        }
    }

    private static function firstMeaningfulChild(DOMElement $element): ?DOMNode
    {
        foreach ($element->childNodes as $childNode) {
            if ($childNode->nodeType === XML_TEXT_NODE && trim($childNode->textContent) === '') {
                continue;
            }

            return $childNode;
        }

        return null;
    }

    private static function isBlockElement(DOMElement $element): bool
    {
        return in_array(strtolower($element->tagName), [
            'blockquote', 'div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ol', 'p', 'pre', 'table', 'ul',
        ], true);
    }
}
