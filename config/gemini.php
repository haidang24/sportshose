<?php
// Gemini configuration
// Read API key from environment. Do NOT commit real keys.
define('GEMINI_API_KEY', getenv('GEMINI_API_KEY') ?: '');

// Default model; can be overridden by request param if needed
define('GEMINI_DEFAULT_MODEL', 'gemini-1.5-flash-latest');

// Optional safety tuning
define('GEMINI_API_BASE', 'https://generativelanguage.googleapis.com/v1beta');


