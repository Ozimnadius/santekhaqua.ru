<?php
// Site-specific metadata. Values come from the same component result as the visible cards.
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    return;
}

function santekhaquaSchemaText($value): string
{
    return trim(preg_replace('/\s+/u', ' ', strip_tags(html_entity_decode((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
}

function santekhaquaSchemaEscape($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function santekhaquaSchemaUrl($value): string
{
    $value = html_entity_decode(trim((string)$value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    if ($value === '') {
        return '';
    }
    if (strpos($value, '//') === 0) {
        return 'https:' . $value;
    }
    if (preg_match('~^https?://~i', $value)) {
        return $value;
    }
    if ($value[0] === '/') {
        return 'https://santekhaqua.ru' . $value;
    }
    return '';
}

function santekhaquaSchemaPicture($picture): string
{
    if (is_array($picture)) {
        return santekhaquaSchemaUrl($picture['SRC'] ?? $picture['src'] ?? '');
    }
    if (is_numeric($picture) && (int)$picture > 0) {
        return santekhaquaSchemaUrl(CFile::GetPath((int)$picture));
    }
    return santekhaquaSchemaUrl($picture);
}

function santekhaquaSchemaBrand(array $item): string
{
    // Linked brands already have their own Brand object in the Aspro template.
    if (!empty($item['BRAND_ITEM'])) {
        return '';
    }
    $property = $item['PROPERTIES']['BRAND'] ?? [];
    if (!in_array($property['PROPERTY_TYPE'] ?? '', ['S', 'L'], true)
        || !empty($property['USER_TYPE']) || !empty($property['LINK_IBLOCK_ID'])) {
        return '';
    }
    $value = $property['~VALUE'] ?? $property['VALUE'] ?? '';
    if (is_array($value)) {
        $value = implode(', ', array_filter($value, 'is_scalar'));
    }
    return santekhaquaSchemaText($value);
}

function santekhaquaSchemaCatalog(array $result, array $params): string
{
    // Only the main catalog listing, never recommendation sliders or detail-page lists.
    if (($params['SANTEKHAQUA_MAIN_SCHEMA'] ?? '') === 'Y' && ($params['AJAX_REQUEST'] ?? '') === 'Y') {
        return ''; // Keep one catalog in the initial document when another tab loads.
    }
    if ((int)($params['IBLOCK_ID'] ?? 0) !== 25
        || ($params['SLIDE_ITEMS'] ?? false) || ($params['GIFT_ITEMS'] ?? false)
        || (($params['IS_CATALOG_PAGE'] ?? '') !== 'Y' && ($params['SANTEKHAQUA_MAIN_SCHEMA'] ?? '') !== 'Y') || empty($result['ITEMS'])) {
        return '';
    }
    $offers = [];
    foreach ($result['ITEMS'] as $item) {
        $pricedItem = $item;
        if (!empty($item['OFFERS'])) {
            $pricedItem = $item['OFFERS'][$item['OFFERS_SELECTED'] ?? 0] ?? [];
        }
        $price = $pricedItem['MIN_PRICE'] ?? [];
        $amount = $price['DISCOUNT_VALUE'] ?? $price['VALUE'] ?? null;
        $currency = $price['CURRENCY'] ?? '';
        // Do not manufacture zero prices or mark products with missing prices as offers.
        if (!is_numeric($amount) || (float)$amount <= 0 || !preg_match('/^[A-Z]{3}$/', $currency)) {
            continue;
        }
        $name = santekhaquaSchemaText($pricedItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] ?? $pricedItem['NAME'] ?? $item['NAME'] ?? '');
        $url = santekhaquaSchemaUrl($pricedItem['DETAIL_PAGE_URL'] ?? $item['DETAIL_PAGE_URL'] ?? '');
        $image = santekhaquaSchemaPicture($pricedItem['PREVIEW_PICTURE'] ?? '')
            ?: santekhaquaSchemaPicture($pricedItem['DETAIL_PICTURE'] ?? '')
            ?: santekhaquaSchemaPicture($item['PREVIEW_PICTURE'] ?? '')
            ?: santekhaquaSchemaPicture($item['DETAIL_PICTURE'] ?? '');
        if ($name === '' || $url === '' || $image === '') {
            continue;
        }
        $description = santekhaquaSchemaText($pricedItem['~PREVIEW_TEXT'] ?? $pricedItem['PREVIEW_TEXT'] ?? '');
        if ($description === '') {
            $description = santekhaquaSchemaText($item['~PREVIEW_TEXT'] ?? $item['PREVIEW_TEXT'] ?? '');
        }
        $inStock = CMax::GetTotalCount($pricedItem, $params) > 0;
        $offers[] = [
            'url' => $url, 'name' => $name, 'description' => $description ?: $name,
            'image' => $image, 'availability' => 'https://schema.org/' . ($inStock ? 'InStock' : 'OutOfStock'),
            'price' => rtrim(rtrim(number_format((float)$amount, 4, '.', ''), '0'), '.'),
            'priceCurrency' => $currency,
        ];
    }
    if (!$offers) {
        return '';
    }
    $name = santekhaquaSchemaText($result['NAME'] ?? $result['SECTION']['NAME'] ?? $params['TITLE_BLOCK'] ?? '');
    if ($name === '' && ($params['SANTEKHAQUA_MAIN_SCHEMA'] ?? '') === 'Y') {
        $name = santekhaquaSchemaText($params['TITLE_BLOCK'] ?? '');
    }
    if ($name === '') {
        return '';
    }
    $description = santekhaquaSchemaText($result['~DESCRIPTION'] ?? $result['DESCRIPTION'] ?? '');
    $image = santekhaquaSchemaPicture($result['PICTURE'] ?? '') ?: $offers[0]['image'];
    $html = '<div class="santekhaqua-catalog-schema" itemscope itemtype="https://schema.org/OfferCatalog">';
    foreach (['name' => $name, 'description' => $description ?: $name, 'image' => $image] as $key => $value) {
        $html .= in_array($key, ['url', 'image', 'availability'], true)
                ? '<link itemprop="' . $key . '" href="' . santekhaquaSchemaEscape($value) . '">'
                : '<meta itemprop="' . $key . '" content="' . santekhaquaSchemaEscape($value) . '">';
    }
    foreach ($offers as $offer) {
        $html .= '<div itemprop="itemListElement" itemscope itemtype="https://schema.org/Offer">';
        foreach ($offer as $key => $value) {
            $html .= in_array($key, ['url', 'image', 'availability'], true)
                ? '<link itemprop="' . $key . '" href="' . santekhaquaSchemaEscape($value) . '">'
                : '<meta itemprop="' . $key . '" content="' . santekhaquaSchemaEscape($value) . '">';
        }
        $html .= '</div>';
    }
    return $html . '</div>';
}
