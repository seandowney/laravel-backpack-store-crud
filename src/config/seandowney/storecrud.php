<?php
// order statuses must match the numbers in the array below
if (!defined('ORDER_PENDING')) {
    define('ORDER_PENDING', 1);
    define('ORDER_PROCESSING', 2);
    define('ORDER_DISPATCHED', 3);
    define('ORDER_REFUNDED', 4);
}

return [

    /*
    | SeanDowney/StoreCrud configs.
    */

    'currency' => [
        'symbol' => '€',
        'code'   => 'EUR',
    ],

    // You can make sure all your URLs use this prefix by using the backpack_url() helper instead of url()
    'route_prefix' => 'store',

    'order_statuses' => [
        1 => 'Pending',
        2 => 'Processing',
        3 => 'Dispatched',
        4 => 'Refunded',
    ],

    'countries' => [
        "IE" => "Ireland",
        "NI" => "Northern Ireland",
        "GB" => "United Kingdom",
        "US" => "United States",
        "AF" => "Afghanistan",
        "AX" => "Åland Islands",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia, Plurinational State of",
        "BQ" => "Bonaire, Sint Eustatius and Saba",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, the Democratic Republic of the",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Côte d’Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CW" => "Curaçao",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GG" => "Guernsey",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and McDonald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran, Islamic Republic of",
        "IQ" => "Iraq",
        "IM" => "Isle of Man",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JE" => "Jersey",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People’s Republic of",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People’s Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia, The Former Yugoslav Republic of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States of",
        "MD" => "Moldova, Republic of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestine, State of",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Réunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "BL" => "Saint Barthélemy",
        "SH" => "Saint Helena, Ascension and Tristan da Cunha",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "MF" => "Saint Martin (French part)",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SX" => "Sint Maarten (Dutch part)",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "SS" => "South Sudan",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Province of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic of",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela, Bolivarian Republic of",
        "VN" => "Vietnam",
        "VG" => "Virgin Islands, British",
        "VI" => "Virgin Islands, U.S.",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"
    ],

    'continents' => [
        "BE" => "EU", "BF" => "AF", "BG" => "EU", "BA" => "EU", "BB" => "NA", "WF" => "OC", "BL" => "NA", "BM" => "NA", "BN" => "AS", "BO" => "SA", "BH" => "AS", "BI" => "AF", "BJ" => "AF", "BT" => "AS", "JM" => "NA", "BV" => "AN", "BW" => "AF", "WS" => "OC", "BQ" => "NA", "BR" => "SA", "BS" => "NA", "JE" => "EU", "BY" => "EU", "BZ" => "NA", "RU" => "EU", "RW" => "AF", "RS" => "EU", "TL" => "OC", "RE" => "AF", "TM" => "AS", "TJ" => "AS", "RO" => "EU", "TK" => "OC", "GW" => "AF", "GU" => "OC", "GT" => "NA", "GS" => "AN", "GR" => "EU", "GQ" => "AF", "GP" => "NA", "JP" => "AS", "GY" => "SA", "GG" => "EU", "GF" => "SA", "GE" => "AS", "GD" => "NA", "GB" => "EU", "GA" => "AF", "SV" => "NA", "GN" => "AF", "GM" => "AF", "GL" => "NA", "GI" => "EU", "GH" => "AF", "OM" => "AS", "TN" => "AF", "JO" => "AS", "HR" => "EU", "HT" => "NA", "HU" => "EU", "HK" => "AS", "HN" => "NA", "HM" => "AN", "VE" => "SA", "PR" => "NA", "PS" => "AS", "PW" => "OC", "PT" => "EU", "SJ" => "EU", "PY" => "SA", "IQ" => "AS", "PA" => "NA", "PF" => "OC", "PG" => "OC", "PE" => "SA", "PK" => "AS", "PH" => "AS", "PN" => "OC", "PL" => "EU", "PM" => "NA", "ZM" => "AF", "EH" => "AF", "EE" => "EU", "EG" => "AF", "ZA" => "AF", "EC" => "SA", "IT" => "EU", "VN" => "AS", "SB" => "OC", "ET" => "AF", "SO" => "AF", "ZW" => "AF", "SA" => "AS", "ES" => "EU", "ER" => "AF", "ME" => "EU", "MD" => "EU", "MG" => "AF", "MF" => "NA", "MA" => "AF", "MC" => "EU", "UZ" => "AS", "MM" => "AS", "ML" => "AF", "MO" => "AS", "MN" => "AS", "MH" => "OC", "MK" => "EU", "MU" => "AF", "MT" => "EU", "MW" => "AF", "MV" => "AS", "MQ" => "NA", "MP" => "OC", "MS" => "NA", "MR" => "AF", "IM" => "EU", "UG" => "AF", "TZ" => "AF", "MY" => "AS", "MX" => "NA", "IL" => "AS", "FR" => "EU", "IO" => "AS", "SH" => "AF", "FI" => "EU", "FJ" => "OC", "FK" => "SA", "FM" => "OC", "FO" => "EU", "NI" => "NA", "NL" => "EU", "NO" => "EU", "NA" => "AF", "VU" => "OC", "NC" => "OC", "NE" => "AF", "NF" => "OC", "NG" => "AF", "NZ" => "OC", "NP" => "AS", "NR" => "OC", "NU" => "OC", "CK" => "OC", "XK" => "EU", "CI" => "AF", "CH" => "EU", "CO" => "SA", "CN" => "AS", "CM" => "AF", "CL" => "SA", "CC" => "AS", "CA" => "NA", "CG" => "AF", "CF" => "AF", "CD" => "AF", "CZ" => "EU", "CY" => "EU", "CX" => "AS", "CR" => "NA", "CW" => "NA", "CV" => "AF", "CU" => "NA", "SZ" => "AF", "SY" => "AS", "SX" => "NA", "KG" => "AS", "KE" => "AF", "SS" => "AF", "SR" => "SA", "KI" => "OC", "KH" => "AS", "KN" => "NA", "KM" => "AF", "ST" => "AF", "SK" => "EU", "KR" => "AS", "SI" => "EU", "KP" => "AS", "KW" => "AS", "SN" => "AF", "SM" => "EU", "SL" => "AF", "SC" => "AF", "KZ" => "AS", "KY" => "NA", "SG" => "AS", "SE" => "EU", "SD" => "AF", "DO" => "NA", "DM" => "NA", "DJ" => "AF", "DK" => "EU", "VG" => "NA", "DE" => "EU", "YE" => "AS", "DZ" => "AF", "US" => "NA", "UY" => "SA", "YT" => "AF", "UM" => "OC", "LB" => "AS", "LC" => "NA", "LA" => "AS", "TV" => "OC", "TW" => "AS", "TT" => "NA", "TR" => "AS", "LK" => "AS", "LI" => "EU", "LV" => "EU", "TO" => "OC", "LT" => "EU", "LU" => "EU", "LR" => "AF", "LS" => "AF", "TH" => "AS", "TF" => "AN", "TG" => "AF", "TD" => "AF", "TC" => "NA", "LY" => "AF", "VA" => "EU", "VC" => "NA", "AE" => "AS", "AD" => "EU", "AG" => "NA", "AF" => "AS", "AI" => "NA", "VI" => "NA", "IS" => "EU", "IR" => "AS", "AM" => "AS", "AL" => "EU", "AO" => "AF", "AQ" => "AN", "AS" => "OC", "AR" => "SA", "AU" => "OC", "AT" => "EU", "AW" => "NA", "IN" => "AS", "AX" => "EU", "AZ" => "AS", "IE" => "EU", "ID" => "AS", "UA" => "EU"
    ],

    /**
     * Delivery Countries
     */
    'delivery' => [
        'default' => 'IE',

        'countries' => [
            'IE' => 'Ireland',
            'NI' => 'Northern Ireland',
            'GB' => 'Great Britain',
            'US' => 'United States of America',
            'AU' => 'Australia',
            'EU' => 'Rest of Europe',
            'OT' => 'Rest of World',
        ],
    ],
];
