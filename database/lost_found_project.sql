

-- 1. جدول المسؤولين (المستخدمين)
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. إضافة الأدمن الافتراضي (كلمة المرور: 123456)
INSERT INTO `users` (`username`, `password`) VALUES
('admin', 'admin');

-- 3. جدول العناصر (المفقودات والموجودات)
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` enum('lost','found') NOT NULL,
  `status` enum('pending','approved','claimed') NOT NULL DEFAULT 'pending',
  `contact_info` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;