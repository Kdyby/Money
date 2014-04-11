
-- this file was generated by Kdyby/Money at 2014-04-11 13:59:53
-- @see https://github.com/Kdyby/Money/blob/master/bin/generate-currency-table.php

SET NAMES utf8;
SET foreign_key_checks = 0;

CREATE TABLE IF NOT EXISTS `currencies` (
  `code` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` char(5) NOT NULL,
  `decimals` smallint(3) NOT NULL,
  `countries` text NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `currencies` (`code`, `name`, `number`, `decimals`, `countries`) VALUES
('AED', 'UAE Dirham', '784', '2', '[\"UNITED ARAB EMIRATES\"]'),
('AFN', 'Afghani', '971', '2', '[\"AFGHANISTAN\"]'),
('ALL', 'Lek', '008', '2', '[\"ALBANIA\"]'),
('AMD', 'Armenian Dram', '051', '2', '[\"ARMENIA\"]'),
('ANG', 'Netherlands Antillean Guilder', '532', '2', '[\"CURA\\u00c7AO\",\"SINT MAARTEN (DUTCH PART)\"]'),
('AOA', 'Kwanza', '973', '2', '[\"ANGOLA\"]'),
('ARS', 'Argentine Peso', '032', '2', '[\"ARGENTINA\"]'),
('AUD', 'Australian Dollar', '036', '2', '[\"AUSTRALIA\",\"CHRISTMAS ISLAND\",\"COCOS (KEELING) ISLANDS\",\"HEARD ISLAND AND McDONALD ISLANDS\",\"KIRIBATI\",\"NAURU\",\"NORFOLK ISLAND\",\"TUVALU\"]'),
('AWG', 'Aruban Florin', '533', '2', '[\"ARUBA\"]'),
('AZN', 'Azerbaijanian Manat', '944', '2', '[\"AZERBAIJAN\"]'),
('BAM', 'Convertible Mark', '977', '2', '[\"BOSNIA AND HERZEGOVINA\"]'),
('BBD', 'Barbados Dollar', '052', '2', '[\"BARBADOS\"]'),
('BDT', 'Taka', '050', '2', '[\"BANGLADESH\"]'),
('BGN', 'Bulgarian Lev', '975', '2', '[\"BULGARIA\"]'),
('BHD', 'Bahraini Dinar', '048', '3', '[\"BAHRAIN\"]'),
('BIF', 'Burundi Franc', '108', '0', '[\"BURUNDI\"]'),
('BMD', 'Bermudian Dollar', '060', '2', '[\"BERMUDA\"]'),
('BND', 'Brunei Dollar', '096', '2', '[\"BRUNEI DARUSSALAM\"]'),
('BOB', 'Boliviano', '068', '2', '[\"BOLIVIA, PLURINATIONAL STATE OF\"]'),
('BOV', 'Mvdol', '984', '2', '[\"BOLIVIA, PLURINATIONAL STATE OF\"]'),
('BRL', 'Brazilian Real', '986', '2', '[\"BRAZIL\"]'),
('BSD', 'Bahamian Dollar', '044', '2', '[\"BAHAMAS\"]'),
('BTN', 'Ngultrum', '064', '2', '[\"BHUTAN\"]'),
('BWP', 'Pula', '072', '2', '[\"BOTSWANA\"]'),
('BYR', 'Belarussian Ruble', '974', '0', '[\"BELARUS\"]'),
('BZD', 'Belize Dollar', '084', '2', '[\"BELIZE\"]'),
('CAD', 'Canadian Dollar', '124', '2', '[\"CANADA\"]'),
('CDF', 'Congolese Franc', '976', '2', '[\"CONGO, DEMOCRATIC REPUBLIC OF THE \"]'),
('CHE', 'WIR Euro', '947', '2', '[\"SWITZERLAND\"]'),
('CHF', 'Swiss Franc', '756', '2', '[\"LIECHTENSTEIN\",\"SWITZERLAND\"]'),
('CHW', 'WIR Franc', '948', '2', '[\"SWITZERLAND\"]'),
('CLF', 'Unidad de Fomento', '990', '4', '[\"CHILE\"]'),
('CLP', 'Chilean Peso', '152', '0', '[\"CHILE\"]'),
('CNY', 'Yuan Renminbi', '156', '2', '[\"CHINA\"]'),
('COP', 'Colombian Peso', '170', '2', '[\"COLOMBIA\"]'),
('COU', 'Unidad de Valor Real', '970', '2', '[\"COLOMBIA\"]'),
('CRC', 'Costa Rican Colon', '188', '2', '[\"COSTA RICA\"]'),
('CUC', 'Peso Convertible', '931', '2', '[\"CUBA\"]'),
('CUP', 'Cuban Peso', '192', '2', '[\"CUBA\"]'),
('CVE', 'Cape Verde Escudo', '132', '2', '[\"CAPE VERDE\"]'),
('CZK', 'Czech Koruna', '203', '2', '[\"CZECH REPUBLIC\"]'),
('DJF', 'Djibouti Franc', '262', '0', '[\"DJIBOUTI\"]'),
('DKK', 'Danish Krone', '208', '2', '[\"DENMARK\",\"FAROE ISLANDS\",\"GREENLAND\"]'),
('DOP', 'Dominican Peso', '214', '2', '[\"DOMINICAN REPUBLIC\"]'),
('DZD', 'Algerian Dinar', '012', '2', '[\"ALGERIA\"]'),
('EGP', 'Egyptian Pound', '818', '2', '[\"EGYPT\"]'),
('ERN', 'Nakfa', '232', '2', '[\"ERITREA\"]'),
('ETB', 'Ethiopian Birr', '230', '2', '[\"ETHIOPIA\"]'),
('EUR', 'Euro', '978', '2', '[\"\\u00c5LAND ISLANDS\",\"ANDORRA\",\"AUSTRIA\",\"BELGIUM\",\"CYPRUS\",\"ESTONIA\",\"EUROPEAN UNION\",\"FINLAND\",\"FRANCE\",\"FRENCH GUIANA\",\"FRENCH SOUTHERN TERRITORIES\",\"GERMANY\",\"GREECE\",\"GUADELOUPE\",\"HOLY SEE (VATICAN CITY STATE)\",\"IRELAND\",\"ITALY\",\"LATVIA\",\"LUXEMBOURG\",\"MALTA\",\"MARTINIQUE\",\"MAYOTTE\",\"MONACO\",\"MONTENEGRO\",\"NETHERLANDS\",\"PORTUGAL\",\"R\\u00c9UNION\",\"SAINT BARTH\\u00c9LEMY\",\"SAINT MARTIN (FRENCH PART)\",\"SAINT PIERRE AND MIQUELON\",\"SAN MARINO\",\"SLOVAKIA\",\"SLOVENIA\",\"SPAIN\"]'),
('FJD', 'Fiji Dollar', '242', '2', '[\"FIJI\"]'),
('FKP', 'Falkland Islands Pound', '238', '2', '[\"FALKLAND ISLANDS (MALVINAS)\"]'),
('GBP', 'Pound Sterling', '826', '2', '[\"GUERNSEY\",\"ISLE OF MAN\",\"JERSEY\",\"UNITED KINGDOM\"]'),
('GEL', 'Lari', '981', '2', '[\"GEORGIA\"]'),
('GHS', 'Ghana Cedi', '936', '2', '[\"GHANA\"]'),
('GIP', 'Gibraltar Pound', '292', '2', '[\"GIBRALTAR\"]'),
('GMD', 'Dalasi', '270', '2', '[\"GAMBIA\"]'),
('GNF', 'Guinea Franc', '324', '0', '[\"GUINEA\"]'),
('GTQ', 'Quetzal', '320', '2', '[\"GUATEMALA\"]'),
('GYD', 'Guyana Dollar', '328', '2', '[\"GUYANA\"]'),
('HKD', 'Hong Kong Dollar', '344', '2', '[\"HONG KONG\"]'),
('HNL', 'Lempira', '340', '2', '[\"HONDURAS\"]'),
('HRK', 'Croatian Kuna', '191', '2', '[\"CROATIA\"]'),
('HTG', 'Gourde', '332', '2', '[\"HAITI\"]'),
('HUF', 'Forint', '348', '2', '[\"HUNGARY\"]'),
('IDR', 'Rupiah', '360', '2', '[\"INDONESIA\"]'),
('ILS', 'New Israeli Sheqel', '376', '2', '[\"ISRAEL\"]'),
('INR', 'Indian Rupee', '356', '2', '[\"BHUTAN\",\"INDIA\"]'),
('IQD', 'Iraqi Dinar', '368', '3', '[\"IRAQ\"]'),
('IRR', 'Iranian Rial', '364', '2', '[\"IRAN, ISLAMIC REPUBLIC OF\"]'),
('ISK', 'Iceland Krona', '352', '0', '[\"ICELAND\"]'),
('JMD', 'Jamaican Dollar', '388', '2', '[\"JAMAICA\"]'),
('JOD', 'Jordanian Dinar', '400', '3', '[\"JORDAN\"]'),
('JPY', 'Yen', '392', '0', '[\"JAPAN\"]'),
('KES', 'Kenyan Shilling', '404', '2', '[\"KENYA\"]'),
('KGS', 'Som', '417', '2', '[\"KYRGYZSTAN\"]'),
('KHR', 'Riel', '116', '2', '[\"CAMBODIA\"]'),
('KMF', 'Comoro Franc', '174', '0', '[\"COMOROS\"]'),
('KPW', 'North Korean Won', '408', '2', '[\"KOREA, DEMOCRATIC PEOPLE\\u2019S REPUBLIC OF\"]'),
('KRW', 'Won', '410', '0', '[\"KOREA, REPUBLIC OF\"]'),
('KWD', 'Kuwaiti Dinar', '414', '3', '[\"KUWAIT\"]'),
('KYD', 'Cayman Islands Dollar', '136', '2', '[\"CAYMAN ISLANDS\"]'),
('KZT', 'Tenge', '398', '2', '[\"KAZAKHSTAN\"]'),
('LAK', 'Kip', '418', '2', '[\"LAO PEOPLE\\u2019S DEMOCRATIC REPUBLIC\"]'),
('LBP', 'Lebanese Pound', '422', '2', '[\"LEBANON\"]'),
('LKR', 'Sri Lanka Rupee', '144', '2', '[\"SRI LANKA\"]'),
('LRD', 'Liberian Dollar', '430', '2', '[\"LIBERIA\"]'),
('LSL', 'Loti', '426', '2', '[\"LESOTHO\"]'),
('LTL', 'Lithuanian Litas', '440', '2', '[\"LITHUANIA\"]'),
('LYD', 'Libyan Dinar', '434', '3', '[\"LIBYA\"]'),
('MAD', 'Moroccan Dirham', '504', '2', '[\"MOROCCO\",\"WESTERN SAHARA\"]'),
('MDL', 'Moldovan Leu', '498', '2', '[\"MOLDOVA, REPUBLIC OF\"]'),
('MGA', 'Malagasy Ariary', '969', '2', '[\"MADAGASCAR\"]'),
('MKD', 'Denar', '807', '2', '[\"MACEDONIA, THE FORMER \\nYUGOSLAV REPUBLIC OF\"]'),
('MMK', 'Kyat', '104', '2', '[\"MYANMAR\"]'),
('MNT', 'Tugrik', '496', '2', '[\"MONGOLIA\"]'),
('MOP', 'Pataca', '446', '2', '[\"MACAO\"]'),
('MRO', 'Ouguiya', '478', '2', '[\"MAURITANIA\"]'),
('MUR', 'Mauritius Rupee', '480', '2', '[\"MAURITIUS\"]'),
('MVR', 'Rufiyaa', '462', '2', '[\"MALDIVES\"]'),
('MWK', 'Kwacha', '454', '2', '[\"MALAWI\"]'),
('MXN', 'Mexican Peso', '484', '2', '[\"MEXICO\"]'),
('MXV', 'Mexican Unidad de Inversion (UDI)', '979', '2', '[\"MEXICO\"]'),
('MYR', 'Malaysian Ringgit', '458', '2', '[\"MALAYSIA\"]'),
('MZN', 'Mozambique Metical', '943', '2', '[\"MOZAMBIQUE\"]'),
('NAD', 'Namibia Dollar', '516', '2', '[\"NAMIBIA\"]'),
('NGN', 'Naira', '566', '2', '[\"NIGERIA\"]'),
('NIO', 'Cordoba Oro', '558', '2', '[\"NICARAGUA\"]'),
('NOK', 'Norwegian Krone', '578', '2', '[\"BOUVET ISLAND\",\"NORWAY\",\"SVALBARD AND JAN MAYEN\"]'),
('NPR', 'Nepalese Rupee', '524', '2', '[\"NEPAL\"]'),
('NZD', 'New Zealand Dollar', '554', '2', '[\"COOK ISLANDS\",\"NEW ZEALAND\",\"NIUE\",\"PITCAIRN\",\"TOKELAU\"]'),
('OMR', 'Rial Omani', '512', '3', '[\"OMAN\"]'),
('PAB', 'Balboa', '590', '2', '[\"PANAMA\"]'),
('PEN', 'Nuevo Sol', '604', '2', '[\"PERU\"]'),
('PGK', 'Kina', '598', '2', '[\"PAPUA NEW GUINEA\"]'),
('PHP', 'Philippine Peso', '608', '2', '[\"PHILIPPINES\"]'),
('PKR', 'Pakistan Rupee', '586', '2', '[\"PAKISTAN\"]'),
('PLN', 'Zloty', '985', '2', '[\"POLAND\"]'),
('PYG', 'Guarani', '600', '0', '[\"PARAGUAY\"]'),
('QAR', 'Qatari Rial', '634', '2', '[\"QATAR\"]'),
('RON', 'New Romanian Leu', '946', '2', '[\"ROMANIA\"]'),
('RSD', 'Serbian Dinar', '941', '2', '[\"SERBIA\"]'),
('RUB', 'Russian Ruble', '643', '2', '[\"RUSSIAN FEDERATION\"]'),
('RWF', 'Rwanda Franc', '646', '0', '[\"RWANDA\"]'),
('SAR', 'Saudi Riyal', '682', '2', '[\"SAUDI ARABIA\"]'),
('SBD', 'Solomon Islands Dollar', '090', '2', '[\"SOLOMON ISLANDS\"]'),
('SCR', 'Seychelles Rupee', '690', '2', '[\"SEYCHELLES\"]'),
('SDG', 'Sudanese Pound', '938', '2', '[\"SUDAN\"]'),
('SEK', 'Swedish Krona', '752', '2', '[\"SWEDEN\"]'),
('SGD', 'Singapore Dollar', '702', '2', '[\"SINGAPORE\"]'),
('SHP', 'Saint Helena Pound', '654', '2', '[\"SAINT HELENA, ASCENSION AND \\nTRISTAN DA CUNHA\"]'),
('SLL', 'Leone', '694', '2', '[\"SIERRA LEONE\"]'),
('SOS', 'Somali Shilling', '706', '2', '[\"SOMALIA\"]'),
('SRD', 'Surinam Dollar', '968', '2', '[\"SURINAME\"]'),
('SSP', 'South Sudanese Pound', '728', '2', '[\"SOUTH SUDAN\"]'),
('STD', 'Dobra', '678', '2', '[\"SAO TOME AND PRINCIPE\"]'),
('SVC', 'El Salvador Colon', '222', '2', '[\"EL SALVADOR\"]'),
('SYP', 'Syrian Pound', '760', '2', '[\"SYRIAN ARAB REPUBLIC\"]'),
('SZL', 'Lilangeni', '748', '2', '[\"SWAZILAND\"]'),
('THB', 'Baht', '764', '2', '[\"THAILAND\"]'),
('TJS', 'Somoni', '972', '2', '[\"TAJIKISTAN\"]'),
('TMT', 'Turkmenistan New Manat', '934', '2', '[\"TURKMENISTAN\"]'),
('TND', 'Tunisian Dinar', '788', '3', '[\"TUNISIA\"]'),
('TOP', 'Pa’anga', '776', '2', '[\"TONGA\"]'),
('TRY', 'Turkish Lira', '949', '2', '[\"TURKEY\"]'),
('TTD', 'Trinidad and Tobago Dollar', '780', '2', '[\"TRINIDAD AND TOBAGO\"]'),
('TWD', 'New Taiwan Dollar', '901', '2', '[\"TAIWAN, PROVINCE OF CHINA\"]'),
('TZS', 'Tanzanian Shilling', '834', '2', '[\"TANZANIA, UNITED REPUBLIC OF\"]'),
('UAH', 'Hryvnia', '980', '2', '[\"UKRAINE\"]'),
('UGX', 'Uganda Shilling', '800', '0', '[\"UGANDA\"]'),
('USD', 'US Dollar', '840', '2', '[\"AMERICAN SAMOA\",\"BONAIRE, SINT EUSTATIUS AND SABA\",\"BRITISH INDIAN OCEAN TERRITORY\",\"ECUADOR\",\"EL SALVADOR\",\"GUAM\",\"HAITI\",\"MARSHALL ISLANDS\",\"MICRONESIA, FEDERATED STATES OF\",\"NORTHERN MARIANA ISLANDS\",\"PALAU\",\"PANAMA\",\"PUERTO RICO\",\"TIMOR-LESTE\",\"TURKS AND CAICOS ISLANDS\",\"UNITED STATES\",\"UNITED STATES MINOR OUTLYING ISLANDS\",\"VIRGIN ISLANDS (BRITISH)\",\"VIRGIN ISLANDS (U.S.)\"]'),
('USN', 'US Dollar (Next day)', '997', '2', '[\"UNITED STATES\"]'),
('UYI', 'Uruguay Peso en Unidades Indexadas (URUIURUI)', '940', '0', '[\"URUGUAY\"]'),
('UYU', 'Peso Uruguayo', '858', '2', '[\"URUGUAY\"]'),
('UZS', 'Uzbekistan Sum', '860', '2', '[\"UZBEKISTAN\"]'),
('VEF', 'Bolivar', '937', '2', '[\"VENEZUELA, BOLIVARIAN REPUBLIC OF\"]'),
('VND', 'Dong', '704', '0', '[\"VIET NAM\"]'),
('VUV', 'Vatu', '548', '0', '[\"VANUATU\"]'),
('WST', 'Tala', '882', '2', '[\"SAMOA\"]'),
('XAF', 'CFA Franc BEAC', '950', '0', '[\"CAMEROON\",\"CENTRAL AFRICAN REPUBLIC\",\"CHAD\",\"CONGO\",\"EQUATORIAL GUINEA\",\"GABON\"]'),
('XCD', 'East Caribbean Dollar', '951', '2', '[\"ANGUILLA\",\"ANTIGUA AND BARBUDA\",\"DOMINICA\",\"GRENADA\",\"MONTSERRAT\",\"SAINT KITTS AND NEVIS\",\"SAINT LUCIA\",\"SAINT VINCENT AND THE GRENADINES\"]'),
('XDR', 'SDR (Special Drawing Right)', '960', '0', '[\"INTERNATIONAL MONETARY FUND (IMF)\\u00a0\"]'),
('XOF', 'CFA Franc BCEAO', '952', '0', '[\"BENIN\",\"BURKINA FASO\",\"C\\u00d4TE D\'IVOIRE\",\"GUINEA-BISSAU\",\"MALI\",\"NIGER\",\"SENEGAL\",\"TOGO\"]'),
('XPF', 'CFP Franc', '953', '0', '[\"FRENCH POLYNESIA\",\"NEW CALEDONIA\",\"WALLIS AND FUTUNA\"]'),
('XSU', 'Sucre', '994', '0', '[\"SISTEMA UNITARIO DE COMPENSACION REGIONAL DE PAGOS \\\"SUCRE\\\"\"]'),
('XUA', 'ADB Unit of Account', '965', '0', '[\"MEMBER COUNTRIES OF THE AFRICAN DEVELOPMENT BANK GROUP\"]'),
('YER', 'Yemeni Rial', '886', '2', '[\"YEMEN\"]'),
('ZAR', 'Rand', '710', '2', '[\"LESOTHO\",\"NAMIBIA\",\"SOUTH AFRICA\"]'),
('ZMW', 'Zambian Kwacha', '967', '2', '[\"ZAMBIA\"]'),
('ZWL', 'Zimbabwe Dollar', '932', '2', '[\"ZIMBABWE\"]')
ON DUPLICATE KEY UPDATE `code` = VALUES(`code`), `name` = VALUES(`name`), `number` = VALUES(`number`), `decimals` = VALUES(`decimals`), `countries` = VALUES(`countries`);