<?php

return [
    /**
     * Number of days to cache the locale's word-list, rather than reading from file each time
     */
    'cacheDays' => 7,
    /**
     * Override Laravel's set locale
     */
    'locale' => null,
    /**
     * Include extra words as profanity, all locales should be lowercase with _ (underscores) if needed
     */
    'includingWords' => [
        'en' => [],
    ],
    /**
     * Exclude these words profanity, all locales should be lowercase with _ (underscores) if needed
     * Note that words may match multiple derivations of profanity words, so you should include them all
     */
    'excludingWords' => [
        'en' => [],
    ],
];
