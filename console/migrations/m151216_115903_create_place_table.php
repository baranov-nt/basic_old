<?php

use yii\db\Migration;

class m151216_115903_create_place_table extends Migration
{
    public function safeUp()
    {
        /* Таблица локального адреса */
        $this->createTable('place_address', [
            'id'        => $this->primaryKey(),
            'place_id'  => $this->string()->notNull(),
            'city_id'   => $this->integer()->notNull(),
        ]);

        $this->createIndex('place_index', 'place_address', 'place_id');

        /* Таблица города */
        $this->createTable('place_city', [
            'id'        => $this->primaryKey(),
            'place_id'  => $this->string()->notNull(),
            'region_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('city_index', 'place_city', 'place_id');

        /* Связь таблицы городов с локальным адресом */
        $this->addForeignKey('place_city', 'place_address', 'city_id', 'place_city', 'id');

        /* Таблица регионов */
        $this->createTable('place_region', [
            'id'            => $this->primaryKey(),
            'place_id'      => $this->string(),
            'country_id'    => $this->integer()->notNull(),
        ]);

        $this->createIndex('region_index', 'place_region', 'place_id');

        /* Связь таблицы городов с таблицей регионов, если региона у города нет пишем в регион place_id = NULL.
         * В таблице регионов есть связь с таблицей стран, где указывается к какой стране принадлежит город
         */
        $this->addForeignKey('city_region', 'place_city', 'region_id', 'place_region', 'id');

        /* Таблица стран */
        $this->createTable('place_country', [
            'id'                        => $this->primaryKey(),
            'iso2'                      => $this->string(2)->defaultValue(null),                       // код страны 2 символа
            'short_name'                => $this->string(80)->notNull(),           // короткое название страны
            'long_name'                 => $this->string(80)->notNull(),           // длинное название страны
            'iso3'                      => $this->string(3)->defaultValue(null),                       // код страны 3 символа
            'numcode'                   => $this->string(6)->defaultValue(null),                       // цифровой код страны
            'un_member'                 => $this->string(12)->defaultValue(null),
            'calling_code'              => $this->string(8)->defaultValue(null),                       // телефонный код страны
            'cctld'                     => $this->string(5)->defaultValue(null),                       // домен страны
            'phone_number_digits_code'  => $this->smallInteger(5)->defaultValue(null),                 // количество цифр после кода
            'currency'                  => $this->string(3)->defaultValue(null),                       // валюта страны
            'system_measure'            => $this->boolean()->defaultValue(false),      // система мер (0 - метрическая, 1 - английская)
        ]);

        /* Связь таблицы регионов с таблицей стран, если региона у города нет пишем в регион place_id = NULL. */
        $this->addForeignKey('region_country', 'place_region', 'country_id', 'place_country', 'id');

        /* Связь пользователя с таблицей стран, если региона у города нет пишем в регион place_id = NULL. */
        $this->addForeignKey('user_country', 'user', 'country_id', 'place_country', 'id');

        $this->batchInsert('place_country', ['id', 'iso2', 'short_name', 'long_name', 'iso3', 'numcode', 'un_member', 'calling_code', 'cctld', 'phone_number_digits_code',
            'currency', 'system_measure'],
            [
                [1, 'AF', Yii::t('countries', 'Afghanistan'), 'Islamic Republic of Afghanistan', 'AFG', '004', 'yes', '93', '.af', null, 'AFA', 0],
                //[2, 'AX', Yii::t('countries', 'Aland Islands'), 'Aland Islands', 'ALA', '248', 'no', '358', '.ax', 10, null, 0],
                [3, 'AL', Yii::t('countries', 'Albania'), 'Republic of Albania', 'ALB', '008', 'yes', '355', '.al', 9, 'ALL', 0],
                [4, 'DZ', Yii::t('countries', 'Algeria'), 'People\'s Democratic Republic of Algeria', 'DZA', '012', 'yes', '213', '.dz', 9, 'DZD', 0],
                [5, 'AS', Yii::t('countries', 'American Samoa'), 'American Samoa', 'ASM', '016', 'no', '1-684', '.as', 10, 'USD', 0],
                [6, 'AD', Yii::t('countries', 'Andorra'), 'Principality of Andorra', 'AND', '020', 'yes', '376', '.ad', null, 'EUR', 0],
                [7, 'AO', Yii::t('countries', 'Angola'), 'Republic of Angola', 'AGO', '024', 'yes', '244', '.ao', null, 'AOA', 0],
                [8, 'AI', Yii::t('countries', 'Anguilla'), 'Anguilla', 'AIA', '660', 'no', '1-264', '.ai', 10, 'XCD', 0],
                [9, 'AQ', Yii::t('countries', 'Antarctica'), 'Antarctica', 'ATA', '010', 'no', '672', '.aq', null, 'NOK', 0],
                [10, 'AG', Yii::t('countries', 'Antigua and Barbuda'), 'Antigua and Barbuda', 'ATG', '028', 'yes', '1-268', '.ag', 10, 'XCD', 0],
                [11, 'AR', Yii::t('countries', 'Argentina'), 'Argentine Republic', 'ARG', '032', 'yes', '54', '.ar', null, 'ARA', 0],
                [12, 'AM', Yii::t('countries', 'Armenia'), 'Republic of Armenia', 'ARM', '051', 'yes', '374', '.am', 8, 'AMD', 0],
                [13, 'AW', Yii::t('countries', 'Aruba'), 'Aruba', 'ABW', '533', 'no', '297', '.aw', null, 'AWG', 0],
                [14, 'AU', Yii::t('countries', 'Australia'), 'Commonwealth of Australia', 'AUS', '036', 'yes', '61', '.au', 9, 'AUD', 0],
                [15, 'AT', Yii::t('countries', 'Austria'), 'Republic of Austria', 'AUT', '040', 'yes', '43', '.at', 10, 'EUR', 0],
                [16, 'AZ', Yii::t('countries', 'Azerbaijan'), 'Republic of Azerbaijan', 'AZE', '031', 'yes', '994', '.az', 9, 'AZM', 0],
                [17, 'BS', Yii::t('countries', 'Bahamas'), 'Commonwealth of The Bahamas', 'BHS', '044', 'yes', '1-242', '.bs', 10, 'BSD', 0],
                [18, 'BH', Yii::t('countries', 'Bahrain'), 'Kingdom of Bahrain', 'BHR', '048', 'yes', '973', '.bh', 8, 'BHD', 0],
                [19, 'BD', Yii::t('countries', 'Bangladesh'), 'People\'s Republic of Bangladesh', 'BGD', '050', 'yes', '880', '.bd', 10, 'BDT', 0],
                [20, 'BB', Yii::t('countries', 'Barbados'), 'Barbados', 'BRB', '052', 'yes', '1-246', '.bb', 10, 'BBD', 0],
                [21, 'BY', Yii::t('countries', 'Belarus'), 'Republic of Belarus', 'BLR', '112', 'yes', '375', '.by', 9, 'BYR', 0],
                [22, 'BE', Yii::t('countries', 'Belgium'), 'Kingdom of Belgium', 'BEL', '056', 'yes', '32', '.be', 9, 'EUR', 0],
                [23, 'BZ', Yii::t('countries', 'Belize'), 'Belize', 'BLZ', '084', 'yes', '501', '.bz', null, 'BZD', 0],
                [24, 'BJ', Yii::t('countries', 'Benin'), 'Republic of Benin', 'BEN', '204', 'yes', '229', '.bj', null, 'XAF', 0],
                [25, 'BM', Yii::t('countries', 'Bermuda'), 'Bermuda Islands', 'BMU', '060', 'no', '1-441', '.bm', 10, 'BMD', 0],
                [26, 'BT', Yii::t('countries', 'Bhutan'), 'Kingdom of Bhutan', 'BTN', '064', 'yes', '975', '.bt', null, 'BTN', 0],
                [27, 'BO', Yii::t('countries', 'Bolivia'), 'Plurinational State of Bolivia', 'BOL', '068', 'yes', '591', '.bo', null, 'BOB', 0],
                //[28, 'BQ', Yii::t('countries', 'Bonaire, Sint Eustatius and Saba'), 'Bonaire, Sint Eustatius and Saba', 'BES', '535', 'no', '599', '.bq', null, null, 0],
                [29, 'BA', Yii::t('countries', 'Bosnia and Herzegovina'), 'Bosnia and Herzegovina', 'BIH', '070', 'yes', '387', '.ba', 8, 'BAM', 0],
                [30, 'BW', Yii::t('countries', 'Botswana'), 'Republic of Botswana', 'BWA', '072', 'yes', '267', '.bw', null, 'BWP', 0],
                //[31, 'BV', Yii::t('countries', 'Bouvet Island'), 'Bouvet Island', 'BVT', '074', 'no', 'NONE', '.bv', null, null, 0],
                [32, 'BR', Yii::t('countries', 'Brazil'), 'Federative Republic of Brazil', 'BRA', '076', 'yes', '55', '.br', 9, 'BRL', 0],
                [33, 'IO', Yii::t('countries', 'British Indian Ocean Territory'), 'British Indian Ocean Territory', 'IOT', '086', 'no', '246', '.io', 7, 'GBP', 0],
                [34, 'BN', Yii::t('countries', 'Brunei'), 'Brunei Darussalam', 'BRN', '096', 'yes', '673', '.bn', null, 'BND', 0],
                [35, 'BG', Yii::t('countries', 'Bulgaria'), 'Republic of Bulgaria', 'BGR', '100', 'yes', '359', '.bg', 9, 'BGL', 0],
                [36, 'BF', Yii::t('countries', 'Burkina Faso'), 'Burkina Faso', 'BFA', '854', 'yes', '226', '.bf', 8, 'XAF', 0],
                [37, 'BI', Yii::t('countries', 'Burundi'), 'Republic of Burundi', 'BDI', '108', 'yes', '257', '.bi', null, 'BIF', 0],
                [38, 'KH', Yii::t('countries', 'Cambodia'), 'Kingdom of Cambodia', 'KHM', '116', 'yes', '855', '.kh', null, 'KHR', 0],
                [39, 'CM', Yii::t('countries', 'Cameroon'), 'Republic of Cameroon', 'CMR', '120', 'yes', '237', '.cm', null, 'XAF', 0],
                [40, 'CA', Yii::t('countries', 'Canada'), 'Canada', 'CAN', '124', 'yes', '1', '.ca', 10, 'CAD', 0],
                [41, 'CV', Yii::t('countries', 'Cape Verde'), 'Republic of Cape Verde', 'CPV', '132', 'yes', '238', '.cv', null, 'CVE', 0],
                [42, 'KY', Yii::t('countries', 'Cayman Islands'), 'The Cayman Islands', 'CYM', '136', 'no', '1-345', '.ky', 10, 'KYD', 0],
                [43, 'CF', Yii::t('countries', 'Central African Republic'), 'Central African Republic', 'CAF', '140', 'yes', '236', '.cf', null, 'XAF', 0],
                [44, 'TD', Yii::t('countries', 'Chad'), 'Republic of Chad', 'TCD', '148', 'yes', '235', '.td', null, 'XAF', 0],
                [45, 'CL', Yii::t('countries', 'Chile'), 'Republic of Chile', 'CHL', '152', 'yes', '56', '.cl', null, 'CLF', 0],
                [46, 'CN', Yii::t('countries', 'China'), 'People\'s Republic of China', 'CHN', '156', 'yes', '86', '.cn', 11, 'CNY', 0],
                [47, 'CX', Yii::t('countries', 'Christmas Island'), 'Christmas Island', 'CXR', '162', 'no', '61', '.cx', null, 'AUD', 0],
                [48, 'CC', Yii::t('countries', 'Cocos [Keeling] Islands'), 'Cocos [Keeling] Islands', 'CCK', '166', 'no', '61', '.cc', null, 'AUD', 0],
                [49, 'CO', Yii::t('countries', 'Colombia'), 'Republic of Colombia', 'COL', '170', 'yes', '57', '.co', 10, 'COP', 0],
                [50, 'KM', Yii::t('countries', 'Comoros'), 'Union of the Comoros', 'COM', '174', 'yes', '269', '.km', null, 'KMF', 0],
                [51, 'CG', Yii::t('countries', 'Congo'), 'Republic of the Congo', 'COG', '178', 'yes', '242', '.cg', null, 'XAF', 0],
                [52, 'CK', Yii::t('countries', 'Cook Islands'), 'Cook Islands', 'COK', '184', 'some', '682', '.ck', 5, 'NZD', 0],
                [53, 'CR', Yii::t('countries', 'Costa Rica'), 'Republic of Costa Rica', 'CRI', '188', 'yes', '506', '.cr', null, 'CRC', 0],
                [54, 'CI', Yii::t('countries', 'Cote d\'ivoire [Ivory Coast]'), 'Republic of C&ocirc;te D\'Ivoire [Ivory Coast]', 'CIV', '384', 'yes', '225', '.ci', null, 'XAF', 0],
                [55, 'HR', Yii::t('countries', 'Croatia'), 'Republic of Croatia', 'HRV', '191', 'yes', '385', '.hr', null, 'HRK', 0],
                [56, 'CU', Yii::t('countries', 'Cuba'), 'Republic of Cuba', 'CUB', '192', 'yes', '53', '.cu', null, 'CUP', 0],
                //[57, 'CW', Yii::t('countries', 'Curacao'), 'Cura&ccedil;ao', 'CUW', '531', 'no', '599', '.cw', null, null, 0],
                [58, 'CY', Yii::t('countries', 'Cyprus'), 'Republic of Cyprus', 'CYP', '196', 'yes', '357', '.cy', 8, 'EUR', 0],
                [59, 'CZ', Yii::t('countries', 'Czech Republic'), 'Czech Republic', 'CZE', '203', 'yes', '420', '.cz', 9, 'CZK', 0],
                [60, 'CD', Yii::t('countries', 'Democratic Republic of the Congo'), 'Democratic Republic of the Congo', 'COD', '180', 'yes', '243', '.cd', null, 'CDZ', 0],
                [61, 'DK', Yii::t('countries', 'Denmark'), 'Kingdom of Denmark', 'DNK', '208', 'yes', '45', '.dk', 8, 'DKK', 0],
                [62, 'DJ', Yii::t('countries', 'Djibouti'), 'Republic of Djibouti', 'DJI', '262', 'yes', '253', '.dj', null, 'DJF', 0],
                [63, 'DM', Yii::t('countries', 'Dominica'), 'Commonwealth of Dominica', 'DMA', '212', 'yes', '1-767', '.dm', 10, 'XCD', 0],
                [64, 'DO', Yii::t('countries', 'Dominican Republic'), 'Dominican Republic', 'DOM', '214', 'yes', '1-809', '.do', 10, 'DOP', 0],
                [65, 'EC', Yii::t('countries', 'Ecuador'), 'Republic of Ecuador', 'ECU', '218', 'yes', '593', '.ec', null, 'USD', 0],
                [66, 'EG', Yii::t('countries', 'Egypt'), 'Arab Republic of Egypt', 'EGY', '818', 'yes', '20', '.eg', 10, 'EGP', 0],
                [67, 'SV', Yii::t('countries', 'El Salvador'), 'Republic of El Salvador', 'SLV', '222', 'yes', '503', '.sv', null, 'USD', 0],
                [68, 'GQ', Yii::t('countries', 'Equatorial Guinea'), 'Republic of Equatorial Guinea', 'GNQ', '226', 'yes', '240', '.gq', null, 'XAF', 0],
                [69, 'ER', Yii::t('countries', 'Eritrea'), 'State of Eritrea', 'ERI', '232', 'yes', '291', '.er', null, 'ERN', 0],
                [70, 'EE', Yii::t('countries', 'Estonia'), 'Republic of Estonia', 'EST', '233', 'yes', '372', '.ee', null, 'EUR', 0],
                [71, 'ET', Yii::t('countries', 'Ethiopia'), 'Federal Democratic Republic of Ethiopia', 'ETH', '231', 'yes', '251', '.et', null, 'ETB', 0],
                [72, 'FK', Yii::t('countries', 'Falkland Islands [Malvinas]'), 'The Falkland Islands [Malvinas]', 'FLK', '238', 'no', '500', '.fk', 5, 'FKP', 0],
                [73, 'FO', Yii::t('countries', 'Faroe Islands'), 'The Faroe Islands', 'FRO', '234', 'no', '298', '.fo', 5, 'DKK', 0],
                [74, 'FJ', Yii::t('countries', 'Fiji'), 'Republic of Fiji', 'FJI', '242', 'yes', '679', '.fj', null, 'FJD', 0],
                [75, 'FI', Yii::t('countries', 'Finland'), 'Republic of Finland', 'FIN', '246', 'yes', '358', '.fi', 10, 'EUR', 0],
                [76, 'FR', Yii::t('countries', 'France'), 'French Republic', 'FRA', '250', 'yes', '33', '.fr', 9, 'EUR', 0],
                [77, 'GF', Yii::t('countries', 'French Guiana'), 'French Guiana', 'GUF', '254', 'no', '594', '.gf', null, 'EUR', 0],
                [78, 'PF', Yii::t('countries', 'French Polynesia'), 'French Polynesia', 'PYF', '258', 'no', '689', '.pf', 6, 'XPF', 0],
                //[79, 'TF', 'French Southern Territories', 'French Southern Territories', 'ATF', '260', 'no', NULL, '.tf', null, null, 0],
                [80, 'GA', Yii::t('countries', 'Gabon'), 'Gabonese Republic', 'GAB', '266', 'yes', '241', '.ga', 7, 'XAF', 0],
                [81, 'GM', Yii::t('countries', 'Gambia'), 'Republic of The Gambia', 'GMB', '270', 'yes', '220', '.gm', null, 'GMD', 0],
                [82, 'GE', Yii::t('countries', 'Georgia'), 'Georgia', 'GEO', '268', 'yes', '995', '.ge', 9, 'GEL', 0],
                [83, 'DE', Yii::t('countries', 'Germany'), 'Federal Republic of Germany', 'DEU', '276', 'yes', '49', '.de', 10, 'EUR', 0],
                [84, 'GH', Yii::t('countries', 'Ghana'), 'Republic of Ghana', 'GHA', '288', 'yes', '233', '.gh', 9, 'GHC', 0],
                [85, 'GI', Yii::t('countries', 'Gibraltar'), 'Gibraltar', 'GIB', '292', 'no', '350', '.gi', null, 'GIP', 0],
                [86, 'GR', Yii::t('countries', 'Greece'), 'Hellenic Republic', 'GRC', '300', 'yes', '30', '.gr', 10, 'EUR', 0],
                [87, 'GL', Yii::t('countries', 'Greenland'), 'Greenland', 'GRL', '304', 'no', '299', '.gl', 6, 'DKK', 0],
                [88, 'GD', Yii::t('countries', 'Grenada'), 'Grenada', 'GRD', '308', 'yes', '1-473', '.gd', 10, 'XCD', 0],
                //[89, 'GP', Yii::t('countries', 'Guadaloupe'), 'Guadeloupe', 'GLP', '312', 'no', '590', '.gp', null, null, 0],
                [90, 'GU', Yii::t('countries', 'Guam'), 'Guam', 'GUM', '316', 'no', '1-671', '.gu', 10, 'USD', 0],
                [91, 'GT', Yii::t('countries', 'Guatemala'), 'Republic of Guatemala', 'GTM', '320', 'yes', '502', '.gt', null, 'GTQ', 0],
                //[92, 'GG', Yii::t('countries', 'Guernsey'), 'Guernsey', 'GGY', '831', 'no', '44', '.gg', 10, null, 0],
                [93, 'GN', Yii::t('countries', 'Guinea'), 'Republic of Guinea', 'GIN', '324', 'yes', '224', '.gn', null, 'GNS', 0],
                [94, 'GW', Yii::t('countries', 'Guinea-Bissau'), 'Republic of Guinea-Bissau', 'GNB', '624', 'yes', '245', '.gw', null, 'GWP', 0],
                [95, 'GY', Yii::t('countries', 'Guyana'), 'Co-operative Republic of Guyana', 'GUY', '328', 'yes', '592', '.gy', null, 'GYD', 0],
                [96, 'HT', Yii::t('countries', 'Haiti'), 'Republic of Haiti', 'HTI', '332', 'yes', '509', '.ht', null, 'HTG', 0],
                //[97, 'HM', 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HMD', '334', 'no', 'NONE', '.hm', null, null, 0],
                [98, 'HN', Yii::t('countries', 'Honduras'), 'Republic of Honduras', 'HND', '340', 'yes', '504', '.hn', null, 'HNL', 0],
                [99, 'HK', Yii::t('countries', 'Hong Kong'), 'Hong Kong', 'HKG', '344', 'no', '852', '.hk', 8, 'HKD', 0],
                [100, 'HU', Yii::t('countries', 'Hungary'), 'Hungary', 'HUN', '348', 'yes', '36', '.hu', 9, 'HUF', 0],
                [101, 'IS', Yii::t('countries', 'Iceland'), 'Republic of Iceland', 'ISL', '352', 'yes', '354', '.is', null, 'ISK', 0],
                [102, 'IN', Yii::t('countries', 'India'), 'Republic of India', 'IND', '356', 'yes', '91', '.in', 10, 'INR', 0],
                [103, 'ID', Yii::t('countries', 'Indonesia'), 'Republic of Indonesia', 'IDN', '360', 'yes', '62', '.id', 11, 'IDR', 0],
                [104, 'IR', Yii::t('countries', 'Iran'), 'Islamic Republic of Iran', 'IRN', '364', 'yes', '98', '.ir', 10, 'IRR', 0],
                [105, 'IQ', Yii::t('countries', 'Iraq'), 'Republic of Iraq', 'IRQ', '368', 'yes', '964', '.iq', null, 'IQD', 0],
                [106, 'IE', Yii::t('countries', 'Ireland'), 'Ireland', 'IRL', '372', 'yes', '353', '.ie', 9, 'EUR', 0],
                //[107, 'IM', Yii::t('countries', 'Isle of Man'), 'Isle of Man', 'IMN', '833', 'no', '44', '.im', 10, null, 0],
                [108, 'IL', Yii::t('countries', 'Israel'), 'State of Israel', 'ISR', '376', 'yes', '972', '.il', 9, 'ILS', 0],
                [109, 'IT', Yii::t('countries', 'Italy'), 'Italian Republic', 'ITA', '380', 'yes', '39', '.jm', 10, 'EUR', 0],
                [110, 'JM', Yii::t('countries', 'Jamaica'), 'Jamaica', 'JAM', '388', 'yes', '1-876', '.jm', 10, 'JMD', 0],
                [111, 'JP', Yii::t('countries', 'Japan'), 'Japan', 'JPN', '392', 'yes', '81', '.jp', null, 'JPY', 0],
                //[112, 'JE', Yii::t('countries', 'Jersey'), 'The Bailiwick of Jersey', 'JEY', '832', 'no', '44', '.je', 10, null, 0],
                [113, 'JO', Yii::t('countries', 'Jordan'), 'Hashemite Kingdom of Jordan', 'JOR', '400', 'yes', '962', '.jo', null, 'JOD', 0],
                [114, 'KZ', Yii::t('countries', 'Kazakhstan'), 'Republic of Kazakhstan', 'KAZ', '398', 'yes', '7', '.kz', 9, 'KZT', 0],
                [115, 'KE', Yii::t('countries', 'Kenya'), 'Republic of Kenya', 'KEN', '404', 'yes', '254', '.ke', null, 'KES', 0],
                [116, 'KI', Yii::t('countries', 'Kiribati'), 'Republic of Kiribati', 'KIR', '296', 'yes', '686', '.ki', 5, 'AUD', 0],
                //[117, 'XK', Yii::t('countries', 'Kosovo'), 'Republic of Kosovo', '---', '---', 'some', '381', '', null, null, 0],
                [118, 'KW', Yii::t('countries', 'Kuwait'), 'State of Kuwait', 'KWT', '414', 'yes', '965', '.kw', null, 'KWD', 0],
                [119, 'KG', Yii::t('countries', 'Kyrgyzstan'), 'Kyrgyz Republic', 'KGZ', '417', 'yes', '996', '.kg', null, 'KGS', 0],
                [120, 'LA', Yii::t('countries', 'Laos'), 'Lao People\'s Democratic Republic', 'LAO', '418', 'yes', '856', '.la', null, 'LAK', 0],
                [121, 'LV', Yii::t('countries', 'Latvia'), 'Republic of Latvia', 'LVA', '428', 'yes', '371', '.lv', 8, 'EUR', 0],
                [122, 'LB', Yii::t('countries', 'Lebanon'), 'Republic of Lebanon', 'LBN', '422', 'yes', '961', '.lb', null, 'LBP', 0],
                [123, 'LS', Yii::t('countries', 'Lesotho'), 'Kingdom of Lesotho', 'LSO', '426', 'yes', '266', '.ls', null, 'LSL', 0],
                [124, 'LR', Yii::t('countries', 'Liberia'), 'Republic of Liberia', 'LBR', '430', 'yes', '231', '.lr', 7, 'LRD', 1],
                [125, 'LY', Yii::t('countries', 'Libya'), 'Libya', 'LBY', '434', 'yes', '218', '.ly', null, 'LYD', 0],
                [126, 'LI', Yii::t('countries', 'Liechtenstein'), 'Principality of Liechtenstein', 'LIE', '438', 'yes', '423', '.li', null, 'CHF', 0],
                [127, 'LT', Yii::t('countries', 'Lithuania'), 'Republic of Lithuania', 'LTU', '440', 'yes', '370', '.lt', null, 'EUR', 0],
                [128, 'LU', Yii::t('countries', 'Luxembourg'), 'Grand Duchy of Luxembourg', 'LUX', '442', 'yes', '352', '.lu', 9, 'EUR', 0],
                [129, 'MO', Yii::t('countries', 'Macao'), 'The Macao Special Administrative Region', 'MAC', '446', 'no', '853', '.mo', null, 'MOP', 0],
                [130, 'MK', Yii::t('countries', 'Macedonia'), 'The Former Yugoslav Republic of Macedonia', 'MKD', '807', 'yes', '389', '.mk', 8, 'MKD', 0],
                [131, 'MG', Yii::t('countries', 'Madagascar'), 'Republic of Madagascar', 'MDG', '450', 'yes', '261', '.mg', null, 'MGF', 0],
                [132, 'MW', Yii::t('countries', 'Malawi'), 'Republic of Malawi', 'MWI', '454', 'yes', '265', '.mw', null, 'MWK', 0],
                [133, 'MY', Yii::t('countries', 'Malaysia'), 'Malaysia', 'MYS', '458', 'yes', '60', '.my', null, 'MYR', 0],
                [134, 'MV', Yii::t('countries', 'Maldives'), 'Republic of Maldives', 'MDV', '462', 'yes', '960', '.mv', null, 'MVR', 0],
                [135, 'ML', Yii::t('countries', 'Mali'), 'Republic of Mali', 'MLI', '466', 'yes', '223', '.ml', 8, 'XAF', 0],
                [136, 'MT', Yii::t('countries', 'Malta'), 'Republic of Malta', 'MLT', '470', 'yes', '356', '.mt', null, 'EUR', 0],
                [137, 'MH', Yii::t('countries', 'Marshall Islands'), 'Republic of the Marshall Islands', 'MHL', '584', 'yes', '692', '.mh', 7, 'USD', 0],
                [138, 'MQ', Yii::t('countries', 'Martinique'), 'Martinique', 'MTQ', '474', 'no', '596', '.mq', null, 'EUR', 0],
                [139, 'MR', Yii::t('countries', 'Mauritania'), 'Islamic Republic of Mauritania', 'MRT', '478', 'yes', '222', '.mr', null, 'MRO', 0],
                [140, 'MU', Yii::t('countries', 'Mauritius'), 'Republic of Mauritius', 'MUS', '480', 'yes', '230', '.mu', null, 'MUR', 0],
                [141, 'YT', Yii::t('countries', 'Mayotte'), 'Mayotte', 'MYT', '175', 'no', '262', '.yt', null, 'EUR', 0],
                [142, 'MX', Yii::t('countries', 'Mexico'), 'United Mexican States', 'MEX', '484', 'yes', '52', '.mx', 10, 'MXN', 0],
                [143, 'FM', Yii::t('countries', 'Micronesia'), 'Federated States of Micronesia', 'FSM', '583', 'yes', '691', '.fm', 7, 'USD', 0],
                [144, 'MD', Yii::t('countries', 'Moldova'), 'Republic of Moldova', 'MDA', '498', 'yes', '373', '.md', 8, 'MDL', 0],
                [145, 'MC', Yii::t('countries', 'Monaco'), 'Principality of Monaco', 'MCO', '492', 'yes', '377', '.mc', null, 'EUR', 0],
                [146, 'MN', Yii::t('countries', 'Mongolia'), 'Mongolia', 'MNG', '496', 'yes', '976', '.mn', 8, 'MNT', 0],
                //[147, 'ME', Yii::t('countries', 'Montenegro'), 'Montenegro', 'MNE', '499', 'yes', '382', '.me', 8, null, 0],
                [148, 'MS', Yii::t('countries', 'Montserrat'), 'Montserrat', 'MSR', '500', 'no', '1-664', '.ms', 10, 'XCD', 0],
                [149, 'MA', Yii::t('countries', 'Morocco'), 'Kingdom of Morocco', 'MAR', '504', 'yes', '212', '.ma', null, 'MAD', 0],
                [150, 'MZ', Yii::t('countries', 'Mozambique'), 'Republic of Mozambique', 'MOZ', '508', 'yes', '258', '.mz', null, 'MZM', 0],
                [151, 'MM', Yii::t('countries', 'Myanmar [Burma]'), 'Republic of the Union of Myanmar', 'MMR', '104', 'yes', '95', '.mm', null, 'MMK', 0],
                [152, 'NA', Yii::t('countries', 'Namibia'), 'Republic of Namibia', 'NAM', '516', 'yes', '264', '.na', null, 'NAD', 0],
                [153, 'NR', Yii::t('countries', 'Nauru'), 'Republic of Nauru', 'NRU', '520', 'yes', '674', '.nr', null, 'AUD', 0],
                [154, 'NP', Yii::t('countries', 'Nepal'), 'Federal Democratic Republic of Nepal', 'NPL', '524', 'yes', '977', '.np', null, 'NPR', 0],
                [155, 'NL', Yii::t('countries', 'Netherlands'), 'Kingdom of the Netherlands', 'NLD', '528', 'yes', '31', '.nl', 9, 'EUR', 0],
                [156, 'NC', Yii::t('countries', 'New Caledonia'), 'New Caledonia', 'NCL', '540', 'no', '687', '.nc', 6, 'XPF', 0],
                [157, 'NZ', Yii::t('countries', 'New Zealand'), 'New Zealand', 'NZL', '554', 'yes', '64', '.nz', null, 'NZD', 0],
                [158, 'NI', Yii::t('countries', 'Nicaragua'), 'Republic of Nicaragua', 'NIC', '558', 'yes', '505', '.ni', null, 'NIC', 0],
                [159, 'NE', Yii::t('countries', 'Niger'), 'Republic of Niger', 'NER', '562', 'yes', '227', '.ne', 8, 'XOF', 0],
                [160, 'NG', Yii::t('countries', 'Nigeria'), 'Federal Republic of Nigeria', 'NGA', '566', 'yes', '234', '.ng', null, 'NGN', 0],
                [161, 'NU', Yii::t('countries', 'Niue'), 'Niue', 'NIU', '570', 'some', '683', '.nu', 4, 'NZD', 0],
                [162, 'NF', Yii::t('countries', 'Norfolk Island'), 'Norfolk Island', 'NFK', '574', 'no', '672', '.nf', 6, 'AUD', 0],
                [163, 'KP', Yii::t('countries', 'North Korea'), 'Democratic People\'s Republic of Korea', 'PRK', '408', 'yes', '850', '.kp', null, 'KPW', 0],
                [164, 'MP', Yii::t('countries', 'Northern Mariana Islands'), 'Northern Mariana Islands', 'MNP', '580', 'no', '1-670', '.mp', 10, 'USD', 0],
                [165, 'NO', Yii::t('countries', 'Norway'), 'Kingdom of Norway', 'NOR', '578', 'yes', '47', '.no', 8, 'NOK', 0],
                [166, 'OM', Yii::t('countries', 'Oman'), 'Sultanate of Oman', 'OMN', '512', 'yes', '968', '.om', null, 'OMR', 0],
                [167, 'PK', Yii::t('countries', 'Pakistan'), 'Islamic Republic of Pakistan', 'PAK', '586', 'yes', '92', '.pk', 10, 'PKR', 0],
                [168, 'PW', Yii::t('countries', 'Palau'), 'Republic of Palau', 'PLW', '585', 'yes', '680', '.pw', 7, 'USD', 0],
                //[169, 'PS', Yii::t('countries', 'Palestine'), 'State of Palestine [or Occupied Palestinian Territory]', 'PSE', '275', 'some', '970', '.ps', null, null, 0],
                [170, 'PA', Yii::t('countries', 'Panama'), 'Republic of Panama', 'PAN', '591', 'yes', '507', '.pa', 8, 'PAB', 0],
                [171, 'PG', Yii::t('countries', 'Papua New Guinea'), 'Independent State of Papua New Guinea', 'PNG', '598', 'yes', '675', '.pg', null, 'PGK', 0],
                [172, 'PY', Yii::t('countries', 'Paraguay'), 'Republic of Paraguay', 'PRY', '600', 'yes', '595', '.py', null, 'PYG', 0],
                [173, 'PE', Yii::t('countries', 'Peru'), 'Republic of Peru', 'PER', '604', 'yes', '51', '.pe', null, 'PEI', 0],
                [174, 'PH', Yii::t('countries', 'Phillipines'), 'Republic of the Philippines', 'PHL', '608', 'yes', '63', '.ph', 10, 'PHP', 0],
                //[175, 'PN', Yii::t('countries', 'Pitcairn'), 'Pitcairn', 'PCN', '612', 'no', 'NONE', '.pn', null, null, 0],
                [176, 'PL', Yii::t('countries', 'Poland'), 'Republic of Poland', 'POL', '616', 'yes', '48', '.pl', 9, 'PLN', 0],
                [177, 'PT', Yii::t('countries', 'Portugal'), 'Portuguese Republic', 'PRT', '620', 'yes', '351', '.pt', 9, 'EUR', 0],
                [178, 'PR', Yii::t('countries', 'Puerto Rico'), 'Commonwealth of Puerto Rico', 'PRI', '630', 'no', '1-939', '.pr', 10, 'USD', 0],
                [179, 'QA', Yii::t('countries', 'Qatar'), 'State of Qatar', 'QAT', '634', 'yes', '974', '.qa', null, 'QAR', 0],
                [180, 'RE', Yii::t('countries', 'Reunion'), 'R&eacute;union', 'REU', '638', 'no', '262', '.re', null, 'EUR', 0],
                [181, 'RO', Yii::t('countries', 'Romania'), 'Romania', 'ROU', '642', 'yes', '40', '.ro', null, 'ROL', 0],
                [182, 'RU', Yii::t('countries', 'Russia'), 'Russian Federation', 'RUS', '643', 'yes', '7', '.ru', 10, 'RUB', 0],
                [183, 'RW', Yii::t('countries', 'Rwanda'), 'Republic of Rwanda', 'RWA', '646', 'yes', '250', '.rw', null, 'RWF', 0],
                [184, 'BL', Yii::t('countries', 'Saint Barthelemy'), 'Saint Barth&eacute;lemy', 'BLM', '652', 'no', '590', '.bl', null, 'EUR', 0],
                [185, 'SH', Yii::t('countries', 'Saint Helena'), 'Saint Helena, Ascension and Tristan da Cunha', 'SHN', '654', 'no', '290', '.sh', 4, 'SHP', 0],
                [186, 'KN', Yii::t('countries', 'Saint Kitts and Nevis'), 'Federation of Saint Christopher and Nevis', 'KNA', '659', 'yes', '1-869', '.kn', 10, 'XCD', 0],
                [187, 'LC', Yii::t('countries', 'Saint Lucia'), 'Saint Lucia', 'LCA', '662', 'yes', '1-758', '.lc', 10, 'XCD', 0],
                [188, 'MF', Yii::t('countries', 'Saint Martin'), 'Saint Martin', 'MAF', '663', 'no', '590', '.mf', null, 'EUR', 0],
                [189, 'PM', Yii::t('countries', 'Saint Pierre and Miquelon'), 'Saint Pierre and Miquelon', 'SPM', '666', 'no', '508', '.pm', null, 'EUR', 0],
                [190, 'VC', Yii::t('countries', 'Saint Vincent and the Grenadines'), 'Saint Vincent and the Grenadines', 'VCT', '670', 'yes', '1-784', '.vc', 10, 'XCD', 0],
                [191, 'WS', Yii::t('countries', 'Samoa'), 'Independent State of Samoa', 'WSM', '882', 'yes', '685', '.ws', null, 'WST', 0],
                [192, 'SM', Yii::t('countries', 'San Marino'), 'Republic of San Marino', 'SMR', '674', 'yes', '378', '.sm', null, 'EUR', 0],
                [193, 'ST', Yii::t('countries', 'Sao Tome and Principe'), 'Democratic Republic of S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'STP', '678', 'yes', '239', '.st', null, 'STD', 0],
                [194, 'SA', Yii::t('countries', 'Saudi Arabia'), 'Kingdom of Saudi Arabia', 'SAU', '682', 'yes', '966', '.sa', 10, 'SAR', 0],
                [195, 'SN', Yii::t('countries', 'Senegal'), 'Republic of Senegal', 'SEN', '686', 'yes', '221', '.sn', null, 'XOF', 0],
                //[196, 'RS', Yii::t('countries', 'Serbia'), 'Republic of Serbia', 'SRB', '688', 'yes', '381', '.rs', 9, null, 0],
                [197, 'SC', Yii::t('countries', 'Seychelles'), 'Republic of Seychelles', 'SYC', '690', 'yes', '248', '.sc', null, 'SCR', 0],
                [198, 'SL', Yii::t('countries', 'Sierra Leone'), 'Republic of Sierra Leone', 'SLE', '694', 'yes', '232', '.sl', null, 'SLL', 0],
                [199, 'SG', Yii::t('countries', 'Singapore'), 'Republic of Singapore', 'SGP', '702', 'yes', '65', '.sg', null, 'SGD', 0],
                //[200, 'SX', Yii::t('countries', 'Sint Maarten'), 'Sint Maarten', 'SXM', '534', 'no', '1-721', '.sx', 10, null, 0],
                [201, 'SK', Yii::t('countries', 'Slovakia'), 'Slovak Republic', 'SVK', '703', 'yes', '421', '.sk', 9, 'EUR', 0],
                [202, 'SI', Yii::t('countries', 'Slovenia'), 'Republic of Slovenia', 'SVN', '705', 'yes', '386', '.si', null, 'EUR', 0],
                [203, 'SB', Yii::t('countries', 'Solomon Islands'), 'Solomon Islands', 'SLB', '090', 'yes', '677', '.sb', 7, 'SBD', 0],
                [204, 'SO', Yii::t('countries', 'Somalia'), 'Somali Republic', 'SOM', '706', 'yes', '252', '.so', null, 'SOS', 0],
                [205, 'ZA', Yii::t('countries', 'South Africa'), 'Republic of South Africa', 'ZAF', '710', 'yes', '27', '.za', 9, 'ZAR', 0],
                [206, 'GS', Yii::t('countries', 'South Georgia and the South Sandwich Islands'), 'South Georgia and the South Sandwich Islands', 'SGS', '239', 'no', '500', '.gs', null, 'GBP', 0],
                [207, 'KR', Yii::t('countries', 'South Korea'), 'Republic of Korea', 'KOR', '410', 'yes', '82', '.kr', null, 'KRW', 0],
                //[208, 'SS', Yii::t('countries', 'South Sudan'), 'Republic of South Sudan', 'SSD', '728', 'yes', '211', '.ss', null, null, 0],
                [209, 'ES', Yii::t('countries', 'Spain'), 'Kingdom of Spain', 'ESP', '724', 'yes', '34', '.es', 9, 'EUR', 0],
                [210, 'LK', Yii::t('countries', 'Sri Lanka'), 'Democratic Socialist Republic of Sri Lanka', 'LKA', '144', 'yes', '94', '.lk', 7, 'LKR', 0],
                [211, 'SD', Yii::t('countries', 'Sudan'), 'Republic of the Sudan', 'SDN', '729', 'yes', '249', '.sd', null, 'SDG', 0],
                [212, 'SR', Yii::t('countries', 'Suriname'), 'Republic of Suriname', 'SUR', '740', 'yes', '597', '.sr', null, 'SRG', 0],
                [213, 'SJ', Yii::t('countries', 'Svalbard and Jan Mayen'), 'Svalbard and Jan Mayen', 'SJM', '744', 'no', '47', '.sj', null, 'NOK', 0],
                [214, 'SZ', Yii::t('countries', 'Swaziland'), 'Kingdom of Swaziland', 'SWZ', '748', 'yes', '268', '.sz', null, 'SZL', 0],
                [215, 'SE', Yii::t('countries', 'Sweden'), 'Kingdom of Sweden', 'SWE', '752', 'yes', '46', '.se', null, 'SEK', 0],
                [216, 'CH', Yii::t('countries', 'Switzerland'), 'Swiss Confederation', 'CHE', '756', 'yes', '41', '.ch', 9, 'CHF', 0],
                [217, 'SY', Yii::t('countries', 'Syria'), 'Syrian Arab Republic', 'SYR', '760', 'yes', '963', '.sy', null, 'SYP', 0],
                [218, 'TW', Yii::t('countries', 'Taiwan'), 'Republic of China [Taiwan]', 'TWN', '158', 'former', '886', '.tw', 9, 'TWD', 0],
                [219, 'TJ', Yii::t('countries', 'Tajikistan'), 'Republic of Tajikistan', 'TJK', '762', 'yes', '992', '.tj', null, 'TJR', 0],
                [220, 'TZ', Yii::t('countries', 'Tanzania'), 'United Republic of Tanzania', 'TZA', '834', 'yes', '255', '.tz', null, 'TZS', 0],
                [221, 'TH', Yii::t('countries', 'Thailand'), 'Kingdom of Thailand', 'THA', '764', 'yes', '66', '.th', 9, 'THB', 0],
                //[222, 'TL', Yii::t('countries', 'Timor-Leste [East Timor]'), 'Democratic Republic of Timor-Leste', 'TLS', '626', 'yes', '670', '.tl', 8, null, 0],
                [223, 'TG', Yii::t('countries', 'Togo'), 'Togolese Republic', 'TGO', '768', 'yes', '228', '.tg', 8, 'XAF', 0],
                [224, 'TK', Yii::t('countries', 'Tokelau'), 'Tokelau', 'TKL', '772', 'no', '690', '.tk', null, 'NZD', 0],
                [225, 'TO', Yii::t('countries', 'Tonga'), 'Kingdom of Tonga', 'TON', '776', 'yes', '676', '.to', null, 'TOP', 0],
                [226, 'TT', Yii::t('countries', 'Trinidad and Tobago'), 'Republic of Trinidad and Tobago', 'TTO', '780', 'yes', '1-868', '.tt', 10, 'TTD', 0],
                [227, 'TN', Yii::t('countries', 'Tunisia'), 'Republic of Tunisia', 'TUN', '788', 'yes', '216', '.tn', null, 'TND', 0],
                [228, 'TR', Yii::t('countries', 'Turkey'), 'Republic of Turkey', 'TUR', '792', 'yes', '90', '.tr', 10, 'TRY', 0],
                [229, 'TM', Yii::t('countries', 'Turkmenistan'), 'Turkmenistan', 'TKM', '795', 'yes', '993', '.tm', null, 'TMM', 0],
                [230, 'TC', Yii::t('countries', 'Turks and Caicos Islands'), 'Turks and Caicos Islands', 'TCA', '796', 'no', '1-649', '.tc', 10, 'USD', 0],
                [231, 'TV', Yii::t('countries', 'Tuvalu'), 'Tuvalu', 'TUV', '798', 'yes', '688', '.tv', null, 'AUD', 0],
                [232, 'UG', Yii::t('countries', 'Uganda'), 'Republic of Uganda', 'UGA', '800', 'yes', '256', '.ug', null, 'UGS', 0],
                [233, 'UA', Yii::t('countries', 'Ukraine'), 'Ukraine', 'UKR', '804', 'yes', '380', '.ua', 9, 'UAH', 0],
                [234, 'AE', Yii::t('countries', 'United Arab Emirates'), 'United Arab Emirates', 'ARE', '784', 'yes', '971', '.ae', 10, 'AED', 0],
                [235, 'GB', Yii::t('countries', 'United Kingdom'), 'United Kingdom of Great Britain and Nothern Ireland', 'GBR', '826', 'yes', '44', '.uk', 10, 'GBP', 1],
                [236, 'US', Yii::t('countries', 'United States'), 'United States of America', 'USA', '840', 'yes', '1', '.us', 10, 'USD', 1],
                //[237, 'UM', Yii::t('countries', 'United States Minor Outlying Islands'), 'United States Minor Outlying Islands', 'UMI', '581', 'no', 'NONE', 'NONE', null, null, 0],
                [238, 'UY', Yii::t('countries', 'Uruguay'), 'Eastern Republic of Uruguay', 'URY', '858', 'yes', '598', '.uy', null, 'UYU', 0],
                [239, 'UZ', Yii::t('countries', 'Uzbekistan'), 'Republic of Uzbekistan', 'UZB', '860', 'yes', '998', '.uz', null, 'UZS', 0],
                [240, 'VU', Yii::t('countries', 'Vanuatu'), 'Republic of Vanuatu', 'VUT', '548', 'yes', '678', '.vu', null, 'VUV', 0],
                [241, 'VA', Yii::t('countries', 'Vatican City'), 'State of the Vatican City', 'VAT', '336', 'no', '39', '.va', 10, 'EUR', 0],
                [242, 'VE', Yii::t('countries', 'Venezuela'), 'Bolivarian Republic of Venezuela', 'VEN', '862', 'yes', '58', '.ve', null, 'VEF', 0],
                [243, 'VN', Yii::t('countries', 'Vietnam'), 'Socialist Republic of Vietnam', 'VNM', '704', 'yes', '84', '.vn', null, 'VND', 0],
                [244, 'VG', Yii::t('countries', 'Virgin Islands, British'), 'British Virgin Islands', 'VGB', '092', 'no', '1-284', '.vg', 10, 'USD', 0],
                [245, 'VI', Yii::t('countries', 'Virgin Islands, US'), 'Virgin Islands of the United States', 'VIR', '850', 'no', '1-340', '.vi', 10, 'USD', 0],
                [246, 'WF', Yii::t('countries', 'Wallis and Futuna'), 'Wallis and Futuna', 'WLF', '876', 'no', '681', '.wf', null, 'XPF', 0],
                [247, 'EH', Yii::t('countries', 'Western Sahara'), 'Western Sahara', 'ESH', '732', 'no', '212', '.eh', null, 'MAD', 0],
                //[248, 'YE', Yii::t('countries', 'Yemen'), 'Republic of Yemen', 'YEM', '887', 'yes', '967', '.ye', 9, null, 0],
                [249, 'ZM', Yii::t('countries', 'Zambia'), 'Republic of Zambia', 'ZMB', '894', 'yes', '260', '.zm', null, 'ZMK', 0],
                [250, 'ZW', Yii::t('countries', 'Zimbabwe'), 'Republic of Zimbabwe', 'ZWE', '716', 'yes', '263', '.zw', null, 'USD', 0]
            ]);
    }

    public function safeDown()
    {
        $this->dropForeignKey('country_place', 'country');
        $this->dropTable('country');
        $this->dropTable('place');
    }
}