<?php
/**
 * Database Connection & Auto-Setup
 * Uses PDO with MySQL
 */

require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = getenv('DB_HOST') ?: 'localhost';
        $dbname = getenv('DB_NAME') ?: 'astraclicks';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';

        try {
            // First connect without database to create it if needed
            $this->pdo = new PDO(
                "mysql:host=$host;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            // Create database if not exists
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->pdo->exec("USE `$dbname`");

            // Auto-create tables
            $this->createTables();
            $this->seedDefaultData();

        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    private function createTables() {
        $queries = [
            // Services table
            "CREATE TABLE IF NOT EXISTS `services` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `service_name` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(255) NOT NULL UNIQUE,
                `banner_image` VARCHAR(500) DEFAULT NULL,
                `short_description` TEXT DEFAULT NULL,
                `full_description` LONGTEXT DEFAULT NULL,
                `meta_title` VARCHAR(255) DEFAULT NULL,
                `meta_description` TEXT DEFAULT NULL,
                `status` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Service Gallery table
            "CREATE TABLE IF NOT EXISTS `service_gallery` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `service_id` INT NOT NULL,
                `image` VARCHAR(500) NOT NULL,
                `alt_tag` VARCHAR(255) DEFAULT NULL,
                `status` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Blogs table
            "CREATE TABLE IF NOT EXISTS `blogs` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(500) NOT NULL,
                `slug` VARCHAR(500) NOT NULL UNIQUE,
                `category` VARCHAR(255) DEFAULT NULL,
                `short_description` TEXT DEFAULT NULL,
                `full_description` LONGTEXT DEFAULT NULL,
                `featured_image` VARCHAR(500) DEFAULT NULL,
                `meta_title` VARCHAR(255) DEFAULT NULL,
                `meta_description` TEXT DEFAULT NULL,
                `tags` VARCHAR(500) DEFAULT NULL,
                `status` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Gallery table
            "CREATE TABLE IF NOT EXISTS `gallery` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `image_title` VARCHAR(255) DEFAULT NULL,
                `category` VARCHAR(255) DEFAULT NULL,
                `alt_tag` VARCHAR(255) DEFAULT NULL,
                `image` VARCHAR(500) NOT NULL,
                `status` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Enquiries table
            "CREATE TABLE IF NOT EXISTS `enquiries` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `whatsapp_number` VARCHAR(20) NOT NULL,
                `event_details` TEXT DEFAULT NULL,
                `event_date` DATE DEFAULT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Branches table
            "CREATE TABLE IF NOT EXISTS `branches` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `branch_name` VARCHAR(255) NOT NULL,
                `address` TEXT NOT NULL,
                `phone` VARCHAR(20) NOT NULL,
                `google_map` TEXT DEFAULT NULL,
                `status` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Hero Banners table
            "CREATE TABLE IF NOT EXISTS `hero_banners` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `image` VARCHAR(500) NOT NULL,
                `alt_text` VARCHAR(255) DEFAULT NULL,
                `sort_order` INT DEFAULT 0,
                `status` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

            // Site Settings table
            "CREATE TABLE IF NOT EXISTS `site_settings` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `setting_key` VARCHAR(255) NOT NULL UNIQUE,
                `setting_value` TEXT DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        ];

        foreach ($queries as $query) {
            $this->pdo->exec($query);
        }
    }

    private function seedDefaultData() {
        // Check if already seeded
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM services");
        if ($stmt->fetchColumn() > 0) {
            return; // Already seeded
        }

        // Default services
        $services = [
            ['Weddings', 'weddings', 'Capture your special day with stunning wedding photography and videography.', 'Professional wedding photography and videography services to capture every beautiful moment of your special day.'],
            ['Reception', 'reception', 'Beautiful reception photography to preserve your celebration memories.', 'Our reception photography services ensure every joyful moment, dance, and celebration is captured beautifully.'],
            ['Pre-Wedding', 'pre-wedding', 'Create magical pre-wedding memories with our creative shoots.', 'Pre-wedding photoshoot services with creative concepts, beautiful locations, and professional editing.'],
            ['Baby Shoots', 'baby-shoots', 'Adorable baby photography capturing precious early moments.', 'Professional baby photography sessions capturing those precious first moments, smiles, and milestones.'],
            ['Birthdays', 'birthdays', 'Fun and vibrant birthday event photography for all ages.', 'Birthday event photography and videography capturing all the fun, joy, and celebration of your special day.'],
            ['Baby Shower', 'baby-shower', 'Elegant baby shower photography capturing the excitement.', 'Beautiful baby shower event photography capturing the love, excitement, and celebrations with family and friends.'],
            ['Maternity', 'maternity', 'Beautiful maternity photography celebrating the journey.', 'Professional maternity photography sessions celebrating the beautiful journey of motherhood with elegant and creative poses.'],
        ];

        $stmt = $this->pdo->prepare("INSERT INTO services (service_name, slug, short_description, full_description, meta_title, meta_description, status) VALUES (?, ?, ?, ?, ?, ?, 1)");
        foreach ($services as $s) {
            $stmt->execute([$s[0], $s[1], $s[2], $s[3], $s[0] . ' Photography | AstraClicks', $s[2]]);
        }

        // Default branches
        $branches = [
            [
                'AstraClicks - Madipakkam',
                "1st Floor, No 71,\nPonniamman Koil St,\nRam Nagar,\nPuzhuthivakkam,\nMadipakkam,\nChennai,\nTamil Nadu 600091",
                '8754114739',
                'https://maps.google.com/?q=Madipakkam+Chennai'
            ],
            [
                'AstraClicks - Virugambakkam',
                "27/6,\n1st Cross St,\nElango Nagar,\nVirugambakkam,\nChennai,\nTamil Nadu 600092",
                '7200064523',
                'https://maps.google.com/?q=Virugambakkam+Chennai'
            ],
        ];

        $stmt = $this->pdo->prepare("INSERT INTO branches (branch_name, address, phone, google_map, status) VALUES (?, ?, ?, ?, 1)");
        foreach ($branches as $b) {
            $stmt->execute($b);
        }

        // Default site settings
        $settings = [
            ['site_name', 'AstraClicks'],
            ['site_tagline', 'Photography & Videography Studio'],
            ['whatsapp_number', '7200064523'],
            ['instagram_url', 'https://www.instagram.com/weddings_by_astra?igsh=MTJpbWgwYzFyNjUw'],
            ['facebook_url', 'https://www.facebook.com/astraclicks/'],
            ['youtube_url', 'https://www.youtube.com/@astraclicks1128'],
            ['meta_title', 'AstraClicks - Professional Photography & Videography Studio in Chennai'],
            ['meta_description', 'AstraClicks is a premium photography and videography studio in Chennai specializing in weddings, receptions, pre-wedding shoots, baby photography, birthdays, and maternity shoots.'],
        ];

        $stmt = $this->pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
        foreach ($settings as $s) {
            $stmt->execute($s);
        }

        // Default hero banners (using template images)
        $banners = [
            ['assets/images/banner/home_banner_1.jpg', 'AstraClicks Wedding Photography', 1],
            ['assets/images/banner/home_banner_2.jpg', 'AstraClicks Pre-Wedding Shoots', 2],
            ['assets/images/banner/home_banner_3.jpg', 'AstraClicks Reception Coverage', 3],
            ['assets/images/banner/home_banner_4.jpg', 'AstraClicks Baby Photography', 4],
            ['assets/images/banner/home_banner_5.jpg', 'AstraClicks Birthday Events', 5],
            ['assets/images/banner/home_banner_6.jpg', 'AstraClicks Maternity Shoots', 6],
            ['assets/images/banner/home_banner_7.jpg', 'AstraClicks Professional Studio', 7],
            ['assets/images/banner/home_banner_8.jpg', 'AstraClicks Creative Photography', 8],
        ];

        $stmt = $this->pdo->prepare("INSERT INTO hero_banners (image, alt_text, sort_order, status) VALUES (?, ?, ?, 1)");
        foreach ($banners as $b) {
            $stmt->execute($b);
        }
    }
}

// Initialize database
$db = Database::getInstance();
$pdo = $db->getConnection();
