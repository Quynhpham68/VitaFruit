CREATE DATABASE vegetable;
CREATE TABLE `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quyenHan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ;

INSERT INTO `role` VALUES (1,'USER'),(2,'ADMIN');

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `roleID` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `roleID` (`roleID`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `role` (`id`)
);
INSERT INTO `user` (id, email, password, name, phone, image, roleID) 
VALUES (1, 'admin@gmail.com', '$2y$10$1FDxGVWLdnjhepPs0hrN8esbEOkeGX9Xqu/2E5s5nBOKULLkg4uXG', 'Hoàng Minh Trí', '32423423423', '1732003800.jpg', 2);
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` double NOT NULL,
  `details_desc` text,
  `short_desc` varchar(255) DEFAULT NULL,
  `factory` varchar(255) DEFAULT NULL,
  `quantity` int DEFAULT '0',
  `sold` int DEFAULT '0',
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `userId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userId` (`userId`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ;
CREATE TABLE `cart_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `cartId` int DEFAULT NULL,
  `productId` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cartId` (`cartId`),
  KEY `productId` (`productId`),
  CONSTRAINT `cart_detail_ibfk_1` FOREIGN KEY (`cartId`) REFERENCES `cart` (`id`),
  CONSTRAINT `cart_detail_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`id`)
);
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `userId` int DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_userId` (`userId`),
  CONSTRAINT `fk_userId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ;
CREATE TABLE `order_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `productId` int DEFAULT NULL,
  `orderId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  KEY `orderId` (`orderId`),
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`id`),
  CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`)
) ;


CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `star` int NOT NULL,
  `review_detail` text,
  `userId` int DEFAULT NULL,
  `productId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `productId` (`productId`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`id`)
) ;

CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE contact ADD reply TEXT NULL;
ALTER TABLE product ADD COLUMN discount_percent INT DEFAULT 0;
ALTER TABLE product ADD discount_price DECIMAL(10,2) NULL DEFAULT NULL;

CREATE TABLE chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE chat_messages
DROP COLUMN message,
ADD COLUMN question TEXT NOT NULL,
ADD COLUMN reply TEXT NOT NULL;
ALTER TABLE contact
ADD COLUMN user_id INT NULL,
ADD CONSTRAINT contact_ibfk_1 FOREIGN KEY (user_id) REFERENCES user(id);
