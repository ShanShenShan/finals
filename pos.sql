-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 11:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_points` int(5) NOT NULL,
  `image` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_name`, `category_id`, `price`, `quantity`, `product_points`, `image`, `description`) VALUES
(13, 'Coca-cola', 1, 50.00, 490, 1, 'coca-cola.jpg', ''),
(15, 'Chocolate-chips', 4, 165.00, 50, 1, 'Chocolate-chips.jpg', 'Indulge in the rich and velvety goodness of our Chocolate Chips frappe, a delightful blend of chocolatey indulgence and icy refreshment.'),
(16, 'Cookies & Cream', 4, 165.00, 50, 1, 'cokkies & cream.jpg', 'Cookies & Cream: A classic favorite, this frappé combines creamy vanilla with chunks of chocolate cookies for a delightful treat.'),
(17, 'White Mocha', 4, 165.00, 50, 1, 'white mocha.jpg', ' Experience the perfect harmony of espresso and creamy sweetness in our White Mocha frappe, a delightful treat that offers a sophisticated twist.'),
(18, 'Vanilla Cream', 4, 135.00, 50, 1, 'vanilla cream.jpg', 'A smooth and velvety frappé featuring the timeless flavor of vanilla, creating a comforting and satisfying drink.'),
(19, 'Butterscotch', 4, 145.00, 50, 1, 'butterscotch.jpg', 'Indulge in the rich and buttery notes of our Butterscotch frappe, a flavorful blend that combines caramelized sweetness with a chilly, refreshing base.'),
(20, 'Strawberries & Cream', 4, 145.00, 50, 1, 'strawberry and cream.jpg', ' Enjoy the fruity goodness of our Strawberries & Cream frappe, a delightful fusion of ripe strawberries and creamy bliss.'),
(21, 'Green Tea', 4, 170.00, 44, 1, 'green tea.jpg', 'Refresh your senses with our Green Tea frappe, a cool and invigorating blend of matcha goodness that offers a unique and satisfying flavor.'),
(22, 'Milky Chocolate', 4, 170.00, 50, 1, 'milky chocolate.jpg', 'Dive into the comforting taste of our Milky Chocolate frappe, a heavenly blend of creamy milk and indulgent chocolate that promises a soothing and delightful experience.'),
(23, 'Blueberry', 5, 115.00, 50, 1, 'blueberry Tea.jpg', 'Enjoy the tangy freshness of our Blueberry fruit tea, a delightful blend of blueberries and crisp tea.'),
(24, 'Lychee', 5, 125.00, 50, 1, 'lychee Tea.jpg', 'Indulge in the exotic sweetness of our Lychee fruit tea, a tropical treat transporting you with each sip.'),
(25, 'Strawberry', 5, 115.00, 50, 1, 'strawberry Tea.jpg', 'Savor the vibrant taste of summer with our Strawberry fruit tea, a refreshing infusion capturing the essence of sun-kissed berries.'),
(26, 'Classic', 6, 95.00, 50, 1, 'classic.jpg', 'Experience the timeless allure of our Classic milk tea, a perfectly balanced blend of rich black tea and creamy milk, offering a comforting and familiar taste.'),
(27, 'Wintermelon', 6, 100.00, 50, 1, 'wintermelon.jpg', 'Dive into the subtle sweetness of wintermelon in this smooth and creamy milk tea.'),
(28, 'Taro', 6, 100.00, 50, 1, 'Taro.jpg', 'Indulge in the rich and nutty goodness of taro in this delightful milk tea.'),
(29, 'Kafe Americano', 14, 100.00, 50, 1, 'Kafe Americano.jpg', 'Kickstart your day with the bold simplicity of our smooth and robust black coffee, the Kafe Americano.'),
(30, 'Kafe Latte', 14, 110.00, 50, 1, 'Kafelatte.jpg', ' Indulge in the creamy perfection of our expertly crafted Kafe Latte, a delightful blend of rich espresso, steamed milk, and velvety foam.'),
(34, 'Sprite', 1, 50.00, 50, 0, 'sprite.jpg', 'Sprite is a crisp, lemon-lime flavored soft drink known for its refreshing and tangy taste.'),
(36, 'Caramel Macchiato', 14, 115.00, 100, 1, 'caramel machiatto.jpg', 'Experience sweet sophistication with our Caramel Macchiato, layers of espresso, frothy milk, and a drizzle of caramel for a decadent treat.'),
(37, 'Toffee Nut Latte', 14, 115.00, 100, 1, 'toffee nut.jpg', 'Enjoy the warm and nutty notes of our comforting Toffee Nut Iced drink, blending the richness of toffee with aromatic nut essence.'),
(38, 'ShortBread Cookie Latte', 14, 125.00, 100, 1, 'shortbreed cookie latte.jpg', 'Cozy up with our Shortbread Cookie hot drink, a delightful infusion capturing the essence of buttery shortbread in every sip.'),
(39, 'Macadamia Nut Latte', 14, 125.00, 100, 1, 'macadamia nut latte.jpg', 'Indulge in the velvety richness of our Macadamia Nut hot drink, a luxurious blend combining buttery macadamia flavor with comforting warmth.'),
(40, 'Spanish Latte', 14, 110.00, 100, 1, 'spanish latte.jpg', 'Take a coffee journey to Spain with our bold and aromatic Spanish iced drink, inspired by the rich coffee culture of the Iberian Peninsula.'),
(41, 'French Vanilla Latte', 14, 115.00, 100, 1, 'french vanilla caffee.jpg', 'Savor the classic allure of our French Vanilla iced drink, a smooth and sweet blend embodying timeless sophistication.'),
(42, 'Italian Dolce', 14, 120.00, 100, 1, 'italian dolce latte.jpg', 'Immerse yourself in decadence with our Italian Dolce ice drink, a luxurious blend inspired by the sweet delights of Italian desserts.'),
(43, 'Green Tea Latte', 14, 150.00, 100, 1, 'green tea latte.jpg', 'Refresh your senses with our soothing and antioxidant-rich Green Tea Ice drink, offering a calming balance of cold and herbal goodness.'),
(44, 'Kafe Americano', 15, 80.00, 100, 1, 'kafe americanoi.jpg', 'Start your day with the bold simplicity of our smooth black coffee, the Kafe Americano.'),
(45, 'Capuccino', 15, 85.00, 100, 1, 'capuccino.jpg', 'Indulge in the creamy richness of our Very warmth Kafe Latte, a harmonious blend of espresso and steamed milk.'),
(46, 'Caramel Macchiato', 15, 120.00, 100, 1, 'caramel machiatto.jpg', 'Experience sweet sophistication with our Caramel Macchiato, layers of espresso, frothy milk, and a drizzle of caramel.'),
(47, 'Toffee Nut', 15, 120.00, 100, 1, 'toffee nut.jpg', 'Enjoy the warm and nutty notes of our Toffee Nut Latte, a delightful fusion of toffee sweetness and aromatic nuttiness.'),
(48, 'ShortBread Cookie', 15, 125.00, 100, 1, 'Shortbreed Coffee.jpg', 'Cozy up with our Shortbread Cookie Latte, capturing the essence of buttery shortbread in every sip.'),
(49, 'Macadamia Nut', 15, 125.00, 100, 1, 'hot macademia latte.jpg', 'Indulge in the velvety richness of our Macadamia Nut Latte, a luxurious blend of buttery macadamia flavor and comforting warmth.'),
(50, 'Spanish Hot Chocolate', 15, 105.00, 100, 1, 'spanish hot chocolate.jpg', 'Take a coffee journey to Spain with our bold and aromatic Spanish Hot Chocolate, inspired by the rich coffee culture of the Iberian Peninsula.'),
(51, 'French Vanilla', 15, 120.00, 100, 1, 'french vanilla.jpg', 'Savor the classic allure of our French Vanilla Latte, a smooth and sweet blend embodying timeless sophistication.'),
(52, 'Grilled Liempo', 13, 149.00, 100, 1, 'grilled liempo.jpg', 'Indulge in the smoky perfection of our Grilled Liempo, showcasing tender pork belly marinated and char-grilled to perfection.'),
(53, 'Chicken BBQ', 13, 149.00, 100, 1, 'chicken bbq.jpg', 'Savor the grilled goodness of our Chicken BBQ, featuring succulent chicken pieces glazed with a flavorful barbecue marinade.'),
(54, 'Pork Adobo w/Salted Egg', 13, 190.00, 100, 1, 'pork adobo with salted egg.jpg', 'Experience the savory fusion of traditional Pork Adobo complemented by the richness of salted egg, creating a delightful harmony of flavors.'),
(55, 'Sizzling Liempo w/Rice', 13, 149.00, 100, 1, 'sizzling liempo.jpg', 'Enjoy the sizzle and aroma of our Sizzling Liempo, a tantalizing dish of marinated pork belly served on a hot plate.'),
(56, 'Sizzling Pork Chop w/Rice', 13, 149.00, 100, 1, 'sizzling prokchop.jpg', 'Relish the sizzling delight of our Pork Chop, cooked to juicy perfection and served on a sizzling hot plate.'),
(57, 'Lechon Kawali w/Rice', 13, 159.00, 100, 1, 'lechon kawali.jpg', 'Indulge in the crispy goodness of our Lechon Kawali, a Filipino crispy fried pork belly dish served with steaming rice.'),
(58, 'Binagoongan w/ Rice', 13, 59.00, 100, 1, 'binagoongan rice.jpg', 'Delight in the bold flavors of Binagoongan, a savory pork dish cooked in shrimp paste, served with a side of rice.'),
(59, 'Breaded Pork Chop w/ Rice', 13, 159.00, 100, 1, 'breaded porkchop width rice.jpg', 'Experience the satisfying crunch of our Breaded Pork Chop, a crispy delight paired with a serving of steamed rice.'),
(60, 'Bicol Express w/ Rice', 13, 159.00, 100, 1, 'bicol express with rice.jpg', 'Spice up your meal with Bicol Express, a flavorful and creamy pork dish cooked in coconut milk, served alongside steamed rice.'),
(61, 'Beef Tapa Rice', 8, 159.00, 100, 1, 'beef tapa srice.jpg', 'Wake up your taste buds with our Beef Tapa Rice, featuring thinly sliced marinated beef, perfectly grilled to savory perfection and served with steamed rice.'),
(62, 'Corned Beef Rice', 8, 159.00, 100, 1, 'corned beef rice.jpg', 'Indulge in the classic comfort of our Corned Beef Rice, a hearty dish of tender corned beef served alongside a generous portion of fluffy rice.'),
(63, 'Tocino Rice', 8, 150.00, 100, 1, 'tocino rice.jpg', 'Delight in the sweet and savory goodness of our Tocino Rice, showcasing Filipino-style cured pork, grilled to a caramelized perfection, and served with a side of rice.'),
(64, 'Longganisa Rice', 8, 150.00, 100, 1, 'longganisa rice.jpg', 'Enjoy the flavorful kick of our Longganisa Rice, featuring native Filipino sausage, grilled to perfection, and served with steamed rice.'),
(66, 'Boneless Bangus Rice', 8, 150.00, 100, 3, 'boneless bangus rice.jpg', 'Dive into a seafood delight with our Boneless Bangus Rice, featuring boneless milkfish marinated and pan-fried to golden perfection, served with steamed rice.'),
(67, 'Dangit Rice', 8, 150.00, 100, 1, 'danggit.jpg', 'Experience the salty and savory flavors of our Danggit Rice, featuring dried rabbitfish, deep-fried to a delightful crisp, and served with a side of rice.'),
(68, 'Filipino Style Sphaghetti', 7, 180.00, 100, 1, 'filipino style spaghetti.jpg', 'Filipino-style spaghetti combines sweet sauce with hot dogs or ham, creating a unique twist on traditional pasta'),
(69, 'Carbonara', 7, 200.00, 100, 1, 'carbonara.jpg', 'Experience the perfect blend of eggs, Parmesan, and pancetta in every bite – a true taste of Italy.'),
(70, 'Pancit Bihon', 7, 249.00, 100, 1, 'pancit bihon.jpg', 'Delight in the vibrant flavors of Pancit Bihon, a Filipino classic bursting with the perfect mix of rice noodles, savory meats, and fresh vegetables.'),
(71, 'Sweet Spaghetti', 11, 99.00, 100, 1, 'sweet style pasta.jpg', 'Discover the sweet delight of Filipino-style spaghetti: a perfect harmony of tangy-sweet sauce, complemented by savory hot dogs or ham. A beloved taste that brings joy to every bite!'),
(72, 'Creamy Carbonara', 11, 99.00, 100, 1, 'creamy carbonara.jpg', 'Indulge in our creamy Carbonara, a luscious blend of eggs, Parmesan cheese, and crispy pancetta – a decadent Italian classic that melts in your mouth. Taste pure richness with every forkful'),
(73, 'Lasagna', 11, 159.00, 100, 1, 'lasagna.jpg', 'Savor layers of savory indulgence with our classic lasagna. Rich, seasoned meat, creamy ricotta, and gooey melted cheese, all perfectly baked for that comforting, hearty taste that never fails to satisfy'),
(74, 'Crab & Corn Soup', 12, 150.00, 100, 1, 'crab & corn soup.jpg', 'Start your meal with the comforting warmth of our Crab & Corn Soup, a hearty blend of succulent crab meat and sweet corn in a flavorful broth.'),
(75, 'Mushroom Soup', 12, 160.00, 100, 1, 'mushroom soup.jpg', 'Indulge in the earthy goodness of our Mushroom Soup, a velvety concoction that celebrates the rich flavors of assorted mushrooms.'),
(76, 'Pork Sinigang', 12, 310.00, 100, 1, 'pork sinigang.jpg', 'Delight in the tangy and savory notes of our Pork Sinigang, a Filipino classic featuring tender pork and a tamarind-infused broth.'),
(77, 'Salmon Belly Sinigang', 12, 350.00, 100, 1, 'salmon belly sinigang.jpg', 'Experience a seafood twist with our Salmon Belly Sinigang, where the delicate flavors of salmon belly enhance the traditional sinigang experience.'),
(78, 'Bulalo', 12, 500.00, 100, 1, 'bulalo bone marrow soup.jpg', 'Enjoy the robust flavors of our Bulalo, a hearty beef shank and bone marrow soup that promises a satisfying and savory feast.'),
(79, 'Chopsuey', 12, 250.00, 100, 1, 'chopsuey.jpg', 'Explore the vibrant medley of crisp vegetables in our Chopsuey, a stir-fried delight that showcases the freshness of assorted garden greens.'),
(80, 'Crispy Pata', 9, 700.00, 100, 1, 'crispy pata.jpg', 'Indulge in the epitome of crispy delight with our meticulously prepared Crispy Pata, a mouthwatering pork hock dish.'),
(81, 'Sizzling Pork Sisig', 9, 230.00, 100, 1, 'sizzling pork sisig.jpg', 'Experience the bold and sizzling flavors of our signature Pork Sisig, a savory Filipino favorite that promises to tantalize your taste buds.'),
(82, 'Calamares', 9, 250.00, 100, 1, 'calamares.jpg', 'Delight in the perfect crunch of our Calamares, featuring tender squid rings encased in a golden, seasoned batter.'),
(83, 'Buffalo Wings', 9, 279.00, 100, 1, 'buffalo wings.jpg', 'Dive into a spicy and tangy adventure with our Buffalo Wings, offering a perfect balance of heat and flavor.'),
(84, 'Chicken Fillet', 9, 250.00, 100, 1, 'chicken fillet.jpg', 'Enjoy a classic favorite with our Chicken Wings, perfectly seasoned and cooked to crispy perfection.'),
(85, 'Fish Fillet & Fries', 9, 200.00, 100, 1, 'fish fillet and ries.jpg', 'Experience a symphony of textures with our Fish Fillet & Fries, where crispy meets flaky in every bite.'),
(86, 'Buttered Chicken Wings', 9, 250.00, 100, 1, 'buttered chicken wings.jpg', 'Indulge in the richness of our Buttered Chicken Wings, coated in a luscious buttery glaze.'),
(87, 'Soy Garlic Chicken Wings', 9, 250.00, 100, 1, 'soy garlic chicken wings.jpg', 'Delight in the savory harmony of our Soy Garlic Wings, offering a delightful fusion of sweet and savory notes.'),
(88, 'Chicharon Bulaklak', 9, 200.00, 100, 1, 'chicharon bulaklak.jpg', 'Revel in the crispy decadence of Chicharon Bulaklak, a flavorful and indulgent Filipino dish.'),
(89, 'Nachos', 9, 230.00, 100, 1, 'nachos.jpg', 'Share the joy of crunchy bliss with our Nachos, layered with savory toppings for a perfect communal snack.'),
(90, 'French Fries', 9, 120.00, 100, 1, 'frencvh fries.jpg', 'Satisfy your craving for the classics with our perfectly golden and crispy French Fries, a timeless side that never disappoints.'),
(91, 'Costa Rican Tarrazú', 2, 800.00, 100, 1, 'costa rican tarrazú.jpg', 'Known for its bright acidity, full body, and rich flavor, with hints of citrus and chocolate, grown in the Tarrazú region.'),
(92, 'Kopi Luwak', 2, 3000.00, 100, 1, 'kopi luwak.jpg', 'Renowned as one of the most expensive coffees globally, it\'s made from coffee beans that have been eaten and excreted by civets, resulting in a uniquely flavored, smooth coffee.'),
(93, 'Ethiopian Yirgacheffe', 2, 700.00, 100, 1, 'ethiopian yirgacheffe.jpg', 'Known for its bright acidity, distinctive fruity and floral notes, and a complex flavor profile, it\'s considered one of the best coffees from Ethiopia.'),
(94, 'Espresso Shots', 10, 15.00, 100, 1, 'espresso shot.jpg', 'Elevate your drink with an extra kick of intensity by adding an Espresso Shot, enhancing the robust flavor of your favorite beverages.'),
(95, 'Caramel Sauce', 10, 20.00, 100, 1, 'caramel sauce.jpg', 'Indulge your sweet tooth with the rich and luscious addition of Caramel Sauce, drizzled to perfection for a delightful burst of caramelized goodness.'),
(96, 'Sugar Syrup', 10, 10.00, 100, 1, 'sugar syrup.jpg', 'Customize your beverage to your preferred sweetness level by incorporating our Sugar Syrup, ensuring your drink is tailored to your exact taste preferences.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
