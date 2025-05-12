<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\File;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for authorship
        $admin = User::first();

        // Create Home Pages
        $this->createHomePage('en', $admin->id);
        $this->createHomePage('he', $admin->id);
        
        // Create Service Pages
        $this->createServicePages('en', $admin->id);
        $this->createServicePages('he', $admin->id);
        
        // Create Legal Pages
        $this->createLegalPages('en', $admin->id);
        $this->createLegalPages('he', $admin->id);
    }
    
    /**
     * Create home page for a specific language.
     */
    private function createHomePage(string $language, int $userId): void
    {
        $title = $language === 'en' ? 'Powerful Web Hosting Solutions' : 'פתרונות אחסון אתרים מתקדמים';
        $subtitle = $language === 'en' ? 
            'Find the perfect domain for your project, business, or personal brand.' : 
            'מצא את הדומיין המושלם לפרויקט, לעסק או למותג האישי שלך.';
        
        $features = [];
        
        if ($language === 'en') {
            $features = [
                [
                    'title' => 'Shared Hosting',
                    'description' => 'Fast and reliable hosting for your website',
                    'icon' => 'server',
                    'cta_text' => 'View Plans',
                    'cta_url' => '/hosting'
                ],
                [
                    'title' => 'VPS Hosting',
                    'description' => 'Full power, full control for advanced users',
                    'icon' => 'processor',
                    'cta_text' => 'Get Started',
                    'cta_url' => '/vps'
                ],
                [
                    'title' => 'Domain Registration',
                    'description' => 'Get your name online with .com and more',
                    'icon' => 'globe',
                    'cta_text' => 'Check Availability',
                    'cta_url' => '/domains'
                ],
                [
                    'title' => 'Cloud Solutions',
                    'description' => 'Scalable cloud infrastructure for any project',
                    'icon' => 'cloud',
                    'cta_text' => 'Explore',
                    'cta_url' => '/cloud'
                ]
            ];
        } else {
            $features = [
                [
                    'title' => 'אחסון אתרים משותף',
                    'description' => 'אחסון מהיר ואמין לאתר שלך',
                    'icon' => 'server',
                    'cta_text' => 'צפה בתוכניות',
                    'cta_url' => '/hosting'
                ],
                [
                    'title' => 'אחסון VPS',
                    'description' => 'עוצמה מלאה ושליטה מלאה למשתמשים מתקדמים',
                    'icon' => 'processor',
                    'cta_text' => 'התחל עכשיו',
                    'cta_url' => '/vps'
                ],
                [
                    'title' => 'רישום דומיינים',
                    'description' => 'קבל את השם שלך ברשת עם com. ועוד',
                    'icon' => 'globe',
                    'cta_text' => 'בדוק זמינות',
                    'cta_url' => '/domains'
                ],
                [
                    'title' => 'פתרונות ענן',
                    'description' => 'תשתית ענן מדרגית לכל פרויקט',
                    'icon' => 'cloud',
                    'cta_text' => 'גלה עוד',
                    'cta_url' => '/cloud'
                ]
            ];
        }
        
        Page::create([
            'title' => $title,
            'slug' => $language === 'en' ? 'home' : 'home-' . $language,
            'type' => 'home',
            'language' => $language,
            'content' => '<p>' . ($language === 'en' ? 
                'Welcome to NM-DigitalHUB, your complete hosting solution. We provide reliable hosting, domain registration, and cloud services for businesses of all sizes.' : 
                'ברוכים הבאים ל-NM-DigitalHUB, פתרון האחסון המושלם שלך. אנו מספקים שירותי אחסון אמינים, רישום דומיינים ושירותי ענן לעסקים בכל הגדלים.') . '</p>',
            'meta_title' => $language === 'en' ? 'NM-DigitalHUB - Web Hosting & Domain Registration' : 'NM-DigitalHUB - אחסון אתרים ורישום דומיינים',
            'meta_description' => $language === 'en' ? 
                'Reliable web hosting, domain registration, VPS and cloud solutions for your business. 24/7 support and great prices.' : 
                'אחסון אתרים אמין, רישום דומיינים, שרתים וירטואליים ופתרונות ענן לעסק שלך. תמיכה 24/7 ומחירים נהדרים.',
            'is_published' => true,
            'layout' => 'default',
            'order' => 1,
            'user_id' => $userId,
            'metadata' => [
                'hero' => [
                    'subtitle' => $subtitle
                ],
                'features' => $features
            ]
        ]);
    }
    
    /**
     * Create service pages for a specific language.
     */
    private function createServicePages(string $language, int $userId): void
    {
        // Create Domains Page
        $this->createDomainsPage($language, $userId);
        
        // Create Hosting Page
        $this->createHostingPage($language, $userId);
        
        // Create VPS Page
        $this->createVpsPage($language, $userId);
        
        // Create Cloud Page
        $this->createCloudPage($language, $userId);
    }
    
    /**
     * Create domains page for a specific language.
     */
    private function createDomainsPage(string $language, int $userId): void
    {
        $title = $language === 'en' ? 'Domain Name Search' : 'חיפוש שמות דומיין';
        $subtitle = $language === 'en' ? 
            'Find the perfect domain name for your business or project.' : 
            'מצא את שם הדומיין המושלם לעסק או לפרויקט שלך.';
            
        $content = $language === 'en' ?
            '<p>Your domain name is your online identity. We offer a wide range of top-level domains at competitive prices. Use our search tool to find the perfect domain for your business or project.</p>' :
            '<p>שם הדומיין שלך הוא הזהות המקוונת שלך. אנו מציעים מגוון רחב של דומיינים במחירים תחרותיים. השתמש בכלי החיפוש שלנו כדי למצוא את הדומיין המושלם לעסק או לפרויקט שלך.</p>';
            
        $pricingTable = $language === 'en' ? [
            ['extension' => '.com', 'registration' => '$12.99', 'renewal' => '$14.99', 'transfer' => '$12.99'],
            ['extension' => '.net', 'registration' => '$14.99', 'renewal' => '$16.99', 'transfer' => '$14.99'],
            ['extension' => '.org', 'registration' => '$12.99', 'renewal' => '$14.99', 'transfer' => '$12.99'],
            ['extension' => '.io', 'registration' => '$39.99', 'renewal' => '$39.99', 'transfer' => '$39.99'],
            ['extension' => '.co', 'registration' => '$24.99', 'renewal' => '$24.99', 'transfer' => '$24.99'],
        ] : [
            ['extension' => '.com', 'registration' => '₪49.99', 'renewal' => '₪59.99', 'transfer' => '₪49.99'],
            ['extension' => '.net', 'registration' => '₪59.99', 'renewal' => '₪69.99', 'transfer' => '₪59.99'],
            ['extension' => '.org', 'registration' => '₪49.99', 'renewal' => '₪59.99', 'transfer' => '₪49.99'],
            ['extension' => '.io', 'registration' => '₪149.99', 'renewal' => '₪149.99', 'transfer' => '₪149.99'],
            ['extension' => '.co.il', 'registration' => '₪99.99', 'renewal' => '₪99.99', 'transfer' => '₪99.99'],
        ];
        
        $domainCards = $language === 'en' ? [
            [
                'title' => '.com Domains',
                'description' => 'The most popular domain extension for businesses worldwide.',
                'price' => 'Starting at $9.99/year'
            ],
            [
                'title' => '.net Domains',
                'description' => 'Ideal for technology, networking and infrastructure companies.',
                'price' => 'Starting at $11.99/year'
            ],
            [
                'title' => '.org Domains',
                'description' => 'Perfect for organizations, non-profits and communities.',
                'price' => 'Starting at $12.99/year'
            ]
        ] : [
            [
                'title' => 'דומיינים com.',
                'description' => 'סיומת הדומיין הפופולרית ביותר לעסקים בכל העולם.',
                'price' => 'החל מ-₪49.99/שנה'
            ],
            [
                'title' => 'דומיינים net.',
                'description' => 'אידיאלי לחברות טכנולוגיה, רשתות ותשתיות.',
                'price' => 'החל מ-₪59.99/שנה'
            ],
            [
                'title' => 'דומיינים org.',
                'description' => 'מושלם לארגונים, מלכ"רים וקהילות.',
                'price' => 'החל מ-₪49.99/שנה'
            ]
        ];
        
        Page::create([
            'title' => $title,
            'slug' => 'domains-' . $language,
            'type' => 'domains',
            'language' => $language,
            'content' => $content,
            'meta_title' => $language === 'en' ? 'Domain Name Registration | NM-DigitalHUB' : 'רישום שמות דומיין | NM-DigitalHUB',
            'meta_description' => $language === 'en' ? 
                'Register your perfect domain name with NM-DigitalHUB. We offer a wide range of top-level domains at competitive prices.' : 
                'רשום את שם הדומיין המושלם שלך עם NM-DigitalHUB. אנו מציעים מגוון רחב של דומיינים במחירים תחרותיים.',
            'is_published' => true,
            'layout' => 'default',
            'order' => 10,
            'user_id' => $userId,
            'metadata' => [
                'subtitle' => $subtitle,
                'pricing_title' => $language === 'en' ? 'Domain Pricing' : 'מחירי דומיינים',
                'pricing_columns' => [
                    'extension' => $language === 'en' ? 'Domain Extension' : 'סיומת דומיין',
                    'registration' => $language === 'en' ? 'Registration' : 'רישום',
                    'renewal' => $language === 'en' ? 'Renewal' : 'חידוש',
                    'transfer' => $language === 'en' ? 'Transfer' : 'העברה'
                ],
                'pricing_table' => $pricingTable,
                'domain_cards' => $domainCards
            ]
        ]);
    }
    
    /**
     * Create hosting page for a specific language.
     */
    private function createHostingPage(string $language, int $userId): void
    {
        $title = $language === 'en' ? 'Web Hosting Plans' : 'תוכניות אחסון אתרים';
        $subtitle = $language === 'en' ? 
            'Secure and reliable hosting for your website.' : 
            'אחסון אתרים אמין ומאובטח.';
            
        $content = $language === 'en' ?
            '<p>Our web hosting solutions are designed to provide fast, reliable and secure hosting for websites of all sizes. Choose the plan that best fits your needs and get your website online today.</p>' :
            '<p>פתרונות אחסון האתרים שלנו מיועדים לספק אחסון מהיר, אמין ומאובטח לאתרים בכל הגדלים. בחר את התוכנית שמתאימה לצרכים שלך והעלה את האתר שלך לאוויר היום.</p>';
            
        $hostingPlans = $language === 'en' ? [
            [
                'name' => 'Basic',
                'price' => '$4.99',
                'price_period' => '/mo',
                'features' => [
                    '1 Website',
                    '10GB Storage',
                    'Free SSL Certificate'
                ],
                'cta_text' => 'Get Started',
                'cta_url' => '#'
            ],
            [
                'name' => 'Premium',
                'price' => '$8.99',
                'price_period' => '/mo',
                'features' => [
                    'Unlimited Websites',
                    '50GB Storage',
                    'Free SSL Certificate',
                    'Free Domain'
                ],
                'cta_text' => 'Get Started',
                'cta_url' => '#',
                'popular' => true
            ],
            [
                'name' => 'Business',
                'price' => '$14.99',
                'price_period' => '/mo',
                'features' => [
                    'Unlimited Websites',
                    '100GB Storage',
                    'Free SSL Certificate',
                    'Free Domain',
                    'Dedicated Resources'
                ],
                'cta_text' => 'Get Started',
                'cta_url' => '#'
            ]
        ] : [
            [
                'name' => 'בסיסי',
                'price' => '₪19.99',
                'price_period' => '/חודש',
                'features' => [
                    'אתר אחד',
                    '10GB אחסון',
                    'תעודת SSL חינם'
                ],
                'cta_text' => 'התחל עכשיו',
                'cta_url' => '#'
            ],
            [
                'name' => 'פרימיום',
                'price' => '₪34.99',
                'price_period' => '/חודש',
                'features' => [
                    'אתרים ללא הגבלה',
                    '50GB אחסון',
                    'תעודת SSL חינם',
                    'דומיין חינם'
                ],
                'cta_text' => 'התחל עכשיו',
                'cta_url' => '#',
                'popular' => true
            ],
            [
                'name' => 'עסקי',
                'price' => '₪59.99',
                'price_period' => '/חודש',
                'features' => [
                    'אתרים ללא הגבלה',
                    '100GB אחסון',
                    'תעודת SSL חינם',
                    'דומיין חינם',
                    'משאבים ייעודיים'
                ],
                'cta_text' => 'התחל עכשיו',
                'cta_url' => '#'
            ]
        ];
        
        Page::create([
            'title' => $title,
            'slug' => 'hosting-' . $language,
            'type' => 'hosting',
            'language' => $language,
            'content' => $content,
            'meta_title' => $language === 'en' ? 'Web Hosting Plans | NM-DigitalHUB' : 'תוכניות אחסון אתרים | NM-DigitalHUB',
            'meta_description' => $language === 'en' ? 
                'Fast and reliable web hosting solutions for businesses of all sizes. Choose from our range of hosting plans designed to fit your needs.' : 
                'פתרונות אחסון אתרים מהירים ואמינים לעסקים בכל הגדלים. בחר מתוך מגוון תוכניות האחסון שלנו המותאמות לצרכים שלך.',
            'is_published' => true,
            'layout' => 'default',
            'order' => 20,
            'user_id' => $userId,
            'metadata' => [
                'subtitle' => $subtitle,
                'hosting_plans' => $hostingPlans
            ]
        ]);
    }
    
    /**
     * Create VPS page for a specific language.
     */
    private function createVpsPage(string $language, int $userId): void
    {
        $title = $language === 'en' ? 'VPS Hosting Solutions' : 'פתרונות אחסון VPS';
        $subtitle = $language === 'en' ? 
            'Virtual Private Servers with full root access and dedicated resources.' : 
            'שרתים וירטואליים פרטיים עם גישת שורש מלאה ומשאבים ייעודיים.';
            
        $content = $language === 'en' ?
            '<p>Our VPS hosting solutions provide the perfect balance of performance, price, and ease of use. With full root access and dedicated resources, you have complete control over your server environment.</p>' :
            '<p>פתרונות אחסון ה-VPS שלנו מספקים את האיזון המושלם בין ביצועים, מחיר וקלות שימוש. עם גישת שורש מלאה ומשאבים ייעודיים, יש לך שליטה מלאה על סביבת השרת שלך.</p>';
            
        $vpsPlans = $language === 'en' ? [
            [
                'name' => 'Basic VPS',
                'price' => '$19.99',
                'price_period' => '/mo',
                'specs' => [
                    '2 vCPU Cores',
                    '2GB RAM',
                    '50GB SSD Storage',
                    '1TB Bandwidth'
                ],
                'cta_text' => 'Get Started',
                'cta_url' => '#'
            ],
            [
                'name' => 'Standard VPS',
                'price' => '$39.99',
                'price_period' => '/mo',
                'specs' => [
                    '4 vCPU Cores',
                    '8GB RAM',
                    '100GB SSD Storage',
                    '3TB Bandwidth'
                ],
                'cta_text' => 'Get Started',
                'cta_url' => '#',
                'popular' => true
            ],
            [
                'name' => 'Premium VPS',
                'price' => '$79.99',
                'price_period' => '/mo',
                'specs' => [
                    '8 vCPU Cores',
                    '16GB RAM',
                    '200GB SSD Storage',
                    '5TB Bandwidth',
                    'Dedicated IP'
                ],
                'cta_text' => 'Get Started',
                'cta_url' => '#'
            ]
        ] : [
            [
                'name' => 'VPS בסיסי',
                'price' => '₪79.99',
                'price_period' => '/חודש',
                'specs' => [
                    '2 ליבות vCPU',
                    '2GB RAM',
                    '50GB אחסון SSD',
                    '1TB רוחב פס'
                ],
                'cta_text' => 'התחל עכשיו',
                'cta_url' => '#'
            ],
            [
                'name' => 'VPS סטנדרטי',
                'price' => '₪159.99',
                'price_period' => '/חודש',
                'specs' => [
                    '4 ליבות vCPU',
                    '8GB RAM',
                    '100GB אחסון SSD',
                    '3TB רוחב פס'
                ],
                'cta_text' => 'התחל עכשיו',
                'cta_url' => '#',
                'popular' => true
            ],
            [
                'name' => 'VPS פרימיום',
                'price' => '₪319.99',
                'price_period' => '/חודש',
                'specs' => [
                    '8 ליבות vCPU',
                    '16GB RAM',
                    '200GB אחסון SSD',
                    '5TB רוחב פס',
                    'כתובת IP ייעודית'
                ],
                'cta_text' => 'התחל עכשיו',
                'cta_url' => '#'
            ]
        ];
        
        $featuresSection = $language === 'en' ? [
            'title' => 'VPS Features',
            'features' => [
                [
                    'title' => 'Full Root Access',
                    'description' => 'Complete control over your server environment.'
                ],
                [
                    'title' => 'Dedicated Resources',
                    'description' => 'Guaranteed CPU, RAM, and storage for your applications.'
                ],
                [
                    'title' => 'SSD Storage',
                    'description' => 'Lightning-fast SSD storage for optimal performance.'
                ],
                [
                    'title' => 'Scalable',
                    'description' => 'Easily upgrade your resources as your needs grow.'
                ],
                [
                    'title' => '24/7 Support',
                    'description' => 'Our expert support team is available around the clock.'
                ],
                [
                    'title' => '99.9% Uptime',
                    'description' => 'We guarantee reliable service with minimal downtime.'
                ]
            ]
        ] : [
            'title' => 'תכונות VPS',
            'features' => [
                [
                    'title' => 'גישת שורש מלאה',
                    'description' => 'שליטה מלאה על סביבת השרת שלך.'
                ],
                [
                    'title' => 'משאבים ייעודיים',
                    'description' => 'מובטחים CPU, RAM ואחסון ליישומים שלך.'
                ],
                [
                    'title' => 'אחסון SSD',
                    'description' => 'אחסון SSD מהיר כברק לביצועים מיטביים.'
                ],
                [
                    'title' => 'מדרגי',
                    'description' => 'שדרוג קל של המשאבים שלך כאשר הצרכים שלך גדלים.'
                ],
                [
                    'title' => 'תמיכה 24/7',
                    'description' => 'צוות התמיכה המומחה שלנו זמין בכל שעות היממה.'
                ],
                [
                    'title' => '99.9% זמן פעילות',
                    'description' => 'אנו מבטיחים שירות אמין עם זמן השבתה מינימלי.'
                ]
            ]
        ];
        
        Page::create([
            'title' => $title,
            'slug' => 'vps-' . $language,
            'type' => 'vps',
            'language' => $language,
            'content' => $content,
            'meta_title' => $language === 'en' ? 'VPS Hosting Solutions | NM-DigitalHUB' : 'פתרונות אחסון VPS | NM-DigitalHUB',
            'meta_description' => $language === 'en' ? 
                'Powerful VPS hosting with dedicated resources, full root access, and 24/7 support. Choose the plan that fits your needs.' : 
                'אחסון VPS עוצמתי עם משאבים ייעודיים, גישת שורש מלאה ותמיכה 24/7. בחר את התוכנית שמתאימה לצרכים שלך.',
            'is_published' => true,
            'layout' => 'default',
            'order' => 30,
            'user_id' => $userId,
            'metadata' => [
                'subtitle' => $subtitle,
                'vps_plans' => $vpsPlans,
                'features_section' => $featuresSection
            ]
        ]);
    }
    
    /**
     * Create cloud page for a specific language.
     */
    private function createCloudPage(string $language, int $userId): void
    {
        $title = $language === 'en' ? 'Cloud Solutions' : 'פתרונות ענן';
        $subtitle = $language === 'en' ? 
            'Scalable cloud solutions for your business.' : 
            'פתרונות ענן מדרגיים לעסק שלך.';
            
        $content = $language === 'en' ?
            '<p>Our cloud solutions provide the flexibility, scalability, and reliability your business needs. From simple storage to complex infrastructure, we have the cloud services to help your business grow.</p>' :
            '<p>פתרונות הענן שלנו מספקים את הגמישות, המדרגיות והאמינות שהעסק שלך צריך. מאחסון פשוט ועד לתשתית מורכבת, יש לנו את שירותי הענן שיעזרו לעסק שלך לצמוח.</p>';
            
        $cloudSolutions = $language === 'en' ? [
            [
                'title' => 'Cloud Storage',
                'icon' => 'database',
                'description' => 'Secure and reliable cloud storage for your files and data.',
                'features' => [
                    'Automatic backups',
                    'Easy file sharing',
                    'Access from anywhere',
                    'Enterprise-grade security'
                ],
                'price' => 'From $9.99',
                'price_period' => '/mo',
                'cta_text' => 'Learn More',
                'cta_url' => '#'
            ],
            [
                'title' => 'Cloud Servers',
                'icon' => 'server',
                'description' => 'Scalable cloud computing resources for any workload.',
                'features' => [
                    'On-demand scaling',
                    'Pay-as-you-go pricing',
                    'Global availability',
                    'High-performance computing'
                ],
                'price' => 'From $29.99',
                'price_period' => '/mo',
                'cta_text' => 'Learn More',
                'cta_url' => '#'
            ],
            [
                'title' => 'Cloud Security',
                'icon' => 'shield',
                'description' => 'Comprehensive security solutions for your cloud infrastructure.',
                'features' => [
                    'DDoS protection',
                    'Firewall services',
                    'Intrusion detection',
                    'Compliance monitoring'
                ],
                'price' => 'From $19.99',
                'price_period' => '/mo',
                'cta_text' => 'Learn More',
                'cta_url' => '#'
            ]
        ] : [
            [
                'title' => 'אחסון בענן',
                'icon' => 'database',
                'description' => 'אחסון ענן מאובטח ואמין עבור הקבצים והנתונים שלך.',
                'features' => [
                    'גיבויים אוטומטיים',
                    'שיתוף קבצים קל',
                    'גישה מכל מקום',
                    'אבטחה ברמה ארגונית'
                ],
                'price' => 'החל מ-₪39.99',
                'price_period' => '/חודש',
                'cta_text' => 'למידע נוסף',
                'cta_url' => '#'
            ],
            [
                'title' => 'שרתי ענן',
                'icon' => 'server',
                'description' => 'משאבי מחשוב ענן מדרגיים לכל עומס עבודה.',
                'features' => [
                    'שינוי גודל לפי דרישה',
                    'תמחור לפי שימוש',
                    'זמינות גלובלית',
                    'מחשוב בביצועים גבוהים'
                ],
                'price' => 'החל מ-₪119.99',
                'price_period' => '/חודש',
                'cta_text' => 'למידע נוסף',
                'cta_url' => '#'
            ],
            [
                'title' => 'אבטחת ענן',
                'icon' => 'shield',
                'description' => 'פתרונות אבטחה מקיפים לתשתית הענן שלך.',
                'features' => [
                    'הגנה מפני מתקפות DDoS',
                    'שירותי חומת אש',
                    'זיהוי חדירות',
                    'ניטור תאימות'
                ],
                'price' => 'החל מ-₪79.99',
                'price_period' => '/חודש',
                'cta_text' => 'למידע נוסף',
                'cta_url' => '#'
            ]
        ];
        
        $testimonials = $language === 'en' ? [
            [
                'name' => 'David Cohen',
                'company' => 'Tech Innovations Ltd',
                'quote' => 'The cloud server solution from NM-DigitalHUB has transformed our business operations. The scalability and reliability have been exceptional.'
            ],
            [
                'name' => 'Sarah Johnson',
                'company' => 'E-commerce Solutions',
                'quote' => 'We\'ve been using the cloud storage services for over a year now, and we couldn\'t be happier with the performance and security.'
            ],
            [
                'name' => 'Michael Levy',
                'company' => 'Digital Marketing Agency',
                'quote' => 'The cloud security services have given us peace of mind knowing our data and clients\' information are protected at all times.'
            ]
        ] : [
            [
                'name' => 'דוד כהן',
                'company' => 'חדשנות טכנולוגית בע"מ',
                'quote' => 'פתרון שרתי הענן מ-NM-DigitalHUB שינה את אופן התפעול העסקי שלנו. המדרגיות והאמינות היו יוצאות מן הכלל.'
            ],
            [
                'name' => 'שרה יוסף',
                'company' => 'פתרונות מסחר אלקטרוני',
                'quote' => 'אנו משתמשים בשירותי אחסון הענן כבר למעלה משנה, ואנחנו לא יכולים להיות מרוצים יותר מהביצועים והאבטחה.'
            ],
            [
                'name' => 'מיכאל לוי',
                'company' => 'סוכנות שיווק דיגיטלי',
                'quote' => 'שירותי אבטחת הענן נתנו לנו שקט נפשי ביודענו שהנתונים והמידע של הלקוחות שלנו מוגנים בכל עת.'
            ]
        ];
        
        Page::create([
            'title' => $title,
            'slug' => 'cloud-' . $language,
            'type' => 'cloud',
            'language' => $language,
            'content' => $content,
            'meta_title' => $language === 'en' ? 'Cloud Solutions | NM-DigitalHUB' : 'פתרונות ענן | NM-DigitalHUB',
            'meta_description' => $language === 'en' ? 
                'Scalable cloud solutions for businesses of all sizes. Storage, servers, and security services designed to help your business grow.' : 
                'פתרונות ענן מדרגיים לעסקים בכל הגדלים. שירותי אחסון, שרתים ואבטחה המיועדים לעזור לעסק שלך לצמוח.',
            'is_published' => true,
            'layout' => 'default',
            'order' => 40,
            'user_id' => $userId,
            'metadata' => [
                'subtitle' => $subtitle,
                'cloud_solutions' => $cloudSolutions,
                'testimonials' => $testimonials,
                'testimonials_title' => $language === 'en' ? 'What Our Customers Say' : 'מה אומרים הלקוחות שלנו'
            ]
        ]);
    }
    
    /**
     * Create legal pages for a specific language.
     */
    private function createLegalPages(string $language, int $userId): void
    {
        // Create Terms Page
        $termsContent = '';
        $termsPath = resource_path('markdown/' . ($language === 'en' ? 'terms.md' : 'terms_he.md'));
        
        if (File::exists($termsPath)) {
            $termsContent = File::get($termsPath);
        } else {
            $termsContent = $language === 'en' ? 
                '# Terms of Service
                
## 1. Terms
By accessing this website, you are agreeing to be bound by these terms of service, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained in this website are protected by applicable copyright and trademark law.

## 2. Use License
Permission is granted to temporarily download one copy of the materials (information or software) on NM-DigitalHUB\'s website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
- modify or copy the materials;
- use the materials for any commercial purpose, or for any public display (commercial or non-commercial);
- attempt to decompile or reverse engineer any software contained on NM-DigitalHUB\'s website;
- remove any copyright or other proprietary notations from the materials; or
- transfer the materials to another person or "mirror" the materials on any other server.' : 
                '# תנאי שירות
                
## 1. תנאים
על ידי גישה לאתר זה, אתה מסכים להיות מחויב לתנאי שירות אלה, לכל החוקים והתקנות החלים, ומסכים כי אתה אחראי לציות לכל החוקים המקומיים החלים. אם אינך מסכים לאיזה מתנאים אלה, אסור לך להשתמש או לגשת לאתר זה. החומרים הכלולים באתר זה מוגנים על ידי זכויות יוצרים וחוקי סימני מסחר החלים.

## 2. רישיון שימוש
ניתן אישור להוריד באופן זמני עותק אחד של החומרים (מידע או תוכנה) באתר של NM-DigitalHUB לצפייה אישית, לא מסחרית בלבד. זהו מתן רישיון, לא העברת בעלות, ובמסגרת רישיון זה אינך רשאי:
- לשנות או להעתיק את החומרים;
- להשתמש בחומרים לכל מטרה מסחרית, או לכל תצוגה ציבורית (מסחרית או לא מסחרית);
- לנסות לפרק או להנדס לאחור כל תוכנה הכלולה באתר של NM-DigitalHUB;
- להסיר כל זכויות יוצרים או סימונים קנייניים אחרים מהחומרים; או
- להעביר את החומרים לאדם אחר או "לשקף" את החומרים בכל שרת אחר.';
        }
        
        Page::create([
            'title' => $language === 'en' ? 'Terms of Service' : 'תנאי שירות',
            'slug' => 'terms-' . $language,
            'type' => 'legal',
            'language' => $language,
            'content' => $termsContent,
            'meta_title' => $language === 'en' ? 'Terms of Service | NM-DigitalHUB' : 'תנאי שירות | NM-DigitalHUB',
            'meta_description' => $language === 'en' ? 
                'Terms of service for NM-DigitalHUB. Please read these terms carefully before using our services.' : 
                'תנאי השירות של NM-DigitalHUB. אנא קרא תנאים אלה בעיון לפני השימוש בשירותים שלנו.',
            'is_published' => true,
            'layout' => 'default',
            'order' => 90,
            'user_id' => $userId
        ]);
        
        // Create Privacy Policy Page
        $policyContent = '';
        $policyPath = resource_path('markdown/' . ($language === 'en' ? 'policy.md' : 'policy_he.md'));
        
        if (File::exists($policyPath)) {
            $policyContent = File::get($policyPath);
        } else {
            $policyContent = $language === 'en' ? 
                '# Privacy Policy

## 1. Introduction
Your privacy is important to us. It is NM-DigitalHUB\'s policy to respect your privacy regarding any information we may collect from you across our website, and other sites we own and operate.

## 2. Information We Collect
We only collect information about you if we have a reason to do so – for example, to provide our services, to communicate with you, or to make our services better. We collect information in the following ways:

### 2.1 Basic Account Information
We ask for basic information from you in order to set up your account. For example, we require individuals who sign up for an account to provide an email address and password.

### 2.2 Information You Provide to Us
We collect information that you provide to us. For example, when you create an account, we collect your name, email address, and any other information you provide.

### 2.3 Automatically Collected Information
We automatically collect some information about your visit to our website. This includes the following:
- Your IP address
- Browser type and version
- Device information
- Log information
- Location information
- Usage information' : 
                '# מדיניות פרטיות

## 1. הקדמה
הפרטיות שלך חשובה לנו. זוהי מדיניות של NM-DigitalHUB לכבד את פרטיותך בנוגע לכל מידע שאנו עשויים לאסוף ממך באתר האינטרנט שלנו ובאתרים אחרים שאנו מחזיקים ומפעילים.

## 2. המידע שאנו אוספים
אנו אוספים מידע עליך רק אם יש לנו סיבה לעשות זאת - לדוגמה, כדי לספק את השירותים שלנו, לתקשר איתך או לשפר את השירותים שלנו. אנו אוספים מידע בדרכים הבאות:

### 2.1 מידע חשבון בסיסי
אנו מבקשים מידע בסיסי ממך כדי להגדיר את החשבון שלך. לדוגמה, אנו דורשים מאנשים הנרשמים לחשבון לספק כתובת דוא"ל וסיסמה.

### 2.2 מידע שאתה מספק לנו
אנו אוספים מידע שאתה מספק לנו. לדוגמה, כאשר אתה יוצר חשבון, אנו אוספים את שמך, כתובת הדוא"ל שלך וכל מידע אחר שאתה מספק.

### 2.3 מידע שנאסף אוטומטית
אנו אוספים אוטומטית מידע מסוים על הביקור שלך באתר שלנו. זה כולל את הבאים:
- כתובת ה-IP שלך
- סוג ודגם דפדפן
- מידע על המכשיר
- מידע יומן
- מידע מיקום
- מידע שימוש';
        }
        
        Page::create([
            'title' => $language === 'en' ? 'Privacy Policy' : 'מדיניות פרטיות',
            'slug' => 'policy-' . $language,
            'type' => 'legal',
            'language' => $language,
            'content' => $policyContent,
            'meta_title' => $language === 'en' ? 'Privacy Policy | NM-DigitalHUB' : 'מדיניות פרטיות | NM-DigitalHUB',
            'meta_description' => $language === 'en' ? 
                'Privacy policy for NM-DigitalHUB. Learn how we collect, use, and protect your personal information.' : 
                'מדיניות הפרטיות של NM-DigitalHUB. למד כיצד אנו אוספים, משתמשים ומגנים על המידע האישי שלך.',
            'is_published' => true,
            'layout' => 'default',
            'order' => 95,
            'user_id' => $userId
        ]);
    }
}